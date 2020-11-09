<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Student;
use App\Models\Schedule;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\ScheduleSummaryResource;
use App\Http\Resources\StudentAttendanceResource;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public $order_table = 'schedule';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedule = Schedule::when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return ScheduleResource::collection($schedule);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new ScheduleResource(Schedule::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Schedule ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of App\Models\Student from App\Models\Schedule instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getAttendances(int $id)
    {
        try {
            $students = Schedule::findOrFail($id)->students;

            return StudentAttendanceResource::collection($students);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Schedule ' . $id . ' not found.'
            ], 404);
        }
    }

    public function editAttendances(Request $request, int $id)
    {
        $this->validate($request, [
            'student_id' => 'required|exists:student,id',
            'status' => 'required|in:hadir,izin,terlambat,alpa',
        ]);

        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->students()
                ->syncWithoutDetaching([
                    $request->student_id => ['status' => $request->status]
                ]);

            $student = $schedule->students()->where('id', $request->student_id)->first();

            return new StudentAttendanceResource($student);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Schedule ' . $id . ' not found.'
            ], 404);
        }
    }

    public function attend(Request $request, int $id)
    {
        try {
            $this->validate($request, [
                'student_id' => 'required|exists:student,id',
            ]);

            $schedule = Schedule::findOrFail($id);
            // TODO: Change HARDCODE Minute
            $current_time = date_create();
            if (date_diff($current_time, date_create($schedule->start_time))->i < 15) {
                $attendance_status = 'hadir';
            } elseif (date_diff(date_create($schedule->end_time), $current_time)->invert) {
                $attendance_status = 'terlambat';
            } else {
                $attendance_status = 'alpa';
            }

            $schedule->students()
                ->syncWithoutDetaching([$request->student_id => ['time' => $current_time, 'status' => $attendance_status]]);

            $student = $schedule->students()->where('id', $request->student_id)->first();

            return new StudentAttendanceResource($student);
        } catch (ModelNotFoundException $e) {
            $desc = ($e->getModel() == 'App\Models\Schedule') ?
                'Schedule ' . $id . ' not found.' : 'Student ' . $request->student_id . ' not found.';

            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => $desc,
            ], 404);
        }
    }

    public function summarize(Request $request)
    {
        $schedule = Schedule::withCount(['students as hadir' => function ($query) {
            $query->where('student_attendance.status', 'hadir');
        }, 'students as izin' => function ($query) {
            $query->where('student_attendance.status', 'izin');
        }, 'students as terlambat' => function ($query) {
            $query->where('student_attendance.status', 'terlambat');
        }, 'students as alpa' => function ($query) {
            $query->where('student_attendance.status', 'alpa');
        }])
            ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return ScheduleSummaryResource::collection($schedule);
    }

    public function open(Request $request, int $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            if (
                !$schedule->start_time
                && date_diff(date_create(), date_create($schedule->time))->invert
            ) {
                $schedule->start_time = date("Y-m-d H:i:s");
                $schedule->save();
            }

            return new ScheduleResource($schedule);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Schedule ' . $id . ' not found.'
            ], 404);
        }
    }

    public function close(Request $request, int $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            if (!$schedule->end_time) {
                $schedule->end_time = date("Y-m-d H:i:s");
                $schedule->save();
            }
            return new ScheduleResource($schedule);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Schedule ' . $id . ' not found.'
            ], 404);
        }
    }
}

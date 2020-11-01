<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Lecturer;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\ScheduleSummaryResource;
use App\Http\Resources\StudentAttendanceResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

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
        $startOfWeek = Carbon::now()->startOfWeek()->startOfDay();
        $endOfWeek = Carbon::now()->endOfWeek()->endOfDay();

        if (Gate::allows('admin')) {
            $schedule = Schedule::when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));
        } elseif (Gate::allows('lecturer')) {
            $lecturer = Lecturer::firstWhere('user_id', $this->user->id);

            $schedule = Schedule::whereHas('subject', function (Builder $query) use ($lecturer) {
                $query->where('lecturer_id', $lecturer->id);
            })
                ->whereBetween('time', [$startOfWeek, $endOfWeek])
                ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));
        } elseif (Gate::allows('student')) {
            $student = Student::firstWhere('user_id', $this->user->id);

            $schedule = Schedule::whereHas('subject', function (Builder $query) use ($student) {
                $query->where('classroom_id', $student->classroom_id);
            })
                ->whereBetween('time', [$startOfWeek, $endOfWeek])
                ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));
        }

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
            $schedule = Schedule::findOrFail($id);

            if (Gate::allows('admin')) {
                $this->validate($request, [
                    'student_id' => 'required|exists:student,id',
                ]);

                $student_id = $request->student_id;
                $student = $schedule->students()->where('id', $student_id)->first();
            } elseif (Gate::allows('student')) {
                $student = Student::firstWhere('user_id', $this->user->id);

                if ($student == null) {
                    throw new ModelNotFoundException;
                }

                $student_id = $student->id;
            }

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
                ->syncWithoutDetaching([$student_id => ['time' => $current_time, 'status' => $attendance_status]]);

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
        try {
            if (Gate::allows('admin')) {
                $schedule = Schedule::withCount(['students as hadir' => function ($query) {
                    $query->where('student_attendance.status', 'hadir');
                }, 'students as izin' => function ($query) {
                    $query->where('student_attendance.status', 'izin');
                }, 'students as terlambat' => function ($query) {
                    $query->where('student_attendance.status', 'terlambat');
                }, 'students as alpa' => function ($query) {
                    $query->where('student_attendance.status', 'alpa');
                }])->orderBy('end_time', 'desc')->get();
            } elseif (Gate::allows('lecturer')) {
                $lecturer = Lecturer::firstWhere('user_id', $this->user->id);
                if ($lecturer == null) throw new ModelNotFoundException("Lecturer not found.", 0);

                $schedule = Schedule::whereIn('subject_id', $lecturer->subjects)
                    ->withCount(['students as hadir' => function ($query) {
                        $query->where('student_attendance.status', 'hadir');
                    }, 'students as izin' => function ($query) {
                        $query->where('student_attendance.status', 'izin');
                    }, 'students as terlambat' => function ($query) {
                        $query->where('student_attendance.status', 'terlambat');
                    }, 'students as alpa' => function ($query) {
                        $query->where('student_attendance.status', 'alpa');
                    }])->orderBy('end_time', 'desc')->get();
            } elseif (Gate::allows('student')) {
                // TODO: GroupBy?
                $student = Student::firstWhere('user_id', $this->user->id);
                if ($student == null) throw new ModelNotFoundException("Student not found.", 0);

                $schedule = Schedule::withCount(['students as hadir' => function ($query) use ($student) {
                    $query->where('student_attendance.status', 'hadir')
                        ->where('student_attendance.student_id', $student->id);
                }, 'students as izin' => function ($query) use ($student) {
                    $query->where('student_attendance.status', 'izin')
                        ->where('student_attendance.student_id', $student->id);
                }, 'students as terlambat' => function ($query) use ($student) {
                    $query->where('student_attendance.status', 'terlambat')
                        ->where('student_attendance.student_id', $student->id);
                }, 'students as alpa' => function ($query) use ($student) {
                    $query->where('student_attendance.status', 'alpa')
                        ->where('student_attendance.student_id', $student->id);
                }])->orderBy('end_time', 'desc')->get();
            }

            return ScheduleSummaryResource::collection($schedule);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => $e->getMessage(),
            ], 404);
        }
    }

    public function open(Request $request, int $id)
    {
        if (Gate::any(['admin', 'lecturer'])) {
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
    }

    public function close(Request $request, int $id)
    {
        if (Gate::any(['admin', 'lecturer'])) {
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
}

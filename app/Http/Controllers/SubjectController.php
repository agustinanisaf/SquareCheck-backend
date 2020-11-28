<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\SubjectAttendanceResource;
use App\Models\Lecturer;
use App\Models\Schedule;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
    public $order_table = 'subject';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (Gate::allows('admin')) {
                $subject = Subject::query();
            } else if (Gate::allows('lecturer')) {
                $lecturer = Lecturer::firstWhere('user_id', $this->user->id);
                if ($lecturer == null)
                    throw new ModelNotFoundException('Lecturer with User ID ' . $this->user->id . ' Not Found', 0);

                $subject = Subject::where('lecturer_id', $lecturer->id);
            } else if (Gate::allows('student')) {
                $student = Student::firstWhere('user_id', $this->user->id);
                if ($student == null)
                    throw new ModelNotFoundException('Student with User ID ' . $this->user->id . ' Not Found', 0);

                $subject = Subject::where('classroom_id', $student->classroom_id);
            }
            $subject = $subject->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return SubjectResource::collection($subject);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => $e->getMessage(),
            ]);
        }
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
            $subject = Subject::findOrFail($id);

            return new SubjectResource($subject);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Subject ' . $id . ' not found.'
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
     * Display a listing of App\Models\Student from App\Models\Subject instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getStudents(int $id)
    {
        try {
            $students = Student::query()
                ->select(['student.*'])
                ->leftJoin('subject', 'subject.classroom_id', '=', 'student.classroom_id')
                ->where('subject.id', '=', $id)
                ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return StudentResource::collection($students);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Subject ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Display a listing of App\Models\Schedule from App\Models\Subject instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSchedules(int $id)
    {
        try {
            $schedules = Subject::findOrFail($id)
                ->schedules()
                ->when(['schedule', $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return ScheduleResource::collection($schedules);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Subject ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Display a listing of App\Models\Student from App\Models\Subject instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getAttendances(int $id)
    {
        try {
            // TODO: Check Lecturer have access to schedule
            if (Gate::any(['admin', 'lecturer'])) {
                $schedules = Schedule::with('students');
            } else if (Gate::allows('student')) {
                $student = Student::firstWhere('user_id', $this->user->id);
                if ($student == null) throw new ModelNotFoundException("Student not found.", 0);

                $schedules = Schedule::with(['students' => function ($query) use ($student) {
                    return $query->where('student_id', $student->id);
                }]);
            }

            $schedules = $schedules->where('subject_id', $id)
                ->when(['schedule', $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return SubjectAttendanceResource::collection($schedules);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => $e->getMessage(),
            ], 404);
        }
    }
}

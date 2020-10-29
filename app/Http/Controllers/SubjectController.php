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
        $subject = Subject::when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return SubjectResource::collection($subject);
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
                ->leftJoin('subject', 'subject.classroom_id', '=', 'student.classroom_id')
                ->where('subject.id', '=', $id)
                ->get(['student.*']);

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
            $schedules = Subject::findOrFail($id)->schedules;

            return ScheduleResource::collection($schedules);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Subject ' . $id . ' not found.'
            ], 404);
        }
    }
}

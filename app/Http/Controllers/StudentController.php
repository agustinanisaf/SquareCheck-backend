<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\ScheduleAttendanceResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StudentResource::collection(Student::all());
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
            return new StudentResource(Student::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Student ' . $id . ' not found.'
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
     * Display a listing of App\Models\Subject from App\Models\Student instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSubjects(int $id)
    {
        try {
            $subjects = Subject::query()
                ->leftJoin('student', 'student.classroom_id', '=', 'subject.classroom_id')
                ->where('student.id', '=', $id)
                ->get(['subject.*']);

            return SubjectResource::collection($subjects);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Student ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Display a listing of App\Models\Schedule from App\Models\Student instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getAttendances(int $id)
    {
        try {
            $attendances = Student::findOrFail($id)->attendances;

            return ScheduleAttendanceResource::collection($attendances);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Student ' . $id . ' not found.'
            ], 404);
        }
    }
}

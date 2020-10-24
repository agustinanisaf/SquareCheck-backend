<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\ScheduleResource;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubjectResource::collection(Subject::all());
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
            return new SubjectResource(Subject::findOrFail($id));
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
            $students = Subject::findOrFail($id)->students;

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
     * Display an instance of App\Models\Lecturer from App\Models\Subject instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getLecturer(int $id)
    {
        try {
            $lecturer = Subject::findOrFail($id)->lecturer;

            return response()->json($lecturer);
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

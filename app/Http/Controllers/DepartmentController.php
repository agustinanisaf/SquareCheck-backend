<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DepartmentStudentResource;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SubjectResource;
use App\Models\Lecturer;

class DepartmentController extends Controller
{
    public $order_table = 'department';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return DepartmentResource::collection($departments);
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
            return new DepartmentResource(Department::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Department ' . $id . ' not found.'
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
     * Display a listing of App\Models\Student from App\Models\Department instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getStudents(int $id)
    {
        try {
            $students = Student::where('department_id', $id)
                ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when(['nrp', 'name'], Closure::fromCallable([$this, 'querySearch']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));;

            return StudentResource::collection($students);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Department ' . $id . ' not found.'
            ], 404);
        }
    }

    public function getAllStudents()
    {
        $departments = Department::withCount(['students as count'])
            ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return DepartmentStudentResource::collection($departments);
    }

    /**
     * Display a listing of App\Models\Lecturer from App\Models\Department instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getLecturers(int $id)
    {
        try {
            $lecturers = Lecturer::where('department_id', $id)
                ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return LecturerResource::collection($lecturers);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Department ' . $id . ' not found.'
            ], 404);
        }
    }

    public function getAllSubjects()
    {
        $departments = Department::withCount(['subjects as count'])
            ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return DepartmentStudentResource::collection($departments);
    }

    /**
     * Display a listing of App\Models\Subject from App\Models\Department instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSubjects(int $id)
    {
        try {
            $subjects = Department::findOrFail($id)
                ->subjects()
                ->when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return SubjectResource::collection($subjects);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Department ' . $id . ' not found.'
            ], 404);
        }
    }
}

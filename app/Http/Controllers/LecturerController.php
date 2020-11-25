<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\SubjectResource;
use Illuminate\Support\Facades\Gate;

class LecturerController extends Controller
{
    public $order_table = 'lecturer';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('admin')) {
            $lecturer = Lecturer::when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return LecturerResource::collection($lecturer);
        } elseif (Gate::allows('lecturer')) {
            $lecturer = Lecturer::firstWhere('user_id', $this->user->id);

            return new LecturerResource($lecturer);
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
            $lecturer = Lecturer::findOrFail($id);

            return new LecturerResource($lecturer);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Lecturer ' . $id . ' not found.'
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
     * Display a listing of App\Models\Subject from App\Models\Lecturer instances.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSubjects(int $id)
    {
        try {
            $subjects = Lecturer::findOrFail($id)
                ->subjects()
                ->when(['subject', $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

            return SubjectResource::collection($subjects);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Student ' . $id . ' not found.'
            ], 404);
        }
    }
}

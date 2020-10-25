<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\SubjectResource;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $lecturer = Lecturer::when($this->limit, Closure::fromCallable([$this, 'queryLimit']))
            ->when($this->orderBy, Closure::fromCallable([$this, 'queryOrderBy']))
            ->get();

            return LecturerResource::collection($lecturer);
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
            $lecturer = Lecturer::findOrFail($id)
                ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']))
                ->when($this->orderBy, Closure::fromCallable([$this, 'queryOrderBy']))
                ->get();

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
            $subjects = Lecturer::findOrFail($id)->subjects;

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

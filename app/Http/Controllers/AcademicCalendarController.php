<?php

namespace App\Http\Controllers;

use Closure;
use App\Http\Resources\AcademicCalendarResource;
use Illuminate\Http\Request;
use App\Models\AcademicCalendar as Calendar;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AcademicCalendarController extends Controller
{
    public $order_table = 'academic_calendar';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars = Calendar::when([$this->order_table, $this->orderBy], Closure::fromCallable([$this, 'queryOrderBy']))
            ->when($this->limit, Closure::fromCallable([$this, 'queryLimit']));

        return AcademicCalendarResource::collection($calendars);
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
            return new AcademicCalendarResource(Calendar::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Academic Calendar ' . $id . ' not found.'
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
}

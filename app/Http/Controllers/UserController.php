<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Fix sesuai field User
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:user',
        ]);

        $user = User::create($request->all());

        return $response()->json($user, 201);
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
            return response()->json(User::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User ' . $id . ' not found.'
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
        // TODO: Fix sesuai field User
        $this->validate($request, [
            'email' => 'email|unique:user',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return response()->json([], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Display a listing of App\Models\Token from App\Models\User resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getToken($id)
    {
        try {
            $tokens = User::findOrFail($id)->tokens();

            return response()->json($tokens);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User ' . $id . ' not found.'
            ], 404);
        }
    }

    /**
     * Create a App\Models\Token for App\Models\User resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createToken(Request $request, $id)
    {
        // TODO: Fix sesuai field Token
        $this->validate($request, [
            'type' => 'required',
        ]);

        try {
            $token = Token::create([
                'user_id' => User::findOrFail($id),
                // TODO: Fix generate token
                'token' => Str::random(10),
                'type' => $request->type,
            ]);

            return response()->json($token, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'User ' . $id . ' not found.'
            ], 404);
        }
    }
}
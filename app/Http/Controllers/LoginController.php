<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');

        try {
            $user = User::where('email', $input['email'])->first();

            if (!$user) {
                return response()->json([
                    'results' => [
                        'message' => 'User not found'
                    ]
                ], 500);
            }

            if ($user && Hash::check($input['password'], $user->password)) {

                $token = $user->createToken($user->email)->plainTextToken;
                $results = User::where('email', $input['email'])->select('name', 'email')->first();
                return response()->json([
                    'results' => [
                        'token' => $token,
                        'message' => 'Login success',
                        'user' => $results
                    ]
                ], 200);
            }

            return response()->json([
                'results' => [
                    'message' => 'Password not match'
                ]
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'results' => [
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        $logout = $user->currentAccessToken()->delete();
        if ($logout) {
            return response([
                'message' => 'Logout success'
            ], 200);
        } else {
            return response([
                'message' => 'Something is wrong!'
            ], 500);
        }
    }
}

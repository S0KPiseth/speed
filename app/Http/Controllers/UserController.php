<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Rules\Lowercase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    /**
     * Display a listing of the resource.
     */

    public function index($id)
    {
        $user = User::with('cars')->find(1);

        return view('pages.account', ['id' => $id, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reqq = $request->validate([
            "username"  => ["string", "max:255", "unique:users", "required", "alpha_dash", new Lowercase()],
            "password" => "max:255|confirmed|required",
            "email" => "email|required",
        ], ['password.confirmed' => 'Password miss match', 'username.unique' => 'User is already taken']);
        $reqq['password'] = bcrypt($reqq['password']);
        $user = User::create($reqq);
        Auth::login($user);
        return redirect()->intended('/home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
}

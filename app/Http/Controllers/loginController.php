<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credential = $request->validate(
            [
                'username' => ["required"],
                'password' => ["required"]
            ]
        );
        if (Auth::attempt($credential)) {
            return redirect("/home")->with('user', Auth::user());
        }

        return back()->withErrors([
            'username' => 'Cannot find user',
            'password' => 'Incorrect credentials'
        ]);
    }
}

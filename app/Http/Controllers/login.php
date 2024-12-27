<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class login extends Controller
{
    //

    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $users = User::where('email',$request->email)->first();

        if(! $users || ! Hash::check($request->password, $users->password))
        {
            throw ValidationException::withMessages([
                'email' => ['email or password is incorrect']
            ]);
        }

        return $users->createToken('user login')->plainTextToken;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}

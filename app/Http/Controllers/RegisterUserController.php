<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store() {
        $attributes = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::default(), 'confirmed'],
        ]);

        $attributes['role'] = 'user';

        // dd($attributes);

        $user = User::create($attributes);
        Auth::login($user);

        return redirect('/');
    }
}

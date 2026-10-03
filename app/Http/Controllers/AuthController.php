<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $formData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if (Auth::attempt($formData)) {
            return redirect()->route('movies.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {

        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $formData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
        ]);
        if ($formData['password'] !== $formData['password_confirmation']) {
            return back()->withErrors([
                'password' => 'The passwords do not match.',
            ]);
        }
        $formData['password'] = Hash::make($formData['password']);
        $user = User::create($formData);
        Auth::login($user);

        return redirect()->route('movies.index');

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');

    }
}

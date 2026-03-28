<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([ //will redirect back with errors if any
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); //create new session id

            // redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('tasks.index');
            }

            return redirect()->route('tasks.my');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,staff'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        Auth::login($user);

        return redirect()->route('tasks.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); //remove current session 
        $request->session()->regenerateToken(); //generate new csrf token so that old token is invalid cannot be used

        return redirect()->route('login');
    }
}

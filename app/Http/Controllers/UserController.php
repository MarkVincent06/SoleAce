<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function renderSignIn()
    {
        return view('sign-in');
    }

    public function renderSignUp()
    {
        return view('sign-up');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:200',
            'lastname' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email',
            'phone' => 'required|numeric|digits_between:1,15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = User::create([
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => $validatedData['password'], // REMOVE THIS BEFORE PRODUCTION PHASE
                // 'password' => Hash::make($validatedData['password']), // UNCOMMENT THIS BEFORE PRODUCTION PHASE
                'role_as' => "client",
            ]);

            // Log the user in
            auth()->login($user);

            return redirect('/')->with('success', 'Account created successfully. You are now logged in.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating your account. Please try again.');
        }
    }

    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // REMOVE LINE 60-66 BEFORE PRODUCTION PHASE
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->password === $credentials['password']) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'You have successfully signed in.');;
        }

        // UNCOMMENT CODE BELOW BEFORE PRODUCTION PHASE
        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('/')->with('success', 'You have successfully signed in.');
        // }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out.');
    }
}

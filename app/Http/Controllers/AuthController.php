<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
   
    public function loginForm()
    {

        return view("auth.loginForm");
    }


    public function login(Request $request)
    {

        // validate data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // login user and redirect to dashboard
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home.index');
        }

        // error redirect
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return view('auth.loginForm');
    }

    public function signupForm()
    {

        return view("auth.signupForm");
    }



    public function register(Request $request)
    {

        // validate data
        $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8']
        ]);


        // Create user (unverified)
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'is_verified' => false
        ]);

        // Todo 

         // Generate OTP and send email
        $otp = $user->generateEmailVerificationToken();
        
        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user, $otp));

            return redirect()->route('email.verify.form', ['user' => $user->id])
                ->with('success', 'Account created! Please check your email for verification code.');
        } catch (\Exception $e) {
            // If email fails, delete the user and show error
            $user->delete();
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again.']);
        }
    }

    public function showEmailVerificationForm($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->is_verified) {
            return redirect()->route('loginForm')->with('success', 'Email already verified!');
        }
        
        return view('auth.verify-email', compact('user'));
    }

    public function verifyEmail(Request $request, $userId)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6']
        ]);

        $user = User::findOrFail($userId);
        
        if ($user->is_verified) {
            return redirect()->route('loginForm')->with('success', 'Email already verified!');
        }

        if ($user->isValidVerificationToken($request->otp)) {
            $user->markEmailAsVerified();
            
            return redirect()->route('loginForm')
                ->with('success', 'Email verified successfully! You can now login.');
        } else {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }
    }

    public function resendVerificationCode($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->is_verified) {
            return redirect()->route('loginForm')->with('success', 'Email already verified!');
        }

        $otp = $user->generateEmailVerificationToken();
        
        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user, $otp));
            return back()->with('success', 'Verification code sent again!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to resend verification email.']);
        }
    }
}
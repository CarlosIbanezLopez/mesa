<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Auth/Login', [
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object) [],
            'auth' => [
                'user' => null
            ],
            'flash' => [
                'status' => session('status'),
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function showRegister()
    {
        return Inertia::render('Auth/Register', [
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object) [],
            'auth' => [
                'user' => null
            ],
            'flash' => [
                'status' => session('status'),
                'success' => session('success'),
                'error' => session('error')
            ],
            'userTypes' => Usertype::where('id', 2)->get()
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'usertype_id' => 'required|exists:usertypes,id',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'usertype_id' => $request->usertype_id,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

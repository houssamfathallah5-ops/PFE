<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'artist') {
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenue sur votre espace Artiste !');
            }
            
            return redirect()->route('songs.index')->with('success', 'Bienvenue sur Melodix !');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:listener,artist',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'artist') {
            \App\Models\Artist::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'slug' => \Illuminate\Support\Str::slug($user->name) . '-' . $user->id,
                'bio' => 'Nouveau chanteur sur Melodix.',
                'monthly_listeners' => 0,
                'total_streams' => 0,
                'is_verified' => false,
            ]);
        }

        Auth::login($user);

        if ($user->role === 'artist') {
            return redirect()->route('admin.dashboard')->with('success', 'Votre compte Artiste a été créé !');
        }

        return redirect()->route('songs.index')->with('success', 'Votre compte Auditeur a été créé !');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = Storage::disk('public')->putFile('avatars', $request->file('avatar'));
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'avatar_path' => $avatarPath,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('posts.index')->with('success', '登録してログインしました。');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = (bool) $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'メールアドレスまたはパスワードが違います。'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('posts.index')->with('success', 'ログインしました。');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('posts.index')->with('success', 'ログアウトしました。');
    }
}

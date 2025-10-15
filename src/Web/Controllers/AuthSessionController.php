<?php

namespace Src\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSessionController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($cred)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Credenciales inválidas'], 401);
            }
            return back()->withErrors(['email' => 'Credenciales inválidas'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $token = $request->user()->createToken('web')->plainTextToken;
        session(['api_token' => $token]);

        return redirect()->route('web.dashboard');

        if ($request->expectsJson()) {
            return response()->json([
                'message'  => 'Bienvenido',
                'redirect' => $redirect,
            ]);
        }
        return redirect()->intended($redirect);
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();
        $request->session()->forget('api_token');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Sesión cerrada']);
        }
        return redirect()->route('web.login')->with('status', 'Sesión cerrada');
    }
}

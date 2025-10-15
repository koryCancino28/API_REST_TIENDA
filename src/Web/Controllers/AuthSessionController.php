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
            return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
        }

        // Crear token Sanctum y guardarlo en sesión para que JS lo use contra /api/v1
        $token = $request->user()->createToken('web')->plainTextToken;
        session(['api_token' => $token]);

        return redirect()->route('web.dashboard');
    }

    public function logout(Request $request)
    {
        // Opcional: revoca solo el token actual (si existiera)
        $request->user()?->currentAccessToken()?->delete();
        // Limpia sesión
        $request->session()->forget('api_token');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('web.login');
    }
}

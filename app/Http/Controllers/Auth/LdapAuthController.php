<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LdapAuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LdapAuthController extends Controller
{
    protected $ldapAuth;

    public function __construct(LdapAuthenticationService $ldapAuth)
    {
        $this->ldapAuth = $ldapAuth;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if ($user = $this->ldapAuth->authenticate($credentials['username'], $credentials['password'])) {
            Auth::login($user);
            return redirect()->intended('/dashboard');
        }

        // Generic error message as per requirements
        return back()->withErrors([
            'credentials' => 'The provided credentials are incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
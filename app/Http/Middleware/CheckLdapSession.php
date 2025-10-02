<?php

namespace App\Http\Middleware;

use App\DTO\LdapUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckLdapSession
{
    /**
     * Verify session and setup auth
     * Demo: Uses session data
     * Later: Will verify with LDAP
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        // Create auth-compatible user object
        $userData = Session::get('user');
        $user = new LdapUser($userData);
        app('auth')->setUser($user);

        return $next($request);
    }
}
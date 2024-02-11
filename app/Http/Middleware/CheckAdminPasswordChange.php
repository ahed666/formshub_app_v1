<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class CheckAdminPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user(); // Assuming 'admin' is your guard

        // Retrieve the password hash stored in the session
        $passwordHashInSession = $request->session()->get('password_hash');

        // Compare the current password hash with the one stored in the session
        if ($user && $passwordHashInSession && !Hash::check($user->getAuthPassword(), $passwordHashInSession)) {
            // Passwords don't match, indicating a password change
            Auth::guard('admin')->logout(); // Logout the admin
            return redirect()->route('admin.login'); // Redirect to login page
        }

        return $next($request);
    }
}

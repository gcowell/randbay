<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class BannedCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user();

        if (!$user)
        {
            return redirect('home');
        }

        if ($user->checkIfBanned())
        {
            Auth::logout();
            return redirect('auth/login')->withErrors(['banned' => 'This account has been suspended for repeated violations of the rules.']);
        }

        return $next($request);
    }
}

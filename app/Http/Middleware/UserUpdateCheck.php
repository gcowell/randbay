<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Contracts\Auth\Guard;

class UserUpdateCheck
{


    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->getPathInfo();
        $requested_id = str_replace("/users/", "", $path);

        $user = User::findOrFail($requested_id);

        if (!($user->id === $this->auth->id()))
        {
            return redirect('/');
        }

        return $next($request);
    }
}

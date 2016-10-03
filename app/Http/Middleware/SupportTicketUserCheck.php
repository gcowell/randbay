<?php

namespace App\Http\Middleware;

use Closure;
use App\SupportTicket;
use Illuminate\Auth\Guard;

class SupportTicketUserCheck
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
        $requested_id = str_replace("/support/", "", $path);

        $ticket = SupportTicket::findOrFail($requested_id);

        if (!($ticket->complainer_id == $this->auth->id() || $ticket->complainee_id == $this->auth->id()))
        {
            return redirect('support');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Transaction;
use Illuminate\Contracts\Auth\Guard;

class TransactionUserCheck
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
        $requested_id = str_replace("/transactions/", "", $path);

        $transaction = Transaction::findOrFail($requested_id);

        if (!($transaction->buyer_id == $this->auth->id() || $transaction->seller_id == $this->auth->id()))
        {
            return redirect('transactions');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckPermission
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
		if(Auth::check() && Auth::user()->role == 'admin')
			return $next($request);
		return abort(404);
	}
}

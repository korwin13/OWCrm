<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Config;

class CrmAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ( ! Session::get('login')) {
			Config::offsetUnset('database.connections.oracle.username');
        	Config::offsetUnset('database.connections.oracle.password');
			//TODO: check auth each time		
			return redirect('auth/login');
		}
		return $next($request);
	}

}

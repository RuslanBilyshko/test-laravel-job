<?php namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserStatusMiddleware {


	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
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

		$status = $this->auth->user()->status;
		$accessUrl = route('accountEdit');
		$currUrl = $request->url();

		if($status == config('user.status.null') && $accessUrl != $currUrl)
		{
			Auth::logout();
			setMessage(trans('app.userStatusNulleMess'),false);
			return redirect()->route('getLogin');
		}
		elseif($status == config('user.status.one') && $accessUrl != $currUrl)
		{
			setMessage(trans('app.userStatusOneMess'),false);
			return redirect($accessUrl);
		}

		return $next($request);


	}

}

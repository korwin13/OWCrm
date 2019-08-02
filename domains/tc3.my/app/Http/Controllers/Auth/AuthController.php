<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		/*$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
		*/
	}

	/**
     * Handle an authentication attempt.
     *
     * @return Response
    */
    public function authenticate()
    {
    	dd($email);
    	var_dump($password);

        Config::set('database.connections.oracle.username', $email);
        Config::set('database.connections.oracle.password', $password);
    	$test_sql = "select sysdate from dual";
    	//$results = DB::select($test_sql);
    	$conn = oci_connect($username, $password, $db);
        if ($conn) {
            // Authentication passed...
            Session::set('login', $email);
            return redirect()->intended();
        }
        else
        {
        	Session::destroy('login');
        	Config::offsetUnset('database.connections.oracle.username');
        	Config::offsetUnset('database.connections.oracle.password');
        }
    }

}

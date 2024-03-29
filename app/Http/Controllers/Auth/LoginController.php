<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// class LoginController extends Controller
// {

//     use AuthenticatesUsers;


//     protected $redirectTo = '/home';


//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
// }


namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        // Attempt authentication against the 'users' table
        if (Auth::attempt($credentials)) {
            return $credentials;
        }

        // If authentication against 'users' table failed, attempt authentication against 'students' table
        $studentCredentials = $request->only($this->username(), 'password');
        $student = \DB::table('students')
                        ->where('reg', $request->email)
                        ->first();

                        if ($student && \Hash::check($request->password, $student->password)) {
                            return redirect()->intended($this->redirectTo);
                        } else {
                            return $credentials; // Fallback to 'users' credentials if neither found in 'students' table

                        }
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
public function login(Request $request)
{
    $decrypted = $request->input('password');
    $user      = User::where('username', $request->input('email'))->first();

    if ($user) {
        if (Crypt::decryptString($user->password) == $decrypted) {
            Auth::login($user);

            return $this->sendLoginResponse($request);
        }
    }

    return $this->sendFailedLoginResponse($request);
}
    protected function authenticated(Request $request,$user){
        return response()->json($user);

    }
    protected function loggedOut(Request $request){
        return response()->json(null);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;

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

    public function init() {
        return view('pages.login.login', []);
    }

    public function signin(Request $request) {

        $oneonId = $request->oneonid;
        $password = $request->password;
        
        $query =  DB::table('t_employees')
            ->where('t_employees.oneon_id', $oneonId)
            ->select(DB::raw('
                t_employees.oneon_id,
                t_employees.mail_address_temporary
            '))
            ->where('oneon_id', $oneonId)
            ->where('mail_address_temporary', $password)
            ->first();

        if (!empty($query)) {
            session(['oneonId' => $oneonId]);
            return redirect()->route('home');
        }

        return redirect()->back();
    }
}

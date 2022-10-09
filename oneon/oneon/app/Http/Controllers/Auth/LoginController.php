<?php

namespace App\Http\Controllers\Auth;

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
                concat( t_employees.last_name, " ", t_employees.first_name) as full_name,
                t_employees.mentee_times,
                t_employees.mentor_times,
                t_employee_tags.tag_code,
                t_employee_tags.department_current_code,
                t_employee_tags.department_past_code,
                t_employee_tags.job_current_code,
                t_employee_tags.job_past_code
            '))
            ->where('oneon_id', $oneonId)
            ->where('mail_address_temporary', $password)
            ->first();

        if (empty($query)) {
            ession(['oneonId' => $oneonId]);
            return redirect()->route('home');
        }

        return redirect()->back();
    }
}

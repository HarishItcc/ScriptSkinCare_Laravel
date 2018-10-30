<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Role;
use App\User;
use App\RoleUser;
use App\Supplier;
use Session;

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

    public function redirectPath()
    {

         $check_data=RoleUser::join('roles','role_user.role_id','=','roles.id')->Where('role_user.user_id',\Auth::user()->id)->select('roles.*')->first();

         Session::put('role_user_name', $check_data->name);
         
         if ($check_data->name=='supplier_admin') {

             $data=Supplier::join('company_details','supplier_details.company_id','=','company_details.id')
            ->Where('supplier_details.user_id',\Auth::user()->id)
            ->select('company_details.business_name')->first();

            Session::put('company_name', $data->business_name);

            return route('supplierhome');
            // or return route('routename');
        }

        return "/home";
    }
    /*
    public function showLoginForm()
    {
        return view('auth.new_login');
    }
    */
}

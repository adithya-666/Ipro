<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

    public function index()
    {
        $data['tittle'] = 'Login';

        return view('auth.login', $data);
    }

    public function login(Request $request)
    {

        $credentials =   $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $checkUser = DB::table('users')->where('username', $request->username)->first();

        if ($checkUser) {

            Auth::loginUsingId($checkUser->id); // Log in the user

            $request->session()->regenerate();
            
            return redirect()->intended('dashboard');

          
        }

        return back()->with('LoginError', 'username or password do not match our records.' );
    }


    public function auth(Request $request)
    {
        // dd($request->all());

        $credentials =   $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd('masukkkk');
         
            if(Auth::user()->role === 'staff') {
              
                return redirect()->intended('dashboard');
            } elseif(Auth::user()->role === 'JKN')
            {
                return redirect()->intended('dashboard-jkn');
            }else{
                return redirect()->intended('dashboard-karu');
            }
          
        }
    }


    public function logout(Request $request)
    {
      
    
        auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}




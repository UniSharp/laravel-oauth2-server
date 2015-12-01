<?php

namespace Unisharp\Oauth2\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    protected $rules = array(
        'username' => 'required',
        'password' => 'required'
        );

    protected $messages = array(
        'username.required' => '帳號為必填項目',
        'password.required' => '密碼為必填項目'
        );

    protected $redirectPath = '/';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator;
        }
        return true;
    }

    public function index(Request $request)
    {
        $params = $request->input();

        return view('oauth2::login.index', compact('params'));
    }

    /**
    * Handle an authentication attempt.
    *
    * @return Response
    */
    public function authenticate(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator !== true) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
 
        if (\Auth::attempt([
            config('oauth2.auth_fields')['username'] => $request->input('username'),
            config('oauth2.auth_fields')['password'] => $request->input('password')
            ])) {

            $params = array_except($request->input(), ['_token', 'username', 'password']);
            return redirect()->route('oauth2.authorize.get', $params);
        }

        return redirect()->back()->withInput()->withErrors('Incorrect username or password!');

    }

}

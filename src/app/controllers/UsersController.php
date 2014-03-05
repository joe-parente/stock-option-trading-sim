<?php

class UsersController extends BaseController {

    protected $layout = "layouts.main";

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
    }

    public function getRegister() {
        $this->layout->content = View::make('users.register');
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->passes()) {
// validation has passed, save user in DB
            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->confirmation_code = str_random('24');
            $user->save();
            $mail_data = array('cc' => $user->confirmation_code);
            $this->sendConfirmEmail($user->email, $mail_data);
            return Redirect::to('users/login')->with('message', 'Thanks for '
                            . 'registering! Please check your inbox and click '
                            . 'on the link we sent you');
        } else {
// validation has failed, display error messages 
            return Redirect::to('users/register')
                            ->with('message', 'The following errors occurred')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function getLogin() {
        $this->layout->content = View::make('users.login');
    }

    public function postSignin() {
// check user confirm code...
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')))) {
            Session::put('profile', $profile);
            if (Auth::user()->confirmation_code == '') {
                return Redirect::to('users/dashboard')
                                ->with('message', 'You are now logged in!');
            } else {
                Auth::logout();
                return Redirect::to('/')
                                ->with('message', 'Please check you email for the link to confirm your account<br />'
                                        . 'If you can\'t find it, click <a href="users/resend">here</a> to resend it.');
            }
        } else {
            Auth::logout();
            return Redirect::to('users/login')
                            ->with('message', 'Your username/password combination was incorrect')
                            ->withInput();
        }
    }

    public function getDashboard() {

        $profile = Session::get('profile');

        //die(var_dump($profile));
        $this->layout->with('header', $profile->user_id);
        $this->layout->content = View::make('users.dashboard')->with('firstname', $profile->user->firstname);
    }

    public function getLogout() {
        Auth::logout();
        Session::forget('profile');
        return Redirect::to('/')->with('message', 'You have been logged out.');
    }

    public function getResend() {
        return Redirect::to('/')->with('message', 'This feature is not implemented yet.');
    }

    public function fbLogin() {
        $facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('/users/login/fb/callback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));
    }

    public function fbCallback() {
        $code = Input::get('code');
        if (strlen($code) == 0) {
            return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
        }
        $facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();

        if ($uid == 0) {
            return Redirect::to('/')->with('message', 'There was an error');
        }
        $me = $facebook->api('/me');

        $profile = Profile::whereUid($uid)->first();
        if (empty($profile)) {
            $user = new User;
            $user->firstname = $me['first_name'];
            $user->lastname = $me['last_name'];
            $user->email = $me['email'];
//$user->photo = 'https://graph.facebook.com/' . $me['username'] . '/picture?type=large';

            $user->save();

            $profile = new Profile();
            $profile->uid = $uid;
            $profile->username = $me['username'];
            $profile = $user->profiles()->save($profile);
        }
        $profile->access_token = $facebook->getAccessToken();
        $profile->save();

        $user = $profile->user;
        Auth::login($user);
        Session::put('profile', $profile);
        return Redirect::action('UsersController@getDashboard');
    }

    public function sendConfirmEmail($user_email, $data) {
        Mail::send('emails.confirm', $data, function() {
            $message->to($user_email, 'Stock Option Sim User')
                    ->subject('Welcome to the Option Simulator!');
        });
    }

}

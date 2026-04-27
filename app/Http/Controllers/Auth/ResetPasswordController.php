<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use DB;
use Mail;

class ResetPasswordController extends Controller
{

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

     /**
    * Reset the given user's password.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token'     => 'required',
            'password'  => 'required|confirmed|min:8',
        ]);

        $password_reset = \DB::table('password_resets')->where('token', $request->token)->first();
        $response='passwords.token';
        if($password_reset){
            $user=User::where('email',$password_reset->email)->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->save();
                Auth::login($user);
                $response = 'passwords.reset';
            }
        }

        switch ($response) {
            case Password::PASSWORD_RESET:
                session()->flash('status',trans($response));
                return redirect('/');
                break;
            default:
                session()->flash('error',trans($response));
                return redirect()->back();
                break;
        }
    }

    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
        Auth::login($user);
    }

    public function showReset(Request $request, $token)
    {
        return view('auth.reset', compact('token'));
    }


    public function postResetEmail(Request $request)
    {
        \Log::info('HERE');
        $this->validate($request, ['email' => 'required|email']);

        if($user = User::where('email',$request->email)->first()) {
            \Log::info('User Found');
            $token = Password::createToken($user);
            $email = $user->email;
            DB::table("password_resets")->insert([
                'email' => $email,
                'token' => $token
            ]);

            Mail::send('email.reset-password', ['user_name' => $user->name,'token' => $token], function ($message) use ($email) {
                $message->subject('Notifikasi Penyetelan Ulang Kata Sandi ');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($email);
            });
            return redirect()->back()->with('status', 'We have e-mailed your password reset link!');
        }else{
            \Log::info('User Not Found');
            return redirect()->back()->withErrors(['email' => 'These credentials do not match our records']);
        }
    }

    public function showResetEmail()
    {
        return view('auth.email');
    }

    public function showSetPassword(Request $request, $token){
        return view('auth.password-set', compact('token'));
    }

    public function setPassword(Request $request)
    {
        $this->validate($request, [
            'token'     => 'required',
            'password'  => 'required|confirmed|min:8',
        ]);

        $user = User::find(Crypt::decryptString($request->token));

        if($user) {
            $user->password = bcrypt($request->password);
            $user->is_active = true;
            $user->save();
            Auth::login($user);
            return redirect('/');
        }
        else {
            $response = 'user not found';
            session()->flash('error',$response);
            return redirect()->back();
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Str;

class StdRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function register()
    {
        return view('stdregister');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createStudent(Request $request)
    {
        $verification_code = (string) \Illuminate\Support\Str::uuid();

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'address' => $request['address'],
            'profession_occupation' => $request['profession_occupation'],
            'date' => $request['date'],
            'state' => $request['state'],
            'verification_code' => $verification_code,
            'user_type' => '1',
        ]);
        $admin_email = ['safe.envirouk@gmail.com'];

        Mail::send('verify-email-template', ['name'=>$request['name'], 'email' => $request['email'], 'uuid' =>$verification_code], function ($message) use ($request) {
            $message->to($request['email'])->subject('Student Account Verification');
        });

        return redirect('/stdlogin')->with('success', 'Account Created successfully, Please Verify Your Email');

    }

    public function verifyUserAccount($verificationCode) {
        $user = User::where('verification_code', $verificationCode)->first();

        if($user != null) {
            $user->email_verified_at = now();
            $user->save();

            $admin_email = ['safe.envirouk@gmail.com'];

            Mail::send('admin-email-template', ['name'=> $user->name, 'email' => $user->email,'phone_number' => $user->phone,
                'state' => $user->state,'profession_occupation' => $user->profession_occupation,'address' => $user->address,'dob' => $user->date], function ($message) use ($admin_email) {
                $message->to($admin_email)->subject('Student Account Created');
            });
            return redirect('/stdlogin')->with('success', 'Account Verified successfully.');
        }

        return redirect('/stdlogin')->with('error', 'Account Not Verified.');

    }
}

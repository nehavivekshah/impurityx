<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register() {
        return view('backend.register');
    }

    public function registerPost(Request $request) {

        $users = User::where('mob','=',$request->reg_mob,'AND','email','=',$request->reg_email)->get();
        if(count($users)==0){
            $user = new User();
            
            $name = explode(' ',$request->reg_name);
            //$username = explode('@',$request->reg_email);
            //$user->username = $username[0];
            $user->first_name = $name[0] ?? 'User';
            $user->last_name = $name[1] ?? '';
            $user->branch = '1';
            $user->photo = '';
            $user->dob = '';
            $user->gender = '';
            $user->mob = $request->reg_mob;
            $user->email = $request->reg_email;
            $user->password = Hash::make($request->reg_password);
            $user->role = '4';
            $user->notify = '1';
            $user->status = '1';

            $user->save();

            return back()->with('success', 'Successfully Registered!!');

            return back()->with('error', 'Oops, Somethings went worng.');
        }else{
            return back()->with('error', 'Your given details are already registered so try other details.');
        }
    }
    
    public function login() {
        return view('backend.login');
    }
    
    public function loginPost(Request $request)
    {
        $credentials = [
            'email' => $request->login_email,
            'password' => $request->login_password,
        ];
    
        // Logout buyer & seller
        Auth::guard('web')->logout();
        Auth::guard('seller')->logout();
        session()->invalidate();
        session()->regenerateToken();
    
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
    
            if ($user->role == '1' || $user->role == '2' || $user->role == '3') {
                session(['users' => $user]);
    
                $settings = Settings::where('role', $user->role)->get();
                session(['settings' => $settings]);
    
                return redirect('/admin')->with('success', 'Successfully Logged In');
            }
    
            Auth::guard('admin')->logout();
            return back()->with('error', 'You are not authorized as admin.');
        }
    
        return back()->with('error', 'Invalid login credentials.');
    }

    
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/admin/login')->with('success', 'Successfully Logged Out.');
    }

}

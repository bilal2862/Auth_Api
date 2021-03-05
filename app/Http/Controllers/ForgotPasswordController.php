<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;
class ForgotPasswordController extends Controller
{
    //
    public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);
            // dd($credentials);
        Password::sendResetLink($credentials);

        return response()->json(["msg" => 'Reset password link sent on your email id.','status'=>'200','data'=>'']);
    }



   public function reset(Request $request) {
      
        $credentials =request()->validate( [
          
            'email' => 'required|email',
              'password' => 'min:6|required_with:password_confirmation',
            'password_confirmation' => 'min:6',
            'token' => 'required|string'
            ]);
        
        // dd($credentials);
      
        $credentials['password'] = Hash::make($request->password);
        $credentials['password_confirmation'] = Hash::make($request->password_confirmation);

        // dd($credentials);
         
        $reset_password_status = Password::reset($credentials, function($user, $password) {
           
        
            $user->password = $password;
            
            $user->save();

        });
        // dd($reset_password_status);
      
        
        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided",'status'=>'404','data'=>'']);
        }

        return response()->json(["msg" => "Password has been successfully changed",'status'=>'200','data'=>'']);
    }


}

<?php

namespace App\Http\Controllers;
use League\OAuth2\Server\Exception\OAuthServerException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
// namespace App\Exceptions;
// 
use Exceptions;
// App\Exceptions\Handler;


class AuthController extends Controller
{
    public function register(Request $request)
    {

        $data=request()->validate(['name'=>'required',
        'password'=>'required',
        'email'=>'email|required'
      
        ]);

        $data['password'] = Hash::make($request->password);
        // dd($data);
       
        $user=User::create($data);
      
        $accessToken=$user->createToken('authToken')->accessToken;
    
      
        return response()->json(["msg" => "success", 'status'=>200,'user'=>$user,'accessToken'=>$accessToken ]);
        
     
    

}
   


    public function login(Request $request)
    {
        $data=request()->validate(['name'=>'required',
        'password'=>'required',
        'email'=>'email|required'
        ]);

        
        
        if(!auth()->attempt($data))
        {
            return response()->json(["msg" => "invalid crediantial", 'status'=>400,'data'=>'']);
        }

        
        $accessToken=auth()->user()->createToken('authToken')->accessToken;

        return response()->json(["msg" => "success", 'status'=>200,'user'=>auth()->user(),
        'accessToken'=>$accessToken 
        ]);
    }


    public function logout(Request $request)
    {
     
       $chk= $request->user()->token()->revoke();

      

        return response()->json(["msg" => "successfully log out", 'status'=>200,'data'=>'']);
    }


    
    public function show()
    {
     
        
        
    try {
    
        return response()->json(["msg" => "success", 'status'=>200,'user' => auth()->user()], 200);
    } catch (OAuthServerException $exception) {
        return response()->json(["msg" => "fail",]);
    }
      

   
}

}

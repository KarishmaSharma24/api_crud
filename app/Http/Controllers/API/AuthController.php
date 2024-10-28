<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ResponseTrait;
    public function register(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->errorResponse('Validation Error.', $validator->errors(), 400);       
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken($input['email'])->plainTextToken;
        $success['name'] =  $user->name;
        return $this->successResponse('User register successfully.', $success, 200 );
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            
        ]);
        if($validator->fails()){
            return $this->errorResponse('Validation Error.', $validator->errors(), 400);       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

            $user = Auth::user(); 

            $user->token =  $user->createToken($user->email)->plainTextToken; 

            return $this->successResponse('User login successfully.' ,$user, 200);

        } 

        return $this->errorResponse("Invalid Credentials",'',401);
 
    }
}

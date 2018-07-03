<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{

	public $loginAfterSignUp = true;

    public function register(Request $request){

    	$this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string|min:3|max:15',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|min:9|max:15',
            'date_of_birth' => 'required|date'
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        $user->save();

        if ($this->loginAfterSignUp)
            return $this->login($request);
        

        return response()->json([
            'success' => true,
            'result' => $user
        ], 200);
    }

    public function login(Request $request){
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'result' => 'Invalid Email or Password',
            ]);
        }
        JWTAuth::setToken($jwt_token);
        $user = JWTAuth::toUser();    
        return response()->json([
            'success' => true,
            'result' => ['token' => $jwt_token , 'user' =>$user ],
        ]);
    }

    public function logout(Request $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'result' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'result' => 'Sorry, the user cannot be logged out'
            ]);
        }
    }

    public function getAuthUser(Request $request){
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json([
            'success' => true,
            'result' => $user
            ]);
    }

    public function updateUsrData(Request $request){

        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);
        
        $attrs = array();
        if($request->has('username'))
            $attrs['username'] = $request->username;

        if($request->has('password')){
            if(! Hash::check($request->oldPass , $user->password))
                return response()->json([
                    'success' => false,
                    'result' => 'password is incorrect'
                ]); 

            $attrs['password'] = bcrypt($request->password);
        }
            

        if($request->has('phone_number'))
            $attrs['phone_number'] = $request->phone_number;

        if($request->has('date_of_birth'))
            $attrs['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));

        if($user->role == "10"){
            if($request->has('role'))
            $attrs['role'] = $request->role;

            if($request->has('is_approved'))
                $attrs['is_approved'] = $request->is_approved;

            if($request->has('is_active'))
                $attrs['is_active'] = $request->is_active;
        }
           
        if(User::whereId($user->id)->update($attrs))
            return response()->json([
                'success' => true,
                'result' => 'updated Successfully'
            ]);

        return response()->json([
            'success' => false,
            'result' => 'Sorry, the user cannot be updated'
        ]);
        
    }

}

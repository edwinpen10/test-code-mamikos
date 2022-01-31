<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseFormatter;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {

       $this->validate($request, [
            'name' => 'required',
            'number_phone' => 'required|numeric|digits:12',
            'password' => 'required',
            'user_type' => 'required',
        ]);
       
        try {

            User::create([
                'name' => $request->name,
                'number_phone' => $request->number_phone,
                'password' => bcrypt($request->password),
                'email' => $request->email == null ?  null : $request->email,
                'user_type' => $request->user_type === 'regular' ? 'regular':'premium',
                'credit_user' => $request->user_type === 'regular' ? 20 : 40
            ]);


            return ResponseFormatter::success(true,null,'Register account success');

        } catch (\Throwable $e) {
             
            return ResponseFormatter::error(false,$e);

        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = request(['number_phone', 'password']);
    
            $user = User::where('number_phone',$credentials['number_phone'])->first();
    
        
            if ($token = Auth::guard('api')->attempt($credentials) ) {
                return $this->respondWithToken($token, 'owner');
                
            }else{
                return ResponseFormatter::error(false,'Number phone or password is not valid',401);
            }
    
        } catch (JWTException $e) {
            return ResponseFormatter::error(false,'Could not create token. Please try again');
            
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $owner)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'account' => auth($owner)->user()
        ];

        return ResponseFormatter::success(true,$data,'Login success');
    }
}

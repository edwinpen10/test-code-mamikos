<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OwnerModel;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ResponseFormatter;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    


    public function register(Request $request)
    {

       $this->validate($request, [
            'name' => 'required',
            'number_phone' => 'required|numeric|digits:12',
            'password' => 'required'
        ]);
       
        try {

            OwnerModel::create([
                'name' => $request->name,
                'number_phone' => $request->number_phone,
                'password' => bcrypt($request->password),
            ]);

            
            $meta = [
                'code' => 200,
                'response_code' => 200,
                'message' => 'Register account success',
            ];

            return ResponseFormatter::success(true,null,'Register account success');

        } catch (\Throwable $e) {
             
            return ResponseFormatter::error(false,$e);

        }
    }


    public function login()
    {

    try {
        $credentials = request(['number_phone', 'password']);

        $user = OwnerModel::where('number_phone',$credentials['number_phone'])->first();

    
        if ($token = Auth::guard('owner')->attempt($credentials) ) {
            return $this->respondWithToken($token, 'owner');
            
        }else{
            return ResponseFormatter::error(false,'Number phone or password is not valid',401);
        }

    } catch (JWTException $e) {
        return ResponseFormatter::error(false,'Could not create token. Please try again');
        
    }
    
       
    }

    public function me()
    {
        return response()->json(auth()->user());
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

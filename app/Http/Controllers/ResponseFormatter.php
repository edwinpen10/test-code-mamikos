<?php 

namespace App\Http\Controllers;

class ResponseFormatter {

    protected static $response =[
        'status' => null,
        'meta' => [
            'code' => 200,
            'response_code' => 200,
            'message' => null
        ],
        'data' => null
    ];

    public static function success($status =null, $data = null, $message = null)
    {
       self::$response['status']=$status;
       self::$response['meta']['message']=$message;
       self::$response['data']=$data;

       return response()->json(self::$response,200);
    }

    public static function error($status =false, $message = null, $code=400)
    {
        
       self::$response['status']=$status;
       self::$response['meta']['code']=$code;
       self::$response['meta']['response_code']=$code;
       self::$response['meta']['message']=$message;

       return response()->json(self::$response,$code);
    }

}
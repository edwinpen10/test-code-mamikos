<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseFormatter;

class AskRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function askroom()
    {
        try {
            DB::transaction(function () {
                DB::table('users')->where('id',auth()->user()->id)->decrement('credit_user',5);
            });
            return ResponseFormatter::success(true,null,'Ask room user success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(false,$th);
        }
        
    }

}

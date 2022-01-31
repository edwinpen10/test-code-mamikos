<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseFormatter;
use App\Models\KostModel;
use Illuminate\Support\Str;

class KostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owner');
    }

    public function kostlist()
    {
        try {
            $data =  KostModel::where('id_owner', auth()->user()->id)->get();

            return ResponseFormatter::success(true,$data,'Get data kost success');
        } catch (\Throwable $th) {

            return ResponseFormatter::error(false,$e);
        }
        
    }

    public function addkost(Request $request)
    {
        $this->validate($request, [
            'title_kost' => 'required',
            'gender' => 'required|numeric|digits:1',
            'province' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'building_year' => 'required|string',
            'price' => 'required|numeric'
        ]);
        
        try {

            $data = KostModel::create([
                'id_owner' => auth()->user()->id,
                'title_kost' => $request->title_kost,
                'gender' => $request->gender,
                'province' => $request->province,
                'city' => $request->city,
                'address' => $request->address,
                'description' => $request->description,
                'building_year' => $request->building_year,
                'price' => $request->price,
                'slug_title' => Str::slug($request->province.' '.$request->city.' '.$request->title_kost.' '.$request->price,'-')
            ]);
               

            return ResponseFormatter::success(true,$data,'Create data kost success');

        } catch (\Throwable $e) {
            return ResponseFormatter::error(false,$e);
        }
    }

    public function updatekost(Request $request, KostModel $id)
    {

        $this->validate($request, [
            'gender' => 'numeric|digits:1',
            'province' => 'string',
            'city' => 'string',
            'address' => 'string',
            'description' => 'string',
            'building_year' => 'string',
            'price' => 'numeric'
        ]);


        try {
            
            $input = $request->all();

            $id->fill($input)->save();

            return ResponseFormatter::success(true,$id,'Update data kost success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(false,$th);
        }
    }

    public function deletekost($id)
    {
        try {

           $data = KostModel::where('id',$id)->where('id_owner', auth()->user()->id)->first();
           $data->delete();
          
            return ResponseFormatter::success(true,null,'Delete data kost success');
          

        } catch (\Throwable $e) {
            return ResponseFormatter::error(false,'Data kost not exists');
        }
    }
}

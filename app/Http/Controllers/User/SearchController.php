<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KostModel;
use App\Http\Controllers\ResponseFormatter;
use App\Http\Resources\DataKostResource;

class SearchController extends Controller
{
    public function search(Request $request)
    {
      
        try {

            $query =  KostModel::when($request->q, function ($query) use ($request) {
                return $query->where('slug_title','LIKE','%'. $request->q.'%');
            })->when($request->price, function ($query) use ($request) {
                return $query->where('price','<=', $request->price);
            })->when($request->sort, function ($query)  use ($request) {
                return $request->sort == true ?  $query->orderByDesc('price') :  $query->orderBy('price'); 
            })->select('title_kost',
            'slug_title',
            'title_kost','gender',
            'province','city',
            'address','description',
            'building_year','price')->paginate(5);
           
            return ResponseFormatter::success(true,$query,'Get data kost success');
        } catch (\Throwable $th) {

            return ResponseFormatter::error(false,$th);
        }
    }

    public function detailkost($slug)
    {
       try {

        $data = KostModel::where('slug_title',$slug)->select('title_kost',
        'slug_title',
        'title_kost','gender',
        'province','city',
        'address','description',
        'building_year','price')->first();

        return ResponseFormatter::success(true,$data,'Get data kost success');
       } catch (\Throwable $th) {
         return ResponseFormatter::error(false,$th);
       }
    }
    
}

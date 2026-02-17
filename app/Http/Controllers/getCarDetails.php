<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\stringContains;

class getCarDetails
{
    public function getMaker(Request $request){
        $query = $request->input("query");
        // $res = Http::get(config('services.carapi.url')."/api/makes/v2?make=".$query);
        // return $res;
        $data = Storage::json("all_orphaned_styles.json");
        $makes = array_keys($data);
        return response()->json([
            "data" => collect($makes)
                ->filter(fn($value) => str_contains(strtolower($value), strtolower($query)))
                ->sortBy(function ($value) use ($query) {
                    return str_starts_with(strtolower($value), strtolower($query)) ? 0 : 1;
                })
                ->values()
                ->all()
        ]);
    }
    public function getModel($maker){

        $data = Storage::json("all_orphaned_styles.json");
        // $res = Http::get(config('services.carapi.url')."/api/models/v2?make=".$maker);
        // return $res;
        return response()->json(["data"=>
            $data[$maker]
        ]);

    }
}


<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Response;


class LocationController extends Controller
{

    public function index()
    {
       $locations = Location::orderBy('name')
           ->get()
           ->transform(function ($obj) {
               return [
                   'id' => $obj->id,
                   'name' => $obj->name,
               ];
           });

       return response()->json([
           'status' => 1,
           'data' => $locations,
       ], Response::HTTP_OK);
    }
}

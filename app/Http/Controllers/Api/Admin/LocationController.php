<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;


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
       ], Responce::HTTP_OK);
    }
}

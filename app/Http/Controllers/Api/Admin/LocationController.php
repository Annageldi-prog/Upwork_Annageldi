<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;


class LocationController extends Controller
{

    public function index()
    {
        $objs = Location::all()->get();

        return response()->json([
            'status' => 1,
            'data' => $objs,
        ], Response::HTTP_OK);
    }
}

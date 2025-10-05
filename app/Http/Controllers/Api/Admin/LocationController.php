<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;


class LocationController extends Controller
{
    public function index()
    {
        return response()->json(Location::all());
    }
}

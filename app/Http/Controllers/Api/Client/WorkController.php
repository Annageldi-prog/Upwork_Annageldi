<?php

namespace App\Http\Controllers\Api\Client;


use App\Http\Controllers\Controller;
use App\Models\Work;

class WorkController extends Controller
{
    public function index()
    {
        return Work::all();
    }
}

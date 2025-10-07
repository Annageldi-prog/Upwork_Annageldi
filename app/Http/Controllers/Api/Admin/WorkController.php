<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Models\Work;
use Symfony\Component\HttpFoundation\Response;

class WorkController extends Controller
{
    public function index()
    {
        $objs = Work::all()->get();

        return response()->json([
            'status' => 1,
            'data' => $objs,
        ], Response::HTTP_OK);
    }
}

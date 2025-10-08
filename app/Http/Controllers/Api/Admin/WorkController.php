<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Work;


class WorkController extends Controller
{
    public function index()
    {
        $works = Work::orderBy('name')
            ->get()
            ->transform(function ($obj) {
                return [
                    'id' => $obj->id,
                    'name' => $obj->name,
                ];
            });

        return response()->json([
            'status' => 1,
            'data' => $works,
        ], Response::HTTP_OK);
    }
}

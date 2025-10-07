<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Work;
use Symfony\Component\HttpFoundation\Response;

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
            'data' => $skills,
        ], Responce::HTTP_OK);
    }
}

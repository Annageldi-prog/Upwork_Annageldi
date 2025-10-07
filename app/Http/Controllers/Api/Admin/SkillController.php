<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Skill;


class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('name')
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

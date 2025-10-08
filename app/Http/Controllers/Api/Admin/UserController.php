<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')
            ->get()
            ->transform(function ($obj) {
                return [
                    'id' => $obj->id,
                    'name' => $obj->name,
                ];
            });

        return response()->json([
            'status' => 1,
            'data' => $users,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors(),
            ],   Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name'     => $request->get('name'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json([
            'message' => 'Ulanyjy üstünlikli döredildi',
            'user'    => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        $obj = User::withCount('responses')
            ->findOrFail($id);

        if ($obj->user_count > 0) {
            return response()->json([
                'status' => 1,
                'message' => 'Ulanyjy tapylmady',
            ], Response::HTTP_OK);
        }

        $obj->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Ulanyjy pozuldy',
        ], Response::HTTP_OK);
    }
}





<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make([
            'name'     => $request->get('name'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ], [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Ulanyjy tapylmady'], 404);
        }

        $validator = Validator::make([
            'name'     => $request->get('name'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        ], [
            'name'     => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $id,
            'password' => 'sometimes|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->get('name')) {
            $user->name = $request->get('name');
        }

        if ($request->get('username')) {
            $user->username = $request->get('username');
        }

        if ($request->get('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        return response()->json([
            'message' => 'Ulanyjy täzelendi',
            'user' => $user
        ]);
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





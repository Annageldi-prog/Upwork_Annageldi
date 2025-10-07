<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::get();
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|unique:clients,username',
            'password'   => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Müşderi döredildi',
            'client'  => $client,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Müşderi tapylmady'], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|string|max:255',
            'last_name'  => 'sometimes|string|max:255',
            'username'   => 'sometimes|string|unique:clients,username,' . $id,
            'password'   => 'sometimes|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('first_name')) $client->first_name = $request->first_name;
        if ($request->has('last_name'))  $client->last_name = $request->last_name;
        if ($request->has('username'))   $client->username = $request->username;
        if ($request->has('password'))   $client->password = Hash::make($request->password);

        $client->save();

        return response()->json([
            'message' => 'Müşderi täzelendi',
            'client'  => $client,
        ]);
    }

    public function destroy($id)
    {
        $obj = Client::withCount('contracts')
            ->findOrFail($id);

        if ($obj->contracts_count > 0) {
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

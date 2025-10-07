<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Work;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ClientController extends Controller
{
    public function index()
    {
        $objs = Client::all()->get();

        return response()->json([
            'status' => 1,
            'data' => $objs,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
        ]);

        $client = Client::create($data);

        return response()->json($client, 201);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $data = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $client->id,
        ]);

        $client->update($data);

        return response()->json($client);
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}

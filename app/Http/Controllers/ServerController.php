<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ServerRepository;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Server::with('requests')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return ServerRepository::save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        return Server::with('requests')->find($server->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        return ServerRepository::save($request, $server);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        return response($server->delete());
    }

    /**
     * Upload a server image/avatar to storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Server $server)
    {
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return response()->json(['error' => 'No se encontó una imagen o la imagen no es válida'], 500);
        }

        $path = $request->file('image')->store('images', 'public');

        $server->avatar = env('APP_URL') . '/storage/' . $path;

        $server->saveOrFail();

        return Server::with('requests')->find($server->id);
    }
}

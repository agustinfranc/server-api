<?php

namespace App\Http\Controllers;

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
        $validatedData = $request->validate([
            'ip' => 'required',
            'host' => 'required',
            'description' => 'max:255',
            'avatar' => 'max:255',
        ]);

        $server = new Server();

        $server->fill($validatedData);

        $server->saveOrFail();

        return Server::with('requests')->find($server->id);
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
        $validatedData = $request->validate([
            'ip' => 'required',
            'host' => 'required',
            'description' => 'max:255',
            'avatar' => 'max:255',
        ]);

        $server->fill($validatedData);

        $server->saveOrFail();

        return Server::with('requests')->find($server->id);
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
}

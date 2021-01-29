<?php

namespace App\Http\Repositories;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerRepository
{
    public static function save(Request $request, Server $server = null): Server
    {
        $validatedData = $request->validate([
            'ip' => 'required|max:255',
            'host' => 'required|max:255',
            'description' => 'max:255',
            'avatar' => 'max:255',
        ]);

        if (!$server) {
            $server = new Server();
        }

        $server->fill($validatedData);

        $server->saveOrFail();

        return Server::with('requests')->find($server->id);
    }

    public static function sort(array $servers): void
    {
        if (empty($servers)) {
            abort(400, 'There is no servers');
        }

        foreach ($servers as $position => $server) {
            $server = Server::findOrFail($server['id']);

            $server->sort = $position;

            $server->saveOrFail();
        }
    }
}

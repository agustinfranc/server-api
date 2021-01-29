<?php

namespace App\Http\Repositories;

use App\Models\Request as ModelsRequest;
use App\Models\Server;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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

    public static function getOne($server): Server
    {
        $now = Carbon::now()->timestamp;

        $unixTimestamp = (int) round($now / 60);

        $requests = [];

        for ($i = 0; $i < 6; $i++) {
            $rawQuery = ModelsRequest::selectRaw('SUM(process) as process, SUM(session) as session, UNIX_TIMESTAMP(created_at) DIV 60 as group_date')
                ->whereServerId($server->id)
                ->whereRaw('UNIX_TIMESTAMP(created_at) DIV 60 = ' . $unixTimestamp)
                ->groupBy('group_date')
                ->get();

            array_push($requests, $rawQuery);

            $unixTimestamp--;
        }

        $server->requests = $requests;

        return $server;
    }

    public static function getAll(): Collection
    {
        return Server::orderBy('sort')->get();
    }
}

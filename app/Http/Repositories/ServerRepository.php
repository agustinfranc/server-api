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
        $intervalScale = 60;
        $intervalNumber = 7;

        $now = Carbon::now()->timestamp;

        $interval = (int) round($now / $intervalScale);

        $interval -= $intervalNumber;

        $requests = [];

        for ($i = 0; $i < $intervalNumber; $i++) {
            $request = ModelsRequest::selectRaw('AVG(process) as process, AVG(session) as session, UNIX_TIMESTAMP(created_at) DIV ' . $intervalScale . ' as timestamp')
                ->whereServerId($server->id)
                ->whereRaw('UNIX_TIMESTAMP(created_at) DIV ' . $intervalScale . ' = ' . $interval)
                ->groupBy('timestamp')
                ->first();

            if (!$request) {
                array_push($requests, [
                    'process' => 0,
                    'session' => 0,
                    'timestamp' => $interval * $intervalScale,
                ]);
            } else {
                array_push($requests, $request);
            }

            $interval++;
        }

        $server->requests = $requests;
        $server->intervalScale = $intervalScale;
        $server->intervalNumber = $intervalNumber;

        return $server;
    }

    public static function getAll(): Collection
    {
        return Server::orderBy('sort')->get();
    }
}

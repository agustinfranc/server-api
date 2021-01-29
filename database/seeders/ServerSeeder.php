<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servers')->insert([
            [
                'id' => 1,
                'ip' => '127.0.0.1',
                'host' => 'localhost',
            ],
            [
                'id' => 2,
                'ip' => '192.168.0.1',
                'host' => 'host1',
            ],
            [
                'id' => 3,
                'ip' => '192.168.0.2',
                'host' => 'host2',
            ],
            [
                'id' => 4,
                'ip' => '192.168.0.3',
                'host' => 'host3',
            ],
            [
                'id' => 5,
                'ip' => '192.168.0.4',
                'host' => 'host4',
            ],
        ]);
    }
}

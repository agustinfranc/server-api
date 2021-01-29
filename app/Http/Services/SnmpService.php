<?php

namespace App\Http\Services;

use Ndum\Laravel\Facades\Snmp;

class SnmpService
{
    private $_snmp;

    public function __construct(string $ip = '127.0.0.1') {
        $this->_snmp = Snmp::newClient($ip, 1, 'public');
    }

    public function getRequest() {
        $process = $this->_snmp->getValue('1.3.6.1.2.1.25.1.6.0');  //Procesos

        $session = $this->_snmp->getValue('1.3.6.1.2.1.25.1.5.0');  //Sesiones

        return [
            'process' => $process,
            'session' => $session,
        ];
    }
}
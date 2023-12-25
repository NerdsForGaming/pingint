<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/ping', function ($request, $response, $args) {
    $ip = $request->getQueryParam('ip');
    if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP)) {
        $data = [
            'error' => 'Invalid IP address provided'
        ];
        return $response->withJson($data, 400); // Bad Request
    }

    $pingResult = getPing($ip);

    $data = [
        'ip_address' => $ip,
        'ping_result' => $pingResult,
    ];

    return $response->withJson($data);
});

function getPing($ip) {
    $output = [];
    $command = 'ping -c 4 ' . $ip;

    exec($command, $output);

    $ping_time = '';
    foreach ($output as $line) {
        if (strpos($line, 'time=') !== false) {
            $start_pos = strpos($line, 'time=') + strlen('time=');
            $end_pos = strpos($line, 'ms', $start_pos);
            $ping_time = substr($line, $start_pos, $end_pos - $start_pos);
            break;
        }
    }

    return $ping_time !== '' ? $ping_time . ' ms' : 'Ping failed';
}

$app->run();

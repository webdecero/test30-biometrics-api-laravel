<?php
return [
    'matcher' =>   [
        'url' =>  env('SOCKET_IO_HOST_MATCHER', 'http://localhost'),
        'port' =>  env('SOCKET_IO_PORT_MATCHER', '9092'),
        'options' => [
            'log' =>  env('SOCKET_IO_LOG', "logs/socket.log"),
            'client' => env('SOCKET_IO_CLIENT_VERSION', 4), //Client::CLIENT_4X
            'transport' => env('SOCKET_IO_TRANSPORT', 'websocket'),
        ]

    ],
    'notify' => [
        'url' =>  env('SOCKET_IO_HOST_NOTIFY', 'http://localhost'),
        'port' =>  env('SOCKET_IO_PORT_NOTIFY', '4001'),
        'options' => [
            'log' =>  env('SOCKET_IO_LOG', "logs/socket.log"),
            'client' => env('SOCKET_IO_CLIENT_VERSION', 4), //Client::CLIENT_4X
            'transport' => env('SOCKET_IO_TRANSPORT', 'websocket'),
        ]

    ]
];

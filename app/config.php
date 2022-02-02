<?php

return [
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'passwd' => 'root',
        'dbname' => 'dentarium'
    ],
    'mode' => 'dev',
    'layouts' => [
        'public' => [],
        'protected' => [
            'cab' => 'user',
            'panel' => 'administrator'
        ]
    ]
];
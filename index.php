<?php

include 'vendor/autoload.php';

// specify the path to the log file when creating new class object
$logger = new \App\Logger('logs.txt');

$massage = 'new message';
$context = [
    'a' => 'a error',
    'b' => 'b error',
    'c' => 'c error',
];

// write using a method that corresponds to the log level
$logger->info($massage, $context);

// pass the log level as an argument directly to the method write
$logger->write('info', $massage, $context);

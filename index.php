<?php

require __DIR__ . '/app/autoload.php';

try {
    session_start();
    \app\App::run();
} catch (Throwable $e) {
    echo '<pre>';
    if((include __DIR__ . '/app/config.php')['mode'] === 'dev') {
        echo 'Error code: ' . $e->getMessage() . '<br /><br />';
        echo 'Trace: ' . $e->getTraceAsString() . '<br /><br />';
        echo 'File: ' . $e->getFile() . '<br /><br />';
        echo 'Line: ' . $e->getLine() . '<br /><br />';
    } else {
        echo 'Сервис временно не работает по неизвестным причинам... Мы уже работаем над решением проблемы';
    }
    echo '</pre>';
}
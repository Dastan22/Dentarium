<?php

spl_autoload_register(function ($class) {
    $classname = '';
    foreach (explode('\\', $class) as $i => $v) {
        if($i === 0) {
            continue;
        }
        $classname .= '/' . $v;
    }
    $classname .= '.php';
    include_once __DIR__ . $classname;
});
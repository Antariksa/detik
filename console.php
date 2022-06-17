<?php
require_once __DIR__ . "/app/Autoload.php";

if (isset($argc)) {
    $class = '\\console\\' . $argv[1];
    $function = $argv[2];
    $param = [];

    if ($argc > 3) {
        for ($i = 3; $i < $argc; $i++) {
            array_push($param, $argv[$i]);
        }
    }

    return call_user_func([new $class(), $function], $param);
}

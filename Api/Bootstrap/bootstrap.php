<?php

require_once "./vendor/autoload.php";
require_once "./Api/Http/Middlewares/middlewaresMap.php";

DotEnv\DotEnv::fill(".env");

Http\Http::CORS();

findPhpFiles("./Api/Http/Routes");

Http\Http::run();

function findPhpFiles($dir, $results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                require_once $path;
            }
        } else if ($value != "." && $value != "..") {
            $results = findPhpFiles($path, $results);
        }
    }
}
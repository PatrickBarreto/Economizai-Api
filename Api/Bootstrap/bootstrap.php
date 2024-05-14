<?php

require_once "./vendor/autoload.php";
require_once "./Api/Http/Middlewares/middlewaresMap.php";

DotEnv\DotEnv::fill(".env");

//To remove error alert for production environment
//
//Api\Common\Error\ErrorHandler::prepareErrorHandler();

Api\Common\Log\Log::storageLogRoute('./.Log');

Http\Http::CORS(['*'],
                 ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                 ['Content-Type','Access-Token', 'Authorization'], 
                 false, 
                 ['Content-Type', 'Authorization'
                ]);

findPhpFiles("./Api/Http/Routes");

Authorizer\JWT\JWT::fillSecretKey(getenv('SECRET_KEY'));

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
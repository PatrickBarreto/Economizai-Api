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

Http\Http::loadRoutesFromPath("./Api/Http/Routes");

Authorizer\JWT\JWT::fillSecretKey(getenv('SECRET_KEY'));

Http\Http::run();

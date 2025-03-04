<?php

namespace Api\Http\Middlewares\Authorization;

use Api\Common\Log\Log;
use Authorizer\JWT\JWT;
use Exception\Exception;
use Http\Middleware\MiddlewareInterface;


class Authorization implements MiddlewareInterface {
    
    public function handler($request, $callback){

        if(isset($request->getHeaders()['Authorization']) && $token = $request->getHeaders()['Authorization']){

            if((stripos($token, 'Bearer ')) !== false){
                $token = substr($token, stripos($token, 'Bearer ') + 7);
            }

            if(JWT::validadeToken($token)) {
                $payload = JWT::getPayload($token);
                if($payload){
                    $request->currentUser = $payload->userData->id;
                }
                return $callback($request);
            }
            Exception::throw('Invalid token', 403);
        }else {
            Exception::throw('Access denied', 403);
        }
    }
}
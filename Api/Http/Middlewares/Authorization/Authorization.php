<?php

namespace Api\Http\Middlewares\Authorization;

use Authorizer\JWT\JWT;
use Exception\Exception;
use Http\Middleware\MiddlewareInterface;


class Authorization implements MiddlewareInterface {
    
    public function handler($request, $callback){

        if(isset($request->getHeaders()['Authorization']) && $JWT = $request->getHeaders()['Authorization']){
            if(JWT::validadeToken($JWT)) {
                $payload = JWT::getPayload($JWT);
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
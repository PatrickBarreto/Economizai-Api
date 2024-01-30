<?php

namespace Api\Http\Middlewares\Authorization;

use Exception\Exception;
use Http\Middleware\MiddlewareInterface;


class Authorization implements MiddlewareInterface {
    
    public function handler($request, $callback){

        if(isset($request->getHeaders()['Authorization'])){
            //Authorization token é gerado no banco de dados no momento do login e será implementado depois no fluxo de auth, task já criada.
            $authorization = "MTg=";
            if($authorization != $request->getHeaders()['Authorization']){
                Exception::throw('Access denied', 403);
            }

            $request->currentUser = base64_decode($authorization);

        }else {
            Exception::throw('Access denied', 403);
        }

        return $callback($request);
    }
}
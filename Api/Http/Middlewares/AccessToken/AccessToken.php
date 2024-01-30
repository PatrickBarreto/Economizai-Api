<?php

namespace Api\Http\Middlewares\AccessToken;

use Exception\Exception;
use Http\Middleware\MiddlewareInterface;


class AccessToken implements MiddlewareInterface {
    
    public function handler($request, $callback){

        if(isset($request->getHeaders()['Access-Token'])){
            //O AccessToken é gerado no banco de dados com base no ambiente, já tem uma task criada
            $accessToken = "bG9jYWxob3N0";
            if($accessToken != $request->getHeaders()['Access-Token']){
                Exception::throw('Access denied', 403);
            }
        }else {
            Exception::throw('Access denied', 403);
        }

        $request->accessToken = $accessToken;
        return $callback($request);
    }
}
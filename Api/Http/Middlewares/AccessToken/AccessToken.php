<?php

namespace Api\Http\Middlewares\AccessToken;

use Exception\Exception;
use Http\Middleware\MiddlewareInterface;
use DataBase\Crud;


class AccessToken implements MiddlewareInterface {
    
    public function handler($request, $callback){

        if(isset($request->getHeaders()['Access-Token'])){ 
            $accessTokenCrud = new Crud('app_access_tokens');
            $accessToken = $accessTokenCrud->select->setFields(['*'])->setWhere('business = "'.getenv('ENVIRONMENT').'"')->fetchObject(false);

            if($accessToken->expires_in <= time() ){
                if($accessToken->expired == 0){
                    $accessTokenCrud->update->setSet(['expired' => '1'])->setWhere('id = '.$accessToken->id)->runQuery();
                }
                Exception::throw('Access denied', 403);
            }

            if($accessToken->token_hash != $request->getHeaders()['Access-Token']){
                Exception::throw('Access denied', 403);
            }
        }else {
            Exception::throw('Access denied', 403);
        }

        $request->accessToken = $accessToken->token_hash;
        return $callback($request);
    }
}
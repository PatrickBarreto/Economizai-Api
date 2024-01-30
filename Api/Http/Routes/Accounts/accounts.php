<?php

use Http\Http;
use Api\Controller\Accounts\Account;


Http::post('/accounts', 
    function($request){
        (new Account)->createAccount($request->getBody());
        Http::response();
    }
);

Http::get('/accounts/{id}', 
    function($request){
        $return = (new Account)->getAccountData((int)$request->getPathParams()['id']);
        Http::response($return);
    }, 
    ['Auth']
);

Http::put('/accounts/{id}',
    function($request){
        (new Account)->updateAccount($request->getBody(), (int)$request->getPathParams()['id']);
        Http::response();
    },
    ['Auth']
);

Http::delete('/accounts/{id}', 
    function($request){
        (new Account)->deleteAccount((int)$request->getPathParams()['id']);
        Http::response();
    }, 
    ['Auth']
);
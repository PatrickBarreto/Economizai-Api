<?php

use Api\Controller\ShoppingLists\ShoppingList;
use Http\Http;

Http::post('/shopping-list/create', 
            function($request){
                ShoppingList::createShoppingList($request);
                Http::response();
            },['Auth']);



Http::post('/shopping-list/{id}/create/hash', 
            function($request){
                $hash = ShoppingList::createHash($request);
                Http::response();
            },['Auth']);



Http::get('/shopping-list', 
            function($request){
                $return = ShoppingList::findUsersShoppingLists($request->currentUser);
                Http::response($return);
            },['Auth']);


Http::get('/shopping-list/{id}', 
            function($request){
                Http::response(ShoppingList::findShoppingList($request));
            },['Auth']);


Http::put('/shopping-list/{id}', 
            function($request){
                ShoppingList::updateShoppingList($request);
                Http::response();
            },['Auth']);


Http::delete('/shopping-list/{id}', 
            function($request){
                ShoppingList::deleteShoppingList($request);
                Http::response();
            },['Auth']);
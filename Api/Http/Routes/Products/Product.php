<?php

use Api\Controller\Products\Product;
use Http\Http;

Http::post('/product', 
            function($request){
                Product::createProduct($request);
                Http::response();
            },['Auth']);


Http::get('/products', 
            function($request){
                $return = Product::findUsersProducts($request->currentUser);
                Http::response($return);
            },['Auth']);


Http::get('/product/{id}', 
            function($request){
                Http::response(Product::findProduct($request));
            },['Auth']);


Http::put('/product/{id}', 
            function($request){
                Product::updateProduct($request);
                Http::response();
            },['Auth']);


Http::delete('/product/{id}', 
            function($request){
                Product::deleteProduct($request);
                Http::response();
            },['Auth']);
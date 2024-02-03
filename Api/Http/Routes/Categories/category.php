<?php

use Api\Controller\Categories\Category;
use Http\Http;

Http::post('/category', 
            function($request){
                Category::createCategory($request);
                Http::response();
            },['Auth']);


Http::get('/categories', 
            function($request){
                $return = Category::findUsersCategories($request->currentUser);
                Http::response($return);
            },['Auth']);


Http::get('/category/{id}', 
            function($request){
                Http::response(Category::findCategory($request));
            },['Auth']);


Http::put('/category/{id}', 
            function($request){
                Category::updateCategory($request);
                Http::response();
            },['Auth']);


Http::delete('/category/{id}', 
            function($request){
                Category::deleteCategory($request);
                Http::response();
            },['Auth']);
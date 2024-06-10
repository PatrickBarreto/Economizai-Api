<?php

use Api\Controller\Brands\Brand;
use Http\Http;

Http::post('/brands/create', 
            function($request){
                Brand::createBrand($request);
                Http::response();
            },['Auth']);


Http::get('/brands', 
            function($request){
                $return = Brand::findUsersBrands($request->currentUser);
                Http::response($return);
            },['Auth']);


Http::get('/brands/{id}', 
            function($request){
                Http::response(Brand::findBrand($request));
            },['Auth']);


Http::get('/brands/bonds/category/{id}', 
            function($request){
                Http::response(Brand::findAllBrandsWithInformationAboutBondCategory($request));
            },['Auth']);


Http::put('/brands/{id}', 
            function($request){
                Brand::updateBrand($request);
                Http::response();
            },['Auth']);


Http::delete('/brands/{id}', 
            function($request){
                Brand::deleteBrand($request);
                Http::response();
            },['Auth']);
<?php

use Api\Controller\Categories\BondCategoryProducts\CategoryProducts;
use Http\Http;

Http::post('/category/{id}/new-product', 
			function($request){
				CategoryProducts::addNewProduct($request);
				Http::response();
			},['Auth']);

			
Http::delete('/category/{id}/products', 
			function($request){
				CategoryProducts::removeProduct($request);
				Http::response();
			},['Auth']);
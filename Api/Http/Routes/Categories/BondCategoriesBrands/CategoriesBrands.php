<?php

use Api\Controller\Categories\BondCategoryBrands\CategoryBrands;
use Http\Http;

Http::post('/category/{id}/new-brand', 
			function($request){
				CategoryBrands::addNew($request);
				Http::response();
			},['Auth']);

			
Http::delete('/category/{id}/brand', 
			function($request){
				CategoryBrands::remove($request);
				Http::response();
			},['Auth']);
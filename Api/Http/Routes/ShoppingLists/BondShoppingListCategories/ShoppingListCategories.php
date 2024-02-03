<?php

use Api\Controller\ShoppingLists\BondShoppingListCategories\ShoppingListCategories;
use Http\Http;

Http::post('/shopping-list/{id}/new-category', 
			function($request){
				ShoppingListCategories::addNewProduct($request);
				Http::response();
			},['Auth']);

			
Http::delete('/shopping-list/{id}/category', 
			function($request){
				ShoppingListCategories::removeProduct($request);
				Http::response();
			},['Auth']);
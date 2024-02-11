<?php

use Api\Controller\ShoppingLists\BondShoppingListProducts\ShoppingListProducts;
use Http\Http;

Http::post('/shopping-list/{id}/new-product', function($request){
    ShoppingListProducts::add($request);
    Http::response();
});

Http::get('/shopping-list/{id}/products', function($request){
    $list = ShoppingListProducts::list($request);
    Http::response($list);
});


Http::delete('/shopping-list/product/bond/{bondId}', function($request){
    ShoppingListProducts::remove($request);
    Http::response();
});
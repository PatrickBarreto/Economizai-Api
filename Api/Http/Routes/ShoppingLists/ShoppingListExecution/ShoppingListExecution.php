<?php

use Http\Http;
use Api\Controller\ShoppingLists\ShoppingListProductOptions\ShoppingListProductOptions;

Http::post('/shopping-list/execution/{hash}/{productListId}', function($request) {
    ShoppingListProductOptions::addOptionProduct($request);
    Http::response();
});


Http::get('/shopping-list/execution/{hash}/{productListId}/best-choice', function ($request) {
    $result = ShoppingListProductOptions::findBestOption($request);
    Http::response($result);
},
['Auth']);


Http::get('/shopping-list/execution/{hash}/{productListId}', function($request) {
    $options = ShoppingListProductOptions::listAllOptionByHashAndProductsListId($request);
    Http::response($options);
});


Http::get('/shopping-list/execution/{hash}/product/option/{productOptionId}', function($request) {
    $option = ShoppingListProductOptions::findOptionByProductOptionId($request);
    Http::response($option);
});


Http::delete('/shopping-list/execution/{hash}/product/option/{productOptionId}', function($request) {
    ShoppingListProductOptions::delete($request);
    Http::response();
});
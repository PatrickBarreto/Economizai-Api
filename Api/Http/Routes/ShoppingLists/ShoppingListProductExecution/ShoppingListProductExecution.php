<?php

use Http\Http;
use Api\Controller\ShoppingLists\ShoppingListProductExecution\ShoppingListProductExecution;

Http::post('/shopping-list/execution/{hash}/{productListId}', function($request) {
    ShoppingListProductExecution::addOptionProduct($request);
    Http::response();
});


Http::get('/shopping-list/execution/{hash}/{productListId}', function($request) {
    $options = ShoppingListProductExecution::listAllOptionByHashAndProductsListId($request);
    Http::response($options);
});


Http::get('/shopping-list/execution/{hash}/product/option/{productOptionId}', function($request) {
    $option = ShoppingListProductExecution::findOptionByProductOptionId($request);
    Http::response($option);
});


Http::delete('/shopping-list/execution/{hash}/product/option/{productOptionId}', function($request) {
    ShoppingListProductExecution::delete($request);
    Http::response();
});
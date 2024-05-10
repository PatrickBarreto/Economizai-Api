<?php

namespace Api\Controller\Products;

use Api\Models\Products\Product as ProductModel;
use Api\Models\Products\ProductRepository;
use Exception\Exception;
use Http\Request\Request;

class Product {

    public static function createProduct(Request $request) {
        return (new ProductRepository(new ProductModel))
                ->createProduct($request);
    }
    

    
    public static function findUsersProducts(int $currentUser){
        $product = (new ProductRepository(new ProductModel))
                    ->findAllUsersProducts($currentUser, ['id', 'name', 'type', 'volume', 'unit_mensure']);
        if($product) {
            return $product;
        }
        Exception::throw("Product not found", 404);
    }



    public static function findProduct(Request $request){
        $product = (new ProductRepository(new ProductModel))
                    ->findProduct($request->currentUser, $request->getPathParams()['id'], ['id', 'accounts_id', 'name', 'type', 'volume', 'unit_mensure']);
        if($product) {
            return $product;
        }
        Exception::throw("Product not found", 404);
    }



    public static function updateProduct(Request $request){
        $product = (new ProductRepository(new ProductModel))
                    ->findProduct((int)$request->currentUser, (int)$request->getPathParams()['id'], ['*'], false);
        if($product) {
            return $product->updateProduct($request->currentUser, $request->getBody());
        }
        Exception::throw("Product not found", 404);
    }



    public static function deleteProduct(Request $request){
        $product = (new ProductRepository(new ProductModel))
                    ->findProduct($request->currentUser, $request->getPathParams()['id'], ['id'], false);
        if($product) {
            return $product->deleteProduct();
        }
        Exception::throw("Product not found", 404);
    }
}
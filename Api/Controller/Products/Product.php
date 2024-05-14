<?php

namespace Api\Controller\Products;

use Api\Common\Log\Log;
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
        $productRepository = (new ProductRepository(new ProductModel));
        $product = $productRepository->findAllUsersProducts($currentUser, ['id', 'name', 'type', 'volume', 'unit_mensure']);
        if($product) {
            return $product;
        }
        Exception::throw("Product not found", 404);
    }



    public static function findProduct(Request $request){
        $productRepository = (new ProductRepository(new ProductModel));
        $product = $productRepository->findProduct($request->currentUser, $request->getPathParams()['id'], ['id', 'accounts_id', 'name', 'type', 'volume', 'unit_mensure']);
        if($product) {
            return $product;
        }
        Exception::throw("Product not found", 404);
    }



    public static function updateProduct(Request $request){
        $productRepository = (new ProductRepository(new ProductModel));
        $product = $productRepository->findProduct((int)$request->currentUser, (int)$request->getPathParams()['id'], ['*'], false);
        if($product instanceof ProductModel) {
            return $productRepository->updateProduct($request->currentUser, $request->getBody(), $product);
        }
        Exception::throw("Product not found", 404);
    }



    public static function deleteProduct(Request $request){
        $productRepository = (new ProductRepository(new ProductModel));
        $product = $productRepository->findProduct($request->currentUser, $request->getPathParams()['id'], ['id'], false);
        if($product instanceof ProductModel) {
            return $productRepository->deleteProduct($product->getProperty('id'));
        }
        Exception::throw("Product not found", 404);
    }
}
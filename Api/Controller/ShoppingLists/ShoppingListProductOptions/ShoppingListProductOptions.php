<?php

namespace Api\Controller\ShoppingLists\ShoppingListProductOptions;

use Api\Common\MathOperations\Comparations;
use Api\Models\Products\Product;
use Api\Models\ShoppingLists\BondShoppingListProducts\ShoppingListProducts;
use Api\Models\ShoppingLists\ShoppingListExecution;
use Api\Models\ShoppingLists\ShoppingListProductOptions\ShoppingListProductOptions as ShoppingListProductExecutionModel;

use Exception\Exception;
use Http\Request\Request;

class ShoppingListProductOptions {

    public static function addOptionProduct(Request $request){
        
        $executionHash =        isset($request->getPathParams()['hash']) ? $request->getPathParams()['hash'] : '';
        $productListId =        isset($request->getPathParams()['productListId']) ? (int)$request->getPathParams()['productListId'] : 0;

        $productOptionId =      isset($request->getBody()->products_id) ? $request->getBody()->products_id : 0;
        $productOptionBrandId = isset($request->getBody()->brands_id) ? $request->getBody()->brands_id : 0;
        $quantity =             isset($request->getBody()->quantity) ? $request->getBody()->quantity : 0;
        $typeDescription =      isset($request->getBody()->type_description) ? $request->getBody()->type_description : 0;
        $weight =              isset($request->getBody()->weight) ? $request->getBody()->weight : 0;
        $unitMensure =          isset($request->getBody()->unit_mensure) ? $request->getBody()->unit_mensure : 0;
        $price =                isset($request->getBody()->price) ? $request->getBody()->price : 0;

        if(!$executionHash || !$productListId || !$productOptionId || !$productOptionBrandId || !$quantity || !$typeDescription || !$weight || !$unitMensure || !$price){
            Exception::throw('Miss information', 200);
        }

        $shoppingListExecution =   (new ShoppingListExecution())->findExecutionsByHash($executionHash);
       

        return (new ShoppingListProductExecutionModel())->create([
                                                    $shoppingListExecution->getProperty('execution_hash'),
                                                    $productListId, 
                                                    $productOptionId,
                                                    $productOptionBrandId,
                                                    $typeDescription,
                                                    $weight,
                                                    $unitMensure,
                                                    $quantity,
                                                    $price
                                                ]);

    }

    public static function listAllOptionByHashAndProductsListId(Request $request){

        $executionHash =    isset($request->getPathParams()['hash']) ? $request->getPathParams()['hash'] : '';
        $productListId =    isset($request->getPathParams()['productListId']) ? (int)$request->getPathParams()['productListId'] : 0;
        
        $options =   (new ShoppingListProductExecutionModel())->listOptionsByProductList($executionHash, (int)$productListId);

        
        if($options){
            return $options;
        }
       
        Exception::throw('Option product list not found', 200);

    }

    public static function findOptionByProductOptionId(Request $request){

        $executionHash =   isset($request->getPathParams()['hash']) ? $request->getPathParams()['hash'] : 0;
        $productOptionId = isset($request->getPathParams()['productOptionId']) ? (int)$request->getPathParams()['productOptionId'] : 0;
        
        $details =   (new ShoppingListProductExecutionModel())->findDetailByProductOptionId($productOptionId, $executionHash);

        if($details){
            return $details;
        }
       
        Exception::throw('Option product list not found', 200);

    }

    public static function delete(Request $request){
        
        $executionHash =   isset($request->getPathParams()['hash']) ? $request->getPathParams()['hash'] : 0;
        $productOptionId = isset($request->getPathParams()['productOptionId']) ? (int)$request->getPathParams()['productOptionId'] : 0;
        
        $productOption = (new ShoppingListProductExecutionModel)->findProductOption($productOptionId, $executionHash);

        if($productOption){
            $productOption->delete();
            return true;
        }

        Exception::throw('Product option not found', 200);
        
    } 

    public static function findBestOption(Request $request) {
        
        $executionHash =  isset($request->getPathParams()['hash']) ? $request->getPathParams()['hash'] : '';
        $productListId =  isset($request->getPathParams()['productListId']) ? (int)$request->getPathParams()['productListId'] : 0;
        
        $productIten = (new ShoppingListProducts)->findBondsById($productListId);
        $products = (new Product)->findProduct($request->currentUser, $productIten->getProperty('products_id'));
        $options = (new ShoppingListProductExecutionModel())->listOptionsByProductList($executionHash, (int)$productListId);
        
        $data = [];
        $data['calcType'] = $products['unit_mensure'];

        foreach($options as $option){
            $data['itensToCopare'][] = [
                'id'=>$option['id'],
                'name'=>$option['products_id'], 
                'brand_id'=>$option['brands_id'], 
                'price'=>(float)$option['price'], 
                'weight'=>$option['quantity'] * (Comparations::convertOptionToUnitMensure($option, $products['unit_mensure']))
            ];
        }

       return Comparations::compare($data);
       
    }
}
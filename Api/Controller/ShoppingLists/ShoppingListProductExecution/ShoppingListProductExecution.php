<?php

namespace Api\Controller\ShoppingLists\ShoppingListProductExecution;

use Api\Models\ShoppingLists\ShoppingListExecution;
use Api\Models\ShoppingLists\ShoppingListProductExecution\ShoppingListProductExecution as ShoppingListProductExecutionModel;

use Exception\Exception;
use Http\Request\Request;

class ShoppingListProductExecution {

    public static function addOptionProduct(Request $request){
        
        $executionHash =        isset($request->getPathParams()['hash']) ? $request->getPathParams()['hash'] : '';
        $productListId =        isset($request->getPathParams()['productListId']) ? (int)$request->getPathParams()['productListId'] : 0;

        $productOptionId =      isset($request->getBody()->products_id) ? $request->getBody()->products_id : 0;
        $productOptionBrandId = isset($request->getBody()->brands_id) ? $request->getBody()->brands_id : 0;
        $typeDescription =      isset($request->getBody()->type_description) ? $request->getBody()->type_description : 0;
        $quantity =             isset($request->getBody()->quantity) ? $request->getBody()->quantity : 0;
        $price =                isset($request->getBody()->price) ? $request->getBody()->price : 0;

        if(!$executionHash || !$productListId || !$productOptionId || !$quantity || !$typeDescription || !$price){
            Exception::throw('Miss information', 200);
        }

        $shoppingListExecution =   (new ShoppingListExecution())->findExecutionsByHash($executionHash);
       

        return (new ShoppingListProductExecutionModel())->create([
                                                    $shoppingListExecution->getProperty('execution_hash'),
                                                    $productListId, 
                                                    $productOptionId,
                                                    $productOptionBrandId,
                                                    $typeDescription,
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
}
<?php

namespace Api\Controller\ShoppingLists\BondShoppingListProducts;

use Api\Models\Categories\BondCategoryProducts\CategoryProducts;
use Api\Models\ShoppingLists\BondShoppingListProducts\ShoppingListProducts as ShoppingListProductsModel;

use Exception\Exception;
use Http\Request\Request;

class ShoppingListProducts {

    public static function add(Request $request){
        $categoryId = isset($request->getPathParams()['id']) ? (int)$request->getPathParams()['id'] : 0;
        $categoriesId = isset($request->getBody()->categories_id) ? $request->getBody()->categories_id : 0;
        $productsId = isset($request->getBody()->products_id) ? $request->getBody()->products_id : 0;
        $amount = isset($request->getBody()->amount) ? $request->getBody()->amount : 0;
        
        if(!$categoriesId || !$productsId || !$categoryId){
            Exception::throw('Miss information', 200);
        }
       
       if (count((new CategoryProducts)->findBonds($productsId, $categoriesId)) > 0) {
           return (new ShoppingListProductsModel())->create([
                                                       $categoryId, 
                                                       $categoriesId,
                                                       $productsId,
                                                       $amount
                                                   ]);
       }

       Exception::throw('These category and product are not bonded', 200);

    }

    public static function list(Request $request){
       return (new ShoppingListProductsModel)->findBondsByShoppingListId($request->getPathParams()['id']);
    }

    public static function remove(Request $request){
        $bond = (new ShoppingListProductsModel())->findBondsById((int)$request->getPathParams()['bondId']);
        if($bond){
            return $bond->delete();
        }
        Exception::throw("Product not found", 200);
    }
}
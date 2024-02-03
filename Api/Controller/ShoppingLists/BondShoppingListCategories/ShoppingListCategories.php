<?php

namespace Api\Controller\ShoppingLists\BondShoppingListCategories;

use Api\Models\ShoppingLists\BondShoppingListCategories\ShoppingListCategories as ShoppingListCategoriesModel;
use Exception\Exception;
use Http\Request\Request;

class ShoppingListCategories {

    public static function addNewProduct(Request $request){
        $shoppingListId = $request->getPathParams()['id'];
        foreach($request->getBody()->categories_id as $cateogires){
            $values[] = [$cateogires, (int)$shoppingListId];
        }
        (new ShoppingListCategoriesModel())->createBond($values);
    }


    public static function removeProduct(Request $request){
        $bonds = (new ShoppingListCategoriesModel())->findBonds($request->getPathParams()['id'], $request->getQueryStrings()['ids']);
        if($bonds){
            foreach($bonds as $bond){
                $bond->deleteBond();
            }
            return true;
        }
        Exception::throw("Categories bond not found", 200);
    }
}
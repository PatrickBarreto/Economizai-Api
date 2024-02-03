<?php

namespace Api\Controller\Categories\BondCategoryProducts;

use Api\Models\Categories\BondCategoryProducts\CategoryProducts as CategoryProductsModel;
use Exception\Exception;
use Http\Request\Request;

class CategoryProducts {

    public static function addNewProduct(Request $request){
        $category = $request->getPathParams()['id'];
        foreach($request->getBody()->product_id as $productId){
            $values[] = [$productId, (int)$category];
        }
        (new CategoryProductsModel())->createBond($values);
    }


    public static function removeProduct(Request $request){
        $bonds = (new CategoryProductsModel())->findBonds($request->getQueryStrings()['ids'], $request->getPathParams()['id']);
        if($bonds){
            foreach($bonds as $bond){
                $bond->deleteBond();
            }
            return true;
        }
        Exception::throw("Category product not found", 200);
    }
}
<?php

namespace Api\Controller\Categories\BondCategoryBrands;

use Api\Models\Categories\BondCategoryBrands\CategoryBrands as CategoryBrandsModel;
use Exception\Exception;
use Http\Request\Request;

class CategoryBrands {

    public static function addNew(Request $request){
        $categoryId = $request->getPathParams()['id'];
        foreach($request->getBody()->brands_id as $brands){
            $values[] = [(int)$categoryId, $brands];
        }
        (new CategoryBrandsModel())->createBond($values);
    }


    public static function remove(Request $request){
        $bonds = (new CategoryBrandsModel())->findBonds($request->getPathParams()['id'], $request->getQueryStrings()['ids']);
        if($bonds){
            foreach($bonds as $bond){
                $bond->deleteBond();
            }
            return true;
        }
        Exception::throw("Brand bond not found", 200);
    }
}
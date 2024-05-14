<?php

namespace Api\Controller\Categories\BondCategoryProducts;

use Api\Common\Log\Log;
use Api\Models\Categories\BondCategoryProducts\CategoryProducts as CategoryProductsModel;
use Api\Models\Categories\BondCategoryProducts\CategoryProductsRepository;
use Exception\Exception;
use Http\Request\Request;

class CategoryProducts {

    public static function addNewProduct(Request $request){
        $bondsRepository = (new CategoryProductsRepository(new CategoryProductsModel));
        $category = $request->getPathParams()['id'];

        foreach($request->getBody()->product_id as $productId){
            $values[] = [$productId, (int)$category];
        }
        $bondsRepository->createBond($values);
    }


    public static function removeProduct(Request $request){
        $bondsRepository = (new CategoryProductsRepository(new CategoryProductsModel));
        $bonds = $bondsRepository->findBonds($request->getQueryStrings()['ids'], $request->getPathParams()['id']);

        if(is_array($bonds) && $bonds[0] instanceof CategoryProductsModel){
            $bondsRepository->deleteAllBond($request->getPathParams()['id'], $request->getQueryStrings()['ids']);
            return true;
        }
        Exception::throw("Category product not found", 200);
    }
}
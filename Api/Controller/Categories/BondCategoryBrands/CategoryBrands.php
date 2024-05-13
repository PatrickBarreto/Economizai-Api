<?php

namespace Api\Controller\Categories\BondCategoryBrands;

use Api\Models\Categories\BondCategoryBrands\CategoryBrands as CategoryBrandsModel;
use Api\Models\Categories\BondCategoryBrands\CategoryBrandsRepository;
use Exception\Exception;
use Http\Request\Request;

class CategoryBrands {

    public static function addNew(Request $request){
        $categoryBrandsRepository = new CategoryBrandsRepository(new CategoryBrandsModel);
        
        $categoryId = $request->getPathParams()['id'];

        foreach($request->getBody()->brands_id as $brands){
            $values[] = [(int)$categoryId, $brands];
        }
        $categoryBrandsRepository->createBond($values);
    }


    public static function remove(Request $request){
        $categoryBrandsRepository = new CategoryBrandsRepository(new CategoryBrandsModel);
        
        $bonds = $categoryBrandsRepository->findBonds($request->getQueryStrings()['ids'], $request->getPathParams()['id'],['*']);

        if(is_array($bonds) && $bonds[0] instanceof CategoryBrandsModel){
            $categoryBrandsRepository->deleteAllBond($request->getPathParams()['id'], $request->getQueryStrings()['ids']);
            return true;
        }

        Exception::throw("Brand bond not found", 200);
    }
}
<?php

namespace Api\Controller\ShoppingLists\BondShoppingListProducts;

use Api\Models\Categories\BondCategoryProducts\CategoryProducts;
use Api\Models\Categories\BondCategoryProducts\CategoryProductsRepository;
use Api\Models\ShoppingLists\BondShoppingListProducts\ShoppingListProducts as ShoppingListProductsModel;
use Api\Models\ShoppingLists\BondShoppingListProducts\ShoppingListProductsRepository;

use Exception\Exception;
use Http\Request\Request;

class ShoppingListProducts {

    public static function add(Request $request){

        $categoryProductsBondRepository = new CategoryProductsRepository(new CategoryProducts);
        $shoppingListProductRepository = new ShoppingListProductsRepository(new ShoppingListProductsModel);

        $categoryId = isset($request->getPathParams()['id']) ? (int)$request->getPathParams()['id'] : 0;
        $categoriesId = isset($request->getBody()->categories_id) ? $request->getBody()->categories_id : 0;
        $productsId = isset($request->getBody()->products_id) ? $request->getBody()->products_id : 0;
        $amount = isset($request->getBody()->amount) ? $request->getBody()->amount : 0;

        if(!$categoriesId || !$productsId || !$categoryId){
            Exception::throw('Miss information', 200);
        }
       
        $categoryProductBonds = $categoryProductsBondRepository->findBonds($productsId, $categoriesId);

        if (is_array($categoryProductBonds) && count($categoryProductBonds) > 0) {
            return $shoppingListProductRepository->create([
                                                        $categoryId, 
                                                        $categoriesId,
                                                        $productsId,
                                                        $amount
                                                    ]);
        }
        Exception::throw('These category and product are not bonded', 200);

    }

    public static function list(Request $request){
        $shoppingListProductRepository = new ShoppingListProductsRepository(new ShoppingListProductsModel);
        
        return $shoppingListProductRepository->findBondsByShoppingListId($request->getPathParams()['id']);
    }

    public static function remove(Request $request){
        $shoppingListProductRepository = new ShoppingListProductsRepository(new ShoppingListProductsModel);
        $bond = $shoppingListProductRepository->findBondsById((int)$request->getPathParams()['bondId']);
       
        if($bond instanceof ShoppingListProductsModel){
            return $shoppingListProductRepository->deleteProductFromList($bond->getProperty('id'));
        }
        Exception::throw("Product not found", 200);
    }
}
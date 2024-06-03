<?php

namespace Api\Controller\Categories;

use Api\Common\Log\Log;
use Api\Models\Categories\BondCategoryBrands\CategoryBrands;
use Api\Models\Categories\BondCategoryBrands\CategoryBrandsRepository;
use Api\Models\Categories\BondCategoryProducts\CategoryProducts;
use Api\Models\Products\ProductRepository;
use Api\Models\Categories\BondCategoryProducts\CategoryProductsRepository;
use Api\Models\Categories\Category as CategoryModel;
use Api\Models\Categories\CategoryRepository;
use Api\Models\Products\Product;
use Exception\Exception;
use Http\Request\Request;

class Category {

    public static function createCategory(Request $request) {
        $body = $request->getBody();

        $categoryRepository = new CategoryRepository(new CategoryModel);
        $categoryInsertIntance = $categoryRepository->createCategory($request);   

        if($body->products){
            foreach($body->products as $product){
                (new CategoryProductsRepository(new CategoryProducts))->createBond([$categoryInsertIntance->lastInsertId, $product]);
            }
        }
        if($body->brands){
            foreach($body->brands as $brand){
                (new CategoryBrandsRepository(new CategoryBrands))->createBond([$categoryInsertIntance->lastInsertId, $brand]);
            }
        }

        return true;
    }
    


    public static function findUsersCategories(int $currentUser){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $productRepository = new ProductRepository(new Product);
        $categories = $categoryRepository->findAllUsersCategories($currentUser, ['id','accounts_id', 'name']);

        if($categories) {
            return $categories;
        }
        Exception::throw("Category not found", 404);
    }



    public static function findCategory(Request $request){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $productRepository = new ProductRepository(new Product);
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name']);
        
        if($category) {
            $category['products'] = $productRepository->findAllProductsAndCheckIfBondWithCategory($request->currentUser, (int)$category['id']);
            $category['brands'] = $categoryRepository->findUsersCategoriesAndBrands($request->currentUser, (int)$category['id']);

            return $category;
        }
        Exception::throw("Category not found", 404);
    }



    public static function updateCategory(Request $request){
        $categoryRepository = (new CategoryRepository(new CategoryModel));
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
        
        if($category instanceof CategoryModel) {
            return $categoryRepository->updateCategory($request->currentUser, $request->getBody(), $category);
        }
        Exception::throw("Category not found", 404);
    }



    public static function deleteCategory(Request $request){
        $categoryRepository = (new CategoryRepository(new CategoryModel));
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
    
        if($category instanceof CategoryModel) {
            return $categoryRepository->deleteCategory($category->getProperty('id'));
        }
        Exception::throw("Category not found", 404);
    }
}
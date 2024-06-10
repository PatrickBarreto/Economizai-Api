<?php

namespace Api\Controller\Categories;

use Api\Common\Log\Log;
use Api\Models\Brands\Brand as BrandModel;
use Api\Models\Brands\BrandRepository;
use Api\Models\Categories\BondCategoryBrands\CategoryBrands;
use Api\Models\Categories\BondCategoryBrands\CategoryBrandsRepository;
use Api\Models\Categories\BondCategoryProducts\CategoryProducts;
use Api\Models\Products\ProductRepository;
use Api\Models\Categories\BondCategoryProducts\CategoryProductsRepository;
use Api\Models\Categories\Category as CategoryModel;
use Api\Models\Categories\CategoryRepository;
use Api\Models\Products\Product;
use DataBase\RepositoryConnection\Repository;
use Exception\Exception;
use Http\Request\Request;

class Category {

    public static function createCategory(Request $request) {
        $body = $request->getBody();

        $categoryRepository = new CategoryRepository(new CategoryModel);
        $categoryProductsRepository = new CategoryProductsRepository(new CategoryProducts);
        $categoryBrandsRepository = new CategoryBrandsRepository(new CategoryBrands);

        $categoryInsertIntance = $categoryRepository->createCategory($request);   

        if($body->products){
            foreach($body->products as $product){
                $categoryProductsRepository->createBond([$categoryInsertIntance->lastInsertId, $product]);
            }
        }
        if($body->brands){
            foreach($body->brands as $brand){
                $categoryBrandsRepository->createBond([$categoryInsertIntance->lastInsertId, $brand]);
            }
        }

        return true;
    }
    


    public static function findUsersCategories(int $currentUser){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $categories = $categoryRepository->findAllUsersCategories($currentUser, ['id','accounts_id', 'name']);

        if($categories) {
            return $categories;
        }
        Exception::throw("Category not found", 404);
    }



    public static function findCategory(Request $request){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $brandsRepository = new BrandRepository(new BrandModel);
        $productRepository = new ProductRepository(new Product);
       
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name']);
        
        if($category) {
            $category['products'] = $productRepository->findAllProductsAndCheckIfBondWithCategory($request->currentUser, (int)$category['id']);
            $category['brands'] = $brandsRepository->findAllBrandsAndCheckIfBondWithCategory($request->currentUser, (int)$category['id']);

            return $category;
        }
        Exception::throw("Category not found", 404);
    }



    public static function updateCategory(Request $request){
        $body = (object)$request->getBody();

        $categoryRepository             = new CategoryRepository(new CategoryModel); 
        $bondsCategoryProductRepository = new CategoryProductsRepository(new CategoryProducts);
        $bondCategoryBrandsRepository   = new CategoryBrandsRepository(new CategoryBrands);
        
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
        
        if($category instanceof CategoryModel) {
            
            $categoryRepository->updateCategory($request->currentUser, $body, $category);

            self::makeBond($bondsCategoryProductRepository, $category, $body->products ? $body->products : []);
            self::makeBond($bondCategoryBrandsRepository, $category, $body->brands ? $body->brands : []);


            return true;
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

    

    private static function makeBond(Repository $bondsTypeRepository, CategoryModel $category, array $bondable ){
        
        if($bondsTypeRepository instanceof CategoryProductsRepository){
            $categoryProductBonds = $bondsTypeRepository->findBondsByCategoryId($category->getProperty('id'), ['GROUP_CONCAT(products_id) as productIds']);   
            $categoryProductBonds = array_map(function ($id) {
                                                return (int)$id;
                                            },explode(',', $categoryProductBonds[0]['productIds']));
    
            if($bondable || $categoryProductBonds){
                $toCrerateBond = array_diff($bondable, $categoryProductBonds);
                $toRemoveBond = array_diff($categoryProductBonds, $bondable);
    
                foreach($toCrerateBond as $bondProductIdToCreate){
                    $bondsTypeRepository->createBond([$category->getProperty('id'), $bondProductIdToCreate]);
                }
    
                if($toRemoveBond){
                    $bondsTypeRepository->deleteAllBond($category->getProperty('id'), implode(",", $toRemoveBond));
                }

            }

            return;
        }
        
        if($bondsTypeRepository instanceof CategoryBrandsRepository){
            $categoryBrandsBonds = $bondsTypeRepository->findBondsByCategoryId($category->getProperty('id'), ['GROUP_CONCAT(brands_id) as brandsId']);
            $categoryBrandsBonds = array_map(function ($id) {
                                                return (int)$id;
                                            },explode(',', $categoryBrandsBonds[0]['brandsId']));
    
            if($bondable || $categoryBrandsBonds){
                $toCrerateBond = array_diff($bondable, $categoryBrandsBonds);
                $toRemoveBond = array_diff($categoryBrandsBonds, $bondable);
    
                foreach($toCrerateBond as $bondProductIdToCreate){
                    $bondsTypeRepository->createBond([$category->getProperty('id'), $bondProductIdToCreate]);
                }
    
                if($toRemoveBond){
                    $bondsTypeRepository->deleteAllBond($category->getProperty('id'), implode(",", $toRemoveBond));
                }
            }
        }
    }
}
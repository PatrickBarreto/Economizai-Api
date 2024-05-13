<?php

namespace Api\Controller\Categories;

use Api\Models\Categories\Category as CategoryModel;
use Api\Models\Categories\CategoryRepository;
use Exception\Exception;
use Http\Request\Request;

class Category {

    public static function createCategory(Request $request) {
        return (new CategoryRepository(new CategoryModel))->createCategory($request);
    }
    


    public static function findUsersCategories(int $currentUser){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $categories = $categoryRepository->findAllUsersCategories($currentUser, ['id','accounts_id', 'name']);

        if($categories) {
            foreach($categories as $key => $category) {
                $categories[$key]['products'] = $categoryRepository->findUsersCategoriesAndProducts($currentUser, (int)$category['id']);
            }
            return $categories;
        }
        Exception::throw("Category not found", 200);
    }



    public static function findCategory(Request $request){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $category = $categoryRepository->findCategory($request->getPathParams()['id'], ['id','accounts_id', 'name']);
        
        if($category) {
            $category['products'] = $categoryRepository->findUsersCategoriesAndProducts($request->currentUser, (int)$category['id']);
            return $category;
        }
        Exception::throw("Category not found", 200);
    }



    public static function updateCategory(Request $request){
        $categoryRepository = (new CategoryRepository(new CategoryModel));
        $category = $categoryRepository->findCategory($request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
        
        if($category instanceof CategoryModel) {
            return $categoryRepository->updateCategory($request->currentUser, $request->getBody(), $category->getProperty('id'));
        }
        Exception::throw("Category not found", 200);
    }



    public static function deleteCategory(Request $request){
        $categoryRepository = (new CategoryRepository(new CategoryModel));
        $category = $categoryRepository->findCategory($request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
    
        if($category instanceof CategoryModel) {
            return $categoryRepository->deleteCategory($category->getProperty('id'));
        }
        Exception::throw("Category not found", 200);
    }
}
<?php

namespace Api\Controller\Categories;

use Api\Models\Categories\Category as CategoryModel;
use Exception\Exception;
use Http\Request\Request;
use stdClass;

class Category {

    public static function createCategory(Request $request) {
        return (new CategoryModel)->createCategory($request);
    }
    



    public static function findUsersCategories(int $currentUser){
        $categories = (new CategoryModel)->findAllUsersCategories($currentUser, ['id','accounts_id', 'name']);
        if($categories) {
            foreach($categories as $key => $category) {
                $categories[$key]['products'] = (new CategoryModel)->findUsersCategoriesAndProducts($currentUser, (int)$category['id']);
            }
        }
        return $categories;
        Exception::throw("Category not found", 200);
    }




    public static function findCategory(Request $request){
        $category = (new CategoryModel)->findCategory($request->getPathParams()['id'], ['id','accounts_id', 'name']);
        if($category) {
            $category['products'] = (new CategoryModel)->findUsersCategoriesAndProducts($request->currentUser, (int)$category['id']);
            return $category;
        }
        Exception::throw("Category not found", 200);
    }



    public static function updateCategory(Request $request){
        $category = (new CategoryModel)->findCategory($request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
        if($category) {
            return $category->updateCategory($request->currentUser, $request->getBody());
        }
        Exception::throw("Category not found", 200);
    }



    public static function deleteCategory(Request $request){
        $category = (new CategoryModel)->findCategory($request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
        if($category) {
            return $category->deleteCategory();
        }
        Exception::throw("Category not found", 200);
    }
}
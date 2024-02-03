<?php

namespace Api\Controller\ShoppingLists;

use Api\Models\Categories\BondCategoryProducts\CategoryProducts;
use Api\Models\Categories\Category as CategoryModel;
use Api\Models\ShoppingLists\ShoppingList as ShoppingListsModel;
use Exception\Exception;
use Http\Request\Request;

class ShoppingList {

    public static function createShoppingList(Request $request) {
        return (new ShoppingListsModel)->createShoppingList($request);
    }
    



    public static function findUsersShoppingLists(int $currentUser){
        $shoppingList = (new ShoppingListsModel)->findAllUsersShoppingList($currentUser, ['id','accounts_id', 'name', 'type']);
        if($shoppingList) {
            return $shoppingList;
        }
        Exception::throw("Shopping list not found", 200);
    }




    public static function findShoppingList(Request $request){
        $shoppingList = (new ShoppingListsModel)->findShoppingList($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        
        if($shoppingList) {    
            $shoppingList->categories = $shoppingList->findUsersShoppingListCategories($request->currentUser);
            
            foreach($shoppingList->categories as $category){
                $categories[] = [
                    'categoryId'=> $category['CategoryId'],
                    'categoryName'=> $category['CategoryName'],
                    'categoryProducts' =>(new CategoryModel)->findUsersCategoriesAndProducts($request->currentUser, (int)$category['CategoryId'])
                ];
            }
         
            return [
                'id' => $shoppingList->getProperty('id'),
                'listName' => $shoppingList->getProperty('name'),
                'type' => $shoppingList->getProperty('type'),
                'itens' =>  $categories
            ];
        }
        Exception::throw("Shopping list not found", 200);
    }



    public static function updateShoppingList(Request $request){
        $shoppingList = (new ShoppingListsModel)->findShoppingList($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        if($shoppingList) {
            return $shoppingList->updateShoppingList($request->currentUser, $request->getBody());
        }
        Exception::throw("Shopping list not found", 200);
    }



    public static function deleteShoppingList(Request $request){
        $shoppingList = (new ShoppingListsModel)->findShoppingList($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        if($shoppingList) {
            return $shoppingList->deleteShoppingList();
        }
        Exception::throw("Shopping list not found", 200);
    }
}
<?php

namespace Api\Controller\ShoppingLists;

use Api\Models\ShoppingLists\ShoppingList as ShoppingListsModel;
use Api\Models\ShoppingLists\ShoppingListExecution;
use Api\Models\ShoppingLists\ShoppingListExecutionRepository;
use Api\Models\ShoppingLists\ShoppingListRepository;
use Exception\Exception;
use Http\Request\Request;

class ShoppingList {

    
    public static function createHash(Request $request) {
        return (new ShoppingListExecutionRepository(new ShoppingListExecution))->createHashExecution((int)$request->getPathParams()['id']);
    }
    


    public static function createShoppingList(Request $request) {
        return (new ShoppingListRepository(new ShoppingListsModel))->createShoppingList($request);
    }



    public static function findUsersShoppingLists(int $currentUser){
        $shoppingListRepository = new ShoppingListRepository(new ShoppingListsModel);
        $shoppingList = $shoppingListRepository->findAllUsersShoppingList($currentUser, ['id','accounts_id', 'name', 'type']);
        
        if($shoppingList) {
            return $shoppingList;
        }
        Exception::throw("Shopping list not found", 404);
    }



    public static function findShoppingList(Request $request){
        $shoppingListRepository = new ShoppingListRepository(new ShoppingListsModel);
        $shoppingList = $shoppingListRepository->findShoppingList($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type']);
        
        if($shoppingList) {    
            return $shoppingList;
        }
        
        Exception::throw("Shopping list not found", 404);
    }



    public static function updateShoppingList(Request $request){
        $shoppingListRepository = new ShoppingListRepository(new ShoppingListsModel);
        $shoppingList =  $shoppingListRepository->findShoppingList($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);

        if($shoppingList instanceof ShoppingListsModel) {
            return $shoppingListRepository->updateShoppingList($request->currentUser, $request->getBody(), $shoppingList->getProperty('id'));
        }
        Exception::throw("Shopping list not found", 404);
    }



    public static function deleteShoppingList(Request $request){
        $shoppingListRepository = new ShoppingListRepository(new ShoppingListsModel);
        $shoppingList =  $shoppingListRepository->findShoppingList($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        
        if($shoppingList instanceof ShoppingListsModel) {
            return $shoppingListRepository->deleteShoppingList($shoppingList->getProperty('id'));
        }
        Exception::throw("Shopping list not found", 404);
    }
}
<?php

namespace Api\Models\ShoppingLists;

use DataBase\RepositoryConnection\Repository;
use Http\Request\Request;
use stdClass;

class ShoppingListRepository extends Repository{

    public function createShoppingList(Request $request) {
        $content = $request->getBody();
        return $this->insert()->setFields(['accounts_id', 'name', 'type'])
                            ->setValues([$request->currentUser, $content->name, $content->type])
                            ->runQuery();
    }



    public function findAllUsersShoppingList(int $currentUserId, $fields = ['*']) {
        return $this->select()->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function findShoppingList(int $currentUserId, int $shopplingList, array $fields = ['*'], $array = true) {
        $query = $this->select()->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$shopplingList);
        
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, $this->getDtoPath());
    }



    public function findUsersShoppingListCategories(int $currentUserId){
        return $this->select()->setFields(['categories.id as CategoryId', 'categories.name as CategoryName'])
                            ->setLeftJoin(
                                    ['table'=>'shopping_lists'], 
                                    ['table'=>'bond_shopping_list_categories', 'ON'=>'shopping_lists_id']
                                )
                            ->setInnerJoin(
                                    ['table'=>'bond_shopping_list_categories', 'ON'=>'categories_id'],
                                    ['table'=>'categories']
                                )
                            ->setWhere('shopping_lists.id = '.$this->id .' AND shopping_lists.accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function updateShoppingList(int $currentUserId, stdClass $content, int $shoppingListId) {
        return $this->update()->setSet([
                                    ['name'=>$content->name],
                                    ['type'=>$content->type],
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$shoppingListId)
                            ->runQuery();
       
    }



    public function deleteShoppingList(int $shoppingListId) {
       return $this->delete()->setWhere('id = '.$shoppingListId)->runQuery();
    }    

    
}
<?php

namespace Api\Models\ShoppingLists;

use DataBase\CrudExtension;
use Http\Request\Request;
use stdClass;

class ShoppingList extends CrudExtension{

    public static string $table = 'shopping_lists';

    protected int $id;
    protected int $accounts_id;
    protected string $name;
    protected string$type;
    protected string $created;
    protected string $edited;


    public function createShoppingList(Request $request) {
        $content = $request->getBody();
        return $this->insert->setFields(['accounts_id', 'name', 'type'])
                            ->setValues([$request->currentUser, $content->name, $content->type])
                            ->runQuery();
    }



    public function findAllUsersShoppingList(int $currentUserId, $fields = ['*']) {
        return $this->select->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function findShoppingList(int $currentUserId, int $shopplingList, array $fields = ['*'], $array = true) {
        $query = $this->select->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$shopplingList);
        
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, self::class);
    }
   
   
   
    public function updateShoppingList(int $currentUserId, stdClass $content) {
        return $this->update->setSet([
                                    ['name'=>$content->name],
                                    ['type'=>$content->type],
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$this->id)
                            ->runQuery();
       
    }



    public function deleteShoppingList() {
       return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }    

    
}
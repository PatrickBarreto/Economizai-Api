<?php

namespace Api\Models\Products;

use DataBase\CrudExtension;
use Http\Request\Request;
use stdClass;

class Product extends CrudExtension{

    public static string $table = 'products';

    protected int $id;
    protected int $shopping_list_id;
    protected int $brands_id;
    protected string $name;
    protected string $type;
    protected int $volume;
    protected string $unit_mensure;
    protected string $created;
    protected string $edited;
    

    public function createProduct(Request $request) {
        $content = $request->getBody();
        return $this->insert->setFields(['accounts_id','brands_id', 'name', 'type'])
                            ->setValues([$request->currentUser, $content->brands_id, $content->name, $content->type])
                            ->runQuery();
    }



    public function findAllUsersProducts(int $currentUserId, $fields = ['*']) {
        return $this->select->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function findProduct(int $currentUserId, int $shopplingList, array $fields = ['*'], $array = true) {
        $query = $this->select->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$shopplingList);
        
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, self::class);
    }
   
   
   
    public function updateProduct(int $currentUserId, stdClass $content) {
        return $this->update->setSet([
                                    ['name'=>$content->name],
                                    ['type'=>$content->type],
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$this->id)
                            ->runQuery();
       
    }



    public function deleteProduct() {
       return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }    

    
}
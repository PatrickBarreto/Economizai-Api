<?php

namespace Api\Models\Products;

use DataBase\CrudExtension;
use Http\Request\Request;
use stdClass;

class Product extends CrudExtension{

    public static string $table = 'products';

    protected int $id;
    protected string $name;
    protected string $type;
    protected int $volume;
    protected string $unit_mensure;
    protected string $created;
    protected string $edited;
    

    public function createProduct(Request $request) {
        $content = $request->getBody();
        return $this->insert->setFields(['accounts_id', 'name', 'type', 'volume', 'unit_mensure'])
                            ->setValues([$request->currentUser, $content->name, $content->type, $content->volume, $content->unit_mensure])
                            ->runQuery();
    }



    public function findAllUsersProducts(int $currentUserId, $fields = ['*']) {
        return $this->select->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function findProduct(int $currentUserId, int $productId, array $fields = ['*'], $array = true) {
        $query = $this->select->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$productId);
        
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
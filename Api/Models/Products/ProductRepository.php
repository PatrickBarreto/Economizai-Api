<?php

namespace Api\Models\Products;

use DataBase\RepositoryConnection\Repository;
use Http\Request\Request;
use stdClass;

class ProductRepository extends Repository{

    public function createProduct(Request $request) {
        $content = $request->getBody();
        return $this->insert()->setFields(['accounts_id', 'name', 'type', 'volume', 'unit_mensure'])
                            ->setValues([$request->currentUser, $content->name, $content->type, $content->volume, $content->unit_mensure])
                            ->runQuery();
    }



    public function findAllUsersProducts(int $currentUserId, $fields = ['*']) {
        return $this->select()->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->setOrder('created', 'DESC')
                            ->fetchAssoc(true);
    }
   
   
   
    public function findProduct(int $currentUserId, int $productId, array $fields = ['*'], $array = true) {
        $query = $this->select()->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$productId);
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, $this->getDtoPath());
    }
   
   
   
    public function updateProduct(int $currentUserId, stdClass $content) {
        return $this->update()->setSet([
                                    ['name' => empty($content->name) ?  $this->name : $content->name],
                                    ['type' => empty($content->type) ? $this->type : $content->type],
                                    ['volume' => empty($content->volume) ? $this->volume : $content->volume],
                                    ['unit_mensure' => empty($content->unit_mensure) ? $this->unit_mensure : $content->unit_mensure],
                                    ['edited'=>time()]
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$this->id)
                            ->runQuery();
    }



    public function deleteProduct() {
       return $this->delete()->setWhere('id = '.$this->id)->runQuery();
    }    

    
}
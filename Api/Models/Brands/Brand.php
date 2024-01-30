<?php

namespace Api\Models\Brands;

use DataBase\CrudExtension;
use Http\Request\Request;
use stdClass;

class Brand extends CrudExtension{

    public static string $table = 'brands';

    protected int $id;
    protected int $account_id;
    protected string $name;
    protected string$type;
    protected string $created;
    protected string $edited;


    public function createBrand(Request $request) {
        $content = $request->getBody();
        return $this->insert->setFields(['account_id', 'name', 'type'])
                            ->setValues([$request->currentUser, $content->name, $content->type])
                            ->runQuery();
    }



    public function findAllUsersBrand(int $currentUserId, $fields = ['*']) {
        return $this->select->setFields($fields)
                            ->setWhere('account_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function findBrand(int $currentUserId, int $shopplingList, array $fields = ['*'], $array = true) {
        $query = $this->select->setFields($fields)->setWhere('account_id = '. $currentUserId. ' AND id = '.$shopplingList);
        
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, self::class);
    }
   
   
   
    public function updateBrand(int $currentUserId, stdClass $content) {
        return $this->update->setSet([
                                    ['name'=>$content->name],
                                    ['type'=>$content->type],
                                ])
                            ->setWhere('account_id = '. $currentUserId. ' AND id = '.$this->id)
                            ->runQuery();
       
    }



    public function deleteBrand() {
       return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }    

    
}
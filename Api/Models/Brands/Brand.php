<?php

namespace Api\Models\Brands;

use DataBase\RepositoryConnection\DataBaseCorrespondence;
use Http\Request\Request;
use stdClass;

class Brand extends DataBaseCorrespondence{

    private static string $table = 'brands';

    protected int $id;
    protected int $accounts_id;
    protected string $name;
    protected string$type;
    protected string $created;
    protected string $edited;

    public static function getTable(){
        return self::$table;
    }

    public function createBrand(Request $request) {
        $content = $request->getBody();
        return $this->insert->setFields(['accounts_id', 'name', 'type'])
                            ->setValues([$request->currentUser, $content->name, $content->type])
                            ->runQuery();
    }



    public function findAllUsersBrand(int $currentUserId, $fields = ['*']) {
        return $this->select->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
   
    public function findBrand(int $currentUserId, int $shopplingList, array $fields = ['*'], $array = true) {
        $query = $this->select->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$shopplingList);
        
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, self::class);
    }
   
   
   
    public function updateBrand(int $currentUserId, stdClass $content) {
        return $this->update->setSet([
                                    ['name'=>$content->name],
                                    ['type'=>$content->type],
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$this->id)
                            ->runQuery();
       
    }



    public function deleteBrand() {
       return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }    

    
}
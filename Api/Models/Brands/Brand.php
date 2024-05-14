<?php

namespace Api\Models\Brands;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

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

    public function getProperty(string $propertyName){
        return $this->$propertyName;
    }
    
}
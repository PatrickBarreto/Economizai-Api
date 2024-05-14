<?php

namespace Api\Models\Categories;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class Category extends DataBaseCorrespondence{

    private static string $table = 'categories';

    protected int $id;
    protected int $accounts_id;
    protected string $name;
    protected string $type;
    protected string $created;
    protected string $edited;


    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $propertyName){
        return $this->$propertyName;
    }
    
}
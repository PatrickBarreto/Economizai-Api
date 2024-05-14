<?php

namespace Api\Models\ShoppingLists;

use DataBase\RepositoryConnection\DataBaseCorrespondence;
use Http\Request\Request;
use stdClass;

class ShoppingList extends DataBaseCorrespondence{

    private static string $table = 'shopping_lists';

    protected int $id;
    protected int $accounts_id;
    protected string $name;
    protected string$type;
    protected string $created;
    protected string $edited;


    public static function getTable(){
        return self::$table;
    }


    public function getProperty(string $name){
        return $this->$name;
    }
    
}
<?php

namespace Api\Models\ShoppingLists;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class ShoppingListExecution extends DataBaseCorrespondence{

    private static string $table = 'shopping_lists_executions';

    protected int $id;
    protected int $shopping_lists_id;
    protected string $execution_hash;


    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $property){
        return $this->$property;
    }
}
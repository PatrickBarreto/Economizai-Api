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

    public function createHashExecution(int $shopping_lists_id) {
        return $this->insert->setFields(['shopping_lists_id', 'execution_hash'])
                            ->setValues([$shopping_lists_id, md5($shopping_lists_id)])
                            ->fetchObject(false, self::class);
    }

    public function findExecutionsByListId(int $listId) {
        return $this->select->setFields(['id', 'shopping_lists_id', 'execution_hash'])
                            ->setWhere('shopping_lists_id = '.$listId)
                            ->fetchObject(false, self::class);
    }

    public function findExecutionsByHash(string $hash) {
        return $this->select->setFields(['id', 'shopping_lists_id', 'execution_hash'])
                            ->setWhere('execution_hash = "'.$hash.'"')
                            ->fetchObject(false, self::class);
    }
}
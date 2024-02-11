<?php

namespace Api\Models\ShoppingLists;

use DataBase\CrudExtension;

class ShoppingListExecution extends CrudExtension{

    public static string $table = 'shopping_lists_executions';

    protected int $id;
    protected int $shopping_lists_id;
    protected string $execution_hash;


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

    public function findExecutionsByhash(string $hash) {
        return $this->select->setFields(['id', 'shopping_lists_id', 'execution_hash'])
                            ->setWhere('execution_hash = "'.$hash.'"')
                            ->fetchObject(false, self::class);
    }
}
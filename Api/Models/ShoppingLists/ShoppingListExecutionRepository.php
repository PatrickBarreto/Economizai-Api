<?php

namespace Api\Models\ShoppingLists;

use DataBase\RepositoryConnection\Repository;

class ShoppingListExecutionRepository extends Repository{

    public function createHashExecution(int $shopping_lists_id) {
        return $this->insert()->setFields(['shopping_lists_id', 'execution_hash'])
                            ->setValues([$shopping_lists_id, md5(time())])
                            ->fetchObject(false, $this->getDtoPath());
    }

    public function findExecutionsByListId(int $listId) {
        return $this->select()->setFields(['id', 'shopping_lists_id', 'execution_hash', 'created'])
                            ->setWhere('shopping_lists_id = '.$listId)
                            ->fetchObject(true, $this->getDtoPath());
    }

    public function findExecutionsByHash(string $hash) {
        return $this->select()->setFields(['id', 'shopping_lists_id', 'execution_hash'])
                            ->setWhere('execution_hash = "'.$hash.'"')
                            ->fetchObject(false, $this->getDtoPath());
    }
}
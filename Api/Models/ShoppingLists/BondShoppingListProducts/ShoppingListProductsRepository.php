<?php

namespace Api\Models\ShoppingLists\BondShoppingListProducts;

use DataBase\RepositoryConnection\Repository;

class ShoppingListProductsRepository extends Repository{

    public function create(array $values) {
        return $this->insert()->setFields(['shopping_lists_id', 'categories_id', 'products_id', 'amount'])->setValues($values)->runQuery();
    }

    public function find($products_id, $shopping_lists_id, array $fields = ['*']) {
        return $this->select()->setFields($fields)->setWhere('shopping_lists_id = '.$shopping_lists_id.' AND products_id IN ('.$products_id.')')->fetchObject(true, $this->getDtoPath());
    }

    public function findBondsByShoppingListId(int $shopping_list_id, array $fields = ['*']){
        return $this->select()->setFields($fields)->setWhere('shopping_lists_id = '.$shopping_list_id)->fetchAssoc(true);
    }

    public function findBondsById(int $id, array $fields = ['*']){
        return $this->select()->setFields($fields)->setWhere('id = '.$id)->fetchObject(false, $this->getDtoPath());
    }

    public function deleteProductFromList(int $shoppingListProductId) {
        return $this->delete()->setWhere('id = '.$shoppingListProductId)->runQuery();
    }
}

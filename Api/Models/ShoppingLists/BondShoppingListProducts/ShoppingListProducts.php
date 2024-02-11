<?php

namespace Api\Models\ShoppingLists\BondShoppingListProducts;

use DataBase\CrudExtension;

class ShoppingListProducts extends CrudExtension{

    public static string $table = 'bond_shopping_lists_products';

    protected int $id;
    protected int $shopping_lists_id;
    protected int $categories_id;
    protected int $products_id;
    protected int $amount;

    public function create(array $values) {
        return $this->insert->setFields(['shopping_lists_id', 'categories_id', 'products_id', 'amount'])->setValues($values)->runQuery();
    }

    public function find($products_id, $shopping_lists_id, array $fields = ['*']) {
        return $this->select->setFields($fields)->setWhere('shopping_lists_id = '.$shopping_lists_id.' AND products_id IN ('.$products_id.')')->fetchObject(true, self::class);
    }

    public function findBondsByShoppingListId(int $shopping_list_id, array $fields = ['*']){
        return $this->select->setFields($fields)->setWhere('shopping_lists_id = '.$shopping_list_id)->fetchAssoc(true);
    }

    public function findBondsById(int $id, array $fields = ['*']){
        return $this->select->setFields($fields)->setWhere('id = '.$id)->fetchObject(false, self::class);
    }

    public function delete() {
        return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }
}

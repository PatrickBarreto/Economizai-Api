<?php

namespace Api\Models\ShoppingLists\BondShoppingListCategories;

use DataBase\CrudExtension;

class ShoppingListCategories extends CrudExtension{

    public static string $table = 'bond_shopping_list_categories';

    protected int $id;
    protected int $categories_id;
    protected int $shopping_lists_id;

    public function createBond(array $values) {
        return $this->insert->setFields(['categories_id', 'shopping_lists_id'])->setValues($values)->runQuery();
    }

    public function findBonds($shopping_lists_id, $categories_id, array $fields = ['*']) {
        return $this->select->setFields($fields)->setWhere('categories_id = '.$categories_id.' AND shopping_lists_id IN ('.$shopping_lists_id.')')->fetchObject(true, self::class);
    }

    public function findBondsByCategoryId(int $categories_id, array $fields = ['*']){
        return $this->select->setFields($fields)->setWhere('categories_id = '.$categories_id)->fetchAssoc(true);
    }

    public function deleteBond() {
        return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }
}

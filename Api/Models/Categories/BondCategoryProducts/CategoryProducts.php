<?php

namespace Api\Models\Categories\BondCategoryProducts;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class CategoryProducts extends DataBaseCorrespondence{

    private static string $table = 'bond_categories_products';

    protected int $id;
    protected int $categories_id;
    protected int $products_id;


    public static function getTable(){
        return self::$table;
    }

    public function createBond(array $values) {
        return $this->insert->setFields(['products_id', 'categories_id'])->setValues($values)->runQuery();
    }

    public function findBonds($products_id, $categories_id, array $fields = ['*']) {
        return $this->select->setFields($fields)->setWhere('categories_id = '.$categories_id.' AND products_id IN ('.$products_id.')')->fetchObject(true, self::class);
    }

    public function findBondsByCategoryId(int $categories_id, array $fields = ['*']){
        return $this->select->setFields($fields)->setWhere('categories_id = '.$categories_id)->fetchAssoc(true);
    }

    public function deleteBond() {
        return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }
}

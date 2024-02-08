<?php

namespace Api\Models\Categories\BondCategoryBrands;

use DataBase\CrudExtension;

class CategoryBrands extends CrudExtension{

    public static string $table = 'bond_categories_brands';

    protected int $id;
    protected int $categories_id;
    protected int $brands_id;

    public function createBond(array $values) {
        return $this->insert->setFields(['categories_id', 'brands_id'])->setValues($values)->runQuery();
    }

    public function findBonds($brands_id, $categories_id, array $fields = ['*']) {
        return $this->select->setFields($fields)->setWhere('categories_id = '.$categories_id.' AND brands_id IN ('.$brands_id.')')->fetchObject(true, self::class);
    }

    public function findBondsByCategoryId(int $categories_id, array $fields = ['*']){
        return $this->select->setFields($fields)->setWhere('categories_id = '.$categories_id)->fetchAssoc(true);
    }

    public function deleteBond() {
        return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }
}

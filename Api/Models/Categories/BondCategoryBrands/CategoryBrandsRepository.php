<?php

namespace Api\Models\Categories\BondCategoryBrands;

use DataBase\RepositoryConnection\Repository;

class CategoryBrandsRepository extends Repository{

    public function createBond(array $values) {
        return $this->insert()->setFields(['categories_id', 'brands_id'])->setValues($values)->runQuery();
    }

    public function findBonds($brands_id, $categories_id, array $fields = ['*']) {
        return $this->select()->setFields($fields)->setWhere('categories_id = '.$categories_id.' AND brands_id IN ('.$brands_id.')')->fetchObject(true, $this->getDtoPath());
    }

    public function findBondsByCategoryId(int $categories_id, array $fields = ['*']){
        return $this->select()->setFields($fields)->setWhere('categories_id = '.$categories_id)->fetchAssoc(true);
    }

    public function deleteBond(int $id) {
        return $this->delete()->setWhere('id = '.$id)->runQuery();
    }

    public function deleteAllBond(int $categorieId, string $brandsIds) {
        return $this->delete()->setWhere('categories_id = '.$categorieId.' AND brands_id IN ('.$brandsIds.')')->runQuery();
    }

}

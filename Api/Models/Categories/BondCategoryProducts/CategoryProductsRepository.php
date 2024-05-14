<?php

namespace Api\Models\Categories\BondCategoryProducts;

use DataBase\RepositoryConnection\Repository;

class CategoryProductsRepository extends Repository{

    public function createBond(array $values) {
        return $this->insert()->setFields(['products_id', 'categories_id'])->setValues($values)->runQuery();
    }

    public function findBonds($products_id, $categories_id, array $fields = ['*']) {
        return $this->select()->setFields($fields)->setWhere('categories_id = '.$categories_id.' AND products_id IN ('.$products_id.')')->fetchObject(true, $this->getDtoPath());
    }

    public function findBondsByCategoryId(int $categories_id, array $fields = ['*']){
        return $this->select()->setFields($fields)->setWhere('categories_id = '.$categories_id)->fetchAssoc(true);
    }

    public function deleteBond(int $id) {
        return $this->delete()->setWhere('id = '.$id)->runQuery();
    }

    public function deleteAllBond(int $categorieId, string $productsId) {
        return $this->delete()->setWhere('categories_id = '.$categorieId.' AND products_id IN ('.$productsId.')')->runQuery();
    }
}

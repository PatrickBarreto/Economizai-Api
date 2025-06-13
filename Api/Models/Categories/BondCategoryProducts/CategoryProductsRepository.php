<?php

namespace Api\Models\Categories\BondCategoryProducts;

use DataBase\RepositoryConnection\Repository;

class CategoryProductsRepository extends Repository{

    public function createBond(int $productId, array $categories) {
        $bondedValues = [];
        foreach($categories as $category){
          array_push($bondedValues, [$category,$productId]);
        }
        
        return $this->insert()->setFields(['categories_id','products_id'])->setValues($bondedValues)->runQuery();
    }

    public function findBonds($products_id, $categories_id, array $fields = ['*']) {
        return $this->select()->setFields($fields)->setWhere('categories_id = '.$categories_id.' AND products_id IN ('.$products_id.')')->fetchObject(true, $this->getDtoPath());
    }

    public function findBondsByCategoryId(int $categories_id, array $fields = ['*']){
        return $this->select()->setFields($fields)->setWhere('categories_id = '.$categories_id)->fetchAssoc(true);
    }

    public function findBondCategoriesByProductId(int $products_id){
        return $this->select()
          ->setFields(['bond_categories_products.id as bondId', 'categories.id' , 'categories.name'])
          ->setInnerJoin(['table'=>'bond_categories_products', 'ON'=>'categories_id'], ['table'=>'categories'])
          ->setWhere('bond_categories_products.products_id = '.$products_id)
          ->fetchAssoc(true);
    }

    public function deleteBond(int $id) {
        return $this->delete()->setWhere('id = '.$id)->runQuery();
    }

    public function updateBonds(int $productsId, array $categories) {
      $this->delete()->setWhere('products_id IN ('.(string)$productsId.')')->runQuery();
      if($categories){
        $this->createBond($productsId, $categories);
      }
      return true;
    }
}

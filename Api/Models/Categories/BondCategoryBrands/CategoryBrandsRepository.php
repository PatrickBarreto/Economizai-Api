<?php

namespace Api\Models\Categories\BondCategoryBrands;

use DataBase\RepositoryConnection\Repository;

class CategoryBrandsRepository extends Repository{

    public function createBond(int $brandId, array $categories) {
      $bondedValues = [];
      foreach($categories as $category){
        array_push($bondedValues, [$category,$brandId]);
      }
      
      return $this->insert()->setFields(['categories_id','brands_id'])->setValues($bondedValues)->runQuery();
    }

    public function findBondCategoriesByBrandId(int $brands_id){
      return $this->select()
        ->setFields(['bond_categories_brands.id as bondId', 'categories.id' , 'categories.name'])
        ->setInnerJoin(['table'=>'bond_categories_brands', 'ON'=>'categories_id'], ['table'=>'categories'])
        ->setWhere('bond_categories_brands.brands_id = '.$brands_id)
        ->fetchAssoc(true);
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

      public function updateBonds(int $brandsId, array $categories) {
      $this->delete()->setWhere('brands_id IN ('.(string)$brandsId.')')->runQuery();
      if($categories){
        $this->createBond($brandsId, $categories);
      }
      return true;
    }

}

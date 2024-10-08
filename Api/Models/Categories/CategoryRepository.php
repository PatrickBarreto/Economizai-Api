<?php

namespace Api\Models\Categories;

use DataBase\RepositoryConnection\Repository;
use Http\Request\Request;
use stdClass;

class CategoryRepository extends Repository{

    public function createCategory(Request $request) {
        $content = $request->getBody();
        return $this->insert()->setFields(['accounts_id', 'name'])
                            ->setValues([$request->currentUser, $content->name])
                            ->runQuery();
    }


    public function findAllUsersCategories(int $currentUserId, $fields = ['*']) {
        return $this->select()->setFields($fields)
                            ->setWhere('accounts_id = 0 OR accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
    public function findUsersCategoriesAndProducts(int $currentUserId, int $categoryId){
        return $this->select()->setFields(['products.id','products.name'])
                    ->setInnerJoin(
                                ['table'=>'categories'], 
                                ['table'=>'bond_categories_products', 'ON'=>'categories_id']
                                )
                    ->setInnerJoin(
                                ['table'=>'bond_categories_products', 'ON'=>'products_id'],
                                ['table'=>'products']
                                )
                    ->setWhere('categories.id = '.$categoryId .' OR categories.id = 0 AND categories.accounts_id = '. $currentUserId)
                    ->fetchAssoc(true);
    }


    public function findUsersCategoriesAndBrands(int $currentUserId, int $categoryId){
        return $this->select()->setFields(['brands.id','brands.name'])
                    ->setInnerJoin(
                                ['table'=>'categories'], 
                                ['table'=>'bond_categories_brands', 'ON'=>'categories_id']
                                )
                    ->setInnerJoin(
                                ['table'=>'bond_categories_brands', 'ON'=>'brands_id'],
                                ['table'=>'brands']
                                )
                    ->setWhere('categories.id = '.$categoryId .' OR categories.id = 0 AND categories.accounts_id = '. $currentUserId)
                    ->fetchAssoc(true);
    }
   
    
    public function findCategory(int $currentUserId, int $categoryId, array $fields = ['*'], $array = true) {
        $query = $this->select()->setFields($fields)->setWhere('accounts_id = 0 OR accounts_id = '.$currentUserId.' AND id = '.$categoryId);
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, $this->getDtoPath());
    }
   
   
   
    public function updateCategory(int $currentUserId, stdClass $content, Category $category) {
        return $this->update()->setSet([
                ['name' => empty($content->name) ?  $category->getProperty('name') : $content->name],
                ['edited'=>time()]
            ])
        ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$category->getProperty('id'))
        ->runQuery();
    }


    public function deleteCategory(int $categoryId) {
       return $this->delete()->setWhere('id = '.$categoryId)->runQuery();
    }    
}
<?php

namespace Api\Models\Categories;

use DataBase\CrudExtension;
use Http\Request\Request;
use stdClass;

class Category extends CrudExtension{

    public static string $table = 'categories';

    protected int $id;
    protected int $accounts_id;
    protected string $name;
    protected string$type;
    protected string $created;
    protected string $edited;


    public function createCategory(Request $request) {
        $content = $request->getBody();
        return $this->insert->setFields(['accounts_id', 'name'])
                            ->setValues([$request->currentUser, $content->name])
                            ->runQuery();
    }



    public function findAllUsersCategories(int $currentUserId, $fields = ['*']) {
        return $this->select->setFields($fields)
                            ->setWhere('accounts_id = 0 OR accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }
   
   
    public function findUsersCategoriesAndProducts(int $currentUserId, int $categoryId){
        return $this->select->setFields(['products.id','products.name', 'brands.id as brandId', 'brands.name as brandName'])
                    ->setInnerJoin(
                                ['table'=>'categories'], 
                                ['table'=>'bond_categories_products', 'ON'=>'categories_id']
                                )
                    ->setInnerJoin(
                                ['table'=>'bond_categories_products', 'ON'=>'products_id'],
                                ['table'=>'products']
                                )
                    ->setLeftJoin(
                        ['table'=>'products','ON'=>'brands_id'], 
                        ['table'=>'brands']
                        )
                    ->setWhere('categories.id = '.$categoryId .' OR categories.id = 0 AND categories.accounts_id = '. $currentUserId)
                    ->fetchAssoc(true);
    }
   
    public function findCategory(int $categoryId, array $fields = ['*'], $array = true) {
        $query = $this->select->setFields($fields)->setWhere('id = '.$categoryId);
        
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, self::class);
    }
   
   
   
    public function updateCategory(int $currentUserId, stdClass $content) {
        $teste = $this->update->setSet([
                                    ['name'=>$content->name]
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$this->id)
                            ->runQuery();
    }


    public function deleteCategory() {
       return $this->delete->setWhere('id = '.$this->id)->runQuery();
    }    
    
}
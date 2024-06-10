<?php

namespace Api\Models\Brands;

use Api\Common\Log\Log;
use DataBase\RepositoryConnection\Repository;
use Http\Request\Request;
use stdClass;

class BrandRepository extends Repository{


    public function createBrand(Request $request) {
        $content = $request->getBody();
        return $this->insert()->setFields(['accounts_id', 'name', 'type'])
                            ->setValues([$request->currentUser, $content->name, $content->type])
                            ->runQuery();
    }



    public function findAllUsersBrand(int $currentUserId, $fields = ['*']) {
        return $this->select()->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->fetchAssoc(true);
    }


     public function findAllBrandsAndCheckIfBondWithCategory(int $currentUserId, int $categoryID){
        return $this->select()->setFields(['brands.id', 'brands.name', 'brands.type', 
                                            '(
                                                SELECT GROUP_CONCAT(categories_id, "") as categoriesConcat
                                                FROM bond_categories_brands 
                                                WHERE bond_categories_brands.brands_id = brands.id AND bond_categories_brands.categories_id = '.$categoryID.'
                                            ) as brandsCategory'])
            ->setLeftJoin(['table' => 'brands'], ['table' => 'bond_categories_brands', 'ON'=>'brands_id'] )
            ->setWhere('brands.accounts_id = '. $currentUserId)
            ->setGroupBy(['brands.id'])
            ->fetchObject(true);
    }
   
   
   
    public function findBrand(int $currentUserId, int $shopplingList, array $fields = ['*'], $array = true) {
        $query = $this->select()->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$shopplingList);
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, $this->getDtoPath());
    }
   
   
   
    public function updateBrand(int $currentUserId, stdClass $content, Brand $brand) {
        return $this->update()->setSet([
                                    ['name'=> $content->name ? $content->name : $brand->getProperty('name')],
                                    ['type'=> $content->type ? $content->type : $brand->getProperty('type')],
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$brand->getProperty('id'))
                            ->runQuery();
       
    }



    public function deleteBrand(int $brandId) {
       return $this->delete()->setWhere('id = '.$brandId)->runQuery();
    }    

    
}
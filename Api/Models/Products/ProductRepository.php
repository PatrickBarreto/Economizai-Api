<?php

namespace Api\Models\Products;

use DataBase\RepositoryConnection\Repository;
use Http\Request\Request;
use stdClass;

class ProductRepository extends Repository{

    public function createProduct(Request $request) {
        $content = $request->getBody();
        return $this->insert()->setFields(['accounts_id', 'name', 'type', 'volume', 'unit_mensure'])
                            ->setValues([$request->currentUser, $content->name, $content->type, $content->volume, $content->unit_mensure])
                            ->runQuery();
    }



    public function findAllUsersProducts(int $currentUserId, $fields = ['*']) {
        return $this->select()->setFields($fields)
                            ->setWhere('accounts_id = '. $currentUserId)
                            ->setOrder('created', 'DESC')
                            ->fetchAssoc(true);
    }
   
   
   
    public function findProduct(int $currentUserId, int $productId, array $fields = ['*'], $array = true) {
        $query = $this->select()->setFields($fields)->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$productId);
        return ($array) ? $query->fetchAssoc() : $query->fetchObject(false, $this->getDtoPath());
    }


    //Preciso trazer toda listagem de produtos, porém, preciso sinalizar qual deles já possui vinculo com a categoria da onde esse endpoint foi chamado.

    public function findAllProductsAndCheckIfBondWithCategory(int $currentUserId, int $categoryID){
        return $this->select()->setFields(['products.id', 'products.name', 'products.type', 'products.volume', 'products.unit_mensure', 
                                            '(
                                                SELECT GROUP_CONCAT(categories_id, "") as categoriesConcat
                                                FROM bond_categories_products 
                                                WHERE bond_categories_products.products_id = products.id AND bond_categories_products.categories_id = '.$categoryID.'
                                            ) as productsCategory'])
            ->setLeftJoin(['table' => 'products'], ['table' => 'bond_categories_products', 'ON'=>'products_id'] )
            ->setWhere('products.accounts_id = '. $currentUserId)
            ->setGroupBy(['products.id'])
            ->fetchObject(true);
    }
   
   
   
    public function updateProduct(int $currentUserId, stdClass $content, Product $product) {
        return $this->update()->setSet([
                                    ['name' => empty($content->name) ?  $product->getProperty('name') : $content->name],
                                    ['type' => empty($content->type) ? $product->getProperty('type') : $content->type],
                                    ['volume' => empty($content->volume) ? $product->getProperty('volume') : $content->volume],
                                    ['unit_mensure' => empty($content->unit_mensure) ? $product->getProperty('unit_mensure') : $content->unit_mensure],
                                    ['edited'=>time()]
                                ])
                            ->setWhere('accounts_id = '. $currentUserId. ' AND id = '.$product->getProperty('id'))
                            ->runQuery();
    }



    public function deleteProduct(int $productId) {
       return $this->delete()->setWhere('id = '.$productId)->runQuery();
    }    

    
}
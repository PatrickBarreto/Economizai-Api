<?php

namespace Api\Models\ShoppingLists\ShoppingListProductOptions;

use DataBase\RepositoryConnection\Repository;

class ShoppingListProductOptionsRepository extends Repository{

    public function create(array $values) {

        //Antes de inserir isso deve verificar se o produto e a marca são da mesma categoria
        
        return $this->insert()->setFields([
                                        'shopping_lists_execution_hash',
                                        'bond_shopping_lists_products_id',
                                        'products_id',
                                        'brands_id',
                                        'type_description',
                                        'wheight',
                                        'unit_mensure',
                                        'quantity',
                                        'price'
                                        ])->setValues($values)->runQuery();
    }


    public function listOptionsByProductList(string $executionHash, int $productListId){
        return $this->select()->setWhere('shopping_lists_execution_hash = "'.$executionHash.'" 
                                        AND bond_shopping_lists_products_id = '.$productListId)
                            ->fetchAssoc(true);
    }


    public function findDetailByProductOptionId(int $id, string $executionHash){
        return $this->select()->setFields(
                                [
                                    'bond_shopping_lists_products_options.id as OptionId',
                                    'bond_shopping_lists_products_options.products_id as OptionProductId',
                                    'products.name as OptionProductName',
                                    'brands.name as OptionProductBrandName',
                                ])
                    ->setInnerJoin(
                                    ['table'=> 'bond_shopping_lists_products_options','ON'=> 'bond_shopping_lists_products_id'],
                                    ['table'=> 'bond_shopping_lists_products']
                                )
                    ->setInnerJoin(
                                    ['table'=> 'bond_shopping_lists_products_options','ON'=> 'products_id'],
                                    ['table'=> 'products']
                                )
                    ->setInnerJoin(
                                    ['table'=> 'bond_shopping_lists_products_options','ON'=> 'brands_id'],
                                    ['table'=> 'brands']
                                )
                    ->setWhere('bond_shopping_lists_products_options.id = '.$id.' 
                                AND bond_shopping_lists_products_options.shopping_lists_execution_hash = "'.$executionHash.'"')
                    ->fetchAssoc(false);
    }

    public function findProductOption(int $id, string $executionHash){
        return $this->select()->setWhere('bond_shopping_lists_products_options.id = '.$id.' 
                                        AND bond_shopping_lists_products_options.shopping_lists_execution_hash = "'.$executionHash.'"')
                            ->fetchObject(false, self::class);
    }

    public function delete(){
        return $this->delete()->setWhere('bond_shopping_lists_products_options.id = '.$this->id.' 
                                        AND bond_shopping_lists_products_options.shopping_lists_execution_hash = "'.$this->shopping_lists_execution_hash.'"')
                            ->fetchObject(false, self::class);
    }
}

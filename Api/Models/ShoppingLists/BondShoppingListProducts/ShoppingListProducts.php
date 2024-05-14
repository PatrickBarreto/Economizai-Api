<?php

namespace Api\Models\ShoppingLists\BondShoppingListProducts;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class ShoppingListProducts extends DataBaseCorrespondence{

    private static string $table = 'bond_shopping_lists_products';

    protected int $id;
    protected int $shopping_lists_id;
    protected int $categories_id;
    protected int $products_id;
    protected int $amount;


    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $property){
        return $this->$property;
    }

}

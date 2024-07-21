<?php

namespace Api\Models\ShoppingLists\ShoppingListProductOptions;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class ShoppingListProductOptions extends DataBaseCorrespondence{

    private static string $table = 'bond_shopping_lists_products_options';

    protected int $id;
    protected string $shopping_lists_execution_hash;
    protected int $bond_shopping_lists_products_id;
    protected int $products_id;
    protected int $brands_id;
    protected string $type_description;
    protected float $wheight;
    protected string $unit_mensure;
    protected int $quantity;
    protected float $price;



    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $property){
        return $this->$property;
    }
}
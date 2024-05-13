<?php

namespace Api\Models\Categories\BondCategoryProducts;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class CategoryProducts extends DataBaseCorrespondence{

    private static string $table = 'bond_categories_products';

    protected int $id;
    protected int $categories_id;
    protected int $products_id;


    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $propertyName){
        return $this->$propertyName;
    }
}

<?php

namespace Api\Models\Categories\BondCategoryBrands;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class CategoryBrands extends DataBaseCorrespondence{

    private static string $table = 'bond_categories_brands';

    protected int $id;
    protected int $categories_id;
    protected int $brands_id;
    
    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $propertyName){
        return $this->$propertyName;
    }

}

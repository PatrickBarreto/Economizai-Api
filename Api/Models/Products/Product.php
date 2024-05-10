<?php

namespace Api\Models\Products;

use DataBase\RepositoryConnection\DataBaseCorrespondence;

class Product extends DataBaseCorrespondence{

    private static string $table = 'products';

    protected int $id;
    protected string $name;
    protected string $type;
    protected int $volume;
    protected string $unit_mensure;
    protected int $created;
    protected int $edited;
    

    public static function getTable(){
        return self::$table;
    }
    
}
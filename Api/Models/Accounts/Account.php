<?php

namespace Api\Models\Accounts;

use DataBase\RepositoryConnection\DataBaseCorrespondence;
use DataBase\RepositoryConnection\Repository;
use stdClass;

class Account extends DataBaseCorrespondence{
    private static string $table = 'accounts';

    protected int $id;
    public string $name;
    public string $phone;
    public string $email;
    public string $password;

    public static function getTable(){
        return self::$table;
    }

    public function getProperty(string $paramName){
        return $this->$paramName;
    }
}
<?php

namespace Api\Models\Accounts;

use DataBase\CrudExtension;
use stdClass;

class Account extends CrudExtension{
    public static string $table = 'accounts';

    protected int $id;
    public string $name;
    public string $phone;
    public string $email;

    public function createAccount(stdClass $content){
        return $this->insert->setFields(['name', 'phone', 'email'])->setValues([$content->name, (string)$content->phone, $content->email])->runQuery();
    }



    public function getAccountData(int $id, array $fields = ["*"], $array = false){
        if($array){
            $return = $this->select->setFields($fields)->setWhere('id = '.$id)->fetchAssoc(false);
        }else {
            $return = $this->select->setFields($fields)->setWhere('id = '.$id)->fetchObject(false, self::class);
        }
        return $return;
    }



    public function updateAccount(){
        return $this->update->setSet([
                                    ['name'=>$this->name], 
                                    ['phone'=>$this->phone], 
                                    ['email'=>$this->email]
                                ])
                                ->setWhere("id = ".$this->id)->runQuery();
    }



    public function deleteAccount(){
        return $this->delete->setWhere("id = ".$this->id)->runQuery();
    }
}
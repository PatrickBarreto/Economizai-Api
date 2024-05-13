<?php

namespace Api\Models\Accounts;

use DataBase\RepositoryConnection\Repository;
use stdClass;

class AccountRepository extends Repository{

    public function createAccount(stdClass $content){
        return $this->insert()->setFields(['name', 'phone', 'email', 'password'])->setValues([$content->name, (string)$content->phone, $content->email, md5($content->password)])->runQuery();
    }


    public function getUserLoginByPhoneAndPassword(string $phone, string $password){
        return $this->select()->setFields(['id', 'name', 'phone', 'email'])
                            ->setWhere('phone = '.$phone.' AND password = "'.md5($password).'"');
    }


    public function getUserLoginByEmailAndPassword(string $email, string $password){
        return $this->select()->setFields(['id', 'name', 'phone', 'email'])
                            ->setWhere('email = "'.$email.'" AND password = "'.md5($password).'"');
    }


    public function getAccountData(int $id, array $fields = ["*"], $array = false){
        if($array){
            $return = $this->select()->setFields($fields)->setWhere('id = '.$id)->fetchAssoc(false);
        }else {
            $return = $this->select()->setFields($fields)->setWhere('id = '.$id)->fetchObject(false, $this->getDtoPath());
        }
        return $return;
    }

    public function updateAccount(int $accountId, $name, $phone, $email){
        return $this->update()->setSet([
                                    ['name'=>$name], 
                                    ['phone'=>$phone], 
                                    ['email'=>$email]
                                ])
                                ->setWhere("id = ".$accountId)->runQuery();
    }

    public function deleteAccount(int $accountId){
        return $this->delete()->setWhere("id = ".$accountId)->runQuery();
    }

}
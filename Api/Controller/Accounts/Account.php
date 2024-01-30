<?php

namespace Api\Controller\Accounts;

use Api\Models\Accounts\Account as ModelAccount;
use Exception\Exception;
use stdClass;

class Account {

    public function createAccount(stdClass $content){
        return (new ModelAccount())->createAccount($content);
    }



    public function getAccountData(int $id){
        $account = (new ModelAccount())->getAccountData($id, ['name','phone', 'email'], true);
        if($account){
            return $account;
        }
        Exception::throw("Account not found", 200);
    }



    public function updateAccount(stdClass $content, int $id){
        $account = (new ModelAccount())->getAccountData(($id));
        if($account){
            $account->name = empty($content->name) ? $account->name : $content->name;
            $account->phone = empty($content->phone) ? $account->phone : $content->phone;
            $account->email = empty($content->email) ? $account->email : $content->email;
            $account->updateAccount();
            return true;
        }
        Exception::throw("Account not found", 200);
    }


    
    public function deleteAccount(int $id){
        $account = (new ModelAccount())->getAccountData(($id));
        if($account){
            $account->deleteAccount();
            return true;
        }
        Exception::throw("Account not found", 200);
    }
}
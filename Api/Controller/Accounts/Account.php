<?php

namespace Api\Controller\Accounts;

use Api\Models\Accounts\Account as ModelAccount;
use Authorizer\JWT\JWT;
use Authorizer\JWT\JWTPayload;
use Exception\Exception;
use stdClass;

class Account {

    public function createAccount(stdClass $content){
        return (new ModelAccount())->createAccount($content);
    }


    public static function login(stdClass $content){
        $user = self::returnAccountInstanceByLoginType($content);
        if($user){
            $payload = new JWTPayload($user->getParam('id'), [
                            'id'=>$user->getParam('id'),
                            'name'=>$user->getParam('name')
            ]);
            $payload->setExp(time()+3600);
            $JWT = JWT::createToken($payload);
            header('Authorization: '.$JWT);
            return;
        }
        Exception::throw("Refused login", 200);
    }

    public static function renewToken(string $JWT){
        $JWT = JWT::renewToken($JWT, 1);
        if($JWT){
            header('Authorization: '.$JWT);
        }
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


    private static function returnAccountInstanceByLoginType(stdClass $content){
        if(isset($content->password)){
            if(isset($content->phone)){
                return (new ModelAccount())->getUserLoginByPhoneAndPassword($content->phone, $content->password)->fetchObject(false, ModelAccount::class);
            }
            if(isset($content->email)){
                return (new ModelAccount())->getUserLoginByEmailAndPassword($content->email, $content->password)->fetchObject(false, ModelAccount::class);
            }
        }
        Exception::throw("Refused login", 200);
    }
}
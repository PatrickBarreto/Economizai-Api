<?php

namespace Api\Controller\Accounts;

use Api\Models\Accounts\Account as ModelAccount;
use Api\Models\Accounts\AccountRepository;
use Authorizer\JWT\JWT;
use Authorizer\JWT\JWTPayload;
use Exception\Exception;
use stdClass;

class Account {

    public function createAccount(stdClass $content){
        return (new AccountRepository(new ModelAccount()))->createAccount($content);
    }


    public static function login(stdClass $content){
        $user = self::returnAccountInstanceByLoginType($content);
        if($user instanceof ModelAccount){
            $payload = new JWTPayload($user->getProperty('id'), 
                                    [
                                        'id'=>$user->getProperty('id'),
                                        'name'=>$user->getProperty('name')
                                    ]
                                );
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
        $accountRepository = new AccountRepository(new ModelAccount());
        $account = $accountRepository->getAccountData($id, ['name','phone', 'email'], true);
        if($account){
            return $account;
        }
        Exception::throw("Account not found", 200);
    }

    public function updateAccount(stdClass $content, int $id){
        $accountRepository = new AccountRepository(new ModelAccount());
        $account = $accountRepository->getAccountData(($id));
        
        if($account instanceof ModelAccount){
            $account->name  = empty($content->name)  ? $account->name  : $content->name;
            $account->phone = empty($content->phone) ? $account->phone : $content->phone;
            $account->email = empty($content->email) ? $account->email : $content->email;
            
            $accountRepository->updateAccount($account->getProperty('id'), $account->name, $account->phone, $account->email);
            return true;
        }
        Exception::throw("Account not found", 200);
    }


    
    public function deleteAccount(int $id){
        $accountRepository = new AccountRepository(new ModelAccount());
        $account = $accountRepository->getAccountData(($id));

        if($account instanceof ModelAccount){
            $accountRepository->deleteAccount($account->getProperty('id'));
            return true;
        }
        Exception::throw("Account not found", 200);
    }


    private static function returnAccountInstanceByLoginType(stdClass $content){
        $accountRepository = new AccountRepository(new ModelAccount());
        
        if(isset($content->password)){
            if(isset($content->phone)){
                return $accountRepository->getUserLoginByPhoneAndPassword($content->phone, $content->password)->fetchObject(false, ModelAccount::class);
            }
            if(isset($content->email)){
                return $accountRepository->getUserLoginByEmailAndPassword($content->email, $content->password)->fetchObject(false, ModelAccount::class);
            }
        }
        Exception::throw("Refused login", 200);
    }
}
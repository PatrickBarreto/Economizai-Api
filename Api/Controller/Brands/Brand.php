<?php

namespace Api\Controller\Brands;

use Api\Models\Brands\Brand as BrandModel;
use Exception\Exception;
use Http\Request\Request;

class Brand {

    public static function createBrand(Request $request) {
        return (new BrandModel)->createBrand($request);
    }
    



    public static function findUsersBrands(int $currentUser){
        $Brand = (new BrandModel)->findAllUsersBrand($currentUser, ['id','account_id', 'name', 'type']);
        if($Brand) {
            return $Brand;
        }
        Exception::throw("Brand not found", 200);
    }




    public static function findBrand(Request $request){
        $Brand = (new BrandModel)->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','account_id', 'name', 'type']);
        if($Brand) {
            return $Brand;
        }
        Exception::throw("Brand not found", 200);
    }



    public static function updateBrand(Request $request){
        $Brand = (new BrandModel)->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','account_id', 'name', 'type'], false);
        if($Brand) {
            return $Brand->updateBrand($request->currentUser, $request->getBody());
        }
        Exception::throw("Brand not found", 200);
    }



    public static function deleteBrand(Request $request){
        $Brand = (new BrandModel)->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','account_id', 'name', 'type'], false);
        if($Brand) {
            return $Brand->deleteBrand();
        }
        Exception::throw("Brand not found", 200);
    }
}
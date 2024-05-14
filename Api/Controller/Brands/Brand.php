<?php

namespace Api\Controller\Brands;

use Api\Models\Brands\Brand as BrandModel;
use Api\Models\Brands\BrandRepository;
use Exception\Exception;
use Http\Request\Request;

class Brand {

    public static function createBrand(Request $request) {
        return (new BrandRepository(new BrandModel))->createBrand($request);
    }
    



    public static function findUsersBrands(int $currentUser){
        $brandRepository = (new BrandRepository(new BrandModel));
        $brand = $brandRepository->findAllUsersBrand($currentUser, ['id','accounts_id', 'name', 'type']);
        if($brand) {
            return $brand;
        }
        Exception::throw("Brand not found", 200);
    }




    public static function findBrand(Request $request){
        $brandRepository = (new BrandRepository(new BrandModel));
        $brand = $brandRepository->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type']);
        if($brand) {
            return $brand;
        }
        Exception::throw("Brand not found", 200);
    }



    public static function updateBrand(Request $request){
        $brandRepository = (new BrandRepository(new BrandModel));
        $brand = $brandRepository->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        if($brand) {
            return $brandRepository->updateBrand($request->currentUser, $request->getBody(), $brand->getProperty('id'));
        }
        Exception::throw("Brand not found", 200);
    }



    public static function deleteBrand(Request $request){
        $brandRepository = (new BrandRepository(new BrandModel));
        $brand = $brandRepository->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        if($brand) {
            return $brandRepository->deleteBrand($brand->getProperty('id'));
        }
        Exception::throw("Brand not found", 200);
    }
}
<?php

namespace Api\Controller\Brands;

use Api\Models\Brands\Brand as BrandModel;
use Api\Models\Brands\BrandRepository;
use Api\Models\Categories\BondCategoryBrands\CategoryBrands;
use Api\Models\Categories\BondCategoryBrands\CategoryBrandsRepository;
use Exception\Exception;
use Http\Request\Request;

class Brand {

    public static function createBrand(Request $request) {
      $brandRepository = (new BrandRepository(new BrandModel));
      $categoryBrandBondRepository = (new CategoryBrandsRepository(new CategoryBrands));
      $brandId = $brandRepository->CreateAndReturnBrandId($request);
      
      $categoryIds = $request->getBody()->categories;

      if($categoryIds) {
        $categoryBrandBondRepository->createBond($brandId, $categoryIds);
      }

      return true;
    }
    



    public static function findUsersBrands(int $currentUser){
        $brandRepository = (new BrandRepository(new BrandModel));
        $brand = $brandRepository->findAllUsersBrand($currentUser, ['id','accounts_id', 'name', 'type']);
        if($brand) {
            return $brand;
        }
        Exception::throw("Brand not found", 404);
    }



    public static function findAllBrandsWithInformationAboutBondCategory(Request $request){
        $brandsRepository = new BrandRepository(new BrandModel);
        $currentUser = $request->currentUser;
        $categoryId = $request->getPathParams('id');

        return $brandsRepository->findAllBrandsAndCheckIfBondWithCategory($currentUser, $categoryId);
    }



    public static function findBrand(Request $request){
        $brandRepository = (new BrandRepository(new BrandModel));
        $categoryBrandBondRepository = (new CategoryBrandsRepository(new CategoryBrands));

        $brand = $brandRepository->findBrand($request->currentUser, $request->getPathParams()['id'], ['id', 'accounts_id', 'name', 'type']);
        if($brand) {
            $bonds = $categoryBrandBondRepository->findBondCategoriesByBrandId($brand['id']);
            $brand['categories'] = $bonds;
            return $brand;
        }
        Exception::throw("Product not found", 404);
    }

    public static function updateBrand(Request $request){
          $brandRepository = (new BrandRepository(new BrandModel));
          $categoryBrandBondRepository = (new CategoryBrandsRepository(new CategoryBrands));

          $brand = $brandRepository->findBrand((int)$request->currentUser, (int)$request->getPathParams()['id'], ['id'], false);
          if($brand instanceof BrandModel) {
            $newBrandData = $request->getBody();
            $brandRepository->updateBrand($request->currentUser, $newBrandData, $brand);
            if(isset($newBrandData->categories)) {
              $categoryBrandBondRepository->updateBonds($brand->getProperty('id'), $newBrandData->categories);
            }
            return true;
          }
          Exception::throw("Brand not found", 404);
      }




    public static function deleteBrand(Request $request){
        $brandRepository = (new BrandRepository(new BrandModel));
        $brand = $brandRepository->findBrand($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name', 'type'], false);
        if($brand instanceof BrandModel) {
            return $brandRepository->deleteBrand($request->currentUser, $brand->getProperty('id'));
        }
        Exception::throw("Brand not found", 404);
    }
}
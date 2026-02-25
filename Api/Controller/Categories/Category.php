<?php

namespace Api\Controller\Categories;

use Api\Common\Log\Log;
use Api\Models\Brands\Brand as BrandModel;
use Api\Models\Brands\BrandRepository;
use Api\Models\Categories\BondCategoryBrands\CategoryBrands;
use Api\Models\Categories\BondCategoryBrands\CategoryBrandsRepository;
use Api\Models\Categories\BondCategoryProducts\CategoryProducts;
use Api\Models\Products\ProductRepository;
use Api\Models\Categories\BondCategoryProducts\CategoryProductsRepository;
use Api\Models\Categories\BondInterface;
use Api\Models\Categories\Category as CategoryModel;
use Api\Models\Categories\CategoryRepository;
use Api\Models\Products\Product;
use Exception\Exception;
use Http\Request\Request;

class Category {

    public static function createCategory(Request $request) {
      $productsRepository = new ProductRepository(new Product);
      $brandsRepository = new BrandRepository(new BrandModel);
      $categoryRepository = new CategoryRepository(new CategoryModel);
      $categoryProductsRepository = new CategoryProductsRepository(new CategoryProducts);
      $categoryBrandsRepository = new CategoryBrandsRepository(new CategoryBrands);

      $body = $request->getBody();

      $categoryInsertIntance = $categoryRepository->createCategory($request);   

      $productsUser = $productsRepository->findAllUsersProducts($request->currentUser, ['id']);
      $brandsUser = $brandsRepository->findAllUsersBrand($request->currentUser, ['id']);

      $usersProductsIds = array_map(function($p){
          return $p['id'];
      }, $productsUser);

      $usersBrandsIds = array_map(function($b){
          return $b['id'];
      }, $brandsUser);

      if($body->products && $usersProductsIds && array_intersect($body->products, $usersProductsIds)){
        $categoryProductsRepository->createBondCategory($categoryInsertIntance->lastInsertId, $body->products);
      }

      if($body->brands && $usersBrandsIds && array_intersect($body->brands, $usersBrandsIds)){
        $categoryBrandsRepository->createBondCategory($categoryInsertIntance->lastInsertId, $body->brands);
      }

      return true;
    }
    


    public static function findUsersCategories(int $currentUser){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $categories = $categoryRepository->findCategories($currentUser, ['id','accounts_id', 'name']);

        if($categories) {
            return $categories;
        }
        Exception::throw("Category not found", 404);
    }

    public static function findCategoriesProducts(int $currentUser){
      $categoryRepository = new CategoryRepository(new CategoryModel);
      $categories = $categoryRepository->findCategoriesProducts($currentUser, [
        'categories.id as catId',
        'categories.name as catName',
        'products.id as prodId',
        'products.type as prodType',
        'products.name as prodName']);

      $mappedCategories = [];

      foreach ($categories as $row) {
        $products = null;
        $categories=null;
        
        [
          'catId' => $catId,
          'catName' => $catName,
          'prodId' => $prodId,
          'prodName' => $prodName, 
          'prodType' => $prodType  
        ] = $row;

        $categories = [
          'id' => $catId,
          'name' => $catName,
        ];

        if(!isset($mappedCategories[$row["catId"]])){
          $mappedCategories[$row["catId"]] = $categories;
        }
        
        if($prodId){
          $products = [
            'id' => $prodId,
            'name' => $prodName,
            'type' => $prodType,
          ];
        }
        $mappedCategories[$row["catId"]]['products'][] = $products;
      }

      if($mappedCategories) {
          return array_values($mappedCategories);
      }

    }



    public static function findCategory(Request $request){
        $categoryRepository = new CategoryRepository(new CategoryModel);
        $brandCategoriesRepository = new CategoryBrandsRepository(new CategoryBrands);
        $productCategoriesRepository = new CategoryProductsRepository(new CategoryProducts);
       
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name'], false);
        $category->products = [];
        $category->brands = [];

        if($category instanceof CategoryModel) {
          
            $toReturn = [
              "id" => $category->getProperty('id'),
              "name"=>  $category->getProperty('name'),
              "accounts_id"=> $category->getProperty('accounts_id'),
              "products"=> $productCategoriesRepository->findBondsByCategoryId($category->getProperty('id')),
              "brands"=> $brandCategoriesRepository->findBondsByCategoryId($category->getProperty('id'))
            ];

          return $toReturn;
        }
        Exception::throw("Category not found", 404);
    }



    public static function updateCategory(Request $request){     
      $categoryRepository             = new CategoryRepository(new CategoryModel); 
      $bondsCategoryProductRepository = new CategoryProductsRepository(new CategoryProducts);
      $bondCategoryBrandsRepository   = new CategoryBrandsRepository(new CategoryBrands);
      
      $body = (object)$request->getBody();

      $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name'], false);

      if($category instanceof CategoryModel) {
          
          $categoryRepository->updateCategory($request->currentUser, $body, $category);
          $products = [];
          $brands = [];

          if(isset($body->products)){
              $products = is_array($body->products) ? $body->products : [$body->products];
              static::resolveBond($bondsCategoryProductRepository, $category, $products, "products");
          }
          
          if(isset($body->brands)){
              $brands = is_array($body->brands) ? $body->brands : [$body->brands];
              static::resolveBond($bondCategoryBrandsRepository, $category, $brands, "brands");
          }

          return true;

      }
      Exception::throw("Category not found", 404);
    }



    public static function deleteCategory(Request $request){
        $categoryRepository = (new CategoryRepository(new CategoryModel));
        $category = $categoryRepository->findCategory($request->currentUser, $request->getPathParams()['id'], ['id','accounts_id', 'name'], false);

        if($category instanceof CategoryModel) {
          return $categoryRepository->deleteCategory($request->currentUser, $category->getProperty('id'));
        }
        Exception::throw("Category not found", 404);
    }


     /**
     * Este método está na controller, mas talvez vire um serviço para ser compartilhado com outras classes.. Um serviço abstrato que vou concluir conforme
     * for utilizando isso em outros pontos do sistema. 
     */
    private static function resolveBond (BondInterface $bondsTypeRepository, CategoryModel $category, array $bondable, string $bondType ) {
      $column = $bondType == "products" ? "products_id" : "brands_id";

      $categoryBonds = $bondsTypeRepository->findBondsByCategoryId($category->getProperty('id'), ['id', $column]);   

      $categoryBonds = array_map(function ($bond) use ($column) {
        return $bond[$column];
      }, $categoryBonds);
                  
      if($bondable || $categoryBonds){
          $toCrerateBond = array_diff($bondable, $categoryBonds);
          $toRemoveBond = array_diff($categoryBonds, $bondable);
          
          if($toCrerateBond){
            $bondsTypeRepository->createBondCategory($category->getProperty('id'), $toCrerateBond);
          }

          if($toRemoveBond){
              $bondsTypeRepository->deleteAllBond($category->getProperty('id'), $toRemoveBond);
          }
        }

      return;
    }
}
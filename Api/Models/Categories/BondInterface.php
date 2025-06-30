<?php 
namespace Api\Models\Categories;

interface BondInterface {
  public function findBondsByCategoryId(int $categories_id, array $fields = ['*']);
  public function deleteAllBond(int $categorieId, array $toBond);
  public function createBondCategory(int $categoryId, array $toBond);
}

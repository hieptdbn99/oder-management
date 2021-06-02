<?php
namespace App\Repositories\Product;

interface ProductInterface {
    public function getAllProduct();
    public function getProductById($id);
    public function getProductByName($name);
}

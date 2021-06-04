<?php

namespace App\Repositories\Product;
use App\Product;
use App\Repositories\Product\ProductInterface;

class ProductRepository implements ProductInterface
{
    public function getAllProduct()
    {
        return Product::all();
    }
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }
    public function getProductByName($name)
    {
        return Product::where('name',$name)->get();
    }
}

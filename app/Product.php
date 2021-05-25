<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    /**
     * The oder that belong to the Product
     *
     * @return \Illuminate\Database\'Order'lations\BelongsToMany
     */
    protected $table = 'products';


    // Khởi ạo khóa ngoại bảng trung gian quan hệ nhiều nhiều.
    public function oder()
    {
        return $this->belongsToMany('Order', 'order_product', 'product_id', 'order_id');
    }

    // Lấy tất cả sản phẩm.
    public function getAllProduct(){
        return Product::all();
    }

    // Lấy sản phẩm theo id.
    public function getProductById($id){
        return Product::find($id);
    }

    // Lấy sản phẩm bằng tên
    public function getProductByName($name){
        return Product::where('name',$name)->get();
    }
}

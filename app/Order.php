<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    // // Lấy khóa ngaoij vào bảng trung gian
    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }

}

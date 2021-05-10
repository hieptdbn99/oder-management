<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    public function product(){
        return $this->belongsToMany('Product', 'order_product', 'order_id', 'product_id');
    }
}

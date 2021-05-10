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
    public function oder()
    {
        return $this->belongsToMany('Order', 'order_product', 'product_id', 'order_id');
    }
}

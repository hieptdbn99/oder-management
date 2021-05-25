<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    protected $table = 'order_product';

    // Lấy đơn hàng + sản phẩm trong bảng trung gian
    public function getOrderProduct($id)
    {
        return OrderProduct::where('order_id', $id)->get();
    }

    // Lấy sản phẩm 1 đơn hàng
    public function getProductOfOrder($id)
    {
        return OrderProduct::where('order_product.order_id', $id)
            ->join('products', 'order_product.product_id', '=', 'products.id')->get();
    }

    // Lấy sản phẩm để edit
    public function getEditProductOrder($order_id, $product_id)
    {
        return OrderProduct::where('order_id', $order_id)->where('product_id', $product_id)->get();
    }

    // Xóa đơn hàng và sản phẩm trong bảng đơn hàng - sản phẩm
    public function deleteOrderProduct($id)
    {
        OrderProduct::where('order_id', $id)->delete();
    }
}

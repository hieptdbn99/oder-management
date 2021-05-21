<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    //

    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }
    public function getAllOrderPaginate()
    {
        return Order::orderBy('id', 'DESC')->paginate(4);
    }
    public function getOrderById($id)
    {
        return Order::find($id);
    }
    public function getProductByIdOrder($id)
    {
        return Order::find($id)->product()->get();
    }
    public function getOrderProduct($id)
    {
        return DB::table('order_product')->where('order_id', $id)->get();
    }
    public function getProductOfOrder($id)
    {
        return DB::table('order_product')->where('order_product.order_id', $id)
            ->join('products', 'order_product.product_id', '=', 'products.id')->get();
    }
    public function getEditProductOrder($order_id, $product_id)
    {
        return DB::table('order_product')->where('order_id', $order_id)->where('product_id', $product_id)->get();
    }
    public function updateOrder($id, $customer, $productIds, $price, $quantity)
    {
        $order = Order::find($id);
        $order->namecustomer = $customer['namecustomer'];
        if ($customer['avatar'] != "") {
            $order->avatar =  $customer['avatar'];
        }
        $order->phone = $customer['phone'];
        $order->email =  $customer['email'];
        $order->address = $customer['address'];
        $order->note = $customer['note'];
        $order->date = $customer['date'];
        $order->save();
        $arrIdPro = $productIds;
        $arrPricePro = $price;
        $arrQtyPro = $quantity;
        for ($i = 0; $i < count($arrIdPro); $i++) {
            $productDB =   Product::find($arrIdPro[$i]);
            $totalPrice =   intval($arrQtyPro[$i]) * intval($arrPricePro[$i]);
            $order->product()->attach(
                $productDB,
                [
                    'total_product' => $arrQtyPro[$i],
                    'price' => $arrPricePro[$i],
                    'total_price' => $totalPrice
                ]
            );
        }
        $order->totalprice = Order::find($id)->product()->sum('total_price');
        $order->totalproduct = Order::find($id)->product()->sum('total_product');
        $order->save();
    }
    public function storeOrder($customer, $productIds, $price, $quantity)
    {
        $this->namecustomer = $customer['namecustomer'];
        $this->avatar = $customer['avatar'];
        $this->phone = $customer['phone'];
        $this->email =  $customer['email'];
        $this->address = $customer['address'];
        $this->note = $customer['note'];
        $this->date = $customer['date'];
        $this->save();
        $arrIdPro = $productIds;
        $arrPricePro = $price;
        $arrQtyPro = $quantity;

        for ($i = 0; $i < count($arrIdPro); $i++) {
            $productDB =   Product::find($arrIdPro[$i]);
            $totalPrice =   intval($arrQtyPro[$i]) * intval($arrPricePro[$i]);
            $this->product()->attach(
                $productDB,
                [
                    'total_product' => $arrQtyPro[$i],
                    'price' => $arrPricePro[$i],
                    'total_price' => $totalPrice
                ]
            );
        }
        $this->totalprice = Order::find($this->id)->product()->sum('total_price');
        $this->totalproduct = Order::find($this->id)->product()->sum('total_product');
        $this->save();
    }
    public function deleteOrder($id)
    {
        Order::find($id)->delete();
        DB::table('order_product')->where('order_id', $id)->delete();
    }
    public function deleteOrderProduct($id)
    {
        DB::table('order_product')->where('order_id', $id)->delete();
    }
}

<?php

namespace App\Repositories\Order;

use App\Order;
use App\Product;
use App\Repositories\Order\OrderInterface;

class OrderRepository implements OrderInterface {


    public function getAllOrderPaginate()
    {
        return Order::orderBy('id', 'DESC')->paginate(10);
    }
    // Lấy tất cả đơn hàng và phân trang

    //Lấy đơn hàng theo id
    public function getOrderById($id)
    {
        return Order::findOrFail($id);
    }

    //Lấy sản phẩm theo id của đơn hàng
    public function getProductByIdOrder($id)
    {
        return Order::findOrFail($id)->product()->get();
    } 
    
    //cập nhật đơn hàng
    public function updateOrder($id, $customer, $productIds, $price, $quantity)
    {
    
        $order = Order::findOrFail($id);
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
            $productDB =   Product::findOrFail($arrIdPro[$i]);
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
        $order->totalprice = Order::findOrFail($id)->product()->sum('total_price');
        $order->totalproduct = Order::findOrFail($id)->product()->sum('total_product');
        $order->save();
    }

    // tạo mới đơn hàng
    public function storeOrder($customer, $productIds, $price, $quantity)
    {   
        $order = new Order();
        $order->namecustomer = $customer['namecustomer'];
        $order->avatar = $customer['avatar'];
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
            $productDB =   Product::findOrFail($arrIdPro[$i]);
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
        $order->totalprice = Order::findOrFail($order->id)->product()->sum('total_price');
        $order->totalproduct = Order::findOrFail($order->id)->product()->sum('total_product');
        $order->save();
    }

    // xóa đơn hàng
    public function deleteOrder($id)
    {   
        Order::findOrFail($id)->delete();
    }

    // tìm kiếm đơn hàng
    public function searchOrder($name){
        return Order::where('namecustomer','LIKE','%'.$name.'%')->paginate(10);
    }


 }
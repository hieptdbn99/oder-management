<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    // Lấy khóa ngaoij vào bảng trung gian
    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }

    // Lấy tất cả đơn hàng và phân trang
    public function getAllOrderPaginate()
    {
        return Order::orderBy('id', 'DESC')->paginate(10);
    }

    //Lấy đơn hàng theo id
    public function getOrderById($id)
    {
        return Order::find($id);
    }

    //Lấy sản phẩm theo id của đơn hàng
    public function getProductByIdOrder($id)
    {
        return Order::find($id)->product()->get();
    } 
    
    //cập nhật đơn hàng
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

    // tạo mới đơn hàng
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

    // xóa đơn hàng
    public function deleteOrder($id)
    {   
        Order::find($id)->delete();
    }

    // tìm kiếm đơn hàng
    public function searchOrder($name){
        return Order::where('namecustomer','LIKE','%'.$name.'%')->paginate(10);
    }
}

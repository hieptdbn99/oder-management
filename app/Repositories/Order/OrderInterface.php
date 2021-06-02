<?php
namespace App\Repositories\Order;

interface OrderInterface {
    public function getAllOrderPaginate();
    public function getOrderById($id);
    public function getProductByIdOrder($id);
    public function updateOrder($id, $customer, $productIds, $price, $quantity);
    public function storeOrder($customer, $productIds, $price, $quantity);
    public function deleteOrder($id);
    public function searchOrder($name);

}

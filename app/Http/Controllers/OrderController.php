<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderProduct;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->orderObj = new Order();
        $this->productObj = new Product();
    }
    public function index()
    {
        //
        $orders = $this->orderObj->getAllOrderPaginate();
        $products = $this->productObj->getAllProduct();
        return view('order.list')->with('products', $products)->with('orders', $orders);
       
    }
    public function search(Request $request){
        // $products = Product::all();
        // $orders = $request->all();
        // // return view('order.orderlist')->with('products',$products)->with('orders',$orders);
        // return response()->json(['data'=>$orders],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //    
        $products = $this->productObj->getAllProduct();
        return view('order.create')->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' =>'required|email:rfc,dns',
            'avatar' => 'required|mimes:jpg,png|max:100000',
            'phone' => 'required|min:10|numeric|',
            'address' => 'required',
            'date' => 'required',
        ]);
        
        $customer = array();

        $namecustomer = $request->name;
        $customer['namecustomer'] = $namecustomer;
        $phone = $request->phone;
        $customer['phone'] = $phone;
        $email = $request->email;
        $customer['email'] = $email;
        $address = $request->address;
        $customer['address'] = $address;
        $note= $request->note;
        $customer['note'] = $note;
        $date = $request->date;
        $customer['date'] = $date;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');    
            $file->move('uploads',$file->getClientOriginalName());
            $avatar = $file->getClientOriginalName();
            $customer['avatar'] = $avatar;
        }
      
        
        $arrIdPro = $request->productIds;
        $arrPricePro = $request->prices;
        $arrQtyPro = $request->quantities;
        $this->orderObj->storeOrder($customer,$arrIdPro,$arrPricePro,$arrQtyPro);  
        return redirect()->route('order.index');
    
    }
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
        $orderFindId = $this->orderObj->getOrderById($id);
        $product = $this->orderObj->getProductByIdOrder($id);
        $orderProduct = $this->orderObj->getOrderProduct($id);
        return response()->json([ 'orderData' => $orderFindId,'productData' => $product,'orderProductData'=>$orderProduct]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $order = $this->orderObj->getOrderById($id);
        $allproduct = $this->productObj->getAllProduct();
        $product = $this->orderObj->getProductByIdOrder($id);
        $orderProduct = $this->orderObj->getProductOfOrder($id);
        return view('order.edit')->with('order',$order)->with('allProduct', $allproduct)->with('orderProduct', $orderProduct);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  
        $request->validate([
            'name' => 'required',
            'email' =>'required|email:rfc,dns',
            'phone' => 'required|min:10|numeric|',
            'address' => 'required',
        ]);
        $nameCustomer = $request->name;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $file->move('uploads',$file->getClientOriginalName());
            $avatar = $file->getClientOriginalName();
        }else{
            $avatar="";
        }
        $email = $request->email;
        $phone = $request->phone;
        $address= $request->address;
        $note = $request->note;
        $this->orderObj->updateOrder($id,$nameCustomer,$avatar,$phone,$email,$address,$note);
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         
            $this->orderObj->deleteOrder($id);
            return response()->json(['data'=>'remove'],200);
            
    }
    public function removeProduct($orderId,$productId){
        $this->orderObj->deleteProductOfOrder($orderId,$productId);
        return response()->json(['data'=>'remove'],200);

    }
    public function editProduct($orderId,$productId){
        
        $orderProduct = $this->orderObj->getEditProductOrder($orderId,$productId);
        $product = $this->productObj->getProductById($productId);
        return response()->json(['data'=>$orderProduct,'product'=>$product],200);
    }
    public function addProduct(Request $request){
        $order = new Order();
        $product = new Product();
        $getOrder = $order->getOrderById($request->order_id);
        $getPrByName= $product ->getProductByName($request->name_product);
        $getOrder->product()->attach($getPrByName,['total_product'=>$request->quantity,'price'=> $request->price,'total_price' => $request->total]);
        return response()->json(['data'=>"ok"],200);
    }
    public function updateProduct(Request $request, $orderId,$productId)
    {
        //
  
        $order = new Order();
        $order-> updateProductInOrder($orderId,$productId,$request->total_product,$request->price,$request->total);
        //     $order->totalprice = Order::find($order->id)->product()->sum('total_price');
        //     $order->totalproduct = Order::find($order->id)->product()->sum('total_product');
            return response()->json(['data'=>"ok"],200);

    }

  
}

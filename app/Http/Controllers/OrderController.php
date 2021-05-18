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
        return view('order.orderlist')->with('products',$this->productObj->getAllProduct())->with('orders',$this->orderObj->getAllOrderPaginate());
       
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
        $namecustomer = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $address = $request->address;
        $note= $request->note;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');    
            $file->move('uploads',$file->getClientOriginalName());
            $avatar = $file->getClientOriginalName();
        }
        $arr_name_pro = $request->name_product;
        $arr_price_pro = $request->price;
        $arr_qty_pro = $request->quantity;
        $arr_total_pro = $request->total;
        $this->orderObj->storeOrder($namecustomer,$avatar,$phone,$email,$address,$note,$arr_name_pro,$arr_price_pro,$arr_qty_pro,$arr_total_pro);  
        return redirect()->route('order.index')->with('successMsg','Thêm mới thành công!');
    
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
        $order_product = $this->orderObj->getOrderProduct($id);
        return response()->json([ 'order_data' => $orderFindId,'product_data' => $product,'order_product_data'=>$order_product]);
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
        $order_product = $this->orderObj->getProductOfOrder($id);
        return view('order.orderedit')->with('order',$order)->with('allProduct',$allproduct)->with('order_product',$order_product);        
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
      
        $namecustomer = $request->name;
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
        $this->orderObj->updateOrder($id,$namecustomer,$avatar,$phone,$email,$address,$note);
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
    public function removeProduct($order_id,$product_id){
        $this->orderObj->deleteProductOfOrder($order_id,$product_id);
        return response()->json(['data'=>'remove'],200);

    }
    public function editProduct($order_id,$product_id){
        
        $order_product = $this->orderObj->getEditProductOrder($order_id,$product_id);
        $product = $this->productObj->getProductById($product_id);
        return response()->json(['data'=>$order_product,'product'=>$product],200);
    }
    public function addProduct(Request $request){
        $order = new Order();
        $product = new Product();
        $get_order = $order->getOrderById($request->order_id);
        $get_pr_by_name= $product ->getProductByName($request->name_product);
        $get_order->product()->attach($get_pr_by_name,['total_product'=>$request->quantity,'price'=> $request->price,'total_price' => $request->total]);
        return response()->json(['data'=>"ok"],200);
    }
    public function updateProduct(Request $request, $order_id,$product_id)
    {
        //
  
        $order = new Order();
        $order-> updateProductInOrder($order_id,$product_id,$request->total_product,$request->price,$request->total);
        //     $order->totalprice = Order::find($order->id)->product()->sum('total_price');
        //     $order->totalproduct = Order::find($order->id)->product()->sum('total_product');
            return response()->json(['data'=>"ok"],200);

    }

  
}

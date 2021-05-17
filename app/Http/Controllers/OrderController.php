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
    public function index()
    {
        //
        $products = Product::all();
        $orders = Order::all();
        // $order = Order::find(1)->product()->sum('total_price');
        // dd($order);

        return view('order.orderlist')->with('products',$products)->with('orders',$orders);
       
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
      
        $order = new Order();
        // But dd request null
    //    dd($request->all());
       
       $input = $request->all();
     
        $order->namecustomer = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $order->note= $request->note;
            $file->move('uploads',$file->getClientOriginalName());
            $order->avatar = $file->getClientOriginalName();
        }
        $order->save();
        // dd($order);
        $arr_name_pro = $request->name_product;
        $arr_price_pro = $request->price;
        $arr_qty_pro = $request->quantity;
        $arr_total_pro = $request->total;

            for($i = 0 ; $i < count($arr_name_pro);$i++){
            
            $productDB =   Product::where('name', $arr_name_pro[$i])->get();
            $order->product()->attach($productDB,['total_product'=>$arr_qty_pro[$i],'price'=> $arr_price_pro[$i],'total_price' => $arr_total_pro[$i]]);
        }
        $order->totalprice = Order::find($order->id)->product()->sum('total_price');
        $order->totalproduct = Order::find($order->id)->product()->sum('total_product');
       
        
        $order->save();
        
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
        $order = Order::find($id);
        $product = Order::find($id)->product()->get();
        $order_product =  DB::table('order_product')->where('order_id',$id)->get();
        return response()->json([ 'order_data' => $order,'product_data' => $product,'order_product_data'=>$order_product]);
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
        $order = Order::find($id);
        $allproduct = Product::all();
        $product = Order::find($id)->product()->get();
        $order_product =  DB::table('order_product')->where('order_product.order_id',$order->id)
        ->join('products', 'order_product.product_id', '=', 'products.id')->get();
        // return response()->json([ 'order_data' => $order,'product_data' => $product,'order_product_data'=>$order_product]);
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
        $order = Order::find($id);
        $order->namecustomer = $request->name;
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $file->move('uploads',$file->getClientOriginalName());
            $order->avatar = $file->getClientOriginalName();
        }
        $order->email = $request->email;
        $order->phone = $request->phone;

        $order->address= $request->address;
        $order->note = $request->note;
        $order->totalprice = Order::find($id)->product()->sum('total_price');
        $order->totalproduct = Order::find($id)->product()->sum('total_product');

        $alert = "Sửa thành công!";
        $order->save();
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
            Order::find($id)->delete();
            DB::table('order_product')->where('order_id',$id)->delete();
            return response()->json(['data'=>'remove'],200);
            
    }
    public function removeProduct($order_id,$product_id){
        $order = Order::find($order_id);

        DB::table('order_product')->where('order_id', $order_id)->where('product_id',$product_id)->delete();
        $order->totalprice = Order::find($order->id)->product()->sum('total_price');
        $order->totalproduct = Order::find($order->id)->product()->sum('total_product');
        return response()->json(['data'=>'remove'],200);

    }
    public function editProduct($order_id,$product_id){

       $order_product = DB::table('order_product')->where('order_id', $order_id)->where('product_id',$product_id)->get();
       $product = Product::find($product_id);
        return response()->json(['data'=>$order_product,'product'=>$product],200);
    }
    public function addProduct(Request $request){
        
        $order = Order::find($request->order_id);
        $product =Product::where('name',$request->name_product)->get();
        // $data = $request->total;
        $order->product()->attach($product,['total_product'=>$request->quantity,'price'=> $request->price,'total_price' => $request->total]);
        // DB::table('order_product')->insert([
        //     'order_id' => $request->order_id,
        //     'product_id' => $product->id,
        //     'total_product' => $request->quantity,

        //     'price' => $request->price,

        //     'total_price' => $request->total,
        $order->totalprice = Order::find($order->id)->product()->sum('total_price');
        $order->totalproduct = Order::find($order->id)->product()->sum('total_product');
        $order->save();
        // ]);
        return response()->json(['data'=>"ok"],200);
    }
    public function updateProduct(Request $request, $order_id,$product_id)
    {
        //
        $order = Order::find($request->order_id);
        $updateProduct = DB::table('order_product')
              ->where('order_id', $order_id)->where('product_id',$product_id)
              ->update(
                  ['total_product' => $request->total_product],
                  ['price' => $request->price],
                  ['total_price' => $request->total]
            
            );
            $order->totalprice = Order::find($order->id)->product()->sum('total_price');
            $order->totalproduct = Order::find($order->id)->product()->sum('total_product');
            return response()->json(['data'=>"ok"],200);

    }

  
}

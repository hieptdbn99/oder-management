<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Product\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $orderRepository,$productRepository;

    public function __construct(OrderInterface $orderRepository,ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderProductObj = new OrderProduct();
        $this->orderRepository = $orderRepository;
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $orders = $this->orderRepository->getAllOrderPaginate();
        $products = $this->productRepository->getAllProduct();

        return view('order.list', compact('products', 'orders'));
    }
    public function search(Request $request)
    {
        // $orders = $this->orderObj->getAllOrderPaginate();
        if ($request->search_name != "") {
            $products = $this->productRepository->getAllProduct();
            $orders = $this->orderRepository->searchOrder($request->search_name);

            return view('order.list', compact('orders', 'products'));
        } else {
            return redirect()->route('order.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //    
        $products = $this->productRepository->getAllProduct();

        return view('order.create', compact('products'));
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
        // $data = $request->all();
        // return response()->json(['data' => $data], 200);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'avatar' => 'required|mimes:jpg,png|max:100000',
            'phone' => 'required|min:10|numeric|',
            'address' => 'required',
            'date' => 'required',
        ]);
        $customer = array();
        $customer['namecustomer'] = $request->name;
        $customer['phone'] = $request->phone;
        $customer['email'] = $request->email;
        $customer['address'] = $request->address;
        $customer['note'] = clean($request->note);
        $customer['date'] = $request->date;
        if ($request->hasFile('file')) {
            $file = $request->file;
            // $file->move('uploads', $file->getClientOriginalName());
            $avatar = $file->store('uploads','public');
            $customer['avatar'] = $avatar;
        }
        $arrIdPro = $request->productIds;
        $arrPricePro = $request->prices;
        $arrQtyPro = $request->quantities;
        $this->orderRepository->storeOrder($customer, $arrIdPro, $arrPricePro, $arrQtyPro);

        return route('order.index');
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
        $orderFindId = $this->orderRepository->getOrderById($id);
        $product = $this->orderRepository->getProductByIdOrder($id);
        $orderProduct = $this->orderProductObj->getOrderProduct($id);

        return response()->json(
            [
                'orderData' => $orderFindId,
                'productData' => $product,
                'orderProductData' => $orderProduct
            ]
        );
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
        $order = $this->orderRepository->getOrderById($id);
        $allProduct = $this->productRepository->getAllProduct();
        $product = $this->orderRepository->getProductByIdOrder($id);
        $orderProduct = $this->orderProductObj->getProductOfOrder($id);

        return view('order.edit', compact('order', 'allProduct', 'orderProduct'));
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
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|min:10|numeric|',
            'address' => 'required',
        ]);

        $customer = array();
        $customer['namecustomer'] = $request->name;
        $customer['phone'] = $request->phone;
        $customer['email'] = $request->email;
        $customer['address'] = $request->address;
        $customer['note'] = clean($request->note);
        $customer['date'] = $request->date;
        if ($request->hasFile('avatar')) {
            $file = $request->file;
            // $file->move('uploads', $file->getClientOriginalName());
            $avatar = $file->store('uploads','public');
            $customer['avatar'] = $avatar;
        } else {
            $customer['avatar'] = "";
        }
        $this->orderProductObj->deleteOrderProduct($id);
        $arrIdPro = $request->productIds;
        $arrPricePro = $request->prices;
        $arrQtyPro = $request->quantities;
        $this->orderRepository->updateOrder($id, $customer, $arrIdPro, $arrPricePro, $arrQtyPro);

        return route('order.index');
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
        $this->orderRepository->deleteOrder($id);
        $this->orderProductObj->deleteOrderProduct($id);

        return response()->json(['data' => 'remove'], 200);
    }
}

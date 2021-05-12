@extends('layout.master');
@section('order-management') 
@if(Session::has('successMsg'))
<div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
@endif

<div class="container">
  <div class="row">
    <div class="title-head col-sm-12 my-5 text-center">
       <h3>QUẢN LÝ ĐƠN HÀNG</h3>
    </div>
    
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOrderModal">Thêm đơn hàng</button>
  </div>
  <!-- table show list order -->
  <div class="row">
      <div class="table-field col-sm-12 mt-3">
      <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Họ tên</th>
      <th scope="col">Số điện thoại</th>
      <th scope="col">Tổng sản phẩm</th>
      <th scope="col">Thành tiền</th>
      <th scope="col">Ngày mua</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orders as $order)
    <tr>
      <th scope="row">{{$i=1}}</th>
      <td>{{$order->namecustomer}}</td>
      <td>{{$order->phone}}</td>
      <td>{{$order->totalproduct}}</td>
      <td>{{$order->totalprice}}</td>
      <td>{{$order->created_at}}</td>
      <td>
        <a href="" class="editOrder" data-url="{{route('order.edit',$order->id)}}" data-toggle="modal" data-target="#editOrderModal"><i class="far fa-edit mr-2"></i></a>
        <a href="" style="color: red;"><i class="far fa-trash-alt"></i></a>
      </td>
    </tr>  
    @endforeach
    
   
  </tbody>
</table>
      </div>
    
  </div>

</div>

{{-- modal --}}
@include('order.ordercreate')
@include('order.orderedit')
{{-- 
  Modal sửa --}}
@endsection


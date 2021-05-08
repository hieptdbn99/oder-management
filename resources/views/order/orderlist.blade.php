@extends('layout.master');
@section('order-management') 

<!-- Modal -->
<div class="container">
  <div class="row">
    <div class="title-head col-sm-12 my-5 text-center">
       <h3>QUẢN LÝ ĐƠN HÀNG</h3>
    </div>
    
    <a href="{{ route('order.create') }}"><button type="button" class="btn btn-primary">
      Thêm đơn hàng
    </button></a>
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
    <tr>
      <th scope="row">1</th>
      <td>Trần Đức Hiệp</td>
      <td>0393933518</td>
      <td>20</td>
      <td>100000</td>
      <td>07-05-2021</td>
      <td>
        <a href=""><i class="far fa-edit mr-2"></i></a>
        <a href="" style="color: red;"><i class="far fa-trash-alt"></i></a>
      </td>
    </tr>
   
  </tbody>
</table>
      </div>
    
  </div>

</div>

@endsection
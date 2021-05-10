@extends('layout.master');
@section('order-management') 


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

{{-- modal --}}
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('order.store') }}" id="add-order-form" data-url="{{ route('order.store') }}" method="post">
          @csrf
          <div class="form-group">
              <label for="">Họ và tên khách hàng</label>
              <input type="text" name="name" class="form-control" id="input-name">
          </div>
          <div class="form-group">
              <label for="">Email</label>
              <input type="email" name="email" class="form-control" id="input-email">
          </div>
          <div class="form-group">
              <label for="">Số điện thoại</label>
              <input type="text" name="phone" class="form-control" id="input-phone">
          </div>
          <div class="form-group">
              <label for="">Địa chỉ</label>
              <input type="text" name="address" class="form-control" id="input-address">
          </div>
          <div class="form-group">
              <label for="" class="d-block">Sản phẩm</label>
              <select class="form-select" id="select-product" name="product_name[]" aria-label="Default select example">
                  @foreach ($products as $product)
                  <option value={{$product->name}} >{{$product->name}}</option> 
                  @endforeach
                  
                  
              </select>
              <input aria-label="quantity" name="product_qty[]" id="input-qty" min="1" type="number" value="1">
              <input id="input-price" name="product_price[]" type="text">
              <a type="submit" href = "" name="list" class="addListPro"><i class="fas fa-plus-square"></i></a>
        
        
        
          </div>
            <div class="form-group">
              <table class="table">
                  <thead>
                    <tr>
                      
                      <th scope="col">Sản phẩm</th>
                      <th scope="col">Số lượng</th>
                      <th scope="col">Đơn giá</th>
                      <th scope="col">Thành tiền</th>
                    </tr>
                  </thead>
                  <tbody id="render-product">
                   
                  </tbody>
                </table>
        
          
        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  </div>
@endsection


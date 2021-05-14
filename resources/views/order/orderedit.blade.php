@extends('layout.master');
 @section('order-management') 
 .<div class="container">
   <div class="row">
      <h3 class="col-sm-12 mb-5">Sửa thông tin đơn hàng</h3>
      <div class="form-edit col-sm-12">
    <form action="" id="form_edit_modal" data-url="" method="post">
      @csrf
    
      <div class="form-group">
          <label for="">Họ và tên khách hàng</label>
          <input type="text" name="name" class="form-control" id="input-name-edit" value="{{$order->namecustomer}}">
          <input type="hidden" name="idHidden" id="id_order" value="{{$order->id}}">
      </div>
      <div class="form-group">
          <label for="">Email</label>
          <input type="email" name="email" class="form-control" id="input-email-edit" value="{{$order->email}}">
      </div>
      <div class="form-group">
          <label for="">Số điện thoại</label>
          <input type="text" name="phone" class="form-control" id="input-phone-edit" value="{{$order->phone}}">
      </div>
      <div class="form-group">
          <label for="">Địa chỉ</label>
          <input type="text" name="address" class="form-control" id="input-address-edit" value="{{$order->address}}">
      </div>
      <div class="form-group">
      
          <label for="" class="d-block">Sản phẩm</label>
          <select class="form-select" id="select-product-edit"  aria-label="Default select example">
              @foreach ($allProduct as $eachProduct)
              <option value={{$eachProduct->name}} >{{$eachProduct->name}}</option> 
              @endforeach
              
              
          </select>
          <input aria-label="quantity" id="add-qty-edit" min="1" type="number" value="1">
          <input id="add-price-edit" type="text">
          <a type="submit" href="{{route('addproduct') }}" class="addListProEdit" data-url="{{ route('addproduct') }}"><i class="fas fa-plus-square"></i></a>
    
    
    
      </div>
        <div class="form-group">
          <label for="">Sản phẩm</label>
          <div class ="">
            <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th>Tên sản phẩm</th>
                      <th>Giá thành</th>
                      <th>số lượng</th>
                  </tr>
              </thead>
              <tbody class="editProduct">
                @foreach ($order_product as $item)
                <tr>
                  <td>{{$item->name}}</td>
                  <td>{{$item->price}}</td>
                  <td>{{$item->total_product}}</td>
                  <td><i class="fas fa-edit mr-2 "></i><i class="fas fa-trash-alt"></i></td>
                </tr>
                @endforeach
                
               
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Sửa</button>
        </div>
    </form>
  </div>
   </div>
 </div>
       
    @endsection
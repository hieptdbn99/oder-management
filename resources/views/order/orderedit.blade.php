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
          <a type="submit" href="{{route('addProduct') }}" class="addListProEdit" data-url="{{ route('addProduct') }}"><i class="fas fa-plus-square"></i></a>
    
    
    
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
                  <td id="show-price-edit">{{$item->price}}</td>
                  <td id="show-quantity-edit">{{$item->total_product}}</td>
                  <td><a href="" class="edit_product" data-url="{{route('editProduct',[$item->order_id,$item->product_id])}}" data-toggle="modal" data-target="#editProduct"><i class="fas fa-edit mr-2 "></i></a><a href="" class="remove_product" data-url="{{route('removeProduct',[$item->order_id,$item->product_id])}}"><i class="fas fa-trash-alt "></i></a></td>
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

{{-- modal --}}
 <div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sửa sản phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="form-edit-product" data-url="{{route('addProduct')}}" method="post">
          @csrf
          <div class="form-group">
              <label for="">Sản phẩm</label>
              <h4 class="show-name-product"><h4>
          </div>
          <div class="form-group">
              <label for="">Số lượng</label>
              <input type="number" min="1" max="9999" name="quantity_edit" class="form-control input_qty_edit">
          </div>
          <div class="form-group">
            <label for="">Đơn giá</label>
            <input type="text" name="price_edit" class="form-control input_price_edit" >
        </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="" class="btn btn-primary submit-edit-product">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <script>
    // "global" vars, built using blade
    var flagsUrl = '{{ URL::asset('order/updateproduct') }}';
  </script>

       
    @endsection
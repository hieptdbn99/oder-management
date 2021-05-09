@extends('layout.master');
@section('order-management') 

    <div class="container">
        <div class="row">
            <div class="col-sm-12 title">
                <h3>Thêm đơn hàng</h3>
            </div>
            <div class="col-sm-12">
             <!-- form thêm đơn hàng -->
                <form action="{{route('order.store')}}" id="add-order-form" data-url="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Họ và tên khách hàng</label>
                        <input type="text" class="form-control" id="input-name">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" id="input-email">
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control" id="input-phone">
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" class="form-control" id="input-address">
                    </div>
                    <div class="form-group">
                        <label for="" class="d-block">Sản phẩm</label>
                        <select class="form-select" id="select-product" aria-label="Default select example">
                            @foreach ($products as $product)
                            <option value={{$product->name}}>{{$product->name}}</option>
                            @endforeach
                            
                            
                        </select>
                        <input aria-label="quantity" id="input-qty" min="1" name="quantity" type="number" value="1">
                        <input id="input-price" type="text" name="price">
                        <a onclick="event.preventDefault(); addProduct()"><i class="fas fa-plus-square"></i></a>



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
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                
                </form>

            </div>
        </div>
    </div>
    <script type="text/javascript">
    var arrayProduct = [];
    var product = {
          name: document.getElementById('select-product'),
          quantity: document.getElementById('input-qty'),
          price:document.getElementById('input-price'),

          total: function() {
            total = parseInt(this.price)*parseInt(this.quantity);
            return total;
          }
        }   
    function addProduct(){
      var product = {
          name: document.getElementById('select-product').value,
          quantity: document.getElementById('input-qty').value,
          price:document.getElementById('input-price').value,

          total: function() {
            total = parseInt(this.price)*parseInt(this.quantity);
            return total;
          }
        }   
        arrayProduct.push(product);
        var listProduct = document.getElementById('render-product')
        listProduct.innerHTML += '<td>'+product.name+'</td><td>'+product.quantity+'</td><td>'+product.price+'</td><td>'+product.total()+'</td></tr>' 
        localStorage.setItem("my_product", JSON.stringify(arrayProduct))
    }


        $(document).ready(function(){
          $('#add-order-form').submit(function(e){
            // e.preventDefault();
            var url = $(this).attr('data-url');
            list = JSON.parse(localStorage.getItem("my_product"))
            console.log(list)
            localStorage.clear();
            $.ajax({
              headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
              type:'post',
              url: url,
              data:{
                  list: JSON.stringify(list),
                  name: $('#input-name').val(),
                  phone: $('#input-phone').val(),
                  email: $('#input-email').val(),
                  address:$('#input-address').val(),
              },
              success: function(data){
                console.log('Done!')
                
              },
              error: function(){
                console.log('Fail')
              }
      
            })
          })
        })
      </script>
       

@endsection
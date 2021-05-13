
  <div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sửa đơn hàng</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="form_edit_modal" data-url="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Họ và tên khách hàng</label>
                <input type="text" name="name" class="form-control" id="input-name-edit" value="">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" id="input-email-edit" value="">
            </div>
            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" id="input-phone-edit" value="">
            </div>
            <div class="form-group">
                <label for="">Địa chỉ</label>
                <input type="text" name="address" class="form-control" id="input-address-edit" value="">
            </div>
            {{-- <div class="form-group">
                <label for="" class="d-block">Sản phẩm</label>
                <select class="form-select" id="select-product"  aria-label="Default select example">
                    @foreach ($products as $product)
                    <option value={{$product->name}} >{{$product->name}}</option> 
                    @endforeach
                    
                    
                </select>
                <input aria-label="quantity" id="input-qty" min="1" type="number" value="1">
                <input id="input-price" type="text">
                <a type="submit" href = "" class="addListPro"><i class="fas fa-plus-square"></i></a>
          
          
          
            </div> --}}
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
                     
                            {{-- <td><select size="1" id="row-1-office" name="row-1-office">
                              <option value="Edinburgh" selected="selected">
                                  Edinburgh
                              </option>
                              <option value="London">
                                  London
                              </option>
                              <option value="New York">
                                  New York
                              </option>
                              <option value="San Francisco">
                                  San Francisco
                              </option>
                              <option value="Tokyo">
                                  Tokyo
                              </option>
                          </select></td>
                            <td><input type="text" id="row-1-age" name="row-1-age" value="61"></td>
                            <td><input type="text" id="row-1-position" name="row-1-position" value="System Architect"></td> --}}
                     
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
    </div>
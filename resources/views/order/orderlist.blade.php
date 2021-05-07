@extends('layout.master');
@section('order-management') 

<!-- Modal -->
<div class="container">
  <div class="row">
    <div class="title-head col-sm-12 my-5 text-center">
       <h3>QUẢN LÝ ĐƠN HÀNG</h3>
    </div>
    
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderModal">
      Thêm đơn hàng
    </button>
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






<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- form -->
        <form action="" id="add-order-form" data-url="{{ route('order.store') }}" method="POST">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#add-order-form').submit(function(e){
      e.preventDefault();
      var url = $(this).attr('data-url');
      $.ajax({
        headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
        type:'post',
        url: url,
        data:{
            name: $('#input-name').val(),
            phone: $('#input-phone').val(),
            email: $('#input-email').val(),
            address:$('#input-address').val(),
        },
        success: function(response){
          alert('Thêm mới thành công')
          $('#orderModal').modal('hide');
        },
        error: function(){
          console.log()
        }

      })
    })
  })
</script>
@endsection

var edit = function(){
    var el = {};

    this.run = function(){
        this.init();
        this.bindEvent();
    }
    this.init = function(){
        el.btnAddPro = $('.addListProEdit');
        el.btnEditPro = $('.edit_product');
        el.btnRemovePro = $('.remove_product');
        el.btnSubmitPro = $('.submit-edit-product');
        el.btnSubmitOrder = $('#form_edit_modal');
    }
    this.bindEvent = function(){
        addProEdit();
        getProToEdit();
        removeProEdit();
        editPro();
        orderEditSubmit();

    }

    var addProEdit = function(){
        el.btnAddPro.click(function(e){
            e.preventDefault();
              var order_id = $('#id_order').val();
              var url = $(this).attr('data-url');
              var name_product= $('#select-product-edit').val();
              var quantity = $('#add-qty-edit').val();
              var price= $('#add-price-edit').val();
              console.log(url);
              var total = parseInt(price)*parseInt(quantity);
              $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                type: 'post',
                url: url,
                data: {
                  order_id: order_id,
                  name_product:name_product,
                  quantity:quantity,
                  price:price,
                  total:total,
                },
                success: function(response){
                  window.location.reload();
                 
                },
                error: function(){
                  console.log('Fail')
                }
        
              })
              
        })
    }
    var editPro = function(){
        el.btnSubmitPro.click(function(e){
            e.preventDefault();
            var url = $('#form-edit-product').attr('data-url');
           
            console.log(url)
            var total_product= $(".input_qty_edit").val()
            var price= $(".input_price_edit").val()
            var total = parseInt(price)*parseInt(total_product)
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              type: 'put',
              url: url,
              data:{
                total_product: total_product,
                price: price,
                total:total,
              },
              success:function(response){
                
                console.log(response.data)
                $('#editProduct').modal('hide');
                window.location.reload()
                
              },
              error:function(jqXHR,textStatus,errorThorwn){
  
              }
            })
              
        })
    }
    var removeProEdit = function(){
        el.btnRemovePro.click(function(e){
            var url = $(this).attr('data-url');
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'delete',
              url: url,
              success:function(response){
                console.log(response.data)
              },
              error:function(jqXHR,textStatus,errorThorwn){

              }
            })   
              
        })
    }

    var getProToEdit =function(){
        el.btnEditPro.click(function(e){
            e.preventDefault();
            var url = $(this).attr('data-url');
              $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
               
                type: 'get',
                url: url,
                success:function(response){
                  
                  console.log(response.product)
                  $('.show-name-product').html(response.product.name)
                  $('.input_qty_edit').val(response.data[0].total_product)
                  $('.input_price_edit').val(response.data[0].price)
                  $('#form-edit-product').attr('data-url',flagsUrl+'/'+response.data[0].order_id+'/'+response.data[0].product_id)
                },
                error:function(jqXHR,textStatus,errorThorwn){
  
                }
              })
          })
    }
    var orderEditSubmit = function(){
        el.btnSubmitOrder.click(function(e){
            var formValues= $(this).serialize()
            var url = $(this).attr('data-url');
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
             
              type: 'put',
              url: url,
              data:{
               data:formValues
              },
              success:function(response){
                              
              },
              error:function(jqXHR,textStatus,errorThorwn){
  
              }
            })
              
        })
    }
}
    $(document).ready(function () {
        var editObj = new edit();
        editObj.run();
    });

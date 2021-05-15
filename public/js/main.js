  
  $(document).ready(function(){
        $('.addListPro').click(function(e){
            e.preventDefault();
            var product = {
                name: $('#select-product').val(),
                quantity: $('#input-qty').val(),
                price:$('#input-price').val(),
        
                total: function() {
                  total = parseInt(this.price)*parseInt(this.quantity);
                  return total;
                }
              }   
              console.log(product.name)
              var msg = '<tr><td>'+product.name+'</td><td>'+product.quantity+'</td><td>'+product.price+'</td><td>'+product.total()+'</td></tr>' 
              var msg_hide='<input type="hidden" name="name_product[]" value="'+product.name+'">'+'<input type="hidden" name="price[]" value="'+product.price+'">'+'<input type="hidden" name="total[]" value="'+product.total()+'">'+'<input type="hidden" name="quantity[]" value="'+product.quantity+'">'
              $('#render-product').append(msg);
              $('#add-order-form').append(msg_hide);
              
        })

      //   $('.editOrder').click(function(e){
      //     e.preventDefault();
      //     var url = $(this).attr('data-url');
      //     $.ajax({
      //       headers: {
      //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      // },
      //       type:'get',
      //       url: url,
      //       dataType: 'json',
      //       success: function(response){
      //         $('#input-name-edit').val(response.order_data.namecustomer);
      //         $('#input-email-edit').val(response.order_data.email);
      //         $('#input-phone-edit').val(response.order_data.phone);
      //         $('#input-address-edit').val(response.order_data.address);
            
      //         for (i = 0; i < response.order_product_data.length; i++) {
      //           var msg_edit = '<tr><td>'+response.product_data[i].name+'</td><td>'+response.order_product_data[i].price+'</td><td>'+response.order_product_data[i].total_product+'</td><td><i data-url = {{route("delete_product",'+response.order_product_data[i].product_id+')}} class="fas fa-edit mr-2 remove_product"></i><i class="fas fa-trash-alt"></i></td></tr>'
      //            $('.editProduct').append(msg_edit);
      //         }
          
             
      //       },
      //       error: function(){
      //         console.log('Fail')
      //       }
    
      //     })
      //   })
        $('.addListProEdit').click(function(e){
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
        $('#form_edit_modal').submit(function(e){

        })
        $('.infoOrder').click(function(e){
          e.preventDefault();
          var url = $(this).attr('data-url');
          $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
            type:'get',
            url: url,
            dataType: 'json',
            success: function(respone){
              $('#info_name').html(respone.order_data.namecustomer);
              $('#info_email').html(respone.order_data.email);
              $('#info_phone').html(respone.order_data.phone);
              $('#info_address').html(respone.order_data.address);
              $('#info_total_price').html(respone.order_data.totalprice+" đ")
            
              for (i = 0; i < respone.order_product_data.length; i++) {
                var msg_edit = '<tr class="tr-info-order"><td>'+respone.product_data[i].name+'</td>'+'<td>'+respone.order_product_data[i].price+'</td><td>'+respone.order_product_data[i].total_product+'</td></tr>'
                 $('.editProduct').append(msg_edit);
              }
             
            },
            error: function(){
              console.log('Fail')
            }
    
          })
          $('.closeInfo').click(function(){
            $('.tr-info-order').remove();
          })
        })
        $('#add-order-form').submit(function(e){
          // e.preventDefault();

          var formValues= $(this).serialize()

          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
            data: 
            {   
                formValues,
              
            },
            success: function(respone){
              alert('Thêm mới thành công')
              $('#addOrderModal').modal('hide');
          //     setTimeout(function(){// 
          //      location.reload(); 
          //  }, 500)
              
            },
            error: function(){
              console.log('Fail')
            }
    
          })
        })
        $('.deleteOrder').click(function(e){
          console.log("ok");
          var url = $(this).attr('data-url');
          if(confirm("Bạn có chắc chắn muốn xóa?")){
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'delete',
              url: url,
              success:function(response){
                window.location.reload()
              },
              error:function(jqXHR,textStatus,errorThorwn){

              }
            })
          }
        })
        $('.remove_product').click(function(e){
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
        $('.edit_product').click(function(e){
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
       
        $('.submit-edit-product').click(function(e){
          e.preventDefault();
          var url = $('#form-edit-product').attr('data-url');
         
          console.log(url)
          var total_product= $(".input_qty_edit").val()
          var price= $("input_price_edit").val()
          var total = parseInt(this.price)*parseInt(this.quantity)
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
      })

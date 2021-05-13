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

      $(document).ready(function(){

// add product to list in order
        $('.addListPro').click(function(e){
            console.log("hello");
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
              arrayProduct.push(product);
              var msg = '<tr><td>'+product.name+'</td><td>'+product.quantity+'</td><td>'+product.price+'</td><td>'+product.total()+'</td></tr>' 
              var msg_hide='<input type="hidden" name="name_product[]" value="'+product.name+'">'+'<input type="hidden" name="price[]" value="'+product.price+'">'+'<input type="hidden" name="total[]" value="'+product.total()+'">'+'<input type="hidden" name="quantity[]" value="'+product.quantity+'">'
              $('#render-product').append(msg);
              $('#add-order-form').append(msg_hide);
              
              localStorage.setItem("my_product", JSON.stringify(arrayProduct))

        })


        $('.editOrder').click(function(e){
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
              $('#input-name-edit').val(respone.order_data.namecustomer);
              $('#input-email-edit').val(respone.order_data.email);
              $('#input-phone-edit').val(respone.order_data.phone);
              $('#input-address-edit').val(respone.order_data.address);
            
              for (i = 0; i < respone.order_product_data.length; i++) {
                var msg_edit = '<tr><td><input type="text" name="name_product[]" value="'+respone.product_data[i].name+'"></td>'+'<td><input type="text" name="price[]" value="'+respone.order_product_data[i].price+'"></td>'+'<td><input type="text" name="quantity[]" value="'+respone.order_product_data[i].total_product+'"></td></tr>'
                 $('.editProduct').append(msg_edit);
              }
             
            },
            error: function(){
              console.log('Fail')
            }
    
          })
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
      })

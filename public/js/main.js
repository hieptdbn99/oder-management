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
              $('#render-product').append(msg);
              
              localStorage.setItem("my_product", JSON.stringify(arrayProduct))

        })


        $('#add-order-form').submit(function(e){
        //   e.preventDefault();
          // chuyển đến router.store

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
                list: JSON.stringify(list),
            },
            success: function(respone){
              alert('Thêm mới thành công')
              $('#addOrderModal').modal('hide');
              setTimeout(function(){// wait for 5 secs(2)
               location.reload(); // then reload the page.(3)
           }, 500)
              
            },
            error: function(){
              console.log('Fail')
            }
    
          })
        })
      })

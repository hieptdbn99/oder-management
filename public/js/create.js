
var create = function(){
    var el = {};

    this.run = function(){
        this.init();
        this.bindEvent();
    }
    this.init = function(){
        el.btnAddPro = $('.addListPro');
        el.btnSubmit = $('#add-order-form');
    }
    this.bindEvent = function(){
        createPro();
        createOrder();
    }

    var createPro = function(){
        el.btnAddPro.click(function(e){
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
    }

    var createOrder =function(){
        el.btnSubmit.submit(function(e){
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
        var createObj = new create();
        createObj.run();
    });

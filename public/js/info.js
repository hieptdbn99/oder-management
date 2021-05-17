
var info = function(){
    var el = {};

    this.run = function(){
        this.init();
        this.bindEvent();
    }
    this.init = function(){
        el.btnInfo =  $('.infoOrder');
       
    }
    this.bindEvent = function(){
        showInfoOrder()
    }

    var showInfoOrder = function(){
       
        el.btnInfo.click(function(e){
            e.preventDefault();
            $('.tr-info-order').remove();
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
                $('#info_avatar').attr('src','../uploads/'+respone.order_data.avatar);
                $('#info_email').html(respone.order_data.email);
                $('#info_phone').html(respone.order_data.phone);
                $('#info_address').html(respone.order_data.address);
                $('#info_note').html(respone.order_data.note);
  
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
            
          })
         
    }
}
    $(document).ready(function () {
        var infoObj = new info();
        infoObj.run();
    });

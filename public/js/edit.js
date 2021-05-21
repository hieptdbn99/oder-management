
var edit = function(){
    var el = {};

    this.run = function(){
        this.init();
        this.bindEvent();
      
    }
    this.init = function(){
        el.btnSubmitOrder = $('#form_edit_modal');
        el.btnAddPro = $('#add_row');
    }
    this.bindEvent = function(){
    
        orderEditSubmit();
        createPro();
        deletePro();
        totalEach();
        

    }
    var createPro = function(){
      var sum = 0;
      el.btnAddPro.click(function(e){
        console.log("hello")
          e.preventDefault();
            $('.editProduct').append($('.hidden-tr').html())
            deletePro();
            // totalEach();
            totalEach();

      })

  }
  var deletePro = function(){
    $('.del').click(function(e){
        e.preventDefault();
        $(this).parent().parent().remove()
        totalPrice()
    })
}
var totalEach = function(){
  $(".input-price").change(function(){
      var price =$(this).val()
      var qty = $(this).parent().siblings('.td-qty').children('.input-quantity').val()
      totalEachPrice = price*qty
      $(this).parent().siblings('.td-totalEach').html(totalEachPrice);
      totalPrice();
  
  });
  $(".input-quantity").change(function(){
      var price =$(this).val()
      var qty = $(this).parent().siblings('.td-price').children('.input-price').val()
      totalEachPrice = price*qty
      $(this).parent().siblings('.td-totalEach').html(totalEachPrice);
      // console.log($('.td-totalEach').html())
      totalPrice()
  });
}
function totalPrice(){
  sum = 0;
  var eachProduct = document.getElementsByClassName('td-totalEach')
  console.log(eachProduct);
  for(var i = 0 ; i < eachProduct.length;i++){
      if(!isNaN(parseInt((eachProduct[i]).innerHTML))){
          sum+= parseInt((eachProduct[i]).innerHTML);
      }
  }
  $('#total-price').html(sum+' đ')
};
    
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

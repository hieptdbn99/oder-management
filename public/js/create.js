
var create = function(){
    var el = {};

    this.run = function(){
        this.init();
        this.bindEvent();
    }
    this.init = function(){
        el.btnAddPro = $('#add_row');
        el.btnSubmit = $('#add-order-form');
        el.deletePro = $('.del');
    }
    this.bindEvent = function(){
        createPro();
        createOrder();
        deletePro();
    }

    var createPro = function(){
        el.btnAddPro.click(function(e){
            e.preventDefault();
          
              console.log("hello")
              console.log($('.hiden-tr').html());
              $('.addRow').append($('.hiden-tr').html())
              
        })
    }
    var deletePro = function(){
        el.deletePro.click(function(e){
            e.preventDefault();
            console.log("hello")
          
             $(this).parent().parent().remove();
              
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
             
              type: 'post',
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

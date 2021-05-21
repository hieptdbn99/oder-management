
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

    }
    var createPro = function(){
      var sum = 0;
      el.btnAddPro.click(function(e){
        console.log("hello")
          e.preventDefault();
            $('.editProduct').append($('.hidden-tr').html())
            deletePro();
            // totalEach();
            
      })

  }
  var deletePro = function(){
    $('.del').click(function(e){
        e.preventDefault();
        $(this).parent().parent().remove()
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

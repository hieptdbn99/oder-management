
var searchOrder = function(){
    var el = {};

    this.run = function(){
        this.init();
        this.bindEvent();
    }
    this.init = function(){
        el.btnSearchOrder = $('.form-search');
    }
    this.bindEvent = function(){
        searchFromOrder();
    }

    var searchFromOrder = function(){
        el.btnSearchOrder.submit(function(e){
            e.preventDefault();
            var url = $(this).attr('data-url');
            var formSearch = $(this).serialize();
              $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: url,
                data:{
                    data:formSearch
                },
                success:function(response){
                    console.log(response.data)
                },
                error:function(jqXHR,textStatus,errorThorwn){
  
                }
              })
            
          })
    }
}
    $(document).ready(function () {
        var searchOrderObj = new searchOrder();
        searchOrderObj.run();
    });

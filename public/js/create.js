var create = function() {
    var el = {};

    this.run = function() {
        this.init();
        this.bindEvent();
    };
    this.init = function() {
        el.btnAddPro = $("#add_row");
        el.btnSubmit = $("#add-order-form");
    };
    this.bindEvent = function() {
        createPro();
        createOrder();
        totalEach();
        totalPrice();
    };

    var createPro = function() {
        var sum = 0;
        el.btnAddPro.click(function(e) {
            e.preventDefault();
            $(".addRow").append($(".hiden-tr").html());
            deletePro();
            totalEach();
        });
    };
    // var totalPrice = function(sum){
    //     sum += pas
    // }
    var deletePro = function() {
        $(".del").click(function(e) {
            e.preventDefault();
            $(this)
                .parent()
                .parent()
                .remove();
            totalPrice();
        });
    };
    var totalEach = function() {
        $(".input-price").change(function() {
            var price = $(this).val();
            var qty = $(this)
                .parent()
                .siblings(".td-qty")
                .children(".input-quantity")
                .val();
            totalEachPrice = price * qty;
            $(this)
                .parent()
                .siblings(".td-totalEach")
                .html(totalEachPrice);
            totalPrice();
        });
        $(".input-quantity").change(function() {
            var price = $(this).val();
            var qty = $(this)
                .parent()
                .siblings(".td-price")
                .children(".input-price")
                .val();
            totalEachPrice = price * qty;
            $(this)
                .parent()
                .siblings(".td-totalEach")
                .html(totalEachPrice);
            // console.log($('.td-totalEach').html())
            totalPrice();
        });
    };
    function totalPrice() {
        sum = 0;
        var eachProduct = document.getElementsByClassName("td-totalEach");
        console.log(eachProduct);
        for (var i = 0; i < eachProduct.length; i++) {
            if (!isNaN(parseInt(eachProduct[i].innerHTML))) {
                sum += parseInt(eachProduct[i].innerHTML);
            }
        }
        $("#total-price").html(sum + " đ");
    }

    var createOrder = function() {
        el.btnSubmit.submit(function(e) {
            e.preventDefault();
            url = $(this).attr("data-url");
            var form_data = new FormData(this);
            var file_data = $("#input-avt").prop("files")[0];   
            form_data.append("file", file_data);
            var note = CKEDITOR.instances['note'].getData();
            form_data.append("note", note);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "post",
                url: url, // <-- point to server-side PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,

                success: function(response) {
                  
                        alert("Thêm mới đơn hàng thành công");
                        window.location.replace(response);
                   
                },
                error: function(response) {
                    $('#err-name-add').text(response.responseJSON.errors.name);
                    $('#err-address-add').text(response.responseJSON.errors.address);
                    $('#err-phone-add').text(response.responseJSON.errors.phone);
                    $('#err-email-add').text(response.responseJSON.errors.email); 
                    $('#err-date-add').text(response.responseJSON.errors.date);              
             
                }
            });
            CKEDITOR.replace('note');
        });
    };
};
$(document).ready(function() {
    var createObj = new create();
    createObj.run();
});

var edit = function() {
    var el = {};

    this.run = function() {
        this.init();
        this.bindEvent();
    };
    this.init = function() {
        el.btnSubmitOrder = $("#form-edit-order");
        el.btnAddPro = $("#add_row");
    };
    this.bindEvent = function() {
        orderEditSubmit();
        createPro();
        deletePro();
        totalEach();
        totalPrice();
    };
    var createPro = function() {
        var sum = 0;
        el.btnAddPro.click(function(e) {
            console.log("hello");
            e.preventDefault();
            $(".editProduct").append($(".hidden-tr").html());
            deletePro();
            // totalEach();
            totalEach();
        });
    };
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

    var orderEditSubmit = function() {
        el.btnSubmitOrder.submit(function(e) {
            e.preventDefault();
            url = $(this).attr("data-url");
            var form_data = new FormData(this);
            form_data.append('_method', 'put');
            var file_data = $("#input-avatar-edit").prop("files")[0];
            form_data.append("avatar", file_data);
            var note = CKEDITOR.instances["text-edit-note"].getData();
            console.log(file_data);
            form_data.append("note", note);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "post",
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,

                success: function(response) {
                    alert("Sửa đơn hàng thành công");
                    window.location.replace(response);
                },
                error: function(response) {
                    $("#err-name-edit").text(response.responseJSON.errors.name);
                    $("#err-avt-edit").text(
                        response.responseJSON.errors.avatar
                    );
                    $("#err-address-edit").text(
                        response.responseJSON.errors.address
                    );
                    $("#err-phone-edit").text(
                        response.responseJSON.errors.phone
                    );
                    $("#err-email-edit").text(
                        response.responseJSON.errors.email
                    );
                    $("#err-date-edit").text(response.responseJSON.errors.date);
                }
            });
            CKEDITOR.replace("text-edit-note");
        });
    };
};
$(document).ready(function() {
    var editObj = new edit();
    editObj.run();
});

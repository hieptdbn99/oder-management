var info = function() {
    var el = {};

    this.run = function() {
        this.init();
        this.bindEvent();
    };
    this.init = function() {
        el.btnInfo = $(".infoOrder");
    };
    this.bindEvent = function() {
        showInfoOrder();
    };

    var showInfoOrder = function() {
        el.btnInfo.click(function(e) {
            e.preventDefault();
            $(".tr-info-order").remove();
            var url = $(this).attr("data-url");
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "get",
                url: url,
                dataType: "json",
                success: function(respone) {
                    $("#info_name").html(respone.orderData.namecustomer);
                    $("#info_avatar").attr(
                        "src",
                        "../uploads/" + respone.orderData.avatar
                    );
                    $("#info_email").html(respone.orderData.email);
                    $("#info_phone").html(respone.orderData.phone);
                    $("#info_address").html(respone.orderData.address);
                    $("#info_note").html(respone.orderData.note);
                    $("#info_date").html(
                        getFormattedDate(new Date(respone.orderData.date))
                    );

                    $("#info_total_price").html(
                        respone.orderData.totalprice + " đ"
                    );

                    for (i = 0; i < respone.orderProductData.length; i++) {
                        var msg_edit =
                            '<tr class="tr-info-order"><td>' +
                            respone.productData[i].name +
                            "</td>" +
                            "<td>" +
                            respone.orderProductData[i].price +
                            "</td><td>" +
                            respone.orderProductData[i].total_product +
                            "</td></tr>";
                        $(".editProduct").append(msg_edit);
                    }
                },
                error: function() {
                    console.log("Fail");
                }
            });
        });
        function getFormattedDate(date) {
            let year = date.getFullYear();
            let month = (1 + date.getMonth()).toString().padStart(2, "0");
            let day = date
                .getDate()
                .toString()
                .padStart(2, "0");

            return day + "/" + month + "/" + year;
        }
    };
};
$(document).ready(function() {
    var infoObj = new info();
    infoObj.run();
});

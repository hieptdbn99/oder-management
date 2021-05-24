var deleteOrder = function() {
    var el = {};

    this.run = function() {
        this.init();
        this.bindEvent();
    };
    this.init = function() {
        el.btndeleteOrder = $(".deleteOrder");
    };
    this.bindEvent = function() {
        deleteOrder();
    };

    var deleteOrder = function() {
        el.btndeleteOrder.click(function(e) {
            console.log("ok");
            var url = $(this).attr("data-url");
            if (confirm("Bạn có chắc chắn muốn xóa?")) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    type: "delete",
                    url: url,
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThorwn) {}
                });
            }
        });
    };
};
$(document).ready(function() {
    var deleteOrderObj = new deleteOrder();
    deleteOrderObj.run();
});

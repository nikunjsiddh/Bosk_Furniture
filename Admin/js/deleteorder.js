function deleteorder(order_id) {

    if (confirm('Are you sure you want to delete this order? This will also remove its line items.')) {

        $.ajax({
            url: "back/deleteorder.php",
            type: "POST",
            data: { order_id: order_id },
            success: function(data) {
                $('#return').fadeIn().html(data);
                $('#delete' + order_id).hide('slow');
                setTimeout(function() {
                    location.reload(true);
                }, 2000);
                return false;
            }
        });
        return false;
    }
}

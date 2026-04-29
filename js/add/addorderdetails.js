function order() {
    var form = $('#orderForm')[0];
    var data = new FormData(form);
    var url = 'back/addorderdetails.php';
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('#submit').hide();
           
        },
        success: function(data) {
//             $('#orderForm').trigger("reset");
// 			$('#return').fadeIn().html(data);
//             $('#order').fadeIn().html(data);
//             $('#submit').show();
          alert(data);
            return false;
        }
    });
    return false;
}

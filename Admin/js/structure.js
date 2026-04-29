function product() {
    var form = $('#myform')[0];
    var data = new FormData(form);
    var url = 'back/addproduct.php';
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
            $('#myform').trigger("reset");
			$('#return').fadeIn().html(data);
            $('#product').fadeIn().html(data);
            $('#submit').show();
        //   alert(data);
            return false;
        }
    });
    return false;
}

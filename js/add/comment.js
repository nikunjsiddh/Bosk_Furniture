function contact_us() {
    var form = $('#MyForm')[0];
    var data = new FormData(form);
    var url = 'back/comment.php';
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
		beforeSend: function() {
            $('#submit').hide();
            $('.loader').show();
        },
        success: function(data) {
               $('form').trigger("reset");
               $('#return').fadeIn().html(data);
			   $('#submit').hide();
               $('.loader').hide();
               //alert(data);
            }
    });
    return false;
}
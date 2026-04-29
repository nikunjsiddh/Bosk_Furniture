$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var blog_title = $('#blog_title').val();
        var blog_description = $('#blog_description').val();
      

        if (id === '' || blog_title === '' || blog_description === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editblog.php",
                method: "POST",
                data: $('#MyForm').serialize(),
                beforeSend: function() {
                $('#submit').hide();
                $('#ret').hide();
        },
                success: function(data) {
                    $('#return').fadeIn().html(data);
                    $('#submit').show();
                    $('#ret').show();
                    $('.loader').hide();
                    $('#blogmodal').modal('toggle');
					setTimeout(function() {
                location.reload(true);
            }, 2500);
                    $('#load').load(' #load');
			//		alert(data);
    //                 alert(id);
    //                 alert(name);
                }
            });
        }
    });
});

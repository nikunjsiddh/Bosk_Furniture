$(document).ready(function() {
    $("#signin").click(function(event) {
        event.preventDefault();
        var email = $('#email').val();
        var pwd = $('#pwd').val();
        if (email == '' || pwd == '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {
            $.ajax({
                url: "back/signin.php",
                method: "POST",
                data: $('#myform').serialize(),
                beforeSend: function() {
                    $('#signin').hide();
                    $('.loader').show();
                },
                success: function(data) {
                    $('form').trigger("reset");
                    $('#return').fadeIn().html(data);
                    $('#signin').show();
                    $('.loader').hide();
                    setTimeout(function() {
                                location.reload(true);
                    }, 4000);
				// 	alert(email);
				// 	alert(pwd);
				// 	alert(data);
                }
            });
        }
    });
});
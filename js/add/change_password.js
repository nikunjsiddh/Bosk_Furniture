$(document).ready(function() {
    $("#c_submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var oldpassword = $('#oldpassword').val();
        var newpassword  = $('#newpassword').val();
        var confirmpassword= $('#confirmpassword').val();
       
       
      

        if (id === '' || oldpassword === ''|| newpassword === '' || confirmpassword === '') {
            $('#return1').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editpassword.php",
                method: "POST",
                data: $('#MyForm2').serialize(),
                beforeSend: function() {
                $('#c_submit').hide();
                $('#ret').hide();
        },
                success: function(data) {
                    $('#return2').fadeIn().html(data);
                    $('#c_submit').show();
                    $('#ret').show();
                    $('.loader').hide();
                    $('#productmodal').modal('toggle');
					setTimeout(function() {
                location.reload(true);
            }, 2500);
                    $('#load').load(' #load');
				// 	alert(data);
    //                 alert(id);
    //                 alert(name);
                }
            });
        }
    });
});

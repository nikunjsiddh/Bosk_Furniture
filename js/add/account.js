$(document).ready(function() {
    $("#a_submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var firstname = $('#firstname').val();
        var lastname  = $('#lastname').val();
        // var email = $('#email').val();
        var dob= $('#dob').val();
        var phone= $('#phone').val();
       
       
      

        if (id === '' || firstname === ''|| lastname === '' || dob === ''|| phone === '') {
            $('#return1').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editaccount.php",
                method: "POST",
                data: $('#MyForm1').serialize(),
                beforeSend: function() {
                $('#a_submit').hide();
                $('#ret').hide();
        },
                success: function(data) {
                    $('#return1').fadeIn().html(data);
                    $('#a_submit').show();
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

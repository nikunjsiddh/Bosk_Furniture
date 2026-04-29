$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var addressline1 = $('#addressline1').val();
        var addressline2  = $('#addressline2').val();
        var pincode = $('#pincode').val();
        var country= $('#country').val();
        var state= $('#state').val();
        var city= $('#city').val(); 
       
      

        if (id === '' || addressline1 === ''|| addressline2 === ''|| pincode === ''|| country === ''|| state === ''|| city === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editprofile.php",
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

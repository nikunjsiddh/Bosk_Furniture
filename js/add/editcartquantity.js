$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault();
        // var id = $('#id').val();
        var product_id = $('#product_id').val();
        var user_id  = $('#user_id').val();
        var quantity= $('#quantity').val();
       
       
      

        if ( product_id === ''|| user_id === '' || quantity === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editquantity.php",
                method: "POST",
                data: $('#quantityForm').serialize(),
                beforeSend: function() {
                $('#submit').hide();
                $('#ret').hide();
        },
                success: function(data) {
    //                 $('#return1').fadeIn().html(data);
    //                 $('#submit').show();
    //                 $('#ret').show();
    //                 $('.loader').hide();
    //                 $('#productmodal').modal('toggle');
				// 	setTimeout(function() {
    //             location.reload(true);
    //         }, 2500);
    //                 $('#load').load(' #load');
					alert(data);
    //                 alert(id);
    //                 alert(name);
                }
            });
        }
    });
});

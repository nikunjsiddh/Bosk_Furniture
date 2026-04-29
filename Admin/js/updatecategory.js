$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var name = $('#name').val();
      

        if (id === '' || name === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editcategory.php",
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
                    $('#categorymodal').modal('toggle');
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

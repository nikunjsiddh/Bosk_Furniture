$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var project_name = $('#project_name').val();
        var pro_desc  = $('#pro_desc').val();
        var interior_detail = $('#interior_detail').val();
        
        if (id === '' || project_name === ''|| pro_desc === ''|| interior_detail === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editproject.php",
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
                    $('#projectmodal').modal('toggle');
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

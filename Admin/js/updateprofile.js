$(document).ready(function() {
    $("#c_submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var pname = $('#pname').val();
        var category = $('#category').val();
        var description = $('#description').val();
		var specification = $('#specification').val();
        var feature = $('#feature').val();

        if (id === '' || pname === '' || category === '' || description === '' || specification === '' || feature === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editprofile.php",
                method: "POST",
                data: $('#MyForm').serialize(),
                beforeSend: function() {
                $('#c_submit').hide();
                $('#ret').hide();
        },
                success: function(data) {
                    $('#return').fadeIn().html(data);
                    $('#c_submit').show();
                    $('#ret').show();
                    $('.loader').hide();
                    $('#cctvmodal').modal('toggle');
					setTimeout(function() {
                location.reload(true);
            }, 2500);
                    $('#load').load(' #load');
					//alert(data);
                    //alert(id);
                    //alert(pname);
                }
            });
        }
    });
});

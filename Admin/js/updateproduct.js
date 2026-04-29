$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var pname = $('#pname').val();
        var pcategory  = $('#pcategory').val();
        var description = $('#description').val();
        var  publish_date= $('#publish_date').val();
        var  sku= $('#sku').val();
        var  stock= $('#stock').val(); 
        var  status= $('#status').val();
        var  old_price= $('#old_price').val();
        var  new_price= $('#new_price').val();
        var  tags= $('#tags').val();
      

        if (id === '' || pname === ''|| pcategory === ''|| description === ''|| publish_date === ''|| sku === ''|| stock === ''|| status === ''|| old_price === ''|| new_price === ''|| tags === '') {
            $('#return').html('<h4 style="color:red;">Required All Fields..</h4>');
        } else {

            $.ajax({
                url: "back/editproduct.php",
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

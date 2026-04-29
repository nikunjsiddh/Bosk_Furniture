function deleteproject(id) {

    if (confirm('Are You Sure To Delete This ?')) {

        $.ajax({
            url: "back/deleteproject.php",
            type: "POST",
            data: { id: id },
            success: function(data) {
                $('#return').fadeIn().html(data);
                $('#delete' + id).hide('slow');
				 setTimeout(function() {
                location.reload(true);
            }, 2500);
                return false;
            }
        });
        return false;
    }
}
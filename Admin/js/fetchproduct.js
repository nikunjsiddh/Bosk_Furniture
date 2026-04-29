$(document).ready(function() {

    $(document).on('click', '.editproduct', function(e) {

        $('#productmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#id').val(data[1]);
        $('#pname').val(data[2]);
        $('#pcategory').val(data[3]);
        $('#description').val(data[4]);
        $('#publish_date').val(data[5]);
        $('#sku').val(data[6]);
        $('#stock').val(data[7]);
        $('#status').val(data[8]);
        $('#old_price').val(data[9]);
        $('#new_price').val(data[10]);
        $('#tags').val(data[11]);
       
       
        
    });

});
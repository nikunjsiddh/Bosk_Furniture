$(document).ready(function() {

    $(document).on('click', '.editquantity', function(e) {

        $('#quantitymodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

      
        $('#quantity').val(data[0]);
       
        
    });

});
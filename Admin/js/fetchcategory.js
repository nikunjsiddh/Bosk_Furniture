$(document).ready(function() {

    $(document).on('click', '.editcategory', function(e) {

        $('#categorymodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#id').val(data[1]);
        $('#name').val(data[2]);
       
        
    });

});
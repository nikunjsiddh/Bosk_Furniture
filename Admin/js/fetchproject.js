$(document).ready(function() {

    $(document).on('click', '.editproduct', function(e) {

        $('#projectmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#id').val(data[2]);
        $('#project_name').val(data[3]);
        $('#pro_desc').val(data[4]);
        $('#interior_detail').val(data[5]);
      
       
       
        
    });

});
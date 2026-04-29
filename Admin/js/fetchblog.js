$(document).ready(function() {

    $(document).on('click', '.editblog', function(e) {

        $('#blogmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#id').val(data[1]);
        $('#blog_title').val(data[2]);
         $('#blog_description').val(data[3]);
       
        
    });

});
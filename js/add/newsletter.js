function newsletter() {
    var newsemail = $('#newsemail').val();
    var form = $('#newsletter')[0];
    var data = new FormData(form);
    var url = 'back/newsletter.php';
    if(newsemail === '')
    {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
        toastr["error"]("Email Can't be Empty","Enter Valid Email")
    }
    else
    {
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                        $('form').trigger("reset");
                        $('#return1').fadeIn().html(data);
                        // alert(data);
                    }
            });
            return false;
    }
return false;
}
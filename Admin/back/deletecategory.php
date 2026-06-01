<?php
    include("../connect.php");
    
    if(isset($_POST['id']))
    {
        $id = mysqli_real_escape_string($con,$_POST['id']);
        $id = htmlspecialchars($id);
        $data = "delete from category where id='$id'";
        $result = mysqli_query($con,$data) or die(mysqli_error($con));
        if($result)
        {
            ?>
			<script>
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
            toastr["success"]("Category Deleted Successfully...!","Category")
		</script>
		<?php
        }
        else
        {
            ?>
            <script>
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
                  toastr["warning"]("Something Went Wrong...!","Failed")
          </script>
          <?php	
        }
    }
?>
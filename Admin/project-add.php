<?php
include_once("connect.php");
session_start();
if (isset($_SESSION['email'])) {
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/product-add.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:19 GMT -->
<head>
    <?php include_once"design/header.php"?>

    <!--plugin css file -->
    <link rel="stylesheet" href="assets/plugin/multi-select/css/multi-select.css"><!-- Multi Select Css -->
    <link rel="stylesheet" href="assets/plugin/bootstrap-tagsinput/bootstrap-tagsinput.css"><!-- Bootstrap Tagsinput Css -->
    <link rel="stylesheet" href="assets/plugin/cropper/cropper.min.css"><!--Cropperer Css -->   
    <link rel="stylesheet" href="assets/plugin/dropify/dist/css/dropify.min.css"/><!-- Dropify Css -->
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css"><!-- Datatable Css -->
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css"><!-- Datatable Css -->
    <link rel="stylesheet" href="toastr/toastr.css">
   
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        
        <!-- sidebar -->
         <?php include_once"design/sidebar.php"?>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            <?php include_once"design/nav.php"?>

            <!-- Body: Body -->
            <div class="body d-flex py-3">
                <div class="container-xxl">
                <form onsubmit="return project(this);" id="myform" method="post" enctype="multipart/form-data">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Projects Add</h3>
                                <button type="submit" name="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase">submit</button>
                            </div>
                        </div>
                    </div> <!-- Row end  -->  
                    
                    <div class="row g-3 mb-3">
                        
                        <div class="col-xl-12 col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Basic information</h6>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label  class="form-label">Project Name</label>
                                                <input type="text" name="project_name" class="form-control" required>
                                            </div>
                                      
                            <div class="col-md-12">
                                                <label  class="form-label">Project Description</label>
                                                <textarea type="text" cols="10" name="pro_desc" class="form-control" required></textarea>
                                            </div>
                            <div class="col-md-12">
                                                <label  class="form-label">Interior Details</label>
                                                <textarea type="text" cols="10" name="interior_detail" class="form-control" required></textarea>
                                            </div>
                             <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Images</h6>
                                </div>
                             <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Project Main Image</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" name="img1" class="dropify"  required>
                                            </div>
                                           
                                            
                                        </div>
                                         <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Project Image</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" name="img2" class="dropify" required>
                                            </div>
                                           
                                            
                                        </div>
                                      </div>
                                   
                                </div>
                            </div>
                            
                           
                        </div>
                    </div><!-- Row end  --> 
                    <div id="return"></div>
                     </form>
                </div>
            </div>    
        
            
                            

           
        </div>      

    </div>
    
    <!-- Jquery Core Js -->      
    
    <script src="assets/bundles/libscripts.bundle.js"></script>
   
    <script src="js/project_add.js"></script>
    <!-- Jquery Plugin -->  
    <!--<script src="cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>-->
    <script src="assets/plugin/multi-select/js/jquery.multi-select.js"></script>
    <script src="assets/plugin/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>  
    <script src="assets/plugin/cropper/cropper.min.js"></script>
    <script src="assets/plugin/cropper/cropper-init.js"></script>
    <script src="assets/bundles/dropify.bundle.js"></script>
    <script src="assets/bundles/dataTables.bundle.js"></script>
<script src="toastr/toastr.min.js"></script>
    <!-- Jquery Page Js -->   
    <script src="javascript/template.js"></script>
    <script>
        $(document).ready(function() {
        //Ch-editer
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
            //Datatable
            $('#myCartTable')
            .addClass( 'nowrap' )
            .dataTable( {
                responsive: true,
                columnDefs: [
                    { targets: [-1, -3], className: 'dt-body-right' }
                ]
            });
            $('.deleterow').on('click',function(){
            var tablename = $(this).closest('table').DataTable();  
            tablename
                    .row( $(this)
                    .parents('tr') )
                    .remove()
                    .draw();

            } );
           //Multiselect
           $('#optgroup').multiSelect({ selectableOptgroup: true });
        });

        $(function() {
            $('.dropify').dropify();

            var drEvent = $('#dropify-event').dropify();
            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });

            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-dÃ©posez un fichier ici ou cliquez',
                    replace: 'Glissez-dÃ©posez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'DÃ©solÃ©, le fichier trop volumineux'
                }
            });
        });
            
    </script>
    
</body>
</html> 
<?php 
}
else{
     header("Location: index.php");
    exit();
}
?>
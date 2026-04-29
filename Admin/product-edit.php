<?php
include_once"connect.php";
if (isset($_SESSION['email'])) {
if(isset($_GET['astringdata']))
	{
	    $id = mysqli_real_escape_string($con,$_GET['astringdata']);
	   // $id = base64_decode($id);
	    
	    $cmd3="select * from products where id='$id'";
        $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
        while($row=mysqli_fetch_array($result3))
        {
            $id=$row['id'];
            $pname=$row['pname'];
        }
// echo"id=$id";
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/product-edit.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:12 GMT -->
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
            <form onsubmit="return product(this);" id="myform" method="post" enctype="multipart/form-data">
            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Products Edit</h3>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase">Save</button>
                            </div>
                        </div>
                    </div> <!-- Row end  -->  
                    
                    <?php 
                    $cmd="select * from products where id='$id'";
                   
                        $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                        $row=mysqli_fetch_array($result);              
                                      $id = $row['id'];
                                      $pname=$row['pname'];
                                      $pcategory=$row['pcategory'];
                                      $img1=$row['img1'];
                                      $img2=$row['img2'];
                                      $img3=$row['img3'];
                                      $img4=$row['img4'];
                                      $img5=$row['img5'];
                                      $description=$row['description'];
                                      $publish_date=$row['publish_date'];
                                      $sku=$row['sku'];
                                      $stock=$row['stock'];
                                      $status=$row['status'];
                                      $old_price=$row['old_price'];
                                      $new_price=$row['new_price'];
                                      $mrp=$row['mrp'];
                                       $tags=$row['tags'];
                                       
                      ?>                              
                    
                    <div class="row g-3 mb-3">
                        <div class="col-xl-4 col-lg-4">
                            <div class="sticky-lg-top">
                                <div class="card mb-3">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                        <h6 class="m-0 fw-bold">Pricing Info</h6>
                                    </div>
                                  
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label  class="form-label">Product Price Old</label>
                                                <input type="text" id="old_price" class="form-control" value="<?php echo $old_price; ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label  class="form-label">Product Price New</label>
                                                <input type="text" id="new_price" class="form-control" value="<?php echo $new_price; ?>">
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                        <h6 class="m-0 fw-bold">Visibility Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" id="status" name="status" type="radio" value="<?php echo"$status";?>" checked>
                                            <label class="form-check-label">
                                                Published
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="status" name="status" type="radio" value="<?php echo"$status";?>">
                                            <label class="form-check-label">
                                                Scheduled
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" id="status" name="status" type="radio" value="<?php echo"$status";?>">
                                            <label class="form-check-label">
                                                Hidden
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mb-3">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                        <h6 class="m-0 fw-bold">Publish Schedule</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label  class="form-label">Publish Date</label>
                                                <input type="date" id="publish_date" class="form-control w-100" value="<?php echo$publish_date?>">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                        <h6 class="m-0 fw-bold">Tags</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group demo-tagsinput-area">
                                            <div class="form-line">
                                                <input type="text" id="tags" class="form-control" data-role="tagsinput" value="<?php echo$tags;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                        <h6 class="m-0 fw-bold">Categories</h6>
                                    </div>
                                    <div class="card-body">
                                        <label  class="form-label">Categories Select</label>
                                       <select  name="pcategory" id="pcategory" class="form-select" size="3" aria-label="size 3 select example" required>
                                           <!--<option value=" selected></option>-->
                                            <option id="pcategory" value="Residential Interior">Residential Interior</option>
                                            <option id="pcategory" value="Office Interior">Office Interior</option>
                                            <option id="pcategory" value="Commercial Interior">Commercial Interior</option>
                                            <option id="pcategory" value="Modern Interior">Modern Interior</option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                        <h6 class="m-0 fw-bold">Inventory Info</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label  class="form-label">SKU</label>
                                                <input id="sku" type="text" class="form-control" value="<?php echo$sku;?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label  class="form-label">Total Stock Quantity</label>
                                                <input id="stock" type="text" class="form-control" value="<?php echo$stock;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8">
                            <div class="card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Basic information</h6>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label  class="form-label">Product Name</label>
                                                <input type="text" id="pname" class="form-control"  value="<?php echo$pname;?>">
                                            </div>
                                           <div class="col-md-12">
                                                <label  class="form-label">Product Description</label>
                                                <textarea type="text" id="description" class="form-control"  ><?php echo $description; ?></textarea>
                                            </div>
                                          
                                        </div>
                                    
                                </div>
                            </div>
                            
                            <div class="card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Images</h6>
                                    <p style="color:red;">*You Can Not Edit Images*</p>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Product Image1</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" class="dropify" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" data-default-file="product_image/<?php echo$img1;?>" disabled>
                                            </div>
                                            
                                            
                                        </div>
                                         <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Product Image2</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" class="dropify" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" data-default-file="product_image/<?php echo$img2;?>" disabled>
                                            </div>
                                            
                                            
                                        </div>
                                         <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Product Image3</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" class="dropify" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" data-default-file="product_image/<?php echo$img3;?>" disabled>
                                            </div>
                                            
                                            
                                        </div>
                                         <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Product Image4</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" class="dropify" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" data-default-file="product_image/<?php echo$img4;?>" disabled>
                                            </div>
                                            
                                            
                                        </div>
                                         <div class="row g-3 align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">Product Image5</label>
                                                <small class="d-block text-muted mb-2">Only portrait or square images, 2M max and 2000px max-height.</small>
                                                <input type="file" id="input-file-to-destroy" class="dropify" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" data-default-file="product_image/<?php echo$img5;?>" disabled>
                                            </div>
                                            
                                            
                                        </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div><!-- Row end  --> 
                   
                    
                </div>
            </div>
            <div id="return"></div>
            </form>
            <!-- Modal Custom Settings-->
            <div class="modal fade right" id="Settingmodal" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog  modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Custom Settings</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom_setting">
                            <!-- Settings: Color -->
                            <div class="setting-theme pb-3">
                                <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-color-bucket fs-4 me-2 text-primary"></i>Template Color Settings</h6>
                                <ul class="list-unstyled row row-cols-3 g-2 choose-skin mb-2 mt-2">
                                    <li data-theme="indigo"><div class="indigo"></div></li>
                                    <li data-theme="tradewind"><div class="tradewind"></div></li>
                                    <li data-theme="monalisa"><div class="monalisa"></div></li>
                                    <li data-theme="blue" class="active"><div class="blue"></div></li>
                                    <li data-theme="cyan"><div class="cyan"></div></li>
                                    <li data-theme="green"><div class="green"></div></li>
                                    <li data-theme="orange"><div class="orange"></div></li>
                                    <li data-theme="blush"><div class="blush"></div></li>
                                    <li data-theme="red"><div class="red"></div></li>
                                </ul>
                            </div>
                            <div class="sidebar-gradient py-3">
                                <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-paint fs-4 me-2 text-primary"></i>Sidebar Gradient</h6>
                                <div class="form-check form-switch gradient-switch pt-2 mb-2">
                                    <input class="form-check-input" type="checkbox" id="CheckGradient">
                                    <label class="form-check-label" for="CheckGradient">Enable Gradient! ( Sidebar )</label>
                                </div>
                            </div>
                            <!-- Settings: Template dynamics -->
                            <div class="dynamic-block py-3">
                                <ul class="list-unstyled choose-skin mb-2 mt-1">
                                    <li data-theme="dynamic"><div class="dynamic"><i class="icofont-paint me-2"></i> Click to Dyanmic Setting</div></li>
                                </ul>
                                <div class="dt-setting">
                                    <ul class="list-group list-unstyled mt-1">
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label>Primary Color</label>
                                            <button id="primaryColorPicker" class="btn bg-primary avatar xs border-0 rounded-0"></button>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label>Secondary Color</label>
                                            <button id="secondaryColorPicker" class="btn bg-secondary avatar xs border-0 rounded-0"></button>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label class="text-muted">Chart Color 1</label>
                                            <button id="chartColorPicker1" class="btn chart-color1 avatar xs border-0 rounded-0"></button>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label class="text-muted">Chart Color 2</label>
                                            <button id="chartColorPicker2" class="btn chart-color2 avatar xs border-0 rounded-0"></button>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label class="text-muted">Chart Color 3</label>
                                            <button id="chartColorPicker3" class="btn chart-color3 avatar xs border-0 rounded-0"></button>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label class="text-muted">Chart Color 4</label>
                                            <button id="chartColorPicker4" class="btn chart-color4 avatar xs border-0 rounded-0"></button>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                            <label class="text-muted">Chart Color 5</label>
                                            <button id="chartColorPicker5" class="btn chart-color5 avatar xs border-0 rounded-0"></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Settings: Font -->
                            <div class="setting-font py-3">
                                <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-font fs-4 me-2 text-primary"></i> Font Settings</h6>
                                <ul class="list-group font_setting mt-1">
                                    <li class="list-group-item py-1 px-2">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" name="font" id="font-poppins" value="font-poppins">
                                            <label class="form-check-label" for="font-poppins">
                                                Poppins Google Font
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-1 px-2">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" name="font" id="font-opensans" value="font-opensans" checked="">
                                            <label class="form-check-label" for="font-opensans">
                                                Open Sans Google Font
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-1 px-2">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" name="font" id="font-montserrat" value="font-montserrat">
                                            <label class="form-check-label" for="font-montserrat">
                                                Montserrat Google Font
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item py-1 px-2">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" name="font" id="font-mukta" value="font-mukta">
                                            <label class="form-check-label" for="font-mukta">
                                                Mukta Google Font
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- Settings: Light/dark -->
                            <div class="setting-mode py-3">
                                <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-layout fs-4 me-2 text-primary"></i>Contrast Layout</h6>
                                <ul class="list-group list-unstyled mb-0 mt-1">
                                    <li class="list-group-item d-flex align-items-center py-1 px-2">
                                        <div class="form-check form-switch theme-switch mb-0">
                                            <input class="form-check-input" type="checkbox" id="theme-switch">
                                            <label class="form-check-label" for="theme-switch">Enable Dark Mode!</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center py-1 px-2">
                                        <div class="form-check form-switch theme-high-contrast mb-0">
                                            <input class="form-check-input" type="checkbox" id="theme-high-contrast">
                                            <label class="form-check-label" for="theme-high-contrast">Enable High Contrast</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center py-1 px-2">
                                        <div class="form-check form-switch theme-rtl mb-0">
                                            <input class="form-check-input" type="checkbox" id="theme-rtl">
                                            <label class="form-check-label" for="theme-rtl">Enable RTL Mode!</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-white border lift" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary lift">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div> 

            <!-- Modal Cropper-->
            <div class="modal docs-cropped" id="getCroppedCanvasModal" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cropped</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white border lift" data-bs-dismiss="modal">Close</button>
                            <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.html">Download</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>      

    </div>

    <!-- Jquery Core Js -->      
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="js/editproduct.js"></script>
    <!-- Jquery Plugin -->  
    <script src="../../../../../cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
    <script src="assets/plugin/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js --> 
    <script src="assets/plugin/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
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

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/product-edit.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:17 GMT -->
</html> 
<?php 
}
}
else{
     header("Location: index.php");
    exit();
}
?>
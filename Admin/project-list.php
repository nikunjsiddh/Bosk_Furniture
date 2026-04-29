<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/product-list.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:12 GMT -->
<head>
    <?php include_once"design/header.php"?>
    
    <!--plugin css file -->
    <link rel="stylesheet" href="assets/plugin/nouislider/nouislider.min.css">
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
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Projects</h3>
                                <!--<div class="btn-group group-link btn-set-task w-sm-100">-->
                                <!--    <a href="product-grid.php" class="btn d-inline-flex align-items-center" aria-current="page"><i class="icofont-wall px-2 fs-5"></i>Grid View</a>-->
                                <!--    <a href="product-list.php" class="btn active d-inline-flex align-items-center"><i class="icofont-listing-box px-2 fs-5"></i> List View</a>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3">
                        
                        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="card mb-3 bg-transparent p-2">
                            
                                <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Index</th>
                                                <th>Project Image</th>
                                                <th style="display:none;">Product Id</th>
                                                
                                                <th>Project Name</th>
                                                <th style="display:none;">Project Description</th>
                                                <th style="display:none;">Interior Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                 <?php
                                 include_once"connect.php";
                                 $count=0;
                                  $cmd="select * from projects";
                                  $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                  while($row=mysqli_fetch_array($result))
                                  {     
                                      $id = $row['id'];
                                      $count=$count+1;
                                      $project_name=$row['project_name'];
                                      $pro_desc=$row['pro_desc'];
                                      $interior_detail=$row['interior_detail'];
                                      $img1=$row['img1'];
                                      $img2=$row['img2'];
                                     
                                  ?>
                                <tbody>
                                            <tr>
                                                <td><?php echo $count;?></td>
                                                <td> 
                                                    <a href="#">
                                                        <img class="w120 rounded img-fluid" src="project_image/<?php echo $img1;?>" alt="">
                                                    </a>
                                                </td>
                                                <td style="display:none;"><?php echo $id;?></td>
                                                <td><?php echo $project_name;?></td>
                                                <td style="display:none;"><?php echo $pro_desc;?></td>
                                                <td style="display:none;"><?php echo $interior_detail;?></td>
                                                
                                                
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button data-toggle="modal" data-target="#projectmodal" type="button" class="editproduct btn btn-outline-secondary"><i class="icofont-edit text-success"></i></button>
                                                        <button type="button" onclick="deleteproject(<?php echo $row['id'];  ?>)" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                        <button type="button"   data-bs-toggle="modal" data-bs-target="#viewproject<?php echo $row['id']?>" class="btn btn-outline-secondary deleterow"><i class="icofont-eye text-primary"></i></button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                     
                                        </tbody>
                               <div id="return"></div>
                               
                               <!-- View Modal Start-->
                               <div class="modal fade" id="viewproject<?php echo $row['id'] ?>" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Edit Product Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row">
                                                        <div class="col-md-5">Project Name</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $project_name; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Project Description</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $pro_desc; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Interior Details</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $interior_detail; ?></div>
                                                    </div>
                                       	<br/>
                                       	
                                       	<div class="row">
                                        <div class="col-md-5">Project Image 1</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="project_image/<?php echo $img1; ?>"></div>
                                    </div>
									<br/>
									<?php
									if($img1=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Project Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="project_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Project Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="project_image/<?php echo $img2; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									 
									<br/>
									
								 </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                                
                            </div>
                        </div>
                        </div>
                    </div>
            <!-- modal end-->
            <!-- Edit Modal Start-->
            <div class="modal fade" id="projectmodal" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Project Details</h5>
                            <button type="button" class="btn btn-white border lift" data-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-body">
                                               
                                <form id="MyForm" method="post">
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label for="">Project Name<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="project_name" id="project_name" aria-describedby="helpId"   required />
                                    </div>
                                	<div class="form-group">
                                        <label for="">Project Description<sup style="color:red;">*</sup></label>
                                        <textarea type="text" class="form-control" name="pro_desc" id="pro_desc" aria-describedby="helpId"   required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Interior Details<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="interior_detail" id="interior_detail" aria-describedby="helpId"   required />
                                    </div>
                                   
                                	<div class="modal-footer">                                
                                        <button class="btn waves-effect waves-light btn-primary btn-square btn-block"type="submit" name="submit" id="submit">Submit</button>
                                    </div>
                                </form>
                                <div id="return"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Modal end-->
                                <?php
                              
                                }
                                ?>
                                </table>
                            </div>
                           
                        </div>
                    </div> <!-- Row end  -->
                </div>
            </div>
        
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
            
        </div> 

    </div>

    <!-- Jquery Core Js -->
    
    <script src="assets/bundles/libscripts.bundle.js"></script>
       
    <script src="js/deleteproject.js"></script>
    <script src="js/fetchproject.js"></script>
    <script src="js/updateproject.js"></script>
    <!-- Jquery Plugin --> 
   

    <!-- Jquery Page Js --> 
    <script src="javascript/template.js"></script>
    <script src="toastr/toastr.min.js"></script>
  
</body>

</html> 
<?php 
}
else{
     header("Location: index.php");
    exit();
}
?>

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
                                <h3 class="fw-bold mb-0">Products</h3>
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
                                
                                <!--<div class="card border-0 mb-1">-->
                                <!--    <div class="form-check form-switch position-absolute top-0 end-0 py-3 px-3 d-none d-md-block">-->
                                <!--       <div class="btn-group" role="group" aria-label="Basic outlined example">-->
                                                        <!--<a  class="btn btn-outline-secondary" href="product-edit.php?astringdata=" ><i class="icofont-edit text-success"></i></a>-->
                                <!--                        <button data-toggle="modal" data-target="#productmodal" type="button" class="editproduct btn btn-outline-secondary"><i class="icofont-edit text-success"></i></button>-->
                                <!--                        <button type="button" onclick="deleteproduct(<?php echo $row['id'];  ?>)" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>-->
                                <!--                        <button type="button"   data-bs-toggle="modal" data-bs-target="#expedit<?php echo $row['id']?>" class="btn btn-outline-secondary deleterow"><i class="icofont-eye text-primary"></i></button>-->
                                <!--                    </div>-->
                                <!--    </div>-->
                                <!--    <div class="card-body d-flex align-items-center flex-column flex-md-row">-->
                                <!--        <a href="product-detail.php">-->
                                <!--            <img class="w120 rounded img-fluid" src="product_image/<?php echo $img1;?>" alt="">-->
                                <!--        </a>-->
                                <!--        <div class="ms-md-4 m-0 mt-4 mt-md-0 text-md-start text-center w-100">-->
                                <!--            <a href="product-detail.php"><h6 class="mb-3 fw-bold"><?php echo"$pname";?><span class="text-muted small fw-light d-block">Reference 1204</span></h6></a>-->
                                <!--                <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-md-start">-->
                                <!--                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">-->
                                <!--                        <div class="text-muted small">Product Category</div>-->
                                <!--                        <strong><?php echo$pcategory;?></strong>-->
                                <!--                    </div>-->
                                <!--                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">-->
                                <!--                        <div class="text-muted small">Publish Date</div>-->
                                <!--                        <strong><?php echo$publish_date;?></strong>-->
                                <!--                    </div>-->
                                <!--                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">-->
                                <!--                        <div class="text-muted small">Price</div>-->
                                <!--                        <strong><?php echo $mrp;?>₹</strong>-->
                                <!--                    </div>-->
                                <!--                    <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">-->
                                <!--                        <div class="text-muted small">Stock</div>-->
                                <!--                        <strong><?php echo$stock;?></strong>-->
                                <!--                    </div>-->
                                <!--                </div>-->
                                <!--                <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2 d-inline-flex d-md-none">-->
                                <!--                    <button type="button" class="btn btn-primary">Add Cart</button>-->
                                <!--                </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                                    <th>Product Name</th>
                                                                     <th>Product Quantity</th>
                                                                    <th>Quantity</th>
                                                                    <th>Date</th>
                                                                    
                                                
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                 <?php
                                 include_once"connect.php";
                                 
                                  $cmd41="select * from return_request";
                                                                  $result41=mysqli_query($con,$cmd41) or die(mysqli_error($con));
                                                                  while($row41=mysqli_fetch_array($result41))
                                                                  {    
                                                                      $order_id = $row41['order_id'];
                                                                      $product_id=$row41['product_id'];
                                                                       $user_id=$row41['user_id'];
                                                                      $date_time=$row41['date_time'];
                                                                      $img1=$row41['img1'];
                                                                      $img2=$row41['img2'];
                                                                      $img3=$row41['img3'];
                                                                      $img4=$row41['img4'];
                                                                      $img5=$row41['img5'];
                                                                      $firstname=$row41['firstname'];
                                                                      $lastname=$row41['lastname'];
                                                                      $name=$firstname.' '.$lastname;
                                                                      $email=$row41['email'];
                                                                      $msg=$row41['msg'];
                                                                      $phone=$row41['phone'];
                                                                $cmd42="select * from products where id='$product_id'";
                                                                  $result42=mysqli_query($con,$cmd42) or die(mysqli_error($con));
                                                                  while($row42=mysqli_fetch_array($result42))
                                                                  {    
                                                                      $product_name = $row42['pname'];
                                                                      $cmd43="select * from order_items where product_id='$product_id' and user_id='$user_id' and order_id='$order_id'";
                                                                  $result43=mysqli_query($con,$cmd43) or die(mysqli_error($con));
                                                                  while($row43=mysqli_fetch_array($result43))
                                                                  {    
                                                                      $quantity=$row43['quantity'];
                                  ?>    
                                <tbody>
                                            <tr>
                                                
                                                <td> 
                                                    <a href="#">
                                                        <img class="w120 rounded img-fluid" src="../../../return_request_image/<?php echo $img1;?>" alt="">
                                                    </a>
                                                </td>
                                                <td><?php echo $order_id;?></td>
                                                <td><?php echo $product_name;?></td>
                                                <td><?php echo $quantity;?> Piece</td>
                                                <td><?php echo $date_time;?></td>
                                                
                                               <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                       
                                                        <button type="button"   data-bs-toggle="modal" data-bs-target="#expedit<?php echo $row['id']?>" class="btn btn-outline-secondary deleterow"><i class="icofont-eye text-primary"></i></button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                     
                                        </tbody>
                               <div id="return"></div>
                               
                               <!-- View Modal Start-->
                               <div class="modal fade" id="expedit<?php echo $row['id'] ?>" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title  fw-bold" id="expeditLabel">View Return Request Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row">
                                                        <div class="col-md-5">Order Id</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $order_id; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Name</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $product_name; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Quantity</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $quantity; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Name</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $name; ?>Piece</div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Return Request Date</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $date_time; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Contact Number</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $phone; ?></div>
                                                    </div>
                                       	<br/>
                                       	
                                       	<div class="row">
                                                        <div class="col-md-5">Email</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $email; ?></div>
                                                    </div>
                                       	<br/>
                                       	
                                  
									
									 <div class="row">
                                        <div class="col-md-5">Product Image 1</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="../../../return_request_image/<?php echo $img1; ?>"></div>
                                    </div>
									<br/>
									<?php
									if($img1=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="../../../return_request_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="../../../return_request_image/<?php echo $img2; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									 
									<br/>
									 <?php
									if($img2=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 3</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="../../../return_request_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 3</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="../../../return_request_image/<?php echo $img3; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									<br/>
									 <?php
									if($img3=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 4</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="../../../return_request_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 4</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="../../../return_request_image/<?php echo $img4; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									<br/>
									 <?php
									if($img4=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 5</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="../../../return_request_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 5</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="../../../return_request_image/<?php echo $img5; ?>"></div>
                                    </div>
									<?php									
									}
									?>
                        
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                                
                            </div>
                        </div>
                        </div>
                    </div>
            <!-- modal end-->
            
                                <?php
                                                                  }
                                                                  }
                                }
                                ?>
                                </table>
                            </div>
                           
                        </div>
                    </div> <!-- Row end  -->
                </div>
            </div>
        
            
            
        </div> 

    </div>

    <!-- Jquery Core Js -->
    
    <script src="assets/bundles/libscripts.bundle.js"></script>
       
    <script src="js/deleteproduct.js"></script>
    <script src="js/fetchproduct.js"></script>
    <script src="js/updateproduct.js"></script>
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

<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:17:47 GMT -->
<head>
    <?php include_once"design/header.php"?>

    <!-- plugin css file  -->
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        .hi{
            display:none !important;
        }
    </style>
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

                    <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                        <div class="col">
                            <div class="alert-info alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-shopping-bag" aria-hidden="true"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <?php
                                         include_once"connect.php";
                                         
                                          $cmd="select * from category";
                                          $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                          $no_of_row=mysqli_num_rows($result);
                                          ?>
                                        <div class="h6 mb-0">NO. OF CATEGORY</div>
                                        <span class="small"><?php echo $no_of_row;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert-success alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-dollar fa-lg"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <?php
                                         $cmd1="select * from products";
                                          $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                          $no_of_row1=mysqli_num_rows($result1);
                                          ?>
                                        <div class="h6 mb-0">NO. OF PRODUCTS</div>
                                        <span class="small"><?php echo $no_of_row1;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert-danger alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-credit-card fa-lg"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <?php
                                         $cmd2="select * from orders";
                                          $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                          $no_of_row2=mysqli_num_rows($result2);
                                          ?>
                                        <div class="h6 mb-0">NO. OF ORDERS</div>
                                        <span class="small"><?php echo $no_of_row2;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert-warning alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-smile-o fa-lg"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <?php
                                         $cmd3="select * from user";
                                          $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                                          $no_of_row3=mysqli_num_rows($result3);
                                          ?>
                                        <div class="h6 mb-0">NO. OF USER</div>
                                        <span class="small"><?php echo $no_of_row3;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- Row end  -->
                    
                    <div class="row g-1">
                        
                                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                    <h6 class="m-0 mt-2 fw-bold">Product Listing</h6>
                                </div>
                               
                           
                        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Product Image</th>
                                                <th class="hi">Product Id</th>
                                                
                                                <th>Product Name</th>
                                                <th>Product Category</th>
                                                <th class="hi">Product Description</th>
                                                <th>Publishing Date</th>
                                                <th class="hi">SKU</th>
                                                <th>Stock</th>
                                                <th class="hi">Status</th>
                                                <th>Product Old Price</th>
                                                <th>Product New Price</th>
                                                <th  class="hi">Tags</th>
                                                
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                 <?php
                                 include_once"connect.php";
                                 
                                  $cmd="select * from products";
                                  $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                  while($row=mysqli_fetch_array($result))
                                  {     
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
                                    //   $id = base64_encode($id);
                                  ?>
                                <tbody>
                                            <tr>
                                                
                                                <td> 
                                                    <a href="#">
                                                        <img class="w120 rounded img-fluid" src="product_image/<?php echo $img1;?>" alt="">
                                                    </a>
                                                </td>
                                                <td class="hi"><?php echo $id;?></td>
                                                <td><?php echo $pname;?></td>
                                                <td><?php echo $pcategory;?></td>
                                                <td class="hi"><?php echo $description;?></td>
                                                <td><?php echo $publish_date;?></td>
                                                <td class="hi"><?php echo $sku;?></td>
                                                <td><?php echo $stock;?></td>
                                                <td class="hi"><?php echo $status;?></td>
                                                <td><?php echo $old_price;?></td>
                                                <td><?php echo $new_price;?></td>
                                                <td class="hi"><?php echo $tags;?></td>
                                                
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button data-toggle="modal" data-target="#productmodal" type="button" class="editproduct btn btn-outline-secondary"><i class="icofont-edit text-success"></i></button>
                                                        <button type="button" onclick="deleteproduct(<?php echo $row['id'];  ?>)" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
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
                                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Edit Product Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="row">
                                                        <div class="col-md-5">Product Name</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $pname; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Category</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $pcategory; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">SKU</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $sku; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Stock</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $stock; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Old Price</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $old_price; ?>₹</div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product New Price</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $new_price; ?>₹</div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Publish Date</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $publish_date; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Status</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $status; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Tags</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $tags; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Product Description</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $description; ?></div>
                                                    </div>
                                       	<br/>
                                  
									
									 <div class="row">
                                        <div class="col-md-5">Product Image 1</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/<?php echo $img1; ?>"></div>
                                    </div>
									<br/>
									<?php
									if($img1=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img2; ?>"></div>
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
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 3</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img3; ?>"></div>
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
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 4</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img4; ?>"></div>
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
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 5</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img5; ?>"></div>
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
            <!-- Edit Modal Start-->
            <div class="modal fade" id="productmodal" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Product Details</h5>
                            <button type="button" class="btn btn-white border lift" data-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-body">
                                               
                                <form id="MyForm" method="post">
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label for="">Product Name<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="pname" id="pname" aria-describedby="helpId"   required />
                                    </div>
                                	<div class="form-group">
                                        <label for="">Product Category<sup style="color:red;">*</sup></label>
                                        
                                        <select name="pcategory" id="pcategory"  class="form-control">
                                            
                                            <?php
                                            $cmd1="select * from category";
                                          $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                          while($row1=mysqli_fetch_array($result1))
                                          {     
                                              $id1 = $row1['id'];
                                              $name1=$row1['name'];
                                             
                                          ?>
                                        <option name="pcategory" id="pcategory" value="<?php echo $name1;?>"><?php echo $name1;?></option>
                                       <?php
                                          }
                                       ?>
                                    
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Product Description<sup style="color:red;">*</sup></label>
                                        <textarea type="text" class="form-control" name="description" id="description" aria-describedby="helpId"   required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Publishing Date<sup style="color:red;">*</sup></label>
                                        <input type="date" class="form-control" name="publish_date" id="publish_date" aria-describedby="helpId"   required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">SKU<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="sku" id="sku" aria-describedby="helpId"   required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Stock<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="stock" id="stock" aria-describedby="helpId"   required />
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label for="">Status<sup style="color:red;">*</sup></label>-->
                                    <!--    <input type="text" class="form-control" name="status" id="status" aria-describedby="helpId"   required />-->
                                    <!--</div>-->
                                    <div class="form-group">
                                        <label for="">Old Price<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="old_price" id="old_price" aria-describedby="helpId"   required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">New Price<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="new_price" id="new_price" aria-describedby="helpId"   required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tags<sup style="color:red;">*</sup></label>
                                        <input type="text" class="form-control" name="tags" id="tags" aria-describedby="helpId"   required />
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
                    </div><!-- Row end  -->

                    
                    
                </div>
            </div>
        
           
            
        </div>
    
    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>

    <!-- Plugin Js -->
    <script src="assets/bundles/apexcharts.bundle.js"></script>
    <script src="assets/bundles/dataTables.bundle.js"></script>  

    <!-- Jquery Page Js -->
    <script src="js/template.js"></script>
    <script src="js/page/index.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1Jr7axGGkwvHRnNfoOzoVRFV3yOPHJEU&amp;callback=myMap"></script>  
    <script>
        $('#myDataTable')
        .addClass( 'nowrap')
        .dataTable( {
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
    </script>
    <script src="js/deleteproduct.js"></script>
    <script src="js/fetchproduct.js"></script>
    <script src="js/updateproduct.js"></script>
    <script src="toastr/toastr.min.js"></script>
</body>

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:04 GMT -->
</html> 
<?php 
}
else{
     header("Location: index.php");
    exit();
}
?>

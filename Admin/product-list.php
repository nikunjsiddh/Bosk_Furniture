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
                                                <th>Product Image</th>
                                                <th style="display:none;">Product Id</th>
                                                
                                                <th>Product Name</th>
                                                <th>Product Category</th>
                                                <th style="display:none;">Product Description</th>
                                                <th>Publishing Date</th>
                                                <th style="display:none;">SKU</th>
                                                <th>Stock</th>
                                                <th style="display:none;">Status</th>
                                                <th>Product Old Price</th>
                                                <th>Product New Price</th>
                                                <th style="display:none;">Tags</th>
                                                
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
                                                <td style="display:none;"><?php echo $id;?></td>
                                                <td><?php echo $pname;?></td>
                                                <td><?php echo $pcategory;?></td>
                                                <td style="display:none;"><?php echo $description;?></td>
                                                <td><?php echo $publish_date;?></td>
                                                <td style="display:none;"><?php echo $sku;?></td>
                                                <td><?php echo $stock;?></td>
                                                <td style="display:none;"><?php echo $status;?></td>
                                                <td><?php echo $old_price;?></td>
                                                <td><?php echo $new_price;?></td>
                                                <td style="display:none;"><?php echo $tags;?></td>
                                                
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
                            </div>
                           
                        </div>
                    </div> <!-- Row end  -->
                </div>
            </div>
        
            <!-- Modal Custom Settings-->
           
            
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

<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <?php include_once"design/header.php"?>
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
     <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        .aa {

display:none;
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
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Blog List</h3>
                                <a href="blog-add.php" class="btn btn-primary py-2 px-5 btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i> Add Blog</a>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Blog Image</th>
                                                <th>Blog Id</th>
                                                <th>Blog Title</th>
                                               <th class="aa"> Blog Description</th>
                                                <th>Blog Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                         <?php
                                         include_once"connect.php";
                                         
                                          $cmd="select * from blog";
                                          $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                          while($row=mysqli_fetch_array($result))
                                          {     
                                              $id = $row['id'];
                                              $blog_title=$row['blog_title'];
                                              $blog_description=$row['blog_description'];
                                              $blog_date=$row['blog_date'];
                                              $img=$row['img'];
                                          ?>
                                        <tbody>
                                            <tr>
                                                <td> 
                                                    <a href="product-detail.php">
                                                        <img class="w120 rounded img-fluid" src="blog_image/<?php echo $img;?>" alt="">
                                                    </a>
                                                </td>
                                                <td><?php echo $id;?></td>
                                                <td><?php echo $blog_title;?></td>
                                               <td class="aa"><?php echo $blog_description;?></td>
                                                <td><?php echo $blog_date;?></td>
                                                
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button data-toggle="modal" data-target="#blogmodal" type="button" class="editblog btn btn-outline-secondary"><i class="icofont-edit text-success"></i></button>
                                                        <button type="button"  onclick="deleteblog(<?php echo $row['id'];  ?>)" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                         <button type="button"   data-bs-toggle="modal" data-bs-target="#expedit<?php echo $row['id']?>" class="btn btn-outline-secondary deleterow"><i class="icofont-eye text-primary"></i></button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                     
                                        </tbody>
                                            
                                </div>
                                
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
                                                        <div class="col-md-5">Blog Title</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $blog_title; ?></div>
                                                    </div>
                                       	<br/>
                                       	<div class="row">
                                                        <div class="col-md-5">Blog Description</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $blog_description; ?></div>
                                                    </div>
                                       	<br/>
                                        <div class="row">
                                                        <div class="col-md-5">Blog Date</div>
                                                        <div class="col-md-1">:</div>
                                                        <div class="col-md-5"><?php echo $blog_date; ?></div>
                                                    </div>
                                       	<br/>
                                  
									
									 <div class="row">
                                        <div class="col-md-5">Blog Image</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="blog_image/<?php echo $img; ?>"></div>
                                    </div>
									<br/>
									
                        
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                                
                            </div>
                        </div>
                        </div>
                    </div>
                                <!-- View Modal End-->
                                
                                <!--Category Modal Start-->
                                <div class="modal fade" id="blogmodal" role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Edit Blog Details</h5>
                                                <button type="button" class="btn btn-white border lift" data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="modal-body">
                                               
                                                    <form id="MyForm" method="post">
                                                        <input type="hidden" name="id" id="id">
                                                        <div class="form-group">
                                                            <label for="">Blog Title<sup style="color:red;">*</sup></label>
                                                            <input type="text" class="form-control" name="blog_title" id="blog_title" aria-describedby="helpId"   required />
                                                        </div>
                                						<div class="form-group">
                                                            <label for="">Blog Description<sup style="color:red;">*</sup></label>
                                                            <textarea type="text" class="form-control" name="blog_description" id="blog_description" aria-describedby="helpId"   required /></textarea>
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
                                <!--Category Modal end-->
                                         <?php
                                            }
                                         ?>
                                    </table>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
           
        </div> 

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="toastr/toastr.min.js"></script>
    <script src="js/deleteblog.js"></script>
    <script src="js/fetchblog.js"></script>
    <script src="js/updateblog.js"></script>
    <!-- Plugin Js -->
    <script src="assets/bundles/dataTables.bundle.js"></script>  

    <!-- Jquery Page Js -->
    <script src="javascript/template.js"></script>
    <script>
        $('#myDataTable')
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
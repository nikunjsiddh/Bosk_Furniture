<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
   <?php include_once"design/header.php"?>

    <!-- plugin css file  -->
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    
    
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
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Customers Information</h3>
                               
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row clearfix g-3">
                        <div class="col-sm-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                                        <thead>
                                            <tr>
                                                
                                                <th>Customer Name</th> 
                                                <th>DOB</th>
                                                <th>Mail</th>
                                                <th>Joining Date</th> 
                                                <th>Addressline1</th> 
                                                <th>Addressline2</th>
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <?php
                                     include_once"connect.php";
                                     
                                      $cmd="select * from user";
                                      $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                      while($row=mysqli_fetch_array($result))
                                      {     
                                          $id = $row['id'];
                                          $firstname=$row['firstname'];
                                          $lastname=$row['lastname'];
                                          $dob=$row['dob'];
                                          $email=$row['email'];
                                          $joining_date=$row['joining_date'];
                                          $addressline1=$row['addressline1'];
                                          $addressline2=$row['addressline2'];
                                          $pincode=$row['pincode'];
                                          $state=$row['state'];
                                          $city=$row['city'];
                                          $phone=$row['phone'];
                                          $img=$row['img'];
                                      ?>
                                        <tbody>
                                          <tr>
                                                <td><strong><?php echo$firstname.$lastname?></strong></td>
                                                <td><?php echo$dob;?></td>
                                                <td><?php echo$email?></td>
                                                <td><?php echo$joining_date;?></td>
                                                <td><?php echo$addressline1;?></td>
                                                <td><?php echo$addressline2?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#expedit<?php echo $row['id']?>"><i class="icofont-eye"></i></button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                       
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>
            
          
            <!-- Edit Customers-->
            <div class="modal fade" id="expedit<?php echo $row['id'] ?>" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel">Customer Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="deadline-form">
                            <form>
                                
                                <div class="row g-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-5">Customer Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $firstname.' '.$lastname; ?></div>
                                    </div>
                                    
                                </div>
                                <?php
									if($img=='noimg.jpg')
									{
									?>
									<div class="row g-3 mb-3">
									<div class="row">
                                        <div class="col-md-5">Customer Photo</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="customer_image/noimg.jpg"></div>
                                    </div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row g-3 mb-3">
									<div class="row">
                                        <div class="col-md-5">Customer Photo</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="customer_image/<?php echo $img1; ?>"></div>
                                    </div>
                                    </div>
									<?php									
									}
									?>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Date of Birth</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $dob; ?></div>
                                    </div>
                                </div>
                               <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Mail-Id</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $email; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Mobile Number</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $phone; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Joining Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $joining_date; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Addressline1</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $addressline1; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Addressline2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $addressline2; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">Pincode</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $pincode; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">State</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $state; ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="row">
                                        <div class="col-md-5">City</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $city; ?></div>
                                    </div>
                                </div>
                               
                            </form>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    
                </div>
                </div>
            </div>
            <?php
                }
            ?> 
            </table>
        </div> 
            
    </div>
    
    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>

    <!-- Plugin Js-->
    <script src="assets/bundles/dataTables.bundle.js"></script>

    <!-- Jquery Page Js -->
    <script src="javascript/template.js"></script>
    <script>
        // project data table
        $(document).ready(function() {
            $('#myProjectTable')
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
        });
    </script>
</body>

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/customers.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:23 GMT -->
</html>
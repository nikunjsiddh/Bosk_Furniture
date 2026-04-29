<?php 
include_once("connect.php");
session_start();

if (isset($_SESSION['email'])) {
if(isset($_GET['astringdata']) && isset($_GET['astringdata1']))
	{
	    $order_id = mysqli_real_escape_string($con,$_GET['astringdata']);
	     $user_id = mysqli_real_escape_string($con,$_GET['astringdata1']);
	   //  echo $user_id;
	   $decoded_user_id = base64_decode($user_id);
	   //echo $decoded_user_id;
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/order-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:22 GMT -->
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
            <div class="body d-flex py-3">  
                <div class="container-xxl"> 
                    <div class="row align-items-center"> 
                        <div class="border-0 mb-4"> 
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Order Details: #Order-<?php echo $order_id;?></h3>
                                <?php
                                 $cmd1="select * from user where id='$decoded_user_id'";
                                            $result1=mysqli_query($con,$cmd1)or die(mysqli_error($con));
                                            $row1=mysqli_fetch_array($result1);
                                            $firstname=$row1['firstname'];
                                            $lastname=$row1['lastname'];
                                            $name=$firstname.' '.$lastname;
                                            $email=$row1['email'];
                                            $addressline1=$row1['addressline1'];
                                            $addressline2=$row1['addressline2'];
                                            $pincode=$row1['pincode'];
                                            $state=$row1['state'];
                                            $city=$row1['city'];
                                            $country=$row1['country'];
                                            $phone=$row1['phone'];
                                           
                                            $cmd="select * from orders where order_id='$order_id'";
                                              $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                              $row=mysqli_fetch_array($result);
                                               $address=$row['address'];
                                                //   $user_id=$row['user_id'];
                                                  $date_time=$row['date_time'];
                                                  $phone=$row['phone'];
                                          
                                ?>
                               
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                        <div class="col">
                            <div class="alert-success alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <div class="h6 mb-0">Order Created at</div>
                                        <span class="small"><?php echo $date_time;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert-danger alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-user fa-lg" aria-hidden="true"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <div class="h6 mb-0">Name</div>
                                        <span class="small"><?php echo $name;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert-warning alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <div class="h6 mb-0">Email</div>
                                        <span class="small"><?php echo $email;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="alert-info alert mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-phone-square fa-lg" aria-hidden="true"></i></div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <div class="h6 mb-0">Contact No</div>
                                        <span class="small"><?php echo $phone;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3 row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3 row-deck"> 
                        <div class="col">
                            <div class="card auth-detailblock">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Delivery Address</h6>
                                    
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Block Number:</label>
                                            <span><strong><?php echo $addressline1;?></strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Address:</label>
                                            <span><strong><?php echo $addressline2;?></strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Pincode:</label>
                                            <span><strong><?php echo $pincode;?></strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Phone:</label>
                                            <span><strong><?php echo $phone;?></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Billing Address</h6>
                                   
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Block Number:</label>
                                            <span><strong><?php echo $addressline1;?></strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Address:</label>
                                            <span><strong><?php echo $addressline2;?></strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Pincode:</label>
                                            <span><strong><?php echo $pincode;?></strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Phone:</label>
                                            <span><strong><?php echo $phone;?></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Invoice Deatil</h6>
                                    
                                    <a href="invoice.php?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $decoded_user_id;?>" class="text-muted">Download</a>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Number:</label>
                                            <span><strong>#78414</strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Seller GST :</label>
                                            <span><strong>AFQWEPX17390VJ</strong></span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label col-6 col-sm-5">Purchase GST :</label>
                                            <span><strong>NVFQWEPX1730VJ</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3">
                        <div class="col-xl-12 col-xxl-12">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Order Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="product-cart">
                                        <div class="checkout-table table-responsive">
                                            <table id="myCartTable" class="table display dataTable table-hover align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="product">Product Image</th>
                                                        <th>Product Name</th>
                                                        <th class="quantity">Quantity</th>
                                                        <th class="price">Price</th>
                                                        <th class="price">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                     include_once("connect.php");
                                                        $cmd2="select * from order_items where order_id='$order_id'";
                                                        $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                                        while($row2=mysqli_fetch_array($result2))
                                                        {     
                                                            $product_id = $row2['product_id'];
                                                        //   echo $product_id;
                                                            $price=$row2['price'];
                                                            $quantity=$row2['quantity'];
                                                            
                                                            
                                                         $cmd3="select * from products where id='$product_id' ";
                                                            $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                                                            while($row3=mysqli_fetch_array($result3))
                                                            {     
                                                                $pname = $row3['pname'];
                                                            //   echo $pname;
                                                                $pcategory=$row3['pcategory'];
                                                                $img1=$row3['img1'];
                                                                 $new_price=$row3['new_price'];
                                                                 $total_price = $quantity * $new_price;
                                                                    $totalPrice1 += $total_price; 
                                                           
                                                        ?>
                                                    <tr>
                                                       
                                                        <td>
                                                            <img src="product_image/<?php echo $img1;?>" class="avatar rounded lg" alt="Product">
                                                        </td>
                                                        <td>
                                                            <h6 class="title"><?php echo $pname;?></h6>
                                                        </td>
                                                        <td>
                                                            <?php echo $quantity;?>
                                                        </td>
                                                        <td>
                                                            <p class="price">₹ <?php echo $new_price;?></p>
                                                        </td>
                                                        <td>
                                                             <p class="price">₹ <?php echo $total_price;?></p>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                            }
                                                        }
                                                       
                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                        $total_price = $quantity * $new_price;
                                        $subTotal+=$totalPrice1;
                                        $tax=$subTotal*0.18;
                                        $shipping=$subTotal*0.02;
                                        $total1=$subTotal+$tax+$shipping;
                                        ?>
                                        <div class="checkout-coupon-total checkout-coupon-total-2 d-flex flex-wrap justify-content-end">
                                            <div class="checkout-total">
                                                <div class="single-total">
                                                    <p style="font-weight:bolder!important;" class="value"><b>Subotal Price:</b></p>
                                                    <p class="price"><b>₹ <?php echo $totalPrice1; ?></b></p>
                                                </div>
                                                <div class="single-total">
                                                    <p style="font-weight:bolder!important;" class="value"><b>Shipping Cost (+):</b></p>
                                                    <p class="price"><b>₹ <?php echo $shipping;?></b></p>
                                                </div>
                                                
                                                <div class="single-total">
                                                    <p style="font-weight:bolder!important;" class="value"><b>Tax(18%):</b></p>
                                                    <p class="price"><b>₹ <?php echo $tax;?></b></p>
                                                </div>
                                                <div class="single-total total-payable">
                                                    <p class="value"><b>Total Payable:</b></p>
                                                    <p class="price"><b>₹ <?php echo $total1;?></b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-xl-12 col-xxl-4">-->
                        <!--    <div class="card mb-3">-->
                        <!--        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">-->
                        <!--            <h6 class="mb-0 fw-bold ">Status Orders</h6>-->
                        <!--        </div>-->
                        <!--        <div class="card-body">-->
                        <!--            <form>-->
                        <!--                <div class="row g-3 align-items-center">-->
                        <!--                    <div class="col-md-12">-->
                        <!--                        <label  class="form-label">Order ID</label>-->
                        <!--                        <input type="text" class="form-control" value="78414">-->
                        <!--                    </div>-->
                        <!--                    <div class="col-md-12">-->
                        <!--                        <label  class="form-label">Order Status</label>-->
                        <!--                        <select class="form-select" aria-label="Default select example">-->
                        <!--                            <option  value="1">Progress</option>-->
                        <!--                            <option value="2">Completed</option>-->
                        <!--                            <option selected value="3">Pending</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-md-12">-->
                        <!--                        <label class="form-label">Quantity</label>-->
                        <!--                        <input type="text" class="form-control" value="4">-->
                        <!--                    </div>-->
                        <!--                    <div class="col-md-12">-->
                        <!--                        <label  class="form-label">Order Transection</label>-->
                        <!--                        <select class="form-select" aria-label="Transection">-->
                        <!--                            <option  value="1">Completed</option>-->
                        <!--                            <option value="2">Fail</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-md-12">-->
                        <!--                        <label for="comment" class="form-label">Comment</label>-->
                        <!--                        <textarea  class="form-control" id="comment" rows="4">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</textarea>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--                <button type="button" class="btn btn-primary mt-4 text-uppercase">Submit</button>-->
                        <!--            </form>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
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

    <!-- Plugin Js-->
    <script src="assets/bundles/dataTables.bundle.js"></script>

    <!-- Jquery Page Js -->
    <script src="javascript/template.js"></script>
    <script>
        $(document).ready(function() {
        $('#myCartTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
    });
    </script>
</body>

</html>
<?php
}

}
else{
     header("Location: index.php");
    exit();
}
?>
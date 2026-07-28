<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'My Profile | Bosk Furniture Account';
$page_description = 'View and manage your Bosk Furniture profile - update details, track orders and manage your account preferences.';
$page_keywords    = 'my profile, account, bosk furniture account';
$page_canonical   = '/profile';
$page_robots      = 'noindex, follow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once "design/seo-meta.php"; ?>
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500,600,700%7COpen+Sans:300,400" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- ARCHIVES CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/menu.css">
    <link href="css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/lightcase.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="toastr/toastr.css">


    <style>
        body {
            background-color: white;
        }

        .myaccount-tab-menu {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .myaccount-tab-menu a {
            border: 1px solid #ccc;
            border-bottom: none;
            color: #252525;
            font-weight: 400;
            font-size: 15px;
            display: block;
            padding: 10px 15px;
            text-transform: uppercase;
        }

        .myaccount-tab-menu a:last-child {
            border-bottom: 1px solid #ccc;
        }

        .myaccount-tab-menu a:hover,
        .myaccount-tab-menu a.active {
            background-color: #532A1A;
            border-color: #532A1A;
            color: #fff;
        }

        .myaccount-tab-menu a i.fa {
            font-size: 14px;
            text-align: center;
            width: 25px;
        }

        @media only screen and (max-width: 767.98px) {
            #myaccountContent {
                margin-top: 30px;
            }
        }

        .myaccount-content {
            border: 1px solid #eeeeee;
            padding: 30px;
        }

        @media only screen and (max-width: 575.98px) {
            .myaccount-content {
                padding: 20px 15px;
            }
        }

        .myaccount-content form {
            margin-top: -20px;
        }

        .myaccount-content h3 {
            font-size: 20px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 400;
        }

        .myaccount-content .welcome a {
            color: #252525;
        }

        .myaccount-content .welcome a:hover {
            color: #532A1A;
        }

        .myaccount-content .welcome strong {
            font-weight: 500;
            color: #532A1A;
        }

        .myaccount-content fieldset {
            margin-top: 20px;
        }

        .myaccount-content fieldset legend {
            color: #252525;
            font-size: 20px;
            margin-top: 20px;
            font-weight: 400;
            border-bottom: 1px dashed #ccc;
        }

        .myaccount-table {
            white-space: nowrap;
            font-size: 14px;
        }

        .myaccount-table table th,
        .myaccount-table .table th {
            color: #252525;
            padding: 10px;
            font-weight: 400;
            background-color: #f8f8f8;
            border-color: #ccc;
            border-bottom: 0;
        }

        .myaccount-table table td,
        .myaccount-table .table td {
            padding: 10px;
            vertical-align: middle;
            border-color: #ccc;
        }

        .saved-message {
            background-color: #f4f5f7;
            border-top: 3px solid #532A1A;
            border-radius: 5px 5px 0 0;
            font-weight: 400;
            font-size: 15px;
            color: #555;
            padding: 20px;
        }

        /*-------- Start My Account Page Wrapper --------*/
    </style>
</head>

<body class="inner-page">
    <!-- Wrapper -->
    <div id="wrapper">
        <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <section class="headings">
            <div class="text-heading">
                <div class="container">
                    <h1 class="text-center">PROFILE</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="/">Home</a><span>»</span><span>PROFILE</span>
                    </div>
                </div>
            </div>
        </div>
        <?php
include_once"connect.php";
 if (isset($_SESSION['email'])) {
    $userEmail = mysqli_real_escape_string($con, $_SESSION['email']);

    $cmd    = "select * from user where email='$userEmail'";
    $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
    $row    = mysqli_fetch_array($result);

    // Session has an email, but no matching user in DB (deleted/stale session).
    // Clear the session and send the visitor to log in again instead of
    // rendering a profile with all-null fields.
    if (!$row) {
        session_unset();
        session_destroy();
        echo "<script>window.location='login.php';</script>";
        exit;
    }

    $id              = $row['id'];
    $encode_user_id  = base64_encode($id);
    $email           = $row['email'];
    $firstname       = $row['firstname'];
    $lastname        = $row['lastname'];
    $dob             = $row['dob'];
    $password        = $row['password'];
    $addressline1    = $row['addressline1'];
    $addressline2    = $row['addressline2'];
    $pincode         = $row['pincode'];
    $country         = $row['country'];
    $state           = $row['state'];
    $city            = $row['city'];
    $phone           = $row['phone'];
    $img             = $row['img'];

?>
        <!-- my account wrapper start -->
        <div class="my-account-wrapper mt-5 pt-50 pb-50">
            <div class="container">
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- My Account Page Start -->
                            <div class="myaccount-page-wrapper">
                                <!-- My Account Tab Menu Start -->
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="myaccount-tab-menu nav" role="tablist">
                                            <a href="#dashboad" class="active" data-bs-toggle="tab"><i
                                                    class="fa fa-dashboard"></i>
                                                Dashboard</a>
                                            <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i>
                                                Orders</a>
                                            <a href="#return" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i>
                                                Return Request</a>
                                            <!--<a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i>-->
                                            <!--    Download</a>-->
                                            <!--<a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i>-->
                                            <!--    Payment-->
                                            <!--    Method</a>-->
                                            <a href="#address-edit" data-bs-toggle="tab"><i
                                                    class="fa fa-map-marker"></i>
                                                address</a>
                                            <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i>
                                                Account
                                                Details</a>
                                            <a href="#password-edit" data-bs-toggle="tab"><i class="fa fa-pencil"></i>
                                                Change Password</a>
                                            <a href="logout"><i class="fa fa-sign-out"></i>Logout</a>
                                        </div>
                                    </div>
                                    <!-- My Account Tab Menu End -->

                                    <!-- My Account Tab Content Start -->
                                    <div class="col-lg-9 col-md-8">
                                        <div class="tab-content" id="myaccountContent">
                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h3>Dashboard</h3>
                                                    <div class="welcome">
                                                        <p>Hello, <strong>
                                                                <?php echo$firstname.' '.$lastname;?>
                                                            </strong> (If Not <strong>You
                                                                !</strong><a href="logout" class="logout">
                                                                Logout</a>)</p>
                                                    </div>
                                                    <p class="mb-0">From your account dashboard. you can easily check &
                                                        view your recent orders, manage your shipping and billing
                                                        addresses
                                                        and edit your password and account details.</p>
                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade" id="orders" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h3>Orders</h3>
                                                    <div class="myaccount-table table-responsive text-center">
                                                        <table class="table table-bordered">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th style="text-align:center !important;">Index</th>
                                                                    <th style="text-align:center !important;">Order Id
                                                                    </th>
                                                                    <th style="text-align:center !important;">Date</th>
                                                                    <!--<th>Status</th>-->
                                                                    <th style="text-align:center !important;">Total</th>
                                                                    <th style="text-align:center !important;">Order
                                                                        Detail</th>
                                                                    <th style="text-align:center !important;">Download
                                                                        Invoice</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                            include_once"connect.php";
                                                $count=0;
                                              $cmd4="select * from orders where user_id='$id'";
                                              $result4=mysqli_query($con,$cmd4) or die(mysqli_error($con));
                                              while($row4=mysqli_fetch_array($result4))
                                              {    
                                                  $count = $count+1;
                                                  $order_id = $row4['order_id'];
                                                  $address=$row4['address'];
                                                  $user_id=$row4['user_id'];
                                                 
                                                  $date_time=$row4['date_time'];
                                                  
                                            
                                                 
                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $count;?>
                                                                    </td>
                                                                    <td><b>
                                                                            <?php echo $order_id;?>
                                                                        </b></td>
                                                                    <td>
                                                                        <?php echo $date_time;?>
                                                                    </td>
                                                                    <!--<td>Pending</td>-->
                                                                    <td>$3000</td>
                                                                    <td><a href="order_details?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $encode_user_id;?>"
                                                                            style="background-color:#532A1A;color:white;"
                                                                            class="btn btn__bg">View</a>
                                                                    </td>
                                                                    <td><a href="invoice?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $encode_user_id;?>"
                                                                            style="background-color:#532A1A;color:white;"
                                                                            class="btn btn__bg">Download</a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                              }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade" id="return" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h3>Downloads</h3>
                                                    <div class="myaccount-table table-responsive text-center">
                                                        <table class="table table-bordered">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Order ID</th>
                                                                    <th>Product Name</th>
                                                                    <th>Quantity</th>
                                                                    <th>Date</th>
                                                                    <th>Request Sent?</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                include"connect.php";
                                                                $cmd41="select * from return_request where user_id='$id'";
                                                                  $result41=mysqli_query($con,$cmd41) or die(mysqli_error($con));
                                                                  while($row41=mysqli_fetch_array($result41))
                                                                  {    
                                                                      $order_id = $row41['order_id'];
                                                                      $product_id=$row41['product_id'];
                                                                      $date_time=$row41['date_time'];
                                                                $cmd42="select * from products where id='$product_id'";
                                                                  $result42=mysqli_query($con,$cmd42) or die(mysqli_error($con));
                                                                  while($row42=mysqli_fetch_array($result42))
                                                                  {    
                                                                      $product_name = $row42['pname'];
                                                                $cmd43="select * from order_items where product_id='$product_id' and user_id='$id' and order_id='$order_id'";
                                                                  $result43=mysqli_query($con,$cmd43) or die(mysqli_error($con));
                                                                  while($row43=mysqli_fetch_array($result43))
                                                                  {    
                                                                      $quantity=$row43['quantity'];      
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $order_id;?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $product_name;?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $quantity;?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $date_time;?>
                                                                    </td>
                                                                    <td>YES</td>
                                                                </tr>
                                                                <?php
                                                                }
                                                                  }
                                                                  }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <!--<div class="tab-pane fade" id="download" role="tabpanel">-->
                                            <!--    <div class="myaccount-content">-->
                                            <!--        <h3>Downloads</h3>-->
                                            <!--        <div class="myaccount-table table-responsive text-center">-->
                                            <!--            <table class="table table-bordered">-->
                                            <!--                <thead class="thead-light">-->
                                            <!--                    <tr>-->
                                            <!--                        <th>Product</th>-->
                                            <!--                        <th>Date</th>-->
                                            <!--                        <th>Expire</th>-->
                                            <!--                        <th>Download</th>-->
                                            <!--                    </tr>-->
                                            <!--                </thead>-->
                                            <!--                <tbody>-->
                                            <!--                    <tr>-->
                                            <!--                        <td>Haven - Free Real Estate PSD Template</td>-->
                                            <!--                        <td>Aug 22, 2018</td>-->
                                            <!--                        <td>Yes</td>-->
                                            <!--                        <td><a href="#" style="background-color:#532A1A;color:white;" class="btn btn__bg"><i-->
                                            <!--                            class="fa fa-cloud-download"></i>-->
                                            <!--                                Download File</a></td>-->
                                            <!--                    </tr>-->
                                            <!--                    <tr>-->
                                            <!--                        <td>HasTech - Profolio Business Template</td>-->
                                            <!--                        <td>Sep 12, 2018</td>-->
                                            <!--                        <td>Never</td>-->
                                            <!--                        <td><a style="background-color:#532A1A;color:white;" href="#" class="btn btn__bg"><i-->
                                            <!--                            class="fa fa-cloud-download"></i>-->
                                            <!--                                Download File</a></td>-->
                                            <!--                    </tr>-->
                                            <!--                </tbody>-->
                                            <!--            </table>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <!--<div class="tab-pane fade" id="payment-method" role="tabpanel">-->
                                            <!--    <div class="myaccount-content">-->
                                            <!--        <h3>Payment Method</h3>-->
                                            <!--        <p class="saved-message">You Can't Saved Your Payment Method yet.</p>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h3>Billing Address</h3>
                                                    <address>
                                                        <p><strong>
                                                                <?php echo$firstname.' '.$lastname;?>
                                                            </strong></p><br />
                                                        <form id="MyForm" method="post">
                                                            <input type="hidden" id="id" name="id"
                                                                value="<?php echo$id;?>">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="First Name">Addressline1<span
                                                                                style="color:red">*</span></label><br>
                                                                        <input type="text"
                                                                            class="form-control input-custom input-full"
                                                                            id="addressline1" name="addressline1"
                                                                            value="<?php echo $addressline1;?>"
                                                                            placeholder="First Name">
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="Last Name">Addressline2<span
                                                                                style="color:red">*</span></label><br>
                                                                        <input type="text"
                                                                            class="form-control input-custom input-full"
                                                                            id="addressline2" name="addressline2"
                                                                            value="<?php echo $addressline2;?>"
                                                                            placeholder="Last Name">
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Email">Pincode<span
                                                                        style="color:red">*</span></label><br>
                                                                <input type="text"
                                                                    class="form-control input-custom input-full"
                                                                    id="pincode" name="pincode"
                                                                    value="<?php echo$pincode;?>" placeholder="Email">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Email">Country<span
                                                                        style="color:red">*</span></label><br>
                                                                <input type="text"
                                                                    class="form-control input-custom input-full"
                                                                    id="country" name="country"
                                                                    value="<?php echo$country;?>"
                                                                    placeholder="Date Of Birth">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Email">State<span
                                                                        style="color:red">*</span></label><br>
                                                                <input type="text"
                                                                    class="form-control input-custom input-full"
                                                                    id="state" name="state" value="<?php echo$state;?>"
                                                                    placeholder="Mobile Number">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Email">City<span
                                                                        style="color:red">*</span></label><br>
                                                                <input type="text"
                                                                    class="form-control input-custom input-full"
                                                                    id="city" name="city" value="<?php echo$city;?>"
                                                                    placeholder="No file Choosen">
                                                            </div>


                                                            <div class="single-input-item">
                                                                <button style="background-color:#532A1A;color:white;"
                                                                    name="submit" id="submit" type="submit"
                                                                    class="btn btn__bg">Save Changes</button>
                                                            </div>
                                                        </form>
                                                        <div id="return"></div>
                                                    </address>

                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!--    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
                                            <!--  <div class="modal-dialog" role="document">-->
                                            <!--    <div class="modal-content">-->
                                            <!--      <div class="modal-header">-->
                                            <!--        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                                            <!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                                            <!--          <span aria-hidden="true">&times;</span>-->
                                            <!--        </button>-->
                                            <!--      </div>-->
                                            <!--      <div class="modal-body">-->
                                            <!--        ...-->
                                            <!--      </div>-->
                                            <!--      <div class="modal-footer">-->
                                            <!--        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                                            <!--        <button type="button" class="btn btn-primary">Save changes</button>-->
                                            <!--      </div>-->
                                            <!--    </div>-->
                                            <!--  </div>-->
                                            <!--</div>-->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade" id="account-info" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h3>Account Details</h3><br />
                                                    <div class="account-details-form">
                                                        <form id="MyForm1" method="post">
                                                            <input type="hidden" id="id" name="id"
                                                                value="<?php echo$id;?>">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="First Name">First Name<span
                                                                                style="color:red">*</span></label><br>
                                                                        <input type="text"
                                                                            class="form-control input-custom input-full"
                                                                            id="firstname" name="firstname"
                                                                            value="<?php echo$firstname?>"
                                                                            placeholder="First Name">
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="Last Name">Last Name<span
                                                                                style="color:red">*</span></label><br>
                                                                        <input type="text"
                                                                            class="form-control input-custom input-full"
                                                                            id="lastname" name="lastname"
                                                                            value="<?php echo$lastname?>"
                                                                            placeholder="Last Name">
                                                                    </div>

                                                                </div>
                                                            </div>



                                                            <div class="form-group">
                                                                <label for="Email">Date Of Birth<span
                                                                        style="color:red">*</span></label><br>
                                                                <input type="date"
                                                                    class="form-control input-custom input-full"
                                                                    id="dob" value="<?php echo$dob;?>" name="dob"
                                                                    placeholder="Date Of Birth">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Email">Mobile Number<span
                                                                        style="color:red">*</span></label><br>
                                                                <input type="text"
                                                                    class="form-control input-custom input-full"
                                                                    id="phone" value="<?php echo$phone;?>" name="phone"
                                                                    placeholder="Mobile Number">
                                                            </div>
                                                            <!--<div class="form-group">-->
                                                            <!--   <label for="Email">Image<span style="color:red">*</span></label><br>-->
                                                            <!--    <input type="file" class="form-control input-custom input-full" id="img" name="img"  placeholder="No file Choosen">-->
                                                            <!--</div>-->


                                                            <div class="single-input-item">
                                                                <button style="background-color:#532A1A;color:white;"
                                                                    name="a_submit" id="a_submit" type="submit"
                                                                    class="btn btn__bg">Save Changes</button>
                                                            </div>
                                                        </form>
                                                        <div id="return1"></div>
                                                    </div>
                                                </div>
                                            </div> <!-- Single Tab Content End -->

                                            <!--Single Tab Content Start-->
                                            <div class="tab-pane fade" id="password-edit" role="tabpanel">
                                                <form id="MyForm2" method="post">
                                                    <input type="hidden" id="id" name="id" value="<?php echo$id;?>">
                                                    <fieldset>
                                                        <legend>Password change</legend><br />
                                                        <div class="form-group">
                                                            <label for="Current Password">Current Password<span
                                                                    style="color:red">*</span></label><br>
                                                            <input type="text"
                                                                class="form-control input-custom input-full"
                                                                name="oldpassword" placeholder="Current Password">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="New Password">New Password<span
                                                                            style="color:red">*</span></label><br>
                                                                    <input type="password"
                                                                        class="form-control input-custom input-full"
                                                                        id="newpassword" name="newpassword"
                                                                        placeholder="New Password">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="Confirm Password">Confirm Password<span
                                                                            style="color:red">*</span></label><br>
                                                                    <input type="password"
                                                                        class="form-control input-custom input-full"
                                                                        id="confirmpassword" name="confirmpassword"
                                                                        placeholder="Confirm Password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="CheckPasswordMatch"></div>
                                                    </fieldset>
                                                    <div class="single-input-item">
                                                        <button style="background-color:#532A1A;color:white;"
                                                            name="c_submit" id="c_submit" type="submit"
                                                            class="btn btn__bg">Save Changes</button>
                                                    </div>
                                                </form>
                                                <div id="return2"></div>
                                            </div>
                                            <!--Single Tab Content End-->

                                        </div>
                                    </div> <!-- My Account Tab Content End -->
                                </div>
                            </div> <!-- My Account Page End -->
                        </div>
                    </div>
                </div>
            </div>
        </div><br /><br />
        <?php
 }
 else{
     ?>
        <center>
            <div class="bf-guest">
                <div class="bf-guest-icon"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                <h3 class="bf-guest-title">Login to View Your Profile</h3>
                <p class="bf-guest-text">Hello! Please login or create your Bosk Furniture account to view and manage your profile, orders &amp; details.</p>
                <a href="login" class="bf-guest-btn"><i class="fa fa-sign-in" aria-hidden="true"></i> Login / Register</a>
            </div>
        </center>
        <style>
            .bf-guest{max-width:480px;margin:0 auto;padding:42px 18px 70px;}
            .bf-guest-icon{width:90px;height:90px;border-radius:50%;margin:0 auto 22px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3e9e2,#e7d5c7);color:#532A1A;font-size:38px;box-shadow:0 10px 26px rgba(83,42,26,.18);}
            .bf-guest-title{font-size:23px;font-weight:700;color:#2b1d14;margin:0 0 10px;font-family:'Montserrat',sans-serif;}
            .bf-guest-text{color:#8a7d75;font-size:14.5px;line-height:1.65;margin:0 0 26px;}
            .bf-guest-btn{display:inline-flex;align-items:center;gap:10px;padding:15px 42px;border-radius:50px;background:linear-gradient(135deg,#532A1A 0%,#7a4128 55%,#b8763f 130%);color:#fff !important;font-weight:600;font-size:15px;letter-spacing:.3px;text-decoration:none;box-shadow:0 12px 26px rgba(83,42,26,.30);transition:transform .18s ease,box-shadow .18s ease,filter .18s ease;}
            .bf-guest-btn:hover{transform:translateY(-2px);box-shadow:0 18px 34px rgba(83,42,26,.40);filter:brightness(1.06);color:#fff !important;}
            .bf-guest-btn:active{transform:translateY(0);}
            @media(max-width:480px){.bf-guest{padding:30px 16px 54px;}.bf-guest-title{font-size:19px;}.bf-guest-btn{padding:13px 32px;font-size:14.5px;}.bf-guest-icon{width:78px;height:78px;font-size:32px;}}
        </style>
        <?php
 }
        ?>
        <!-- my account wrapper end -->

        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mmenu.min.js"></script>
        <script src="js/mmenu.js"></script>
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/lightcase.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/inner-script.js"></script>
        <script>
            $(window).on('scroll load', function () {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>
        <script>
            $(document).ready(function () {
                $('.myaccount-tab-menu a').on('click', function (e) {
                    e.preventDefault();
                    var targetTab = $(this).attr("href");

                    // Check if the clicked tab is not the currently active one
                    if (!$(this).hasClass("active")) {
                        // Deactivate the currently active tab
                        $('.myaccount-tab-menu a.active').removeClass("active");
                        $('.tab-pane.active').removeClass("show active");

                        // Activate the newly clicked tab
                        $(this).addClass("active");
                        $(targetTab).addClass("show active");
                    }
                });
            });
        </script>
        <script src="js/add/profile.js"></script>
        <script src="js/add/account.js"></script>
        <script src="js/add/change_password.js"></script>
        <script src="toastr/toastr.min.js"></script>
        <!--<script src="js/vendor.js"></script>-->
        <!--<script src="js/active.js"></script>-->
        <script>
            $(document).ready(function () {
                $("#confirmpassword").on('keyup', function () {
                    var password = $("#newpassword").val();
                    var confirmPassword = $("#confirmpassword").val();
                    if (password != confirmPassword)
                        $("#CheckPasswordMatch").html("Password does not match !").css("color", "red");
                    else
                        $("#CheckPasswordMatch").html("Password match !").css("color", "green");
                });
            });
        </script>

    </div>
    <!-- Wrapper / End -->
</body>

</html>
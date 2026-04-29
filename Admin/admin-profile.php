<?php
session_start();
if (isset($_SESSION['email'])) {
include"connect.php";
$cmd="select * from admin";
                   
$result=mysqli_query($con,$cmd) or die(mysqli_error($con));
$row=mysqli_fetch_array($result);              
$id = $row['id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$dob=$row['dob'];
$email=$row['email'];
$img=$row['img'];
$phone=$row['phone'];
?>   
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/admin-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:35 GMT -->
<head>
    <?php include_once"design/header.php"?>
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        
        <?php include_once"design/sidebar.php"?>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            <?php include_once"design/nav.php"?>
            
            
            <!-- Body: Body -->
            <center>
            <div class="body d-flex py-3">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Admin Profile</h3>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3">
                        
                        <div class="col-xl-4 col-lg-5 col-md-12">
                            <div class="card profile-card flex-column mb-3">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Profile</h6>
                                </div>
                                <div class="card-body d-flex profile-fulldeatil flex-column">
                                    <div class="profile-block text-center w220 mx-auto">
                                        <a href="#">
                                            <img src="assets/images/lg/avatar4.svg" alt="" class="avatar xl rounded img-thumbnail shadow-sm">
                                        </a>
                                        <!--<button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>-->
                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                            <span class="text-muted small">Admin ID : <?php echo $id;?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info w-100">
                                        <h6  class="mb-0 mt-2  fw-bold d-block fs-6 text-center"><?php echo $firstname.$lastname;?></h6>
                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">Dob: <?php echo $dob;?></span>
                                        
                                        <div class="row g-2 pt-2">
                                            <div class="col-xl-12">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-ui-touch-phone"></i>
                                                    <span  class="ms-10"><?php echo$phone;?></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-email"></i>
                                                    <span class="ms-2"><?php echo$email;?></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="d-flex align-items-center">
                                                    <i class="icofont-birthday-cake"></i>
                                                    <span class="ms-2"><?php echo$dob;?></span>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                          
                        </div>
                        
                    </div>
                </div>
            </div>
        </center>
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

            <!-- Edit Password-->
            <div class="modal fade" id="authchange" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Edit Authentication</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="deadline-form">
                            <form>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label for="item1" class="form-label">User Name</label>
                                        <input type="text" class="form-control" id="item1" value="Adrian007"> 
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="taxtno111" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="taxtno111" value="abcxyzabc">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="taxtno11" class="form-label">Conform Password</label>
                                        <input type="text" class="form-control" id="taxtno11">
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

            <!-- Edit profile-->
            <div class="modal fade" id="editprofile" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel1111"> Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="deadline-form">
                            <form>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-12">
                                        <label for="item100" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo$firstname;?>"> 
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="taxtno200" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo$lname;?>">
                                    </div>
                                </div>
                                
                                <div class="row g-3 mb-3">
                                
                                <div class="col-sm-6">
                                    <label for="abc1" class="form-label">Birthday date</label>
                                    <input type="date" class="form-control w-100" id="dob" name="dob" value="<?php echo$dob;?>">
                                </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                    <label for="mailid" class="form-label">Mail</label>
                                    <input type="text" class="form-control" id="mailid" value="<?php echo$email;?>" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="phoneid" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo$phone;?>">
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
        </div>  
    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="js/updateprofile.js"></script>
    <!-- Jquery Page Js -->
    <script src="javascript/template.js"></script>
 </body>

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/admin-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:35 GMT -->
</html> 
<?php 
}
else{
     header("Location: index.php");
    exit();
}
?>
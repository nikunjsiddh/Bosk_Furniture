<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:50 GMT -->
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
                                <h3 class="fw-bold py-3 mb-0">Contact</h3>
                                <div class="d-flex py-2 project-tab flex-wrap w-sm-100">
                                    <ul class="nav nav-tabs tab-body-header rounded ms-3 prtab-set w-sm-100" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#list-view" role="tab">List View</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#grid-view" role="tab">Grid View</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="list-view">
                            <div class="row clearfix g-3">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                            <h6 class="mb-0 fw-bold ">Contact Add</h6>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-sm-12">
                                                    <label for="fileimg" class="form-label">Contact Image</label>
                                                    <input type="File" class="form-control" id="fileimg">
                                                    </div>
                                                    <div class="col-sm-12">
                                                    <label for="depone" class="form-label">Person Name</label>
                                                    <input type="text" class="form-control" id="depone">
                                                    </div>
                                                    <div class="col-sm-12">
                                                    <label for="abc" class="form-label">Birthdate</label>
                                                    <input type="date" class="form-control" id="abc">
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-sm-12">
                                                        <label for="deptwo" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="deptwo">
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <label for="deptwophone" class="form-label">Phone</label>
                                                        <input type="text" class="form-control" id="deptwophone">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Contact</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Person Name</th> 
                                                        <th>Birthdate</th>
                                                        <th>Email</th> 
                                                        <th>Phone</th>   
                                                        <th>Actions</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td>
                                                        <img class="avatar rounded-circle" src="assets/images/xs/avatar1.svg" alt="">
                                                        <span class="fw-bold ms-1">Joan Dyer</span>
                                                    </td>
                                                    <td>
                                                            12/03/2021
                                                    </td>
                                                    <td>JoanDyer@gmail.com</td>
                                                    <td>518-555-0145</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                                <button type="button" class="btn btn-outline-secondary"  data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit text-success"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar2.svg" alt="">
                                                            <span class="fw-bold ms-1">Ryan	Randall</span>
                                                        </td>
                                                        <td>
                                                            12/03/2021
                                                    </td>
                                                    <td>RyanRandall@gmail.com</td>
                                                    <td>617-555-0164</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit text-success"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td>
                                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar3.svg" alt="">
                                                            <span class="fw-bold ms-1">Phil	Glover</span>
                                                        </td>
                                                        <td>
                                                            16/03/2021
                                                    </td>
                                                    <td>PhilGlover@gmail.com</td>
                                                    <td>775-555-0117</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit text-success"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td>
                                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar4.svg" alt="">
                                                            <span class="fw-bold ms-1">Victor Rampling</span>
                                                        </td>
                                                        <td>
                                                            25/02/2021
                                                        </td>
                                                        <td>VictorRampling@gmail.com</td>
                                                        <td>512-555-0189</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit text-success"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td>
                                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar5.svg" alt="">
                                                            <span class="fw-bold ms-1">Sally Graham</span>
                                                        </td>
                                                        <td>
                                                            16/02/2021
                                                        </td>
                                                        <td>SallyGraham@gmail.com</td>
                                                        <td>303-555-0133</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit text-success"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td>
                                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar6.svg" alt="">
                                                            <span class="fw-bold ms-1">Robert Anderson</span>
                                                        </td>
                                                        <td>
                                                        18/01/2021
                                                        </td>
                                                        <td>RobertAnderson@gmail.com</td>
                                                        <td>402-555-0177</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit text-success"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Row End -->
                        </div>
                        <div class="tab-pane fade" id="grid-view">
                            <div class="row clearfix g-3">
                                <div class="col-lg-4">
                                    <div class="card sticky-lg-top">
                                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                            <h6 class="mb-0 fw-bold ">Contact Add</h6>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="row g-3 mb-3">
                                                <div class="col-sm-12">
                                                    <label for="fileimg" class="form-label">Contact Image</label>
                                                    <input type="File" class="form-control" id="fileimg">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="depone" class="form-label">Person Name</label>
                                                    <input type="text" class="form-control" id="depone">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="abc" class="form-label">Birthdate</label>
                                                    <input type="date" class="form-control" id="abc">
                                                </div>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-sm-12">
                                                        <label for="deptwo" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="deptwo">
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <label for="deptwophone" class="form-label">Phone</label>
                                                        <input type="text" class="form-control" id="deptwophone">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Contact</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row row-cols-sm-1 row-cols-md-2 row-col-lg-3 row-cols-xl-2 row-cols-xxl-3">
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar4.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#expedit"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar2.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar1.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar5.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar6.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar7.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar8.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card teacher-card mb-3 flex-column">
                                                <div class="card-body d-flex teacher-fulldeatil flex-column">
                                                    <div class="profile-teacher text-center w220 mx-auto">
                                                        <a href="#">
                                                            <img src="assets/images/lg/avatar9.svg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                                        </a>
                                                        <button class="btn btn-primary" style="position: absolute;top:15px;right: 15px;" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="icofont-edit"></i></button>
                                                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                                            <span class="text-muted small">Contact ID : Con-0001</span>
                                                        </div>
                                                    </div>
                                                    <div class="teacher-info   w-100">
                                                        <h6 class="mb-0 mt-2  fw-bold d-block fs-6 text-center">Adrian	Allan</h6>
                                                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted text-center mx-auto d-block">24 years, California</span>
                                                        <div class="row g-2 pt-2">
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-ui-touch-phone"></i>
                                                                    <span class="ms-2">202-555-0174 </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-email"></i>
                                                                    <span class="ms-2">adrianallan@gmail.com</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-birthday-cake"></i>
                                                                    <span class="ms-2">19/03/1980</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-address-book"></i>
                                                                    <span class="ms-2">775-555-0117</span>
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
                        </div>
                    </div>
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
            
            <!-- Modal Members-->
            <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="addUserLabel">Employee Invitation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="inviteby_email">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email address" id="exampleInputEmail1" aria-describedby="exampleInputEmail1">
                                <button class="btn btn-dark" type="button" id="button-addon2">Sent</button>
                            </div>
                        </div>
                        <div class="members_list">
                            <h6 class="fw-bold ">Employee </h6>
                            <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                <li class="list-group-item py-3 text-center text-md-start">
                                    <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                        <div class="no-thumbnail mb-2 mb-md-0">
                                            <img class="avatar lg rounded-circle" src="assets/images/xs/avatar2.html" alt="">
                                        </div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <h6 class="mb-0  fw-bold">Rachel Carr(you)</h6>
                                            <span class="text-muted">rachel.carr@gmail.com</span>
                                        </div>
                                        <div class="members-action">
                                            <span class="members-role ">Admin</span>
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icofont-ui-settings  fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 text-center text-md-start">
                                    <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                        <div class="no-thumbnail mb-2 mb-md-0">
                                            <img class="avatar lg rounded-circle" src="assets/images/xs/avatar3.html" alt="">
                                        </div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <h6 class="mb-0  fw-bold">Lucas Baker<a href="#" class="link-secondary ms-2">(Resend invitation)</a></h6>
                                            <span class="text-muted">lucas.baker@gmail.com</span>
                                        </div>
                                        <div class="members-action">
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Members
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                        <i class="icofont-check-circled"></i>
                                                            
                                                        <span>All operations permission</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li>
                                                            <a class="dropdown-item" href="#">
                                                            <i class="fs-6 p-2 me-1"></i>
                                                                <span>Only Invite & manage team</span>
                                                            </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icofont-ui-settings  fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="icofont-delete-alt fs-6 me-2"></i>Delete Member</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 text-center text-md-start">
                                    <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                        <div class="no-thumbnail mb-2 mb-md-0">
                                            <img class="avatar lg rounded-circle" src="assets/images/xs/avatar8.html" alt="">
                                        </div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <h6 class="mb-0  fw-bold">Una Coleman</h6>
                                            <span class="text-muted">una.coleman@gmail.com</span>
                                        </div>
                                        <div class="members-action">
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Members
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                        <i class="icofont-check-circled"></i>
                                                            
                                                        <span>All operations permission</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fs-6 p-2 me-1"></i>
                                                                <span>Only Invite & manage team</span>
                                                            </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icofont-ui-settings  fs-6"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-delete-alt fs-6 me-2"></i>Suspend member</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-not-allowed fs-6 me-2"></i>Delete Member</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Edit Contact-->
            <div class="modal fade" id="expedit" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Edit Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="item1" class="form-label">Person Name</label>
                            <input type="text" class="form-control" id="item1" value="Phil Glover"> 
                        </div>
                        <div class="deadline-form">
                            <form>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                    <label  class="form-label">Contact Image</label>
                                    <input type="file" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                    <label for="abc1" class="form-label">Birthdate</label>
                                    <input type="date" class="form-control" id="abc1" value="2021-03-12">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label for="deptwo1" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="deptwo1" value="PhilGlover@gmail.com">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control"  value="775-555-0117">
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

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:53 GMT -->
</html>
<?php 
}
else{
     header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/inventory-info.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:24 GMT -->
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
                                <h3 class="fw-bold mb-0">Stock Inventory List</h3>
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
                                                <th>Id</th>
                                                <th>Products</th>
                                                <th>Category</th>
                                                <th>Date Added</th>
                                                <th>Stock</th>
                                                <th>In Stock</th>
                                                <th>Color</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>#SKUN111</strong></td>
                                                <td><img src="assets/images/product/product-1.jpg" class="avatar lg rounded me-2" alt="profile-image"><span> Oculus VR </span></td>
                                                <td>Game accessories</td>
                                                <td>June 13, 2021</td>
                                                <td>1455</td>
                                                <td>
                                                    451
                                                </td>
                                                <td>Yellow</td>
                                                <td><span class="badge bg-warning">Offer process</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN112</strong></td>
                                                <td><img src="assets/images/product/product-2.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>Wall Clock</span></td>
                                                <td>Clock</td>
                                                <td>June 22, 2021</td>
                                                <td>5555</td>
                                                <td>
                                                    1451
                                                </td>
                                                <td>Gold</td>
                                                <td><span class="badge bg-success">Sell</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN113</strong></td>
                                                <td><img src="assets/images/product/product-3.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>Flower Port</span></td>
                                                <td>accessories</td>
                                                <td>June 16, 2021</td>
                                                <td>555</td>
                                                <td>
                                                    11
                                                </td>
                                                <td>Silver</td>
                                                <td><span class="badge bg-success">Sell</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN114</strong></td>
                                                <td><img src="assets/images/product/product-4.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>Flower Port</span></td>
                                                <td>Port Box</td>
                                                <td>June 23, 2021</td>
                                                <td>7581</td>
                                                <td>
                                                    2468
                                                </td>
                                                <td>Brown</td>
                                                <td><span class="badge bg-warning">Offer process</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN115</strong></td>
                                                <td><img src="assets/images/product/product-5.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>School Bag</span></td>
                                                <td>Bags</td>
                                                <td>June 18, 2021</td>
                                                <td>1581</td>
                                                <td>
                                                    1581
                                                </td>
                                                <td>Chocolate</td>
                                                <td><span class="badge bg-danger">Out of Stock</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN116</strong></td>
                                                <td><img src="assets/images/product/product-6.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>Rado Watch</span></td>
                                                <td>Watch</td>
                                                <td>June 13, 2021</td>
                                                <td>4581</td>
                                                <td>
                                                    3468
                                                </td>
                                                <td>Silver</td>
                                                <td><span class="badge bg-success">Sell</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN117</strong></td>
                                                <td><img src="assets/images/product/product-7.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>Wildcraft</span></td>
                                                <td>Traveling Bag</td>
                                                <td>June 17, 2021</td>
                                                <td>2581</td>
                                                <td>
                                                    2468
                                                </td>
                                                <td>Silver</td>
                                                <td><span class="badge bg-success">Sell</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>#SKUN118</strong></td>
                                                <td><img src="assets/images/product/product-8.jpg" class="avatar lg rounded me-2" alt="profile-image"><span>Chair</span></td>
                                                <td>Furniture</td>
                                                <td>June 17, 2021</td>
                                                <td>581</td>
                                                <td>
                                                    468
                                                </td>
                                                <td>Browen</td>
                                                <td><span class="badge bg-success">Sell</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
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

        </div> 

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>

    <!-- Plugin Js -->
    <script src="assets/bundles/dataTables.bundle.js"></script>  

    <!-- Jquery Page Js -->
    <script src="../js/template.js"></script>
    <script>
        $('#myDataTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
    </script>
</body>

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/inventory-info.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:24 GMT -->
</html> 
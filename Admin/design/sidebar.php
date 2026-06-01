<!-- sidebar -->
        <style>
            /* ===== Brand logo presentation (expanded sidebar) ===== */
            .sidebar .brand-icon{display:flex;align-items:center;justify-content:center;padding:0;margin-bottom:16px;}
            .sidebar .brand-icon .logo-icon{display:none;}
            .sidebar .brand-icon .logo-text{
                display:flex;align-items:center;justify-content:center;width:100%;
                background:linear-gradient(135deg,#ffffff 0%,#eef2f7 100%);
                border-radius:14px;padding:12px 16px;
                box-shadow:0 7px 20px rgba(0,0,0,.24), inset 0 1px 0 rgba(255,255,255,.85);
                transition:transform .25s ease, box-shadow .25s ease;
            }
            .sidebar .brand-icon:hover .logo-text{transform:translateY(-2px);box-shadow:0 12px 28px rgba(0,0,0,.34), inset 0 1px 0 rgba(255,255,255,.85);}
            .sidebar .brand-icon .logo-text img{width:100%;max-width:150px;height:auto;display:block;object-fit:contain;}

            /* ===== mini (collapsed) sidebar -> clean "B" monogram badge ===== */
            .sidebar.sidebar-mini .brand-icon{margin-bottom:8px;}
            .sidebar.sidebar-mini .brand-icon .logo-text{display:none !important;}
            .sidebar.sidebar-mini .brand-icon .logo-icon{
                display:flex !important;align-items:center;justify-content:center;
                width:46px;height:46px;border-radius:13px;
                background:linear-gradient(135deg,#ffffff 0%,#eef2f7 100%);
                box-shadow:0 6px 16px rgba(0,0,0,.26), inset 0 1px 0 rgba(255,255,255,.85);
                transition:transform .2s ease;
            }
            .sidebar.sidebar-mini .brand-icon:hover .logo-icon{transform:translateY(-2px);}
            .sidebar.sidebar-mini .brand-icon .brand-mono{
                font-family:Georgia,'Times New Roman',serif;font-weight:800;font-size:24px;
                line-height:1;color:#5a2d1c;
            }
        </style>
        <div class="sidebar px-4 py-4 py-md-4 me-0">
            <div class="d-flex flex-column h-100">
                <a href="Dash.php" class="mb-0 brand-icon" title="Bosk Furniture — Dashboard">
                    <span class="logo-icon"><span class="brand-mono">B</span></span>
                    <span class="logo-text"><img src="logo.png" alt="Bosk Furniture"></span>
                </a>
                <!-- Menu: main ul -->
                <ul class="menu-list flex-grow-1 mt-3">
                    <li><a class="m-link" href="Dash.php"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-product" href="#">
                            <i class="icofont-truck-loaded fs-5"></i> <span>Products</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="menu-product">
                                <li><a class="ms-link" href="product-add.php">Product Add</a></li>
                                <li><a class="ms-link" href="product-list.php">Product List</a></li>

                            </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-project" href="#">
                            <i class="icofont-truck-loaded fs-5"></i> <span>Projects</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="menu-project">
                                <li><a class="ms-link" href="project-add.php">Project Add</a></li>
                                <li><a class="ms-link" href="project-list.php">Project List</a></li>

                            </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#categories" href="#">
                            <i class="icofont-chart-flow fs-5"></i> <span>Categories</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="categories">
                                 <li><a class="ms-link" href="categories-add.php">Categories Add</a></li>
                                <li><a class="ms-link" href="categorie-list.php">Categories List</a></li>
                               
                               
                            </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-order" href="#">
                        <i class="icofont-notepad fs-5"></i> <span>Orders</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="menu-order">
                            <li><a class="ms-link" href="order-list.php">Orders List</a></li>
                            <li><a class="ms-link" href="order-invoices.php">Order Invoices</a></li>
                        </ul>
                    </li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#customers-info" href="#">
                        <i class="icofont-funky-man fs-5"></i> <span>Customers</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse" id="customers-info">
                            <li><a class="ms-link" href="customers.php">Customers List</a></li>
                           
                        </ul>
                    </li>
                    <!--<li class="collapsed">-->
                    <!--    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-sale" href="#">-->
                    <!--    <i class="icofont-sale-discount fs-5"></i> <span>Sales Promotion</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>-->
                        <!-- Menu: Sub menu ul -->
                    <!--    <ul class="sub-menu collapse" id="menu-sale">-->
                    <!--        <li><a class="ms-link" href="coupons-list.php">Coupons List</a></li>-->
                    <!--        <li><a class="ms-link" href="coupon-add.php">Coupons Add</a></li>-->
                    <!--        <li><a class="ms-link" href="coupon-edit.php">Coupons Edit</a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <!--<li class="collapsed">-->
                    <!--    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-inventory" href="#">-->
                    <!--    <i class="icofont-chart-histogram fs-5"></i> <span>Inventory</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>-->
                        <!-- Menu: Sub menu ul -->
                    <!--    <ul class="sub-menu collapse" id="menu-inventory">-->
                    <!--        <li><a class="ms-link" href="inventory-info.php">Stock List</a></li>-->
                    <!--        <li><a class="ms-link" href="purchase.php">Purchase</a></li>-->
                            <!--<li><a class="ms-link" href="supplier.php">Supplier</a></li>-->
                    <!--        <li><a class="ms-link" href="returns.php">Returns</a></li>-->
                            <!--<li><a class="ms-link" href="department.php">Department</a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                     <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-blog" href="#">
                            <i class="icofont-truck-loaded fs-5"></i> <span>Blog</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="menu-blog">
                                <li><a class="ms-link" href="blog-add.php">Blog Add</a></li>
                                <li><a class="ms-link" href="Blog-list.php">Blog List</a></li>

                            </ul>
                    </li>
                    <li><a class="m-link" href="Return_Request.php"><i class="icofont-home fs-5"></i> <span>Return Request</span></a></li>
                    <!--<li class="collapsed">-->
                    <!--    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-Componentsone" href="#"><i-->
                    <!--            class="icofont-ui-calculator"></i> <span>Accounts</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>-->
                        <!-- Menu: Sub menu ul -->
                    <!--    <ul class="sub-menu collapse" id="menu-Componentsone">-->
                    <!--        <li><a class="ms-link" href="invoices.php">Invoices </a></li>-->
                            <!--<li><a class="ms-link" href="expenses.php">Expenses </a></li>-->
                            <!--<li><a class="ms-link" href="salaryslip.php">Salary Slip </a></li>-->
                    <!--        <li><a class="ms-link" href="create-invoice.php">Create Invoice </a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <!--<li class="collapsed">-->
                    <!--    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#app" href="#">-->
                    <!--    <i class="icofont-code-alt fs-5"></i> <span>App</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>-->
                        <!-- Menu: Sub menu ul -->
                    <!--    <ul class="sub-menu collapse" id="app">-->
                    <!--        <li><a class="ms-link" href="calendar.php">Calandar</a></li>-->
                    <!--        <li><a class="ms-link" href="chat.php"> Chat App</a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <!--<li><a class="m-link" href="store-locator.php"><i class="icofont-focus fs-5"></i> <span>Store Locator</span></a></li>-->
                    <!--<li><a class="m-link" href="ui-elements/ui-alerts.php"><i class="icofont-paint fs-5"></i> <span>UI Components</span></a></li>-->
                    <!--<li class="collapsed">-->
                    <!--    <a class="m-link active" data-bs-toggle="collapse" data-bs-target="#page" href="#">-->
                    <!--    <i class="icofont-page fs-5"></i> <span>Other Pages</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>-->
                        <!-- Menu: Sub menu ul -->
                    <!--    <ul class="sub-menu collapse show" id="page">-->
                    <!--        <li><a class="ms-link active" href="admin-profile.php">Profile Page</a></li>-->
                    <!--        <li><a class="ms-link" href="purchase-plan.php">Price Plan Example</a></li>-->
                    <!--        <li><a class="ms-link" href="charts.php">Charts Example</a></li>-->
                    <!--        <li><a class="ms-link" href="table.php">Table Example</a></li>-->
                    <!--        <li><a class="ms-link" href="forms.php">Forms Example</a></li>-->
                    <!--        <li><a class="ms-link" href="icon.php">Icons</a></li>-->
                    <!--        <li><a class="ms-link" href="contact.php">Contact Us</a></li>-->
                    <!--        <li><a class="ms-link" href="todo-list.php">Todo List</a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                </ul>
                <!-- Menu: menu collepce btn -->
                <button type="button" class="btn btn-link sidebar-mini-btn text-light">
                    <span class="ms-2"><i class="icofont-bubble-right"></i></span>
                </button>
            </div>
        </div>  
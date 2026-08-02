<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

// -----------------------------------------------------------------------------
// POST HANDLERS: Update Status
// -----------------------------------------------------------------------------
$message = '';
$message_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'update_status') {
        $oid = (int)($_POST['order_id'] ?? 0);
        $status = mysqli_real_escape_string($con, $_POST['status'] ?? '');
        $allowed = ['pending','kyc_pending','confirmed','delivered','active','overdue','return_requested','returned','cancelled'];

        if ($oid && in_array($status, $allowed)) {
            $res = mysqli_query($con, "UPDATE rental_orders SET status = '$status' WHERE id = $oid");
            if ($res) {
                // If status is updated to active/delivered, update order items start/end dates
                if (in_array($status, ['delivered', 'active'])) {
                    $items_q = mysqli_query($con, "SELECT id, tenure_months FROM rental_order_items WHERE order_id = $oid");
                    while ($it = mysqli_fetch_assoc($items_q)) {
                        $it_id = (int)$it['id'];
                        $tenure = (int)$it['tenure_months'];
                        $start = date('Y-m-d');
                        $end = date('Y-m-d', strtotime("+{$tenure} months"));
                        mysqli_query($con, "UPDATE rental_order_items SET start_date = '$start', end_date = '$end' WHERE id = $it_id AND start_date IS NULL");
                    }
                }
                echo json_encode(['ok' => true, 'msg' => 'Order status updated to ' . ucfirst($status)]);
            } else {
                echo json_encode(['ok' => false, 'msg' => mysqli_error($con)]);
            }
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Invalid order or status.']);
        }
        exit;
    }
}

// -----------------------------------------------------------------------------
// LOAD DATA
// -----------------------------------------------------------------------------
$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';

$where_clause = '';
if ($filter) {
    $filter_clean = mysqli_real_escape_string($con, $filter);
    $where_clause = " WHERE o.status = '$filter_clean' ";
}

$orders = [];
$q = "
    SELECT o.*, u.firstname, u.lastname, u.phone, u.email,
           a.full_name, a.mobile, a.address_line, a.city, a.pincode
    FROM rental_orders o
    LEFT JOIN user u ON u.id = o.user_id
    LEFT JOIN delivery_addresses a ON a.id = o.address_id
    $where_clause
    ORDER BY o.id DESC
";
$res = mysqli_query($con, $q);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $oid = (int)$row['id'];
        // Fetch items
        $items = [];
        $iq = mysqli_query($con, "
            SELECT roi.*, p.pname product_name, p.img1 product_image
            FROM rental_order_items roi
            JOIN products p ON p.id = roi.product_id
            WHERE roi.order_id = $oid
        ");
        while ($item = mysqli_fetch_assoc($iq)) {
            $items[] = $item;
        }
        $row['items'] = $items;
        $orders[] = $row;
    }
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once"design/header.php"?>
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        #myDataTable thead th{
            text-transform:uppercase;font-size:11.5px;letter-spacing:.6px;
            color:#6c757d;font-weight:700;white-space:nowrap;border-bottom:2px solid #eef0f4;
        }
        #myDataTable tbody tr{transition:background .12s ease;}
        #myDataTable tbody tr:hover{background:#f7f9fc;}
        #myDataTable td{vertical-align:middle;}

        .order-badge {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .badge-pending { background: #fff8e1; color: #b36d00; border: 1px solid #ffd54f; }
        .badge-kyc_pending { background: #eef3ff; color: #3b6fe0; border: 1px solid #c7d2fe; }
        .badge-confirmed { background: #e6f7ee; color: #1aa260; border: 1px solid #a3d9b8; }
        .badge-active { background: #e6f7ee; color: #1aa260; border: 1px solid #a3d9b8; }
        .badge-delivered { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-overdue { background: #fdeef0; color: #c0392b; border: 1px solid #f5b7b1; }
        .badge-returned { background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; }
        .badge-cancelled { background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; }

        .items-list-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eef0f4;
        }
    </style>
</head>

<body>
    <div id="ebazar-layout" class="theme-blue">

        <?php include_once"design/sidebar.php"?>

        <div class="main px-lg-4 px-md-4">

            <?php include_once"design/nav.php"?>

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Header -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Rental Orders</h3>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="rent-orders.php" class="btn btn-sm btn-light border <?php echo !$filter ? 'active' : ''; ?>">All</a>
                                    <a href="rent-orders.php?filter=pending" class="btn btn-sm btn-light border <?php echo $filter === 'pending' ? 'active' : ''; ?>">Pending</a>
                                    <a href="rent-orders.php?filter=active" class="btn btn-sm btn-light border <?php echo $filter === 'active' ? 'active' : ''; ?>">Active</a>
                                    <a href="rent-orders.php?filter=overdue" class="btn btn-sm btn-light border <?php echo $filter === 'overdue' ? 'active' : ''; ?>">Overdue</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders table -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                                <div class="card-body">
                                    <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Order Reference</th>
                                                <th>Customer</th>
                                                <th>Monthly / Deposit</th>
                                                <th>Status</th>
                                                <th>Date Ordered</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $o): ?>
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold text-primary font-monospace"><?php echo htmlspecialchars($o['order_ref']); ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold"><?php echo htmlspecialchars(($o['firstname'] ?? '') . ' ' . ($o['lastname'] ?? '')); ?></div>
                                                        <small class="text-muted d-block"><?php echo htmlspecialchars($o['phone'] ?? ''); ?></small>
                                                    </td>
                                                    <td>
                                                        <div>Monthly: <b>&#8377;<?php echo number_format($o['total_monthly_rent']); ?></b></div>
                                                        <small class="text-muted">Deposit: &#8377;<?php echo number_format($o['total_deposit']); ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="order-badge badge-<?php echo $o['status']; ?>">
                                                            <?php echo str_replace('_', ' ', $o['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php echo date('d M Y h:i A', strtotime($o['created_at'])); ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-secondary btn-sm" onclick='openOrderModal(<?php echo json_encode($o); ?>)'>
                                                            <i class="icofont-eye"></i> View details
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- ORDER DETAILS MODAL -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalRef">Rental Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Status Update -->
                        <div class="col-md-12 bg-light p-3 rounded" style="border: 1px solid #eef0f4;">
                            <label class="form-label fw-bold">Update Order Status</label>
                            <div class="d-flex gap-2">
                                <select class="form-select" id="modalStatusSelect" style="max-width: 250px;">
                                    <option value="pending">Pending</option>
                                    <option value="kyc_pending">KYC Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="active">Active</option>
                                    <option value="overdue">Overdue</option>
                                    <option value="return_requested">Return Requested</option>
                                    <option value="returned">Returned</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button type="button" class="btn btn-primary" onclick="updateOrderStatus()">Update Status</button>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div class="col-md-6">
                            <h6 class="fw-bold border-bottom pb-2">Delivery Address</h6>
                            <div id="modalAddrName" class="fw-bold"></div>
                            <div id="modalAddrPhone"></div>
                            <div id="modalAddrText" class="text-muted small mt-1"></div>
                            <div id="modalAddrPincode" class="text-muted small"></div>
                        </div>

                        <!-- Delivery slot & notes -->
                        <div class="col-md-6">
                            <h6 class="fw-bold border-bottom pb-2">Preferences</h6>
                            <div>Delivery Slot: <b id="modalSlot">None</b></div>
                            <div class="mt-2 text-muted small">Notes: <span id="modalNotes">None</span></div>
                        </div>

                        <!-- Items List -->
                        <div class="col-md-12">
                            <h6 class="fw-bold border-bottom pb-2">Rented Items</h6>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Tenure</th>
                                            <th class="text-end">Rent/mo</th>
                                            <th class="text-end">Deposit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalItemsBody">
                                        <!-- JS populated -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/plugin/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugin/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>

    <script>
        var selectedOrderId = null;

        $(document).ready(function() {
            $('#myDataTable').DataTable({
                responsive: true
            });
        });

        function openOrderModal(o) {
            selectedOrderId = o.id;
            document.getElementById('modalRef').textContent = 'Rental Order — ' + o.order_ref;
            document.getElementById('modalStatusSelect').value = o.status;

            // Address details
            document.getElementById('modalAddrName').textContent = o.full_name || '';
            document.getElementById('modalAddrPhone').textContent = o.mobile || '';
            document.getElementById('modalAddrText').textContent = o.address_line || '';
            document.getElementById('modalAddrPincode').textContent = (o.city || '') + ' - ' + (o.pincode || '');

            // slot and notes
            document.getElementById('modalSlot').textContent = o.delivery_slot || 'No preference';
            document.getElementById('modalNotes').textContent = o.notes || 'None';

            // Items
            var tbody = document.getElementById('modalItemsBody');
            tbody.innerHTML = '';
            o.items.forEach(function(it) {
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center">
                            <img class="items-list-img me-3" src="product_image/${it.product_image}" alt="">
                            <div>
                                <h6 class="m-0 fw-bold">${it.product_name}</h6>
                                <small class="text-muted">Qty: ${it.qty}</small>
                                ${parseInt(it.protection_addon) === 1 ? '<span class="badge bg-success ms-1" style="font-size: 9px;">Protection Addon</span>' : ''}
                            </div>
                        </div>
                    </td>
                    <td><b>${it.tenure_months} Months</b></td>
                    <td class="text-end fw-bold">&#8377;${parseInt(it.monthly_rent).toLocaleString('en-IN')}</td>
                    <td class="text-end text-muted">&#8377;${parseInt(it.deposit).toLocaleString('en-IN')}</td>
                `;
                tbody.appendChild(tr);
            });

            var myModal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
            myModal.show();
        }

        function updateOrderStatus() {
            if (!selectedOrderId) return;
            var val = document.getElementById('modalStatusSelect').value;
            $.post('rent-orders.php', {
                action: 'update_status',
                order_id: selectedOrderId,
                status: val
            }, function(res) {
                if (res.ok) {
                    toastr.success(res.msg || 'Status updated!', 'Success');
                    setTimeout(function() { window.location.reload(); }, 1200);
                } else {
                    toastr.error(res.msg || 'Failed to update', 'Error');
                }
            }, 'json');
        }
    </script>
</body>

</html>

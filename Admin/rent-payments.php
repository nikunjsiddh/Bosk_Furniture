<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

// -----------------------------------------------------------------------------
// POST HANDLERS: Invoice / Deposit operations
// -----------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'pay_invoice') {
        $iid = (int)($_POST['invoice_id'] ?? 0);
        if ($iid) {
            $now = date('Y-m-d H:i:s');
            $res = mysqli_query($con, "UPDATE monthly_rent_invoices SET status = 'paid', paid_at = '$now' WHERE id = $iid");
            if ($res) {
                echo json_encode(['ok' => true, 'msg' => 'Invoice marked as Paid.']);
            } else {
                echo json_encode(['ok' => false, 'msg' => mysqli_error($con)]);
            }
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Invalid invoice.']);
        }
        exit;
    }

    if ($action === 'process_refund') {
        $rid = (int)($_POST['refund_id'] ?? 0);
        $damage = (int)($_POST['damage_charge'] ?? 0);
        $note = mysqli_real_escape_string($con, trim($_POST['admin_note'] ?? ''));

        if ($rid) {
            // Fetch gross deposit
            $gq = mysqli_query($con, "SELECT gross_deposit FROM deposit_refunds WHERE id = $rid LIMIT 1");
            if ($gq && $row = mysqli_fetch_assoc($gq)) {
                $gross = (int)$row['gross_deposit'];
                $net = max(0, $gross - $damage);
                $now = date('Y-m-d H:i:s');
                $q = "
                    UPDATE deposit_refunds
                    SET damage_charge = $damage,
                        net_refund = $net,
                        status = 'processed',
                        admin_note = " . ($note === '' ? "NULL" : "'$note'") . ",
                        processed_at = '$now'
                    WHERE id = $rid
                ";
                $res = mysqli_query($con, $q);
                if ($res) {
                    echo json_encode(['ok' => true, 'msg' => 'Deposit refund processed successfully.']);
                } else {
                    echo json_encode(['ok' => false, 'msg' => mysqli_error($con)]);
                }
            } else {
                echo json_encode(['ok' => false, 'msg' => 'Refund record not found.']);
            }
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Invalid refund ID.']);
        }
        exit;
    }
}

// -----------------------------------------------------------------------------
// LOAD DATA
// -----------------------------------------------------------------------------
// Load Invoices
$invoices = [];
$iq = "
    SELECT i.*, o.order_ref, u.firstname, u.lastname
    FROM monthly_rent_invoices i
    LEFT JOIN rental_orders o ON o.id = i.order_id
    LEFT JOIN user u ON u.id = o.user_id
    ORDER BY i.due_date ASC, i.id DESC
";
$ires = mysqli_query($con, $iq);
if ($ires) {
    while ($row = mysqli_fetch_assoc($ires)) {
        $invoices[] = $row;
    }
}

// Load Refunds
$refunds = [];
$rq = "
    SELECT r.*, o.order_ref, u.firstname, u.lastname
    FROM deposit_refunds r
    LEFT JOIN rental_orders o ON o.id = r.order_id
    LEFT JOIN user u ON u.id = r.user_id
    ORDER BY r.id DESC
";
$rres = mysqli_query($con, $rq);
if ($rres) {
    while ($row = mysqli_fetch_assoc($rres)) {
        $refunds[] = $row;
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
        .nav-tabs .nav-link.active {
            font-weight: 700;
            color: #3b6fe0;
            border-bottom: 3px solid #3b6fe0;
        }
        .status-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            text-transform: uppercase;
        }
        .badge-upcoming { background: #eef3ff; color: #3b6fe0; }
        .badge-due { background: #fff8e1; color: #b36d00; }
        .badge-paid { background: #e6f7ee; color: #1aa260; }
        .badge-overdue { background: #fdeef0; color: #c0392b; }
        .badge-pending { background: #fff8e1; color: #b36d00; }
        .badge-processed { background: #e6f7ee; color: #1aa260; }
        .badge-rejected { background: #fdeef0; color: #c0392b; }
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
                                <h3 class="fw-bold mb-0">Payments &amp; Refunds Manager</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation tabs -->
                    <ul class="nav nav-tabs mb-3" id="paymentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab" aria-controls="invoices" aria-selected="true">Monthly Invoices</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="refunds-tab" data-bs-toggle="tab" data-bs-target="#refunds" type="button" role="tab" aria-controls="refunds" aria-selected="false">Deposit Refunds</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="paymentTabsContent">
                        
                        <!-- TAB 1: INVOICES -->
                        <div class="tab-pane fade show active" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                                <div class="card-body">
                                    <table id="invoiceTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Order Reference</th>
                                                <th>Customer</th>
                                                <th>Month #</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($invoices as $i): ?>
                                                <tr>
                                                    <td><span class="fw-bold font-monospace"><?php echo htmlspecialchars($i['invoice_no']); ?></span></td>
                                                    <td><span class="fw-bold text-primary font-monospace"><?php echo htmlspecialchars($i['order_ref']); ?></span></td>
                                                    <td><?php echo htmlspecialchars(($i['firstname'] ?? '') . ' ' . ($i['lastname'] ?? '')); ?></td>
                                                    <td>Month <?php echo $i['period_month']; ?></td>
                                                    <td class="fw-bold">&#8377;<?php echo number_format($i['amount']); ?></td>
                                                    <td><?php echo date('d M Y', strtotime($i['due_date'])); ?></td>
                                                    <td>
                                                        <span class="status-badge badge-<?php echo $i['status']; ?>"><?php echo $i['status']; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if ($i['status'] !== 'paid'): ?>
                                                            <button class="btn btn-sm btn-success" onclick="markPaid(<?php echo $i['id']; ?>)">
                                                                <i class="icofont-check-circled"></i> Mark Paid
                                                            </button>
                                                        <?php else: ?>
                                                            <small class="text-muted">Paid: <?php echo date('d M Y', strtotime($i['paid_at'])); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: REFUNDS -->
                        <div class="tab-pane fade" id="refunds" role="tabpanel" aria-labelledby="refunds-tab">
                            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                                <div class="card-body">
                                    <table id="refundTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Refund ID</th>
                                                <th>Order Ref</th>
                                                <th>Customer</th>
                                                <th>Gross Deposit</th>
                                                <th>Damage Charges</th>
                                                <th>Net Refund</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($refunds as $r): ?>
                                                <tr>
                                                    <td>#<?php echo $r['id']; ?></td>
                                                    <td><span class="fw-bold text-primary font-monospace"><?php echo htmlspecialchars($r['order_ref']); ?></span></td>
                                                    <td><?php echo htmlspecialchars(($r['firstname'] ?? '') . ' ' . ($r['lastname'] ?? '')); ?></td>
                                                    <td>&#8377;<?php echo number_format($r['gross_deposit']); ?></td>
                                                    <td class="text-danger">&#8377;<?php echo number_format($r['damage_charge']); ?></td>
                                                    <td class="fw-bold text-success">&#8377;<?php echo number_format($r['net_refund']); ?></td>
                                                    <td>
                                                        <span class="status-badge badge-<?php echo $r['status']; ?>"><?php echo $r['status']; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if ($r['status'] === 'pending'): ?>
                                                            <button class="btn btn-sm btn-primary" onclick='openRefundModal(<?php echo json_encode($r); ?>)'>
                                                                <i class="icofont-recycle"></i> Process Refund
                                                            </button>
                                                        <?php else: ?>
                                                            <small class="text-muted">Processed: <?php echo date('d M Y', strtotime($r['processed_at'])); ?></small>
                                                        <?php endif; ?>
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

    <!-- REFUND PROCESSING MODAL -->
    <div class="modal fade" id="refundModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="refundModalTitle">Process Security Deposit Refund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Gross Deposit Paid (&#8377;)</label>
                            <input type="text" id="modalGrossDeposit" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Damage Charges Deducted (&#8377;)</label>
                            <input type="number" id="modalDamageCharge" class="form-control" value="0" min="0" oninput="recalcNetRefund()">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small text-muted">Net Refund Amount (&#8377;)</label>
                            <input type="text" id="modalNetRefund" class="form-control fw-bold text-success" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Admin Inspection Notes</label>
                            <textarea id="modalRefundNotes" class="form-control" rows="2" placeholder="e.g. Scratches on table top - deducted 500, rest refunded."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitRefund()">Process Refund</button>
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
        var selectedRefundId = null;

        $(document).ready(function() {
            $('#invoiceTable').DataTable({ responsive: true });
            $('#refundTable').DataTable({ responsive: true });
        });

        function markPaid(invoiceId) {
            if (confirm("Are you sure you want to mark this invoice as Paid?")) {
                $.post('rent-payments.php', {
                    action: 'pay_invoice',
                    invoice_id: invoiceId
                }, function(res) {
                    if (res.ok) {
                        toastr.success(res.msg, 'Success');
                        setTimeout(function() { window.location.reload(); }, 1000);
                    } else {
                        toastr.error(res.msg, 'Error');
                    }
                }, 'json');
            }
        }

        function openRefundModal(r) {
            selectedRefundId = r.id;
            document.getElementById('modalGrossDeposit').value = r.gross_deposit;
            document.getElementById('modalDamageCharge').value = 0;
            document.getElementById('modalNetRefund').value = r.gross_deposit;
            document.getElementById('modalRefundNotes').value = '';

            var myModal = new bootstrap.Modal(document.getElementById('refundModal'));
            myModal.show();
        }

        function recalcNetRefund() {
            var gross = parseInt(document.getElementById('modalGrossDeposit').value) || 0;
            var damage = parseInt(document.getElementById('modalDamageCharge').value) || 0;
            var net = Math.max(0, gross - damage);
            document.getElementById('modalNetRefund').value = net;
        }

        function submitRefund() {
            if (!selectedRefundId) return;
            var damage = parseInt(document.getElementById('modalDamageCharge').value) || 0;
            var note = document.getElementById('modalRefundNotes').value;

            $.post('rent-payments.php', {
                action: 'process_refund',
                refund_id: selectedRefundId,
                damage_charge: damage,
                admin_note: note
            }, function(res) {
                if (res.ok) {
                    toastr.success(res.msg, 'Success');
                    setTimeout(function() { window.location.reload(); }, 1000);
                } else {
                    toastr.error(res.msg, 'Error');
                }
            }, 'json');
        }
    </script>
</body>

</html>

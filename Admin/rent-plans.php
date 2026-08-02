<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

// -----------------------------------------------------------------------------
// POST HANDLERS (self-contained logic)
// -----------------------------------------------------------------------------
$message = '';
$message_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'toggle_rent') {
        $pid = (int)($_POST['product_id'] ?? 0);
        $val = (int)($_POST['available_for_rent'] ?? 0);
        $res = mysqli_query($con, "UPDATE products SET available_for_rent = $val WHERE id = $pid");
        if ($res) {
            echo json_encode(['ok' => true, 'msg' => 'Status updated successfully.']);
        } else {
            echo json_encode(['ok' => false, 'msg' => mysqli_error($con)]);
        }
        exit;
    }

    if ($action === 'save_plans') {
        $pid = (int)($_POST['product_id'] ?? 0);
        $badge_label = mysqli_real_escape_string($con, trim($_POST['badge_label'] ?? ''));

        // Update product metadata (rent availability & badge)
        $avail = isset($_POST['available_for_rent']) ? 1 : 0;
        mysqli_query($con, "UPDATE products SET available_for_rent = $avail, badge_label = " . ($badge_label === '' ? "NULL" : "'$badge_label'") . " WHERE id = $pid");

        // Tenures to process: 3, 6, 12 months
        $tenures = [3, 6, 12];
        $success = true;

        foreach ($tenures as $t) {
            $plan_enabled = isset($_POST["plan_enable_$t"]) ? 1 : 0;
            $monthly = (int)($_POST["plan_monthly_$t"] ?? 0);
            $deposit = (int)($_POST["plan_deposit_$t"] ?? 0);
            $save    = mysqli_real_escape_string($con, trim($_POST["plan_save_$t"] ?? ''));

            // Check if plan exists
            $chk = mysqli_query($con, "SELECT id FROM rental_plans WHERE product_id = $pid AND tenure_months = $t LIMIT 1");
            if ($chk && mysqli_num_rows($chk) > 0) {
                $plan_id = (int)mysqli_fetch_row($chk)[0];
                if ($plan_enabled) {
                    $q = "UPDATE rental_plans SET monthly_rent = $monthly, deposit = $deposit, save_label = " . ($save === '' ? "NULL" : "'$save'") . ", is_active = 1 WHERE id = $plan_id";
                } else {
                    $q = "UPDATE rental_plans SET is_active = 0 WHERE id = $plan_id";
                }
            } else {
                if ($plan_enabled) {
                    $q = "INSERT INTO rental_plans (product_id, tenure_months, monthly_rent, deposit, save_label, is_active) VALUES ($pid, $t, $monthly, $deposit, " . ($save === '' ? "NULL" : "'$save'") . ", 1)";
                } else {
                    continue;
                }
            }
            if (!mysqli_query($con, $q)) {
                $success = false;
            }
        }

        if ($success) {
            $message = "Rental plans updated successfully for Product ID: $pid.";
            $message_type = 'success';
        } else {
            $message = "Error updating rental plans: " . mysqli_error($con);
            $message_type = 'danger';
        }
    }
}

// -----------------------------------------------------------------------------
// LOAD DATA
// -----------------------------------------------------------------------------
// Get products
$products = [];
$res = mysqli_query($con, "SELECT id, pname, pcategory, new_price, img1, available_for_rent, badge_label FROM products ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($res)) {
    $pid = (int)$row['id'];
    // Fetch active/all plans for this product
    $plans_res = mysqli_query($con, "SELECT * FROM rental_plans WHERE product_id = $pid");
    $plans = [];
    while ($p_row = mysqli_fetch_assoc($plans_res)) {
        $plans[(int)$p_row['tenure_months']] = $p_row;
    }
    $row['plans'] = $plans;
    $products[] = $row;
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once"design/header.php"?>
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        .stat-card{border:0;border-radius:14px;overflow:hidden;transition:transform .15s ease, box-shadow .15s ease;}
        .stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(0,0,0,.08);}
        .stat-icon{width:54px;height:54px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;}
        .stat-value{font-size:26px;font-weight:700;line-height:1;}
        .stat-label{font-size:13px;letter-spacing:.3px;}

        #myDataTable thead th{
            text-transform:uppercase;font-size:11.5px;letter-spacing:.6px;
            color:#6c757d;font-weight:700;white-space:nowrap;border-bottom:2px solid #eef0f4;
        }
        #myDataTable tbody tr{transition:background .12s ease;}
        #myDataTable tbody tr:hover{background:#f7f9fc;}
        #myDataTable td{vertical-align:middle;}

        .prod-thumb{
            width:62px;height:62px;object-fit:cover;border-radius:10px;
            border:1px solid #eef0f4;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.05);
        }
        .plan-badge {
            display: inline-block;
            background: #eef3ff;
            color: #3b6fe0;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            margin-right: 4px;
            margin-bottom: 4px;
        }
        .plan-badge.inactive {
            background: #f8f9fa;
            color: #bdc3c7;
            text-decoration: line-through;
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
                                <h3 class="fw-bold mb-0">Rental Plans Manager</h3>
                                <span class="text-muted small">Configure monthly tenures, security deposits & badge labels per product</span>
                            </div>
                        </div>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Products Table -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                                <div class="card-body">
                                    <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Base Price</th>
                                                <th>Available For Rent</th>
                                                <th>Active Plans (Rent / Deposit)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $p): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img class="prod-thumb me-3" src="product_image/<?php echo htmlspecialchars($p['img1']); ?>" alt="">
                                                            <div>
                                                                <h6 class="m-0 fw-bold"><?php echo htmlspecialchars($p['pname']); ?></h6>
                                                                <small class="text-muted">ID: #<?php echo $p['id']; ?></small>
                                                                <?php if ($p['badge_label']): ?>
                                                                    <span class="badge bg-warning text-dark ms-1" style="font-size:10px;"><?php echo htmlspecialchars($p['badge_label']); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($p['pcategory']); ?></td>
                                                    <td>&#8377;<?php echo number_format($p['new_price']); ?></td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input rent-switch" type="checkbox" data-id="<?php echo $p['id']; ?>" <?php echo $p['available_for_rent'] ? 'checked' : ''; ?>>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $has_plans = false;
                                                        foreach ([3, 6, 12] as $t) {
                                                            if (isset($p['plans'][$t])) {
                                                                $plan = $p['plans'][$t];
                                                                $cls = $plan['is_active'] ? '' : 'inactive';
                                                                echo "<span class='plan-badge $cls'>{$t}m: &#8377;{$plan['monthly_rent']}/&#8377;{$plan['deposit']}</span>";
                                                                if ($plan['is_active']) $has_plans = true;
                                                            }
                                                        }
                                                        if (!$has_plans) {
                                                            echo "<span class='text-muted small'>No active plans</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary btn-sm" onclick='openPlanModal(<?php echo json_encode($p); ?>)'>
                                                            <i class="icofont-edit"></i> Manage Plans
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

    <!-- PLANS MODAL -->
    <div class="modal fade" id="plansModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="post">
                    <input type="hidden" name="action" value="save_plans">
                    <input type="hidden" name="product_id" id="modal_product_id">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modal_title">Manage Rental Plans</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Available for Rent</label>
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" name="available_for_rent" id="modal_available_for_rent" value="1">
                                    <label class="form-check-label text-muted" for="modal_available_for_rent">Enable listing in Rent Catalogue</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Badge Label</label>
                                <input type="text" name="badge_label" id="modal_badge_label" class="form-control" placeholder="e.g. Popular, New, Save 20%">
                                <small class="text-muted">Displays as a sticker on the shop/rent cards</small>
                            </div>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-3 text-primary"><i class="icofont-calendar"></i> Rental Tenures Setup</h6>

                        <!-- Tenure Grid -->
                        <div class="row g-3">
                            <?php foreach ([3, 6, 12] as $t): ?>
                                <div class="col-md-4">
                                    <div class="card p-3" style="background:#fafbfc; border-radius:10px; border:1px solid #eef0f4;">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="plan_enable_<?php echo $t; ?>" id="enable_<?php echo $t; ?>" value="1" onchange="toggleTenureInputs(<?php echo $t; ?>)">
                                            <label class="form-check-label fw-bold text-dark" for="enable_<?php echo $t; ?>"><?php echo $t; ?> Months Plan</label>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small mb-1">Monthly Rent (&#8377;)</label>
                                            <input type="number" name="plan_monthly_<?php echo $t; ?>" id="monthly_<?php echo $t; ?>" class="form-control form-control-sm" required disabled min="0">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small mb-1">Security Deposit (&#8377;)</label>
                                            <input type="number" name="plan_deposit_<?php echo $t; ?>" id="deposit_<?php echo $t; ?>" class="form-control form-control-sm" required disabled min="0">
                                        </div>
                                        <div>
                                            <label class="form-label small mb-1">Save Label (Promo tag)</label>
                                            <input type="text" name="plan_save_<?php echo $t; ?>" id="save_<?php echo $t; ?>" class="form-control form-control-sm" placeholder="e.g. Save 20%" disabled>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
        $(document).ready(function() {
            $('#myDataTable').DataTable({
                responsive: true
            });

            // Handle ajax inline toggle switch
            $('.rent-switch').change(function() {
                var pid = $(this).data('id');
                var val = this.checked ? 1 : 0;
                $.post('rent-plans.php', {
                    action: 'toggle_rent',
                    product_id: pid,
                    available_for_rent: val
                }, function(res) {
                    if (res.ok) {
                        toastr.success(res.msg || 'Updated successfully!', 'Rental Status');
                    } else {
                        toastr.error(res.msg || 'Something went wrong', 'Error');
                    }
                }, 'json');
            });
        });

        function toggleTenureInputs(t) {
            var checked = document.getElementById('enable_' + t).checked;
            document.getElementById('monthly_' + t).disabled = !checked;
            document.getElementById('deposit_' + t).disabled = !checked;
            document.getElementById('save_' + t).disabled = !checked;
        }

        function openPlanModal(p) {
            document.getElementById('modal_product_id').value = p.id;
            document.getElementById('modal_title').textContent = 'Manage Rental Plans — ' + p.pname;
            document.getElementById('modal_available_for_rent').checked = parseInt(p.available_for_rent) === 1;
            document.getElementById('modal_badge_label').value = p.badge_label || '';

            // Setup the tenures
            var tenures = [3, 6, 12];
            tenures.forEach(function(t) {
                var plan = p.plans[t] || null;
                var hasPlan = plan && parseInt(plan.is_active) === 1;

                document.getElementById('enable_' + t).checked = hasPlan;
                document.getElementById('monthly_' + t).value = plan ? plan.monthly_rent : '';
                document.getElementById('deposit_' + t).value = plan ? plan.deposit : '';
                document.getElementById('save_' + t).value = plan ? plan.save_label : '';

                toggleTenureInputs(t);
            });

            var myModal = new bootstrap.Modal(document.getElementById('plansModal'));
            myModal.show();
        }
    </script>
</body>

</html>

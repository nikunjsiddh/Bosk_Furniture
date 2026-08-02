<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

// -----------------------------------------------------------------------------
// POST HANDLERS: Review Submission
// -----------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'review_kyc') {
        $kid = (int)($_POST['kyc_id'] ?? 0);
        $status = mysqli_real_escape_string($con, $_POST['status'] ?? '');
        $note = mysqli_real_escape_string($con, trim($_POST['admin_note'] ?? ''));

        if ($kid && in_array($status, ['approved', 'rejected'])) {
            $now = date('Y-m-d H:i:s');
            $q = "
                UPDATE kyc_verifications
                SET status = '$status',
                    admin_note = " . ($note === '' ? "NULL" : "'$note'") . ",
                    reviewed_at = '$now'
                WHERE id = $kid
            ";
            $res = mysqli_query($con, $q);
            if ($res) {
                // If KYC is approved, we can automatically update any associated 'kyc_pending' orders to 'confirmed'
                if ($status === 'approved') {
                    // Fetch user_id for this verification
                    $uq = mysqli_query($con, "SELECT user_id FROM kyc_verifications WHERE id = $kid LIMIT 1");
                    if ($uq && $row = mysqli_fetch_assoc($uq)) {
                        $uid = (int)$row['user_id'];
                        mysqli_query($con, "UPDATE rental_orders SET status = 'confirmed', kyc_id = $kid WHERE user_id = $uid AND status = 'kyc_pending'");
                    }
                }
                echo json_encode(['ok' => true, 'msg' => 'KYC status updated to ' . ucfirst($status)]);
            } else {
                echo json_encode(['ok' => false, 'msg' => mysqli_error($con)]);
            }
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Invalid KYC ID or status.']);
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
    $where_clause = " WHERE k.status = '$filter_clean' ";
}

$queue = [];
$q = "
    SELECT k.*, u.firstname, u.lastname, u.phone, u.email
    FROM kyc_verifications k
    LEFT JOIN user u ON u.id = k.user_id
    $where_clause
    ORDER BY k.status = 'pending' DESC, k.id DESC
";
$res = mysqli_query($con, $q);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $queue[] = $row;
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

        .kyc-badge {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .badge-pending { background: #fff8e1; color: #b36d00; border: 1px solid #ffd54f; }
        .badge-approved { background: #e6f7ee; color: #1aa260; border: 1px solid #a3d9b8; }
        .badge-rejected { background: #fdeef0; color: #c0392b; border: 1px solid #f5b7b1; }

        .doc-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eef0f4;
            cursor: pointer;
            transition: transform .15s ease;
        }
        .doc-thumb:hover { transform: scale(1.08); }
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
                                <h3 class="fw-bold mb-0">KYC Verification Queue</h3>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="kyc-queue.php" class="btn btn-sm btn-light border <?php echo !$filter ? 'active' : ''; ?>">All</a>
                                    <a href="kyc-queue.php?filter=pending" class="btn btn-sm btn-light border <?php echo $filter === 'pending' ? 'active' : ''; ?>">Pending</a>
                                    <a href="kyc-queue.php?filter=approved" class="btn btn-sm btn-light border <?php echo $filter === 'approved' ? 'active' : ''; ?>">Approved</a>
                                    <a href="kyc-queue.php?filter=rejected" class="btn btn-sm btn-light border <?php echo $filter === 'rejected' ? 'active' : ''; ?>">Rejected</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KYC list -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                                <div class="card-body">
                                    <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Doc Type</th>
                                                <th>Status</th>
                                                <th>Submitted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($queue as $k): ?>
                                                <tr>
                                                    <td>#<?php echo $k['id']; ?></td>
                                                    <td>
                                                        <div class="fw-bold"><?php echo htmlspecialchars(($k['firstname'] ?? '') . ' ' . ($k['lastname'] ?? '')); ?></div>
                                                        <small class="text-muted d-block"><?php echo htmlspecialchars($k['email'] ?? ''); ?> &middot; <?php echo htmlspecialchars($k['phone'] ?? ''); ?></small>
                                                    </td>
                                                    <td><span class="text-uppercase fw-bold"><?php echo htmlspecialchars($k['doc_type']); ?></span></td>
                                                    <td>
                                                        <span class="kyc-badge badge-<?php echo $k['status']; ?>">
                                                            <?php echo $k['status']; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php echo date('d M Y h:i A', strtotime($k['submitted_at'])); ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary btn-sm" onclick='openKycModal(<?php echo json_encode($k); ?>)'>
                                                            <i class="icofont-id-card"></i> Review Uploads
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

    <!-- KYC REVIEW MODAL -->
    <div class="modal fade" id="kycModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTitle">Review KYC Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Documents Preview -->
                        <div class="col-md-12">
                            <h6 class="fw-bold border-bottom pb-2">Uploaded Document Pictures</h6>
                            <div class="d-flex flex-wrap gap-4 justify-content-center py-2">
                                <div class="text-center">
                                    <div class="small fw-bold mb-1">Document Front</div>
                                    <a id="modalFrontLink" href="#" target="_blank">
                                        <img id="modalFrontImg" class="doc-thumb" style="width: 180px; height: 120px;" src="" alt="Doc Front">
                                    </a>
                                </div>
                                <div class="text-center">
                                    <div class="small fw-bold mb-1">Document Back</div>
                                    <a id="modalBackLink" href="#" target="_blank">
                                        <img id="modalBackImg" class="doc-thumb" style="width: 180px; height: 120px;" src="" alt="Doc Back">
                                    </a>
                                </div>
                                <div class="text-center">
                                    <div class="small fw-bold mb-1">Customer Selfie</div>
                                    <a id="modalSelfieLink" href="#" target="_blank">
                                        <img id="modalSelfieImg" class="doc-thumb" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;" src="" alt="Selfie">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Notes & Actions -->
                        <div class="col-md-12 bg-light p-3 rounded" style="border: 1px solid #eef0f4;">
                            <h6 class="fw-bold mb-2">Decision panel</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Rejection Reason / Approval Notes</label>
                                <textarea class="form-control" id="modalAdminNote" rows="2" placeholder="e.g. Pictures are blurry, please re-upload. Or: Checked & matches Aadhaar database."></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success px-4" onclick="saveKycStatus('approved')"><i class="icofont-check-circled me-1"></i> Approve KYC</button>
                                <button type="button" class="btn btn-danger px-4" onclick="saveKycStatus('rejected')"><i class="icofont-close-lineed me-1"></i> Reject KYC</button>
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
        var selectedKycId = null;

        $(document).ready(function() {
            $('#myDataTable').DataTable({
                responsive: true
            });
        });

        function openKycModal(k) {
            selectedKycId = k.id;
            document.getElementById('modalTitle').textContent = 'Review KYC — ' + (k.firstname || '') + ' ' + (k.lastname || '') + ' (' + k.doc_type.toUpperCase() + ')';
            document.getElementById('modalAdminNote').value = k.admin_note || '';

            // Image directories resolution
            var base = '../';
            var defaultImg = 'category_image/noimg.jpg';

            var doc_front = k.doc_front_file ? (k.doc_front_file.indexOf('/') === -1 ? base + 'return_request_image/' + k.doc_front_file : base + k.doc_front_file) : defaultImg;
            var doc_back  = k.doc_back_file  ? (k.doc_back_file.indexOf('/') === -1  ? base + 'return_request_image/' + k.doc_back_file  : base + k.doc_back_file)  : defaultImg;
            var selfie    = k.selfie_file    ? (k.selfie_file.indexOf('/') === -1    ? base + 'return_request_image/' + k.selfie_file    : base + k.selfie_file)    : defaultImg;

            document.getElementById('modalFrontImg').src = doc_front;
            document.getElementById('modalFrontLink').href = doc_front;
            document.getElementById('modalBackImg').src = doc_back;
            document.getElementById('modalBackLink').href = doc_back;
            document.getElementById('modalSelfieImg').src = selfie;
            document.getElementById('modalSelfieLink').href = selfie;

            var myModal = new bootstrap.Modal(document.getElementById('kycModal'));
            myModal.show();
        }

        function saveKycStatus(statusVal) {
            if (!selectedKycId) return;
            var note = document.getElementById('modalAdminNote').value;
            $.post('kyc-queue.php', {
                action: 'review_kyc',
                kyc_id: selectedKycId,
                status: statusVal,
                admin_note: note
            }, function(res) {
                if (res.ok) {
                    toastr.success(res.msg || 'KYC status updated!', 'Success');
                    setTimeout(function() { window.location.reload(); }, 1200);
                } else {
                    toastr.error(res.msg || 'Failed to update', 'Error');
                }
            }, 'json');
        }
    </script>
</body>

</html>

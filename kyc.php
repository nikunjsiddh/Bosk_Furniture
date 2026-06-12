<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'KYC Verification | Rent Furniture | Bosk Furniture';
$page_description = 'Complete a quick, one-time KYC for your furniture rental — upload ID & address proof securely. Encrypted, used only for verification.';
$page_canonical   = '/kyc';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'KYC', 'url' => '/kyc']
];
include_once "design/rent-data.php";
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once "design/header.php"; ?>
    <link rel="stylesheet" href="css/rental.css">
</head>

<body class="inner-page">
    <div id="wrapper">
        <?php include_once "design/nav.php"; ?>
        <div class="clearfix"></div>

        <div class="rent-scope">

            <section class="rent-section">
                <div class="rent-wrap">

                    <!-- flow progress: step 4 KYC -->
                    <?php rent_steps(4); ?>

                    <div class="rent-section-head" style="margin-top:18px;">
                        <span class="eyebrow">Step 4 · Verification</span>
                        <h2>Quick KYC</h2>
                        <p>Renting needs a one-time identity check. Your documents are encrypted and used only for
                            verification.</p>
                    </div>

                    <div class="rent-cols">

                        <!-- ===================== MAIN: details form ===================== -->
                        <div class="rent-panel">
                            <h3><i class="fa fa-user-circle-o"></i> Your details</h3>

                            <form action="rent-checkout.php" method="post" onsubmit="return false;">
                                <div class="kyc-grid">

                                    <div class="kyc-field">
                                        <label for="kycName">Full name</label>
                                        <input type="text" id="kycName" name="full_name"
                                            placeholder="As printed on your ID" autocomplete="name">
                                    </div>

                                    <div class="kyc-field">
                                        <label for="kycMobile">Mobile number</label>
                                        <input type="text" id="kycMobile" name="mobile"
                                            placeholder="10-digit mobile number" autocomplete="tel" inputmode="numeric"
                                            maxlength="10">
                                    </div>

                                    <div class="kyc-field">
                                        <label for="kycIdType">ID type</label>
                                        <select id="kycIdType" name="id_type">
                                            <option value="aadhaar">Aadhaar</option>
                                            <option value="pan">PAN</option>
                                            <option value="passport">Passport</option>
                                            <option value="dl">Driving License</option>
                                        </select>
                                    </div>

                                    <div class="kyc-field">
                                        <label for="kycIdNumber">ID number</label>
                                        <input type="text" id="kycIdNumber" name="id_number"
                                            placeholder="XXXX XXXX 1234" autocomplete="off">
                                    </div>

                                    <!-- ID proof dropzone -->
                                    <div class="kyc-drop" data-input="kycIdFile" id="kycIdDrop">
                                        <div class="ic"><i class="fa fa-id-card-o"></i></div>
                                        <b>Upload ID proof</b>
                                        <span>JPG/PNG/PDF · up to 5 MB</span>
                                        <input type="file" id="kycIdFile" name="id_proof"
                                            accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                                    </div>

                                    <!-- Address proof dropzone -->
                                    <div class="kyc-drop" data-input="kycAddrFile" id="kycAddrDrop">
                                        <div class="ic"><i class="fa fa-home"></i></div>
                                        <b>Upload address proof</b>
                                        <span>JPG/PNG/PDF · up to 5 MB</span>
                                        <input type="file" id="kycAddrFile" name="address_proof"
                                            accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                                    </div>

                                </div><!-- /.kyc-grid -->

                                <div class="kyc-secure">
                                    <i class="fa fa-lock"></i>
                                    <div>Documents are encrypted and stored securely — never shared. Full ID numbers are
                                        never stored in plain text.</div>
                                </div>

                                <div style="margin-top:20px;">
                                    <a class="rent-btn rent-btn-block" href="rent-checkout.php">Continue to Checkout <i
                                            class="fa fa-arrow-right"></i></a>
                                </div>
                            </form>
                        </div><!-- /.rent-panel -->

                        <!-- ===================== ASIDE: why KYC ===================== -->
                        <aside class="rent-aside">
                            <h3>Why KYC?</h3>

                            <div class="kyc-secure" style="margin-top:0;background:var(--rt-soft);">
                                <i class="fa fa-check"></i>
                                <div><b>Verified renters only</b> — a trusted community on both sides of every rental.</div>
                            </div>
                            <div class="kyc-secure" style="background:var(--rt-soft);">
                                <i class="fa fa-check"></i>
                                <div><b>Protects you &amp; us</b> — your refundable deposit and the furniture both stay safe.</div>
                            </div>
                            <div class="kyc-secure" style="background:var(--rt-soft);">
                                <i class="fa fa-check"></i>
                                <div><b>One-time only</b> — verify once and rent again later without re-uploading.</div>
                            </div>
                            <div class="kyc-secure" style="background:var(--rt-soft);">
                                <i class="fa fa-check"></i>
                                <div><b>Required by policy</b> — a standard part of every furniture rental agreement.</div>
                            </div>

                            <div class="rent-refund-note">
                                <i class="fa fa-shield"></i>
                                <div>Your data is encrypted end-to-end and used <b>only</b> for verification — never sold,
                                    never shared with third parties.</div>
                            </div>
                        </aside><!-- /.rent-aside -->

                    </div><!-- /.rent-cols -->

                </div><!-- /.rent-wrap -->
            </section>

        </div><!-- /.rent-scope -->

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* KYC dropzones: click a dropzone to open its hidden file input,
           then show the chosen filename inside the dropzone. */
        (function () {
            var drops = document.querySelectorAll('.kyc-drop');
            drops.forEach(function (drop) {
                var inputId = drop.getAttribute('data-input');
                var input = inputId ? document.getElementById(inputId) : null;
                if (!input) return;

                drop.addEventListener('click', function () {
                    input.click();
                });

                input.addEventListener('click', function (e) {
                    /* don't let the inner input bubble back up and re-open the picker */
                    e.stopPropagation();
                });

                input.addEventListener('change', function () {
                    if (!input.files || !input.files.length) return;
                    var name = input.files[0].name;
                    var b = drop.querySelector('b');
                    var span = drop.querySelector('span');
                    if (b) b.textContent = 'Selected: ' + name;
                    if (span) span.textContent = 'Click to choose a different file';
                    drop.style.borderColor = 'var(--rt-brand)';
                    drop.style.background = 'var(--rt-cream)';
                });
            });
        })();
    </script>
</body>

</html>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "design/rent-data.php";

$p = rent_find(isset($_GET['id']) ? (int)$_GET['id'] : 1);
if (!$p) {
    $p = $RENTAL_PRODUCTS[0];
}

/* default / active plan = last one (12 months, best value) */
$planCount   = count($p['plans']);
$defaultIdx  = $planCount - 1;
$defaultPlan = $p['plans'][$defaultIdx];

$page_title       = htmlspecialchars($p['name']) . ' on Rent | Bosk Furniture';
$page_description = 'Rent the ' . htmlspecialchars($p['name']) . ' on a flexible 3, 6 or 12-month plan. Pick your tenure, see the monthly rent & refundable deposit, free delivery and setup.';
$page_keywords    = strtolower($p['name']) . ' on rent, rent ' . strtolower($p['category']) . ' online, monthly furniture rental, bosk furniture rent';
$page_canonical   = '/rent-product?id=' . $p['id'];
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => $p['name'], 'url' => '/rent-product?id=' . $p['id']]
];
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

                    <!-- flow progress: step 2 (Plan) -->
                    <?php rent_steps(2); ?>

                    <!-- breadcrumb -->
                    <div style="font-size:13px;color:var(--rt-dim);margin:18px 0 22px;">
                        <a href="/" style="color:var(--rt-dim);text-decoration:none;">Home</a>
                        <span style="margin:0 7px;color:var(--rt-line);">&raquo;</span>
                        <a href="rent" style="color:var(--rt-dim);text-decoration:none;">Rent Furniture</a>
                        <span style="margin:0 7px;color:var(--rt-line);">&raquo;</span>
                        <span style="color:var(--rt-brand);font-weight:600;"><?php echo htmlspecialchars($p['name']); ?></span>
                    </div>

                    <!-- ===================== PRODUCT DETAIL ===================== -->
                    <div class="rent-pd">

                        <!-- LEFT: gallery -->
                        <div class="rent-pd-gallery">
                            <div class="main">
                                <img id="rpMain" src="<?php echo rent_img($p['gallery'][0]); ?>"
                                    alt="<?php echo htmlspecialchars($p['name']); ?> on rent">
                            </div>
                            <div class="rent-pd-thumbs">
                                <?php foreach ($p['gallery'] as $gi => $g): ?>
                                    <img src="<?php echo rent_img($g); ?>"
                                        class="<?php echo $gi === 0 ? 'active' : ''; ?>"
                                        alt="<?php echo htmlspecialchars($p['name']); ?> view <?php echo $gi + 1; ?>"
                                        onclick="rpSwap(this, '<?php echo rent_img($g); ?>')"<?php echo $gi === 0 ? '' : ' loading="lazy" decoding="async"'; ?>>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- RIGHT: info + plan selection -->
                        <div class="rent-pd-info">
                            <div class="rent-card-cat" style="margin-bottom:0;"><?php echo htmlspecialchars($p['category']); ?></div>
                            <h1><?php echo htmlspecialchars($p['name']); ?></h1>
                            <p class="lede"><?php echo htmlspecialchars($p['desc']); ?></p>

                            <?php if (!empty($p['combo_items'])): ?>
                                <ul class="rent-combo-items" style="margin-bottom:18px;">
                                    <?php foreach ($p['combo_items'] as $ci): ?>
                                        <li><?php echo htmlspecialchars($ci); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <div class="rent-card-meta" style="margin-bottom:18px;">
                                <?php if (!empty($p['eta'])): ?>
                                    <span class="rent-chip eta"><i class="fa fa-truck"></i> Delivery in <?php echo htmlspecialchars($p['eta']); ?> · <?php echo htmlspecialchars(rent_city()); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($p['badge'])): ?>
                                    <span class="rent-chip dep"><i class="fa fa-star"></i> <?php echo htmlspecialchars($p['badge']); ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- plan selector -->
                            <div class="rent-plans-head">
                                <i class="fa fa-calendar" style="color:var(--rt-accent);"></i> Choose your rental plan
                            </div>
                            <div class="rent-plans" id="rpPlans">
                                <?php foreach ($p['plans'] as $idx => $plan):
                                    $isDefault = ($idx === $defaultIdx);
                                ?>
                                    <label class="rent-plan<?php echo $isDefault ? ' selected' : ''; ?>"
                                        data-monthly="<?php echo (int)$plan['monthly']; ?>"
                                        data-deposit="<?php echo (int)$plan['deposit']; ?>"
                                        onclick="rpSelect(this)">
                                        <input type="radio" name="plan" value="<?php echo (int)$plan['tenure']; ?>"<?php echo $isDefault ? ' checked' : ''; ?>>
                                        <?php if (!empty($plan['save'])): ?>
                                            <span class="save"><?php echo htmlspecialchars($plan['save']); ?></span>
                                        <?php endif; ?>
                                        <div class="tenure"><?php echo (int)$plan['tenure']; ?> Months</div>
                                        <div class="mo"><?php echo rent_money($plan['monthly']); ?><small>/mo</small></div>
                                        <div class="dep">Deposit <?php echo rent_money($plan['deposit']); ?></div>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <!-- BOSK Shield damage-protection add-on -->
                            <div class="rent-addon" id="rpShield" onclick="rpShieldToggle()" style="margin-bottom:16px;">
                                <div class="ic"><i class="fa fa-shield"></i></div>
                                <div>
                                    <b>Add BOSK Shield damage protection</b>
                                    <span>Covers accidental damage, spills &amp; scratches beyond normal wear — no deductions from your deposit.</span>
                                </div>
                                <div class="price">+<span id="rpShieldAmt"><?php echo rent_money((int)round($defaultPlan['monthly'] * RENT_SHIELD_RATE)); ?></span>/mo</div>
                            </div>

                            <!-- summary box (reflects selected plan) -->
                            <div class="rent-summary-box">
                                <div class="rent-srow">
                                    <span class="k">Monthly rent</span>
                                    <span class="v" id="rpMonthly"><?php echo rent_money($defaultPlan['monthly']); ?></span>
                                </div>
                                <div class="rent-srow" id="rpShieldRow" style="display:none;">
                                    <span class="k">BOSK Shield (per month)</span>
                                    <span class="v" id="rpShieldLine">₹0</span>
                                </div>
                                <div class="rent-srow">
                                    <span class="k">Refundable deposit</span>
                                    <span class="v" id="rpDeposit"><?php echo rent_money($defaultPlan['deposit']); ?></span>
                                </div>
                                <div class="rent-srow total">
                                    <span class="k">Due at checkout (1st month + deposit)</span>
                                    <span class="v" id="rpTotal"><?php echo rent_money($defaultPlan['monthly'] + $defaultPlan['deposit']); ?></span>
                                </div>
                            </div>

                            <!-- refundable callout -->
                            <div class="rent-refund-note">
                                <i class="fa fa-shield"></i>
                                <div>The deposit is <b>fully refundable</b> when you return the piece at the end of your
                                    tenure, less any charges for damage beyond normal wear.</div>
                            </div>

                            <!-- actions -->
                            <div style="margin-top:22px;">
                                <a class="rent-btn rent-btn-block" href="rent-cart">
                                    Add to Rental Cart <i class="fa fa-arrow-right"></i>
                                </a>
                                <a class="rent-btn rent-btn-outline rent-btn-block" href="rent" style="margin-top:12px;">
                                    <i class="fa fa-angle-left"></i> Back to catalogue
                                </a>
                            </div>

                            <!-- quick reassurance chips -->
                            <div class="rent-card-meta" style="margin-top:18px;">
                                <span class="rent-chip"><i class="fa fa-truck"></i> Free delivery &amp; setup</span>
                                <span class="rent-chip"><i class="fa fa-refresh"></i> Return · extend · buy</span>
                                <span class="rent-chip"><i class="fa fa-wrench"></i> Free maintenance</span>
                            </div>
                        </div>

                    </div><!-- /.rent-pd -->

                </div>
            </section>

        </div><!-- /.rent-scope -->

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* swap the main gallery image when a thumbnail is clicked */
        function rpSwap(thumb, src) {
            var main = document.getElementById('rpMain');
            if (main) main.src = src;
            document.querySelectorAll('.rent-pd-thumbs img').forEach(function (t) {
                t.classList.remove('active');
            });
            thumb.classList.add('active');
        }

        /* format an integer to ₹ + thousands separator (matches rent_money) */
        function rpMoney(n) {
            return '₹' + Math.round(n).toLocaleString('en-IN');
        }

        /* current selection state (plan + shield add-on) */
        var rpShieldOn = false;
        var RP_SHIELD_RATE = <?php echo json_encode(RENT_SHIELD_RATE); ?>;

        function rpCurrentPlan() {
            return document.querySelector('#rpPlans .rent-plan.selected') ||
                document.querySelector('#rpPlans .rent-plan');
        }

        /* re-compute the summary box from the selected plan + shield state */
        function rpRefresh() {
            var plan = rpCurrentPlan();
            if (!plan) return;
            var monthly = parseInt(plan.getAttribute('data-monthly'), 10) || 0;
            var deposit = parseInt(plan.getAttribute('data-deposit'), 10) || 0;
            var shield = Math.round(monthly * RP_SHIELD_RATE);
            var moTotal = monthly + (rpShieldOn ? shield : 0);

            document.getElementById('rpMonthly').textContent = rpMoney(monthly);
            document.getElementById('rpDeposit').textContent = rpMoney(deposit);
            document.getElementById('rpTotal').textContent = rpMoney(moTotal + deposit);
            document.getElementById('rpShieldAmt').textContent = rpMoney(shield);
            document.getElementById('rpShieldLine').textContent = rpMoney(shield);
            document.getElementById('rpShieldRow').style.display = rpShieldOn ? '' : 'none';
        }

        /* select a plan: highlight it, check its radio, update the summary */
        function rpSelect(plan) {
            document.querySelectorAll('#rpPlans .rent-plan').forEach(function (el) {
                el.classList.remove('selected');
            });
            plan.classList.add('selected');
            var radio = plan.querySelector('input[type=radio]');
            if (radio) radio.checked = true;
            rpRefresh();
        }

        /* toggle the BOSK Shield add-on */
        function rpShieldToggle() {
            rpShieldOn = !rpShieldOn;
            document.getElementById('rpShield').classList.toggle('on', rpShieldOn);
            rpRefresh();
        }
    </script>
</body>

</html>

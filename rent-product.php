<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "connect.php";
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
                        <a href="index.php" style="color:var(--rt-dim);text-decoration:none;">Home</a>
                        <span style="margin:0 7px;color:var(--rt-line);">&raquo;</span>
                        <a href="rent.php" style="color:var(--rt-dim);text-decoration:none;">Rent Furniture</a>
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
                                        onclick="rpSwap(this, '<?php echo rent_img($g); ?>')">
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- RIGHT: info + plan selection -->
                        <div class="rent-pd-info">
                            <div class="rent-card-cat" style="margin-bottom:0;"><?php echo htmlspecialchars($p['category']); ?></div>
                            <?php if (!empty($p['badge'])): ?>
                                <span class="rent-card-badge" style="position:static;display:inline-block;margin:6px 0 0;"><?php echo htmlspecialchars($p['badge']); ?></span>
                            <?php endif; ?>
                            <h1><?php echo htmlspecialchars($p['name']); ?></h1>
                            <p class="lede"><?php echo htmlspecialchars($p['desc']); ?></p>

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
                                        data-plan-id="<?php echo (int)($plan['id'] ?? 0); ?>"
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

                            <!-- summary box (reflects selected plan) -->
                            <div class="rent-summary-box">
                                <div class="rent-srow">
                                    <span class="k">Monthly rent</span>
                                    <span class="v" id="rpMonthly"><?php echo rent_money($defaultPlan['monthly']); ?></span>
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
                                <!-- Add to Cart toast feedback -->
                                <div id="rpCartMsg" style="display:none;padding:10px 14px;border-radius:8px;font-size:13.5px;margin-bottom:12px;font-weight:600;"></div>

                                <button id="rpAddToCart" class="rent-btn rent-btn-block" type="button"
                                    data-product-id="<?php echo (int)$p['id']; ?>">
                                    <i class="fa fa-shopping-bag"></i> Add to Rental Cart
                                </button>
                                <a class="rent-btn rent-btn-outline rent-btn-block" href="rent-cart.php" style="margin-top:10px;">
                                    <i class="fa fa-shopping-bag"></i> View Rental Cart
                                    <?php $cnt = rent_cart_count(); if ($cnt > 0): ?>
                                        <span style="background:var(--rt-brand);color:#fff;border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:11px;margin-left:6px;"><?php echo $cnt; ?></span>
                                    <?php endif; ?>
                                </a>
                                <a class="rent-btn rent-btn-outline rent-btn-block" href="rent.php" style="margin-top:12px;">
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

        /* format an integer to ₹ + thousands separator */
        function rpMoney(n) {
            return '₹' + Math.round(n).toLocaleString('en-IN');
        }

        /* select a plan: highlight it, check its radio, update the summary */
        function rpSelect(plan) {
            document.querySelectorAll('#rpPlans .rent-plan').forEach(function (el) {
                el.classList.remove('selected');
            });
            plan.classList.add('selected');
            var radio = plan.querySelector('input[type=radio]');
            if (radio) radio.checked = true;

            var monthly = parseInt(plan.getAttribute('data-monthly'), 10) || 0;
            var deposit = parseInt(plan.getAttribute('data-deposit'), 10) || 0;
            var total   = monthly + deposit;

            document.getElementById('rpMonthly').textContent = rpMoney(monthly);
            document.getElementById('rpDeposit').textContent = rpMoney(deposit);
            document.getElementById('rpTotal').textContent   = rpMoney(total);
        }

        /* Add to Cart — AJAX POST to back/rent-handler.php */
        document.getElementById('rpAddToCart').addEventListener('click', function () {
            var btn = this;
            var selectedPlan = document.querySelector('#rpPlans .rent-plan.selected');
            if (!selectedPlan) {
                rpShowMsg('Please select a rental plan first.', 'warn');
                return;
            }
            var planId    = parseInt(selectedPlan.getAttribute('data-plan-id'), 10) || 0;
            var productId = parseInt(btn.getAttribute('data-product-id'), 10) || 0;

            if (!planId) {
                /* Demo mode (no DB yet) — just redirect to cart */
                window.location.href = 'rent-cart.php';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding…';

            var fd = new FormData();
            fd.append('action', 'add_to_cart');
            fd.append('product_id', productId);
            fd.append('plan_id', planId);
            fd.append('qty', 1);

            fetch('back/rent-handler.php', { method: 'POST', body: fd })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.ok) {
                        rpShowMsg('✓ Added to rental cart!', 'ok');
                        btn.innerHTML = '<i class="fa fa-check"></i> Added to Cart';
                        setTimeout(function () {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa fa-shopping-bag"></i> Add to Rental Cart';
                        }, 2000);
                    } else {
                        rpShowMsg(res.msg || 'Could not add item.', 'err');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-shopping-bag"></i> Add to Rental Cart';
                    }
                })
                .catch(function () {
                    rpShowMsg('Network error — please try again.', 'err');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa fa-shopping-bag"></i> Add to Rental Cart';
                });
        });

        function rpShowMsg(text, type) {
            var el = document.getElementById('rpCartMsg');
            if (!el) return;
            el.textContent = text;
            el.style.display = 'block';
            if (type === 'ok') {
                el.style.background = '#e6f7ee';
                el.style.color      = '#1aa260';
                el.style.border     = '1px solid #a3d9b8';
            } else if (type === 'warn') {
                el.style.background = '#fff8e1';
                el.style.color      = '#b36d00';
                el.style.border     = '1px solid #ffd54f';
            } else {
                el.style.background = '#fdeef0';
                el.style.color      = '#c0392b';
                el.style.border     = '1px solid #f5b7b1';
            }
            clearTimeout(el._t);
            el._t = setTimeout(function () { el.style.display = 'none'; }, 4000);
        }
    </script>
</body>

</html>

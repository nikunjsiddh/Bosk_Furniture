<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Furniture on Rent in India | Bosk Furniture';
$page_description = 'Rent premium furniture online from Bosk Furniture — sofas, beds, dining sets & wardrobes on flexible 3, 6 or 12 month plans. Free delivery, refundable deposit, return / extend / buyout any time.';
$page_keywords    = 'furniture on rent, rent furniture online india, sofa on rent, bed on rent, monthly furniture rental, bosk furniture rent';
$page_canonical   = '/rent';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent']
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

            <!-- ===================== CITY BAR (city-first catalogue) ===================== -->
            <div class="rent-citybar">
                <span><i class="fa fa-map-marker"></i> Renting in</span>
                <button type="button" class="city-btn" onclick="rentCityOpen()">
                    <?php echo htmlspecialchars(rent_city()); ?> <i class="fa fa-angle-down"></i>
                </button>
                <span style="opacity:.75;">Free delivery &amp; setup in your city</span>
            </div>

            <!-- ===================== HERO ===================== -->
            <section class="rent-hero">
                <div class="rent-hero-inner">
                    <span class="rent-badge"><i class="fa fa-refresh"></i> Furniture on Rent</span>
                    <h1>Great furniture, <span class="hl">without the big upfront cost.</span></h1>
                    <p>Furnish your home the flexible way. Pick a piece, choose a 3, 6 or 12-month plan and pay a small
                        monthly rent. Free delivery &amp; setup, a fully refundable deposit, and the freedom to return,
                        extend or buy out any time.</p>
                    <div class="rent-hero-cta">
                        <a href="#catalogue" class="rent-btn"><i class="fa fa-search"></i> Browse Rental Catalogue</a>
                        <a href="#how" class="rent-btn rent-btn-outline" style="background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.4);"><i class="fa fa-play-circle-o"></i> How It Works</a>
                    </div>
                    <div class="rent-hero-stats">
                        <div class="st"><b>3·6·12</b><span>Month plans</span></div>
                        <div class="st"><b>Free</b><span>Delivery &amp; setup</span></div>
                        <div class="st"><b>100%</b><span>Refundable deposit</span></div>
                        <div class="st"><b>3 ways</b><span>To end: return·extend·buy</span></div>
                    </div>
                </div>
            </section>

            <!-- ===================== HOW IT WORKS ===================== -->
            <section class="rent-section rent-how" id="how">
                <div class="rent-wrap">
                    <div class="rent-section-head">
                        <span class="eyebrow">Simple &amp; transparent</span>
                        <h2>How renting works</h2>
                        <p>From browsing to delivery in a few clear steps — you always see the monthly rent and the
                            refundable deposit before you confirm.</p>
                    </div>
                    <div class="rent-how-grid">
                        <div class="rent-how-step">
                            <span class="n">1</span>
                            <div class="ic"><i class="fa fa-search"></i></div>
                            <h4>Browse &amp; pick a plan</h4>
                            <p>Explore the rental catalogue and choose a 3, 6 or 12-month tenure.</p>
                        </div>
                        <div class="rent-how-step">
                            <span class="n">2</span>
                            <div class="ic"><i class="fa fa-shopping-bag"></i></div>
                            <h4>Add to rental cart</h4>
                            <p>Your tenure and refundable deposit are attached to the item.</p>
                        </div>
                        <div class="rent-how-step">
                            <span class="n">3</span>
                            <div class="ic"><i class="fa fa-id-card-o"></i></div>
                            <h4>Quick KYC &amp; slot</h4>
                            <p>Verify your mobile, upload ID proof and pick a delivery window.</p>
                        </div>
                        <div class="rent-how-step">
                            <span class="n">4</span>
                            <div class="ic"><i class="fa fa-check-circle"></i></div>
                            <h4>Pay &amp; get it delivered</h4>
                            <p>Pay the deposit + 1st month — we deliver &amp; set up free.</p>
                        </div>
                        <div class="rent-how-step">
                            <span class="n">5</span>
                            <div class="ic"><i class="fa fa-recycle"></i></div>
                            <h4>Return, extend or buy</h4>
                            <p>At tenure end: return (deposit refunded), extend, or buy the piece.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===================== CATALOGUE ===================== -->
            <section class="rent-section" id="catalogue">
                <div class="rent-wrap">
                    <div class="rent-section-head" style="margin-bottom:24px;">
                        <span class="eyebrow">The rental collection</span>
                        <h2>Rentable furniture</h2>
                        <p>Every piece below is available on rent. Tap a product to choose your tenure and see the full
                            monthly rent &amp; deposit.</p>
                    </div>

                    <!-- toolbar: category filters + count -->
                    <div class="rent-toolbar">
                        <div class="rent-filters" id="rentFilters">
                            <?php foreach ($RENTAL_CATEGORIES as $i => $cat): ?>
                                <button class="rent-filter<?php echo $i === 0 ? ' active' : ''; ?>"
                                    data-cat="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="rent-sort">
                            <select id="rentBudget" aria-label="Filter by monthly budget">
                                <?php foreach ($RENTAL_BUDGETS as $bi => $b): ?>
                                    <option value="<?php echo (int)$b['min']; ?>-<?php echo (int)$b['max']; ?>"><?php echo htmlspecialchars($b['label']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span><b id="rentCount"><?php echo count($RENTAL_PRODUCTS); ?></b> items in <?php echo htmlspecialchars(rent_city()); ?></span>
                        </div>
                    </div>

                    <!-- product grid -->
                    <div class="rent-grid" id="rentGrid">
                        <?php foreach ($RENTAL_PRODUCTS as $p):
                            $from = rent_from_price($p);
                            $minDep = min(array_column($p['plans'], 'deposit'));
                            $inStock = !empty($p['in_stock']);
                        ?>
                            <article class="rent-card<?php echo $inStock ? '' : ' oos'; ?>"
                                data-cat="<?php echo htmlspecialchars($p['category']); ?>"
                                data-price="<?php echo (int)$from; ?>">
                                <div class="rent-card-img">
                                    <?php if (!empty($p['badge'])): ?>
                                        <span class="rent-flag <?php echo rent_badge_class($p['badge']); ?>"><?php echo htmlspecialchars($p['badge']); ?></span>
                                    <?php endif; ?>
                                    <span class="rent-card-tag">3 · 6 · 12 mo</span>
                                    <a href="#" class="rent-card-fav" title="Save" onclick="return false;"><i class="fa fa-heart-o"></i></a>
                                    <a href="rent-product.php?id=<?php echo $p['id']; ?>">
                                        <img src="<?php echo rent_img($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?> on rent" loading="lazy">
                                    </a>
                                    <?php if (!$inStock): ?>
                                        <div class="rent-oos-overlay">Out of stock — available soon</div>
                                    <?php endif; ?>
                                </div>
                                <div class="rent-card-body">
                                    <div class="rent-card-cat"><?php echo htmlspecialchars($p['category']); ?></div>
                                    <h3 class="rent-card-title">
                                        <a href="rent-product.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></a>
                                    </h3>
                                    <?php if (!empty($p['combo_items'])): ?>
                                        <ul class="rent-combo-items">
                                            <?php foreach (array_slice($p['combo_items'], 0, 3) as $ci): ?>
                                                <li><?php echo htmlspecialchars($ci); ?></li>
                                            <?php endforeach; ?>
                                            <?php if (count($p['combo_items']) > 3): ?>
                                                <li>+ <?php echo count($p['combo_items']) - 3; ?> more</li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="rent-card-price">
                                        <span class="from">from</span>
                                        <span class="amt"><?php echo rent_money($from); ?></span>
                                        <span class="per">/month</span>
                                    </div>
                                    <div class="rent-card-meta">
                                        <span class="rent-chip dep"><i class="fa fa-shield"></i> <?php echo rent_money($minDep); ?> refundable</span>
                                        <?php if ($inStock && !empty($p['eta'])): ?>
                                            <span class="rent-chip eta"><i class="fa fa-truck"></i> Delivery in <?php echo htmlspecialchars($p['eta']); ?></span>
                                        <?php else: ?>
                                            <span class="rent-chip"><i class="fa fa-truck"></i> Free setup</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="rent-card-cta">
                                        <?php if ($inStock): ?>
                                            <a href="rent-product.php?id=<?php echo $p['id']; ?>" class="rent-btn rent-btn-block rent-btn-sm">
                                                View &amp; Rent <i class="fa fa-angle-right"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="contact.php" class="rent-btn rent-btn-outline rent-btn-block rent-btn-sm">
                                                <i class="fa fa-bell-o"></i> Notify Me
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- empty state (shown by filter JS when a category has no items) -->
                    <div class="rent-empty" id="rentEmpty" style="display:none;">
                        <div class="ic"><i class="fa fa-search"></i></div>
                        <h3>Nothing here yet</h3>
                        <p>We don't have rentable items in this category right now. Try another category.</p>
                    </div>

                    <!-- trust strip (what's included in every rent) -->
                    <div class="rent-trust" style="margin-top:34px;">
                        <div class="tr"><i class="fa fa-truck"></i><div><b>Free delivery &amp; install</b>in 2–5 days</div></div>
                        <div class="tr"><i class="fa fa-wrench"></i><div><b>Free maintenance</b>repairs on us, always</div></div>
                        <div class="tr"><i class="fa fa-exchange"></i><div><b>Free relocation</b>we shift it when you move</div></div>
                        <div class="tr"><i class="fa fa-undo"></i><div><b>Easy closure</b>return · extend · buy anytime</div></div>
                    </div>

                    <div class="rent-note" style="margin-top:22px;">
                        <i class="fa fa-info-circle"></i>
                        <div>This is the dedicated <b>Rent Furniture</b> catalogue. Buying instead? Visit our
                            <a href="all_products.php" style="color:var(--rt-brand);font-weight:600;">Shop</a> for furniture to own.</div>
                    </div>
                </div>
            </section>

        </div><!-- /.rent-scope -->

        <!-- ===================== CITY SELECT MODAL ===================== -->
        <div class="rent-city-modal" id="rentCityModal" role="dialog" aria-modal="true" aria-labelledby="rentCityTitle">
            <div class="box">
                <h3 id="rentCityTitle"><i class="fa fa-map-marker" style="color:var(--rt-accent);"></i> Choose your city</h3>
                <p>Catalogue, stock and delivery time depend on your city.</p>
                <div class="rent-city-grid">
                    <?php foreach ($RENTAL_CITIES as $c): ?>
                        <a class="rent-city-opt<?php echo $c === rent_city() ? ' selected' : ''; ?>"
                            href="rent.php?city=<?php echo urlencode($c); ?>#catalogue">
                            <i class="fa fa-building-o"></i><?php echo htmlspecialchars($c); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <a class="rent-btn rent-btn-outline rent-btn-block rent-btn-sm" style="margin-top:16px;" onclick="rentCityClose();return false;" href="#">Maybe later</a>
            </div>
        </div>

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* Category + budget filter for the rental catalogue */
        (function () {
            var filters = document.querySelectorAll('#rentFilters .rent-filter');
            var cards = document.querySelectorAll('#rentGrid .rent-card');
            var empty = document.getElementById('rentEmpty');
            var budget = document.getElementById('rentBudget');
            var count = document.getElementById('rentCount');
            var activeCat = 'All';

            function apply() {
                var range = budget ? budget.value.split('-') : ['0', '0'];
                var min = parseInt(range[0], 10) || 0;
                var max = parseInt(range[1], 10) || 0; /* 0 = no upper limit */
                var shown = 0;
                cards.forEach(function (c) {
                    var okCat = (activeCat === 'All' || c.getAttribute('data-cat') === activeCat);
                    var price = parseInt(c.getAttribute('data-price'), 10) || 0;
                    var okBudget = (max === 0) || (price >= min && price <= max);
                    var match = okCat && okBudget;
                    c.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                if (empty) empty.style.display = shown ? 'none' : 'block';
                if (count) count.textContent = shown;
            }

            filters.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    filters.forEach(function (b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    activeCat = btn.getAttribute('data-cat');
                    apply();
                });
            });
            if (budget) budget.addEventListener('change', apply);
        })();

        /* City select modal */
        function rentCityOpen() {
            var m = document.getElementById('rentCityModal');
            if (m) { m.classList.add('open'); document.body.style.overflow = 'hidden'; }
        }
        function rentCityClose() {
            var m = document.getElementById('rentCityModal');
            if (m) { m.classList.remove('open'); document.body.style.overflow = ''; }
        }
        (function () {
            var m = document.getElementById('rentCityModal');
            if (!m) return;
            m.addEventListener('click', function (e) { if (e.target === m) rentCityClose(); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') rentCityClose(); });
        })();
    </script>
</body>

</html>

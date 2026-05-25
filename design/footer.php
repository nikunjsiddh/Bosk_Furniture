<!-- START FOOTER -->
<style>
    /* ============================================================ */
    /* ================== BOSK MODERN FOOTER ===================== */
    /* ============================================================ */
    .bosk-footer {
        --bf-brand: #532A1A;
        --bf-brand-light: #7a4128;
        --bf-accent: #b8763f;
        --bf-cream: #fbf5f1;
        --bf-bg: #ffffff;
        --bf-bg-soft: #faf6f2;
        --bf-heading: #1a1a1a;
        --bf-text: #4a3f38;
        --bf-text-dim: #8a7d75;
        --bf-line: rgba(83,42,26,.10);

        position: relative;
        background:
            radial-gradient(900px 500px at 0% 0%, rgba(83,42,26,.05), transparent 60%),
            radial-gradient(700px 400px at 100% 100%, rgba(184,118,63,.06), transparent 60%),
            var(--bf-bg) !important;
        color: var(--bf-text);
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
        isolation: isolate;
    }

    /* Decorative top divider */
    .bosk-footer::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg,
            transparent 0%,
            var(--bf-brand) 25%,
            var(--bf-accent) 50%,
            var(--bf-brand) 75%,
            transparent 100%);
        background-size: 200% 100%;
        animation: bf-shimmer 6s ease-in-out infinite;
        z-index: 3;
    }
    @keyframes bf-shimmer {
        0%, 100% { background-position: 0% 50%; }
        50%      { background-position: 100% 50%; }
    }

    /* Soft floating orbs */
    .bf-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        opacity: .12;
        pointer-events: none;
        z-index: 0;
    }
    .bf-orb-1 { width: 360px; height: 360px; background: var(--bf-brand); top: -120px; left: -120px; animation: bf-float 14s ease-in-out infinite; }
    .bf-orb-2 { width: 280px; height: 280px; background: var(--bf-accent); bottom: -100px; right: -100px; opacity: .14; animation: bf-float 18s ease-in-out infinite reverse; }
    @keyframes bf-float {
        0%, 100% { transform: translate(0, 0); }
        50%      { transform: translate(30px, -30px); }
    }

    .bosk-footer .container { position: relative; z-index: 2; }

    /* ================== TOP STRIP (NEWSLETTER) ================== */
    .bf-cta-strip {
        position: relative;
        padding: 2.5rem 0;
        background: var(--bf-bg-soft);
        border-bottom: 1px solid var(--bf-line);
    }
    .bf-cta-strip .row { align-items: center; }
    .bf-cta-heading {
        margin: 0;
        color: var(--bf-heading);
        font-size: clamp(1.5rem, 2.6vw, 2rem);
        font-weight: 700;
        line-height: 1.3;
    }
    .bf-cta-heading span {
        background: linear-gradient(120deg, var(--bf-brand) 0%, var(--bf-accent) 50%, var(--bf-brand) 100%);
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: bf-shimmer 5s ease-in-out infinite;
    }
    .bf-cta-sub {
        color: var(--bf-text);
        font-size: 1rem;
        line-height: 1.6;
        margin: .45rem 0 0;
    }

    .bf-newsletter-form {
        position: relative;
        display: flex;
        align-items: stretch;
        background: #fff;
        border: 1px solid var(--bf-line);
        border-radius: 999px;
        padding: 6px;
        transition: border-color .35s ease, box-shadow .35s ease;
        box-shadow: 0 6px 18px rgba(83,42,26,.06);
    }
    .bf-newsletter-form:focus-within:not(.is-invalid) {
        border-color: var(--bf-brand);
        box-shadow: 0 0 0 4px rgba(83,42,26,.08), 0 10px 22px rgba(83,42,26,.10);
    }
    .bf-newsletter-form.is-invalid,
    .bf-newsletter-form.is-invalid:focus-within {
        border-color: #c0392b;
        box-shadow: 0 0 0 4px rgba(192,57,43,.10);
        animation: bf-shake .35s ease;
    }
    @keyframes bf-shake {
        0%, 100% { transform: translateX(0); }
        25%      { transform: translateX(-5px); }
        75%      { transform: translateX(5px); }
    }
    .bf-newsletter-form input[type="email"] {
        flex: 1 1 auto;
        background: transparent !important;
        border: 0 !important;
        outline: 0 !important;
        color: var(--bf-heading) !important;
        font-size: 1rem;
        padding: .8rem 1.2rem;
        min-width: 0;
        box-shadow: none !important;
    }
    .bf-newsletter-form input[type="email"]::placeholder { color: var(--bf-text-dim); }
    .bf-newsletter-form input[type="submit"] {
        flex: 0 0 auto;
        background: linear-gradient(135deg, var(--bf-brand) 0%, var(--bf-brand-light) 100%);
        color: #fff !important;
        border: 0;
        border-radius: 999px;
        padding: .85rem 1.8rem;
        font-size: .9rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        cursor: pointer;
        transition: transform .3s cubic-bezier(.2,.7,.2,1), box-shadow .3s ease, background .35s ease;
        box-shadow: 0 8px 18px rgba(83,42,26,.25);
    }
    .bf-newsletter-form input[type="submit"]:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, var(--bf-accent) 0%, var(--bf-brand) 100%);
        box-shadow: 0 14px 26px rgba(83,42,26,.28);
    }
    .bf-newsletter-wrap label.error,
    .bf-newsletter-wrap .subscription-success {
        display: none;
        font-size: .92rem;
        font-weight: 500;
        margin: .65rem 0 0;
        padding-left: 1.1rem;
        opacity: 0;
        transform: translateY(-4px);
        transition: opacity .25s ease, transform .25s ease;
    }
    .bf-newsletter-wrap label.error { color: #c0392b; }
    .bf-newsletter-wrap label.error::before { content: "⚠  "; }
    .bf-newsletter-wrap .subscription-success { color: #2e7d32; }
    .bf-newsletter-wrap .subscription-success::before { content: "✓  "; font-weight: 700; }
    .bf-newsletter-wrap label.error.is-visible,
    .bf-newsletter-wrap .subscription-success.is-visible {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
    .bf-newsletter-form input[type="submit"]:disabled {
        opacity: .65;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* ================== MAIN GRID ================== */
    .bf-main { padding: 4rem 0 2.5rem; }

    .bf-col h3,
    .bf-col h4 {
        position: relative;
        color: var(--bf-heading);
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        margin: 0 0 1.6rem;
        padding-bottom: .85rem;
    }
    .bf-col h3::after,
    .bf-col h4::after {
        content: "";
        position: absolute;
        left: 0; bottom: 0;
        width: 36px; height: 2px;
        background: linear-gradient(90deg, var(--bf-brand), var(--bf-accent));
        transition: width .4s cubic-bezier(.2,.7,.2,1);
    }
    .bf-col:hover h3::after,
    .bf-col:hover h4::after { width: 64px; }

    /* Brand block */
    .bf-brand-block { padding-right: 1rem; }
    .bf-logo {
        display: inline-block;
        margin-bottom: 1.2rem;
        transition: transform .4s cubic-bezier(.2,.7,.2,1);
    }
    .bf-logo:hover { transform: translateY(-2px); }
    .bf-logo img {
        max-width: 170px;
        height: auto;
    }
    .bf-tagline {
        font-size: .88rem;
        font-weight: 700;
        color: var(--bf-brand);
        letter-spacing: .18em;
        text-transform: uppercase;
        margin: 0 0 1.2rem;
        display: inline-flex;
        align-items: center;
        gap: .55rem;
    }
    .bf-tagline::before {
        content: "";
        width: 26px; height: 2px;
        background: var(--bf-brand);
        display: inline-block;
    }

    .bf-contact { list-style: none; padding: 0; margin: 0; }
    .bf-contact li {
        display: flex;
        gap: .9rem;
        align-items: flex-start;
        padding: .65rem 0;
        font-size: .98rem;
        line-height: 1.65;
        color: var(--bf-text);
        transition: color .3s ease, transform .3s ease;
    }
    .bf-contact li:hover { color: var(--bf-brand); transform: translateX(4px); }
    .bf-contact li i {
        flex: 0 0 38px;
        width: 38px; height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(83,42,26,.08);
        color: var(--bf-brand);
        font-size: 1rem;
        transition: background .3s ease, color .3s ease, transform .3s ease, box-shadow .3s ease;
    }
    .bf-contact li:hover i {
        background: var(--bf-brand);
        color: #fff;
        transform: rotate(-8deg) scale(1.08);
        box-shadow: 0 6px 14px rgba(83,42,26,.22);
    }
    .bf-contact a {
        color: inherit !important;
        text-decoration: none !important;
        transition: color .3s ease;
    }
    .bf-contact a:hover { color: var(--bf-brand) !important; }

    /* Social icons */
    .bf-social {
        display: flex;
        gap: .55rem;
        margin-top: 1.4rem;
    }
    .bf-social a {
        width: 44px; height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff;
        border: 1px solid var(--bf-line);
        color: var(--bf-brand);
        font-size: 1.05rem;
        text-decoration: none !important;
        transition: transform .35s cubic-bezier(.2,.7,.2,1), color .35s ease, border-color .35s ease, box-shadow .35s ease;
        position: relative;
        overflow: hidden;
    }
    .bf-social a::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--bf-brand), var(--bf-accent));
        transform: scale(0);
        transition: transform .4s cubic-bezier(.2,.7,.2,1);
        border-radius: 50%;
        z-index: 0;
    }
    .bf-social a i { position: relative; z-index: 1; }
    .bf-social a:hover {
        color: #fff;
        border-color: transparent;
        transform: translateY(-4px);
        box-shadow: 0 12px 22px rgba(83,42,26,.22);
    }
    .bf-social a:hover::before { transform: scale(1); }

    /* Link lists */
    .bf-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .15rem .8rem;
    }
    .bf-links.bf-links-single { grid-template-columns: 1fr; }
    .bf-links li { margin: 0; }
    .bf-links a {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        color: var(--bf-text) !important;
        font-size: .98rem;
        font-weight: 500;
        text-decoration: none !important;
        padding: .45rem 0;
        line-height: 1.55;
        transition: color .3s ease, padding-left .3s ease;
    }
    .bf-links a::before {
        content: "›";
        opacity: 0;
        color: var(--bf-brand);
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1;
        transform: translateX(-4px);
        transition: opacity .3s ease, transform .3s ease;
    }
    .bf-links a:hover {
        color: var(--bf-brand) !important;
        padding-left: 4px;
    }
    .bf-links a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    /* Categories list */
    .bf-cats {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .bf-cats li { margin: 0; }
    .bf-cat {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .55rem 0;
        color: var(--bf-text) !important;
        text-decoration: none !important;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.55;
        transition: color .3s ease, transform .3s ease;
    }
    .bf-cat-dot {
        width: 9px; height: 9px;
        border-radius: 50%;
        background: var(--bf-brand);
        opacity: .55;
        flex: 0 0 9px;
        transition: opacity .3s ease, transform .3s ease, box-shadow .3s ease, background .3s ease;
    }
    .bf-cat:hover { color: var(--bf-brand) !important; transform: translateX(4px); }
    .bf-cat:hover .bf-cat-dot {
        opacity: 1;
        background: var(--bf-accent);
        transform: scale(1.4);
        box-shadow: 0 0 0 4px rgba(184,118,63,.18);
    }

    /* ================== BOTTOM BAR ================== */
    .bf-bottom {
        border-top: 1px solid var(--bf-line);
        padding: 1.4rem 0;
        background: var(--bf-bg-soft);
    }
    .bf-bottom-inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        color: var(--bf-text-dim);
        font-size: .92rem;
        line-height: 1.55;
    }
    .bf-bottom-inner p { color: var(--bf-text); }
    .bf-bottom-inner a {
        color: var(--bf-brand) !important;
        text-decoration: none !important;
        font-weight: 600;
        transition: color .3s ease;
    }
    .bf-bottom-inner a:hover { color: var(--bf-accent) !important; }
    .bf-bottom-links {
        display: inline-flex;
        gap: 1.2rem;
        flex-wrap: wrap;
    }
    .bf-bottom-links a {
        color: var(--bf-text) !important;
        font-weight: 500;
    }
    .bf-bottom-links a:hover { color: var(--bf-brand) !important; }

    /* ================== RESPONSIVE ================== */
    @media (max-width: 991px) {
        .bf-main { padding: 3rem 0 2rem; }
        .bf-col { margin-bottom: 2rem; }
        .bf-brand-block { padding-right: 0; }
    }
    @media (max-width: 767px) {
        .bf-cta-strip { padding: 2rem 0; text-align: center; }
        .bf-cta-strip .bf-cta-text { margin-bottom: 1.2rem; }
        .bf-newsletter-form input[type="submit"] { padding: .8rem 1.2rem; font-size: .85rem; }
        .bf-links { grid-template-columns: 1fr; }
        .bf-bottom-inner { justify-content: center; text-align: center; }
    }
    @media (max-width: 480px) {
        .bf-newsletter-form { flex-direction: column; border-radius: 14px; padding: 8px; }
        .bf-newsletter-form input[type="email"] { padding: .9rem 1.1rem; font-size: 1rem; text-align: center; }
        .bf-newsletter-form input[type="submit"] { border-radius: 12px; width: 100%; padding: .95rem 1rem; font-size: .9rem; }
        .bf-col h3, .bf-col h4 { font-size: 1.05rem; }
        .bf-contact li { font-size: .95rem; }
        .bf-links a, .bf-cat { font-size: .95rem; }
        .bf-bottom-inner { font-size: .88rem; }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .bosk-footer::before,
        .bf-orb-1, .bf-orb-2,
        .bf-cta-heading span {
            animation: none !important;
        }
        .bf-social a, .bf-contact li, .bf-cat, .bf-links a, .bf-logo {
            transition: none !important;
        }
    }
</style>

<footer class="bosk-footer first-footer" role="contentinfo">
    <span class="bf-orb bf-orb-1" aria-hidden="true"></span>
    <span class="bf-orb bf-orb-2" aria-hidden="true"></span>

    <!-- Newsletter strip -->
    <div class="bf-cta-strip">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 bf-cta-text">
                    <h3 class="bf-cta-heading">Crafted for your home, <span>delivered with love.</span></h3>
                    <p class="bf-cta-sub">Subscribe for fresh designs, seasonal offers and interior inspiration — straight to your inbox.</p>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="bf-newsletter-wrap">
                        <form onsubmit="return newsletter(this);" id="newsletter" class="bf-newsletter-form mailchimp" method="post" novalidate>
                            <input type="email" name="newsemail" id="newsemail" placeholder="Enter your email address" autocomplete="email" maxlength="80" aria-describedby="newsletter-error">
                            <input type="submit" id="newsletter-submit" value="Subscribe">
                        </form>
                        <label for="newsemail" id="newsletter-error" class="error" role="alert"></label>
                        <p class="subscription-success" aria-live="polite"></p>
                        <div id="return1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main grid -->
    <div class="bf-main">
        <div class="container">
            <div class="row">
                <!-- Brand + contact -->
                <div class="col-lg-4 col-md-6 bf-col bf-brand-block">
                    <a href="index.php" class="bf-logo" aria-label="Bosk Furniture — Home">
                        <img src="images/logo-white.png" alt="Bosk Furniture">
                    </a>
                    <span class="bf-tagline">Registered Office</span>
                    <ul class="bf-contact">
                        <li>
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <span>5, Aryamaan Complex, Near Meghani Circle, Sir Patanni Road, Bhavnagar-364001, Gujarat, India.</span>
                        </li>
                        <li>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <a href="tel:+918866647777">+91 88666 47777</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <a href="mailto:boskinfracon@gmail.com">boskinfracon@gmail.com</a>
                        </li>
                        <li>
                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                            <a href="https://wa.me/919737817777" target="_blank" rel="noopener">+91 97378 17777</a>
                        </li>
                    </ul>

                    <div class="bf-social" aria-label="Follow us">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="https://www.youtube.com/" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        <a href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="col-lg-4 col-md-6 bf-col">
                    <h3>Navigation</h3>
                    <ul class="bf-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="all_products.php">Shop</a></li>
                        <li><a href="about-us.php">About Us</a></li>
                        <li><a href="blog-full-list.php">Blog</a></li>
                        <li><a href="design-order-process.php">How it Works</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="profile.php">My Account</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="testimonial.php">Testimonial</a></li>
                        <li><a href="warranty.php">Warranty</a></li>
                        <li><a href="warranty_policy.php">Warranty Policy</a></li>
                        <li><a href="care_and_maintenance_policy.php">Care &amp; Maintenance</a></li>
                        <li><a href="hardware_warranty.php">Hardware Policy</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="col-lg-4 col-md-12 bf-col">
                    <h3>Shop by Category</h3>
                    <ul class="bf-cats">
                        <?php
                            include_once "connect.php";
                            $cmd    = "select * from category limit 8";
                            $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
                            while ($row = mysqli_fetch_array($result)) {
                                $cat_id   = $row['id'];
                                $cat_name = $row['name'];
                        ?>
                        <li>
                            <a class="bf-cat" href="shop.php?astringdata2=<?php echo urlencode($cat_name); ?>">
                                <span class="bf-cat-dot" aria-hidden="true"></span>
                                <span><?php echo htmlspecialchars($cat_name, ENT_QUOTES, 'UTF-8'); ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom bar -->
    <div class="bf-bottom">
        <div class="container">
            <div class="bf-bottom-inner">
                <p style="margin:0;">&copy; <?php echo date('Y'); ?> <a href="index.php">Bosk Furniture</a>. All Rights Reserved.</p>
                <div class="bf-bottom-links">
                    <a href="warranty_policy.php">Warranty</a>
                    <a href="care_and_maintenance_policy.php">Care Policy</a>
                    <a href="contact.php">Support</a>
                </div>
                <p style="margin:0;">Powered by <a href="https://softwingz.com/" target="_blank" rel="noopener">SOFTWINGZ INFOTECH</a></p>
            </div>
        </div>
    </div>
</footer>
<script src="js/add/newsletter.js"></script>

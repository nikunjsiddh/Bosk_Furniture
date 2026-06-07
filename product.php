<?php
// Guarded session_start so it never collides with another include's session_start.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");

// Safe defaults so the rest of the page never sees undefined variables.
$pname      = '';
$decoded_id = 0;

if (isset($_GET['astringdata'])) {

    $raw = $_GET['astringdata'];

    // The site links to this page in TWO styles:
    //   1) plain numeric id   -> product.php?astringdata=5     (related-products block, one shop.php button)
    //   2) base64-encoded id  -> product.php?astringdata=NQ==  (most pages: all_products / shop / order_details)
    // Accept both without breaking existing links.
    if (ctype_digit($raw)) {
        $decoded_id = (int) $raw;
    } else {
        $maybe = base64_decode($raw, true);
        $decoded_id = ($maybe !== false && ctype_digit($maybe)) ? (int) $maybe : 0;
    }

    // Scheduled publishing: a product is only viewable from its Publish Date onward.
    // Future-dated (or missing) products redirect to the shop instead of showing.
    if ($decoded_id > 0) {
        $pubchk = mysqli_query($con, "select id from products where id='" . $decoded_id . "' and publish_date <= NOW()");
        if (!$pubchk || mysqli_num_rows($pubchk) === 0) {
            header("Location: shop.php");
            exit();
        }
    }

    if ($decoded_id > 0) {
        $cmd3    = "select * from products where id='" . $decoded_id . "'";
        $result3 = mysqli_query($con, $cmd3) or die(mysqli_error($con));
        while ($row = mysqli_fetch_array($result3)) {
            $pname           = $row['pname'];
            $seo_pcategory   = isset($row['pcategory'])   ? $row['pcategory']   : '';
            $seo_description = isset($row['description']) ? strip_tags($row['description']) : '';
            $seo_new_price   = isset($row['new_price'])   ? $row['new_price']   : '';
            $seo_img1        = isset($row['img1'])        ? $row['img1']        : '';
            $seo_sku         = isset($row['sku'])         ? $row['sku']         : '';
            $seo_stock       = isset($row['stock'])       ? $row['stock']       : 0;
        }
    }
}

// ---- Dynamic SEO meta from product data ----
$_seo_pname = isset($pname) && $pname !== '' ? $pname : 'Product';
$_seo_short = isset($seo_description) ? substr(trim(preg_replace('/\s+/', ' ', $seo_description)), 0, 155) : '';
if ($_seo_short === '') {
    $_seo_short = 'Buy ' . $_seo_pname . ' online at Bosk Furniture - premium quality furniture with free shipping across India.';
}
$page_title       = $_seo_pname . ' | Buy Online at Bosk Furniture India';
$page_description = $_seo_short;
$page_keywords    = $_seo_pname . ', buy ' . $_seo_pname . ' online, ' . (isset($seo_pcategory) ? $seo_pcategory . ', ' : '') . 'furniture india, bosk furniture';
$page_canonical   = '/product?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '');
$og_type          = 'product';
$page_breadcrumbs = [
    ['name' => 'Home',       'url' => '/'],
    ['name' => 'Shop',       'url' => '/all_products'],
    ['name' => $_seo_pname,  'url' => '/product?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '')]
];
if (!empty($seo_img1)) {
    $og_image = 'https://www.boskfurniture.com/Admin/product_image/' . $seo_img1;
}

// Build Product JSON-LD schema
$_seo_avail = (isset($seo_stock) && $seo_stock > 0) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
$page_schema = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": ' . json_encode($_seo_pname) . ',
  "image": ' . json_encode(!empty($seo_img1) ? 'https://www.boskfurniture.com/Admin/product_image/' . $seo_img1 : 'https://www.boskfurniture.com/images/og-default.jpg') . ',
  "description": ' . json_encode($_seo_short) . ',
  "sku": ' . json_encode(isset($seo_sku) ? $seo_sku : '') . ',
  "brand": {"@type":"Brand","name":"Bosk Furniture"},
  "category": ' . json_encode(isset($seo_pcategory) ? $seo_pcategory : 'Furniture') . ',
  "offers": {
    "@type": "Offer",
    "url": "https://www.boskfurniture.com/product?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '') . '",
    "priceCurrency": "INR",
    "price": ' . json_encode(isset($seo_new_price) ? (string)$seo_new_price : '0') . ',
    "availability": "' . $_seo_avail . '",
    "itemCondition": "https://schema.org/NewCondition",
    "seller": {"@type":"Organization","name":"Bosk Furniture"}
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"Home","item":"https://www.boskfurniture.com/"},
    {"@type":"ListItem","position":2,"name":"Shop","item":"https://www.boskfurniture.com/all_products"},
    {"@type":"ListItem","position":3,"name":' . json_encode($_seo_pname) . ',"item":"https://www.boskfurniture.com/product?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '') . '"}
  ]
}
</script>';

// Re-open the original guard so the HTML only renders when astringdata was supplied
if (isset($_GET['astringdata'])) {
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
    /* =====================================================================
       Bosk Furniture — Redesigned Product Detail
       Brand palette: brown #532A1A · gold #C2A773
       Pure-CSS entrance animations + interactive hover/zoom effects.
       Gallery class hooks (.img-showcase/.img-select/.img-item) are kept
       intact so the existing slide JS keeps working.
       ===================================================================== */
    :root{
        --bosk-brown:#532A1A;
        --bosk-gold:#C2A773;
        --bosk-dark:#2b2419;
        --bosk-soft:#f7f3ec;
    }

    @keyframes boskFadeUp{from{opacity:0;transform:translateY(34px)}to{opacity:1;transform:none}}
    @keyframes boskFadeIn{from{opacity:0}to{opacity:1}}
    @keyframes boskZoomIn{from{opacity:0;transform:scale(.93)}to{opacity:1;transform:none}}
    @keyframes boskPulse{0%{box-shadow:0 0 0 0 rgba(194,167,115,.55)}70%{box-shadow:0 0 0 14px rgba(194,167,115,0)}100%{box-shadow:0 0 0 0 rgba(194,167,115,0)}}
    @keyframes boskPop{0%{opacity:0;transform:translateY(40px) scale(.96)}100%{opacity:1;transform:none}}

    .product-stage{padding:55px 0 30px;}

    /* ---- The main product card ---- */
    .bosk-pcard{
        background:#ffffff;
        border-radius:20px;
        box-shadow:0 24px 60px -28px rgba(83,42,26,.40);
        padding:34px;
        overflow:hidden;
        animation:boskFadeIn .7s ease both;
    }
    @media(max-width:767px){ .bosk-pcard{padding:20px;} }

    /* ---- Gallery ---- */
    .product-imgs{display:flex;flex-direction:column;gap:16px;animation:boskFadeUp .7s ease .05s both;}
    /* Outer framed card around the main image */
    .img-display{
        position:relative;overflow:hidden;border-radius:18px;
        background:linear-gradient(160deg,#fffdf9 0%,#f6efe3 100%);
        padding:12px;
        border:1px solid #ece3d2;
        box-shadow:0 22px 46px -26px rgba(83,42,26,.55);
    }
    /* Inner rounded window so the cover image keeps clean corners */
    .img-frame{position:relative;border-radius:12px;overflow:hidden;box-shadow:inset 0 0 0 1px rgba(83,42,26,.06);}
    /* Soft diagonal sheen that fades in on hover */
    .img-frame::after{content:"";position:absolute;inset:0;z-index:2;pointer-events:none;
        background:linear-gradient(125deg,rgba(255,255,255,.28) 0%,rgba(255,255,255,0) 42%);
        opacity:0;transition:opacity .5s ease;}
    .img-display:hover .img-frame::after{opacity:1;}
    .img-showcase{display:flex;width:100%;transition:transform .55s cubic-bezier(.4,.16,.2,1);}
    .img-showcase img{min-width:100%;width:100%;aspect-ratio:4/3;height:auto;object-fit:cover;display:block;transition:transform .8s ease;}
    /* Smooth, full-bleed zoom on hover */
    .img-display:hover .img-showcase img{transform:scale(1.08);}

    .img-select{display:flex;gap:12px;}
    .img-item{flex:1;margin:0;border-radius:12px;overflow:hidden;cursor:pointer;background:#fff;
        box-shadow:0 6px 16px -10px rgba(0,0,0,.35);
        border:2px solid #ece3d2;transition:transform .3s ease,border-color .3s ease,box-shadow .3s ease;}
    .img-item img{width:100%;height:84px;object-fit:cover;display:block;transition:transform .4s ease;}
    .img-item:hover{transform:translateY(-4px);border-color:var(--bosk-gold);}
    .img-item:hover img{transform:scale(1.08);}
    .img-item.active{border-color:var(--bosk-brown);box-shadow:0 8px 18px -8px rgba(83,42,26,.55);}
    @media(max-width:767px){ .img-item img{height:62px;} }

    /* ---- Product content column ---- */
    .bosk-info{animation:boskFadeUp .7s ease .18s both;}
    .bosk-info .bosk-cat{
        display:inline-block;font-size:12px;letter-spacing:2px;text-transform:uppercase;
        color:var(--bosk-gold);font-weight:700;margin-bottom:10px;
    }
    .bosk-info h1.bosk-title{
        font-family:Montserrat,sans-serif;font-size:32px;font-weight:800;line-height:1.2;
        color:var(--bosk-dark);margin:0 0 14px;
    }
    @media(max-width:767px){ .bosk-info h1.bosk-title{font-size:26px;} }

    /* Stock badge */
    .bosk-stock{
        display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;
        padding:6px 14px;border-radius:30px;margin-bottom:14px;
    }
    .bosk-stock.in{background:rgba(115,196,55,.12);color:#5a9e1e;}
    .bosk-stock.out{background:rgba(244,67,54,.10);color:#e23b2e;}
    .bosk-stock i{font-size:13px;}

    .bosk-sku{display:block;font-size:13px;color:#8a8275;margin-bottom:18px;letter-spacing:.4px;}
    .bosk-sku b{color:var(--bosk-dark);}

    /* Price block */
    .bosk-price{display:flex;align-items:baseline;gap:14px;flex-wrap:wrap;margin-bottom:24px;
        padding-bottom:22px;border-bottom:1px dashed #e5ddd0;}
    .bosk-price .now{font-family:Montserrat,sans-serif;font-size:36px;font-weight:800;color:var(--bosk-brown);}
    .bosk-price .was{font-size:19px;color:#b3aa9b;text-decoration:line-through;}
    .bosk-price .save{
        position:relative;align-self:center;
        font-size:13px;font-weight:800;color:#fff;letter-spacing:.6px;text-transform:uppercase;
        padding:6px 16px;border-radius:30px;
        background:linear-gradient(135deg,#e23b2e 0%,#ff7a3d 100%);
        box-shadow:0 8px 18px -6px rgba(226,59,46,.65);
        animation:boskSave 1.8s ease-in-out infinite;
    }
    .bosk-price .save::before{content:"\f0eb";font-family:FontAwesome;margin-right:6px;font-size:12px;}
    @keyframes boskSave{0%,100%{transform:scale(1);box-shadow:0 8px 18px -6px rgba(226,59,46,.6)}50%{transform:scale(1.06);box-shadow:0 10px 22px -6px rgba(226,59,46,.85)}}

    /* Quantity + cart */
    .bosk-buy{margin-bottom:24px;}
    .bosk-qtyrow{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
    .bosk-qtyrow > label{font-weight:700;color:var(--bosk-dark);margin:0;font-size:15px;}
    .bosk-stepper{display:inline-flex;align-items:center;border:1px solid #e2d9c9;border-radius:30px;overflow:hidden;background:#fff;}
    .bosk-stepper input{width:56px;height:46px;border:none;outline:none;box-shadow:none;text-align:center;font-size:16px;font-weight:700;
        color:var(--bosk-dark);background:transparent;-moz-appearance:textfield;
        border-left:1px solid #ede5d6;border-right:1px solid #ede5d6;border-radius:0;}
    .bosk-stepper input:focus{outline:none;box-shadow:none;}
    .bosk-stepper input::-webkit-outer-spin-button,.bosk-stepper input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0;}
    .bosk-stepper button{width:44px;height:46px;border:none;outline:none;background:transparent;font-size:20px;font-weight:700;
        color:var(--bosk-brown);cursor:pointer;transition:background .2s ease,color .2s ease;line-height:1;}
    .bosk-stepper button:hover{background:var(--bosk-soft);color:var(--bosk-gold);}
    .bosk-stepper button:focus,.bosk-stepper button:focus-visible,.bosk-stepper button:active{outline:none;box-shadow:none;}

    .bosk-cart-btn{
        position:relative;overflow:hidden;isolation:isolate;
        display:inline-flex;align-items:center;justify-content:center;gap:10px;
        background:linear-gradient(135deg,var(--bosk-brown) 0%,#6e3a22 100%);
        background-size:200% 100%;background-position:0 0;
        color:#fff;border:none;border-radius:30px;
        padding:14px 34px;font-size:15px;font-weight:700;letter-spacing:.5px;cursor:pointer;
        text-transform:uppercase;
        transition:transform .3s ease,box-shadow .3s ease,background-position .5s ease;
        box-shadow:0 14px 26px -12px rgba(83,42,26,.7);
    }
    /* Shine sweep that slides across on hover */
    .bosk-cart-btn::before{
        content:"";position:absolute;top:0;left:-120%;width:60%;height:100%;z-index:-1;
        background:linear-gradient(120deg,transparent 0%,rgba(255,255,255,.45) 50%,transparent 100%);
        transform:skewX(-20deg);transition:left .6s ease;
    }
    .bosk-cart-btn:hover{
        background:linear-gradient(135deg,var(--bosk-brown) 0%,var(--bosk-gold) 100%);
        background-position:100% 0;
        transform:translateY(-3px);color:#fff;
        box-shadow:0 20px 34px -12px rgba(194,167,115,.85);
    }
    .bosk-cart-btn:hover::before{left:130%;}
    .bosk-cart-btn:hover .lnr,.bosk-cart-btn:hover i{animation:boskCartNudge .6s ease;}
    .bosk-cart-btn:active{transform:translateY(-1px) scale(.99);}
    .bosk-cart-btn .lnr,.bosk-cart-btn i{font-size:18px;}
    .bosk-cart-btn:disabled{background:#cfc8bb;box-shadow:none;cursor:not-allowed;transform:none;}
    .bosk-cart-btn:disabled::before{display:none;}
    @keyframes boskCartNudge{0%,100%{transform:translateX(0)}30%{transform:translateX(-3px)}60%{transform:translateX(3px)}}

    .bosk-note{margin-top:14px;color:#e23b2e;font-size:13px;font-weight:500;line-height:1.5;}

    /* Description */
    .bosk-desc{animation:boskFadeUp .7s ease .28s both;}
    .bosk-desc h4{font-family:Montserrat,sans-serif;font-size:17px;font-weight:700;color:var(--bosk-dark);
        margin-bottom:12px;display:flex;align-items:center;gap:10px;}
    .bosk-desc h4::before{content:"";width:26px;height:3px;border-radius:3px;background:var(--bosk-gold);display:inline-block;}
    .bosk-desc p{font-family:'Open Sans',sans-serif;font-size:14.5px;line-height:1.9;color:#6b6457;margin:0;}

    /* Trust strip */
    .bosk-trust{display:flex;gap:10px;flex-wrap:wrap;margin-top:26px;}
    .bosk-trust .t{flex:1;min-width:120px;display:flex;align-items:center;gap:10px;background:var(--bosk-soft);
        border-radius:12px;padding:12px 14px;font-size:12.5px;font-weight:600;color:var(--bosk-dark);}
    .bosk-trust .t i{color:var(--bosk-gold);font-size:18px;}

    /* =====================================================================
       Login popup modal
       ===================================================================== */
    .bosk-modal-overlay{
        position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;
        background:rgba(40,28,16,.55);backdrop-filter:blur(4px);
        opacity:0;visibility:hidden;transition:opacity .35s ease,visibility .35s ease;padding:18px;
    }
    .bosk-modal-overlay.open{opacity:1;visibility:visible;}
    .bosk-modal{
        background:#fff;width:100%;max-width:410px;border-radius:20px;padding:36px 32px;position:relative;
        box-shadow:0 30px 70px -20px rgba(0,0,0,.5);
        transform:translateY(40px) scale(.96);opacity:0;
    }
    .bosk-modal-overlay.open .bosk-modal{animation:boskPop .45s cubic-bezier(.21,1.02,.4,1) .05s forwards;}
    .bosk-modal-close{position:absolute;top:16px;right:18px;background:none;border:none;font-size:26px;line-height:1;
        color:#b0a896;cursor:pointer;transition:color .2s ease,transform .2s ease;}
    .bosk-modal-close:hover{color:var(--bosk-brown);transform:rotate(90deg);}
    .bosk-modal-icon{width:60px;height:60px;border-radius:50%;background:var(--bosk-soft);color:var(--bosk-brown);
        display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 16px;animation:boskPulse 2s infinite;}
    .bosk-modal h3{font-family:Montserrat,sans-serif;font-size:23px;font-weight:800;color:var(--bosk-dark);text-align:center;margin:0 0 6px;}
    .bosk-modal .sub{text-align:center;color:#8a8275;font-size:13.5px;margin-bottom:24px;}
    .bosk-field{position:relative;margin-bottom:16px;}
    .bosk-field i{position:absolute;left:18px;top:50%;transform:translateY(-50%);color:var(--bosk-gold);font-size:15px;}
    .bosk-field input{width:100%;height:50px;border:1px solid #e2d9c9;border-radius:30px;padding:0 18px 0 46px;
        font-size:14.5px;color:var(--bosk-dark);outline:none;background:#fbf9f5;transition:border .25s ease,box-shadow .25s ease;}
    .bosk-field input:focus{border-color:var(--bosk-gold);box-shadow:0 0 0 4px rgba(194,167,115,.18);background:#fff;}
    .bosk-modal-submit{width:100%;height:50px;border:none;border-radius:30px;background:var(--bosk-brown);color:#fff;
        font-size:15px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;cursor:pointer;margin-top:4px;
        transition:background .25s ease,transform .2s ease;}
    .bosk-modal-submit:hover{background:var(--bosk-gold);transform:translateY(-2px);}
    .bosk-modal-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
    .bosk-modal-foot{text-align:center;margin-top:20px;font-size:13.5px;color:#8a8275;padding-top:18px;border-top:1px solid #f0eadf;}
    .bosk-modal-foot a{color:var(--bosk-brown);font-weight:700;}
    .bosk-modal-foot a:hover{color:var(--bosk-gold);text-decoration:underline;}
    .bosk-err{color:#e23b2e;font-size:13px;text-align:center;margin-top:12px;}

    /* =====================================================================
       Sidebar widgets (Best Sellers / Tags / Category)
       ===================================================================== */
    .bosk-side{animation:boskFadeUp .7s ease .25s both;}
    .bosk-widget{
        background:#fff;border-radius:18px;padding:24px 22px;margin-bottom:24px;
        box-shadow:0 18px 44px -28px rgba(83,42,26,.40);
        border:1px solid #f0eadf;
    }
    .bosk-wtitle{
        font-family:Montserrat,sans-serif;font-size:18px;font-weight:800;color:var(--bosk-dark);
        margin:0 0 20px;padding-bottom:12px;position:relative;display:flex;align-items:center;gap:10px;
    }
    .bosk-wtitle i{color:var(--bosk-gold);font-size:17px;}
    .bosk-wtitle::after{content:"";position:absolute;left:0;bottom:0;width:46px;height:3px;border-radius:3px;
        background:linear-gradient(90deg,var(--bosk-brown),var(--bosk-gold));}

    /* Best sellers */
    .bosk-seller{display:flex;align-items:center;gap:14px;padding:10px;border-radius:14px;margin-bottom:8px;
        transition:background .25s ease,transform .25s ease;position:relative;}
    .bosk-seller:last-child{margin-bottom:0;}
    .bosk-seller:hover{background:var(--bosk-soft);transform:translateX(4px);}
    .bosk-seller .thumb{width:66px;height:66px;border-radius:12px;overflow:hidden;flex-shrink:0;
        box-shadow:0 6px 16px -10px rgba(0,0,0,.5);background:var(--bosk-soft);}
    .bosk-seller .thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease;}
    .bosk-seller:hover .thumb img{transform:scale(1.1);}
    .bosk-seller .meta{min-width:0;}
    .bosk-seller .meta h6{font-family:Montserrat,sans-serif;font-size:14.5px;font-weight:700;color:var(--bosk-dark);
        margin:0 0 5px;line-height:1.3;}
    .bosk-seller:hover .meta h6{color:var(--bosk-brown);}
    .bosk-seller .meta .pr{font-family:Montserrat,sans-serif;font-size:15px;font-weight:800;color:var(--bosk-gold);margin:0;}
    .bosk-seller .meta .pr i{font-size:11px;margin-right:2px;}

    /* Tags */
    .bosk-tags{display:flex;flex-wrap:wrap;gap:10px;}
    .bosk-tags a{display:inline-block;font-size:13px;font-weight:600;color:var(--bosk-brown);
        background:var(--bosk-soft);border:1px solid #ece3d2;border-radius:30px;padding:7px 16px;
        transition:all .25s ease;}
    .bosk-tags a:hover{background:var(--bosk-brown);color:#fff;border-color:var(--bosk-brown);transform:translateY(-2px);}

    /* Category list */
    .bosk-catlist{list-style:none;margin:0;padding:0;}
    .bosk-catlist li{margin:0;}
    .bosk-catlist li a{display:flex;align-items:center;gap:10px;padding:12px 6px;font-size:14.5px;font-weight:600;
        color:#6b6457;border-bottom:1px solid #f3eee4;transition:all .25s ease;}
    .bosk-catlist li:last-child a{border-bottom:none;}
    .bosk-catlist li a i{color:var(--bosk-gold);font-size:13px;transition:transform .25s ease;}
    .bosk-catlist li a:hover{color:var(--bosk-brown);padding-left:14px;}
    .bosk-catlist li a:hover i{transform:translateX(3px);color:var(--bosk-brown);}

    /* Keep aside / global theme intact */
    img{max-width:100%;}
    </style>
</head>

<body class="inner-page">
    <!-- Wrapper -->
    <div id="wrapper">
       <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <section class="headings">
            <div class="text-heading">
                <div class="container">
                    <h1 class="text-center"><?php echo $pname;?></h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>PRODUCT</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->
        <?php
        // Safe defaults so the page still renders if the product id is missing/invalid.
        $product_id  = 0;
        $pname       = '';
        $pcategory   = '';
        $img1        = '';
        $img2        = '';
        $img3        = '';
        $img4        = '';
        $img5        = '';
        $description = '';
        $stock       = 0;
        $old_price   = '';
        $new_price   = '';
        $tags        = '';
        $sku         = '';

        if (!empty($decoded_id) && $decoded_id > 0) {
            $cmd    = "select * from products where id='" . (int)$decoded_id . "'";
            $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
            $row    = mysqli_fetch_array($result);

            if ($row) {
                $product_id  = $row['id'];
                $pname       = $row['pname'];
                $pcategory   = $row['pcategory'];
                $img1        = $row['img1'];
                $img2        = $row['img2'];
                $img3        = $row['img3'];
                $img4        = $row['img4'];
                $img5        = $row['img5'];
                $description = $row['description'];
                $stock       = $row['stock'];
                $old_price   = $row['old_price'];
                $new_price   = $row['new_price'];
                $tags        = $row['tags'];
                $sku         = $row['sku'];
            }
        }

        // Work out a discount percentage for the "save" badge (only when it makes sense).
        $discount_pct = 0;
        if (is_numeric($old_price) && is_numeric($new_price) && (float)$old_price > (float)$new_price && (float)$old_price > 0) {
            $discount_pct = (int) round(((float)$old_price - (float)$new_price) / (float)$old_price * 100);
        }

        // Keep only the images that actually exist so we never render blank "NO IMAGE" slots.
        // The DB stores a "noimg.jpg" placeholder for empty slots, so drop those too.
        $gallery = array_values(array_filter(
            [$img1, $img2, $img3, $img4, $img5],
            function ($v) {
                $v = trim((string)$v);
                if ($v === '') return false;
                return !preg_match('/^no[-_]?im(g|age)\b/i', $v); // skip noimg.jpg / no-image.* placeholders
            }
        ));
        if (empty($gallery)) { $gallery = [$img1 !== '' ? $img1 : 'noimg.jpg']; } // graceful fallback keeps the frame intact
        $alt_txt = htmlspecialchars($pname, ENT_QUOTES, 'UTF-8') . ' - Bosk Furniture';
        ?>
        <!-- START SECTION BLOG -->
        <section class="shop blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <!-- product-detail-start -->
                        <div class="product-stage">
                            <div class="bosk-pcard">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="product-imgs">
                                            <div class="img-display">
                                                <div class="img-frame">
                                                    <div class="img-showcase">
                                                        <?php foreach ($gallery as $g) { ?>
                                                            <img src="Admin/product_image/<?php echo $g; ?>" alt="<?php echo $alt_txt; ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (count($gallery) > 1) { ?>
                                            <div class="img-select">
                                                <?php foreach ($gallery as $i => $g) { ?>
                                                    <div class="img-item<?php echo $i === 0 ? ' active' : ''; ?>">
                                                        <a href="#" data-id="<?php echo $i + 1; ?>">
                                                            <img src="Admin/product_image/<?php echo $g; ?>" alt="<?php echo $alt_txt; ?>">
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="bosk-info">
                                            <?php if ($pcategory !== '') { ?>
                                                <span class="bosk-cat"><?php echo htmlspecialchars($pcategory, ENT_QUOTES, 'UTF-8'); ?></span>
                                            <?php } ?>
                                            <h1 class="bosk-title"><?php echo $pname;?></h1>

                                            <?php if ($stock > 0) { ?>
                                                <span class="bosk-stock in"><i class="fa fa-check-circle" aria-hidden="true"></i> In Stock</span>
                                            <?php } else { ?>
                                                <span class="bosk-stock out"><i class="fa fa-times-circle" aria-hidden="true"></i> Out of Stock</span>
                                            <?php } ?>

                                            <span class="bosk-sku">SKU: <b><?php echo $sku;?></b></span>

                                            <div class="bosk-price">
                                                <span class="now">₹<?php echo $new_price;?></span>
                                                <?php if ($old_price !== '' && $old_price != $new_price) { ?>
                                                    <span class="was">₹<?php echo $old_price;?></span>
                                                <?php } ?>
                                                <?php if ($discount_pct > 0) { ?>
                                                    <span class="save"><?php echo $discount_pct;?>% OFF</span>
                                                <?php } ?>
                                            </div>

                                            <div class="bosk-buy">
                                            <?php
                                            include_once"connect.php";

                                            if (isset($_SESSION['email'])) {
                                                $userEmail = $_SESSION['email'];

                                                $cmd1   = "select * from user where email='$userEmail'";
                                                $result1= mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                                $row1   = mysqli_fetch_array($result1);
                                                $user_id= isset($row1['id']) ? $row1['id'] : '';
                                            ?>
                                                <form onsubmit="return cart(this);" id="myform" method="post" enctype="multipart/form-data" class="cart">
                                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
                                                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id;?>">
                                                    <div class="bosk-qtyrow">
                                                        <label for="quantity">Quantity</label>
                                                        <div class="bosk-stepper">
                                                            <button type="button" onclick="boskQty(-1)" aria-label="Decrease quantity">&minus;</button>
                                                            <input type="number" name="quantity" id="quantity" min="1" max="10" step="1" value="1">
                                                            <button type="button" onclick="boskQty(1)" aria-label="Increase quantity">&plus;</button>
                                                        </div>
                                                        <?php if ($stock > 0) { ?>
                                                            <button name="submit" id="submit" class="bosk-cart-btn" type="submit"><span class="lnr lnr-cart"></span> Add to Cart</button>
                                                        <?php } ?>
                                                    </div>
                                                    <?php if ($stock <= 0) { ?>
                                                        <p class="bosk-note">* This product is currently out of stock and cannot be added to the cart.</p>
                                                    <?php } ?>
                                                    <div id="return"></div>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="bosk-qtyrow">
                                                    <label for="quantity">Quantity</label>
                                                    <div class="bosk-stepper">
                                                        <button type="button" onclick="boskQty(-1)" aria-label="Decrease quantity">&minus;</button>
                                                        <input type="number" name="quantity" id="quantity" min="1" max="10" step="1" value="1">
                                                        <button type="button" onclick="boskQty(1)" aria-label="Increase quantity">&plus;</button>
                                                    </div>
                                                    <?php if ($stock > 0) { ?>
                                                        <button type="button" class="bosk-cart-btn" onclick="openBoskLogin()"><span class="lnr lnr-cart"></span> Add to Cart</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="bosk-cart-btn" disabled><span class="lnr lnr-cart"></span> Out of Stock</button>
                                                    <?php } ?>
                                                </div>
                                                <p class="bosk-note">* Please sign in to add this product to your cart.</p>
                                            <?php
                                            }
                                            ?>
                                            </div>

                                            <div class="bosk-trust">
                                                <div class="t"><i class="fa fa-truck" aria-hidden="true"></i> Free Shipping</div>
                                                <div class="t"><i class="fa fa-shield" aria-hidden="true"></i> Quality Assured</div>
                                                <div class="t"><i class="fa fa-refresh" aria-hidden="true"></i> Easy Returns</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if (trim(strip_tags($description)) !== '') { ?>
                                <div class="bosk-desc" style="margin-top:34px;">
                                    <h4>Product Description</h4>
                                    <p><?php echo $description;?></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- product-detail-end -->
                    </div>
                    <aside class="col-lg-3 col-md-12">
                        <div class="bosk-side">

                            <div class="bosk-widget">
                                <h3 class="bosk-wtitle"><i class="fa fa-star" aria-hidden="true"></i> Best Sellers</h3>
                                <?php
                                include_once"connect.php";

                                $cmd2="select * from products where publish_date <= NOW() order by id Asc limit 3";
                                $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                while($row2=mysqli_fetch_array($result2))
                                {
                                    $product_id1 = $row2['id'];
                                    $pname2=$row2['pname'];
                                    $pcategory2=$row2['pcategory'];
                                    $img12=$row2['img1'];
                                    $img22=$row2['img2'];
                                    $img32=$row2['img3'];
                                    $img42=$row2['img4'];
                                    $img52=$row2['img5'];
                                    $description2=$row2['description'];
                                    $stock2=$row2['stock'];
                                    $old_price2=$row2['old_price'];
                                    $new_price2=$row2['new_price'];
                                    $tags2=$row2['tags'];
                                ?>
                                <a class="bosk-seller" href="product.php?astringdata=<?php echo $row2['id']; ?>">
                                    <span class="thumb"><img src="Admin/product_image/<?php echo $img12;?>" alt="<?php echo htmlspecialchars(isset($row2['pname']) ? $row2['pname'] : 'Related product', ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture" loading="lazy" decoding="async"></span>
                                    <span class="meta">
                                        <h6><?php echo $pname2;?></h6>
                                        <p class="pr"><i class="fa fa-inr" aria-hidden="true"></i><?php echo $new_price2;?></p>
                                    </span>
                                </a>
                                <?php
                                }
                                ?>
                            </div>

                            <?php if (isset($tags2) && trim((string)$tags2) !== '') { ?>
                            <div class="bosk-widget">
                                <h3 class="bosk-wtitle"><i class="fa fa-tags" aria-hidden="true"></i> Popular Tags</h3>
                                <div class="bosk-tags">
                                    <a href="#"><?php echo $tags2;?></a>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="bosk-widget">
                                <h3 class="bosk-wtitle"><i class="fa fa-th-large" aria-hidden="true"></i> Category</h3>
                                <ul class="bosk-catlist">
                                    <?php
                                         include_once"connect.php";

                                          $cmd4="select * from category";
                                          $result4=mysqli_query($con,$cmd4) or die(mysqli_error($con));
                                          while($row4=mysqli_fetch_array($result4))
                                          {
                                              $categoryid = $row4['id'];
                                              $name=$row4['name'];
                                          ?>
                                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i><?php echo $name;?></a></li>
                                    <?php
                                          }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
        <!-- END SECTION BLOG -->

     <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>

        <!-- ===== Login Popup Modal ===== -->
        <div id="boskLoginModal" class="bosk-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="boskLoginTitle">
            <div class="bosk-modal">
                <button type="button" class="bosk-modal-close" onclick="closeBoskLogin()" aria-label="Close">&times;</button>
                <div class="bosk-modal-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                <h3 id="boskLoginTitle">Welcome Back</h3>
                <p class="sub">Sign in to add this item to your cart</p>
                <form id="boskLoginForm">
                    <div class="bosk-field">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <input type="email" id="bosk_login_email" name="email" placeholder="Email address" required>
                    </div>
                    <div class="bosk-field">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input type="password" id="bosk_login_pwd" name="pwd" placeholder="Password" required>
                    </div>
                    <button type="submit" id="bosk_login_btn" class="bosk-modal-submit">Sign In</button>
                    <div id="bosk_login_return"></div>
                </form>
                <div class="bosk-modal-foot">
                    New to Bosk Furniture? <a href="register.php">Create now</a>
                </div>
            </div>
        </div>

        <!-- ARCHIVES JS -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mmenu.min.js"></script>
        <script src="js/mmenu.js"></script>
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/lightcase.js"></script>
        <script src="js/owl.carousel.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/inner-script.js"></script>
        <script>
            // ---- Gallery slide (unchanged behaviour) ----
            const imgs = document.querySelectorAll('.img-select a');
            const imgBtns = [...imgs];
            let imgId = 1;

            imgBtns.forEach((imgItem) => {
                imgItem.addEventListener('click', (event) => {
                    event.preventDefault();
                    imgId = imgItem.dataset.id;
                    document.querySelectorAll('.img-item').forEach((it) => it.classList.remove('active'));
                    const parent = imgItem.closest('.img-item');
                    if (parent) parent.classList.add('active');
                    slideImage();
                });
            });

            function slideImage(){
                const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
                document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
            }
            window.addEventListener('resize', slideImage);

            // ---- Quantity stepper ----
            function boskQty(step){
                var q = document.getElementById('quantity');
                if(!q) return;
                var v = parseInt(q.value, 10) || 1;
                var min = parseInt(q.min, 10) || 1;
                var max = parseInt(q.max, 10) || 99;
                v += step;
                if(v < min) v = min;
                if(v > max) v = max;
                q.value = v;
            }

            // ---- Login popup ----
            function openBoskLogin(){
                document.getElementById('boskLoginModal').classList.add('open');
                document.body.style.overflow = 'hidden';
            }
            function closeBoskLogin(){
                document.getElementById('boskLoginModal').classList.remove('open');
                document.body.style.overflow = '';
            }
            // Close on overlay click / Esc
            document.getElementById('boskLoginModal').addEventListener('click', function(e){
                if(e.target === this) closeBoskLogin();
            });
            document.addEventListener('keydown', function(e){
                if(e.key === 'Escape') closeBoskLogin();
            });

            // ---- Login submit via AJAX (mirrors the existing signin flow) ----
            $('#boskLoginForm').on('submit', function(e){
                e.preventDefault();
                var email = $('#bosk_login_email').val();
                var pwd   = $('#bosk_login_pwd').val();
                if(email === '' || pwd === ''){
                    $('#bosk_login_return').html('<p class="bosk-err">Please fill in all fields.</p>');
                    return;
                }
                $.ajax({
                    url: 'back/signin.php',
                    method: 'POST',
                    data: { email: email, pwd: pwd },
                    beforeSend: function(){
                        $('#bosk_login_btn').prop('disabled', true).text('Signing in...');
                        $('#bosk_login_return').html('');
                    },
                    success: function(data){
                        // On success signin.php redirects; on failure it shows a toastr error.
                        $('#bosk_login_return').fadeIn().html(data);
                        $('#bosk_login_btn').prop('disabled', false).text('Sign In');
                        // Reload so a successful session re-renders the page with the cart form.
                        setTimeout(function(){ location.reload(true); }, 2500);
                    }
                });
            });
        </script>
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });
        </script>

    </div>
    <!-- Wrapper / End -->
     <script src="toastr/toastr.min.js"></script>
    <script src="js/add/addtocart.js"></script>
</body>

</html>
<?php

}
?>

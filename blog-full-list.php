<?php
$page_title       = 'Furniture &amp; Interior Design Blog | Bosk Furniture';
$page_description = 'Explore the Bosk Furniture blog for furniture trends, interior design tips, modular kitchen ideas and home decor inspiration for Indian homes.';
$page_keywords    = 'furniture blog, interior design blog india, modular kitchen ideas, home decor tips, bosk furniture blog';
$page_canonical   = '/blog-full-list';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog-full-list']
];
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <style>
        /* ============ BLOG LISTING CARDS ============ */
        .blog-section { padding: 60px 0 80px; }
        .blog-section .blog-card {
            position: relative;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.06);
            transition: transform .45s cubic-bezier(.25,.8,.25,1),
                        box-shadow .45s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .blog-section .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 22px 44px rgba(0, 0, 0, 0.18);
        }
        .blog-section .blog-card-img {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 10;
            background: #f3efec;
            display: block;
        }
        .blog-section .blog-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .9s cubic-bezier(.25,.8,.25,1), filter .5s ease;
        }
        .blog-section .blog-card:hover .blog-card-img img {
            transform: scale(1.12);
            filter: brightness(.88);
        }
        .blog-section .blog-card-img::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(83,42,26,.55) 0%, rgba(0,0,0,0) 55%);
            opacity: 0;
            transition: opacity .5s ease;
        }
        .blog-section .blog-card:hover .blog-card-img::after { opacity: 1; }

        .blog-section .blog-date-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: #532A1A;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .5px;
            line-height: 1.2;
            z-index: 2;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0,0,0,.22);
            transition: transform .4s ease;
        }
        .blog-section .blog-card:hover .blog-date-badge { transform: translateY(-3px); }

        .blog-section .blog-card-body {
            padding: 22px 24px 26px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .blog-section .blog-meta {
            font-size: 12px;
            color: #888;
            letter-spacing: .4px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .blog-section .blog-meta i {
            color: #532A1A;
            margin-right: 5px;
        }
        .blog-section .blog-card-body h3 {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.35;
            margin: 0 0 12px;
            color: #222;
            transition: color .35s ease;
        }
        .blog-section .blog-card-body h3 a {
            color: inherit;
            text-decoration: none;
        }
        .blog-section .blog-card:hover .blog-card-body h3 { color: #532A1A; }

        .blog-section .blog-card-body p {
            font-size: 14px;
            line-height: 1.65;
            color: #666;
            margin: 0 0 18px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .blog-section .blog-read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #532A1A;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none !important;
            margin-top: auto;
            width: fit-content;
        }
        .blog-section .blog-read-more::after {
            content: "→";
            display: inline-block;
            transition: transform .35s ease;
        }
        .blog-section .blog-read-more:hover { color: #211610; }
        .blog-section .blog-read-more:hover::after { transform: translateX(6px); }

        @media (max-width: 575px) {
            .blog-section .blog-card-body { padding: 18px 18px 22px; }
            .blog-section .blog-card-body h3 { font-size: 17px; }
        }
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
                    <h1 class="text-center">BLOG</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>BLOG</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        <!-- START SECTION BLOG -->
        <section class="blog-section">
            <div class="container">
                <div class="row">
                    <?php
                    include_once"connect.php";

                    $cmd = "select * from blog where blog_date <= NOW() order by id DESC";
                    $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
                    while ($row = mysqli_fetch_array($result)) {
                        $id              = $row['id'];
                        $blog_title      = $row['blog_title'];
                        $blog_description = $row['blog_description'];
                        $blog_date       = $row['blog_date'];
                        $img             = $row['img'];
                    ?>
                    <div class="col-lg-4 col-md-6 col-12 mt-4" data-aos="fade-up">
                        <article class="blog-card">
                            <a href="details.php?astringdata=<?php echo $id; ?>" class="blog-card-img">
                                <img src="Admin/blog_image/<?php echo $img;?>" alt="<?php echo htmlspecialchars($blog_title); ?>">
                                <span class="blog-date-badge"><?php echo ($blog_date ? date('Y-m-d', strtotime($blog_date)) : '');?></span>
                            </a>
                            <div class="blog-card-body">
                                <div class="blog-meta">
                                    <i class="fa fa-user"></i> By Admin
                                </div>
                                <h3>
                                    <a href="details.php?astringdata=<?php echo $id; ?>"><?php echo $blog_title;?></a>
                                </h3>
                                <p><?php echo strip_tags($blog_description);?></p>
                                <a href="details.php?astringdata=<?php echo $id; ?>" class="blog-read-more">Read more </a>
                            </div>
                        </article>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- END SECTION BLOG -->

        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->
</body>

</html>
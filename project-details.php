<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");
require_once __DIR__ . '/inc/urls.php';

$project_name = '';
$project_slug = '';
$decoded_id   = 0;

// ---- Resolve the project -------------------------------------------------
// Primary key is the slug (/project-<slug>). The legacy ?astringdata form
// still resolves, but 301s to the slug URL.
if (isset($_GET['slug']) && $_GET['slug'] !== '') {

    $stmt = mysqli_prepare($con, "SELECT id FROM projects WHERE slug=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $_GET['slug']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $_found_id);
    if (mysqli_stmt_fetch($stmt)) { $decoded_id = (int) $_found_id; }
    mysqli_stmt_close($stmt);

    if ($decoded_id === 0) {
        http_response_code(404);
        include __DIR__ . '/404.php';
        exit;
    }

} elseif (isset($_GET['astringdata'])) {

    // base64_decode() output was previously interpolated straight into SQL.
    // Accept it only when it decodes to a plain integer.
    $maybe      = base64_decode((string)$_GET['astringdata'], true);
    $decoded_id = ($maybe !== false && ctype_digit($maybe)) ? (int) $maybe : 0;

    if ($decoded_id > 0 && ($legacy_slug = bosk_slug_for($con, 'projects', $decoded_id))) {
        header('Location: ' . bosk_base_path() . url_project($legacy_slug), true, 301);
        exit;
    }
}

if ($decoded_id === 0) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$cmd3    = "select * from projects where id='" . $decoded_id . "'";
$result3 = mysqli_query($con, $cmd3) or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result3)) {
    $project_name = $row['project_name'];
    $project_slug = isset($row['slug']) ? $row['slug'] : '';
}

// ---- Dynamic SEO for project ----
$_seo_proj  = $project_name !== '' ? $project_name : 'Project';
$_seo_path  = '/' . ($project_slug !== '' ? url_project($project_slug) : 'projects');

$_proj_suffix     = ' | BOSK Furniture Projects';
$page_title       = (strlen($_seo_proj . $_proj_suffix) <= 60) ? $_seo_proj . $_proj_suffix : $_seo_proj;
$page_description = 'See the ' . $_seo_proj . ' interior project by BOSK Furniture — made-to-order modular units in marine-grade IS:710 plywood, installed on site in Gujarat.';
$page_keywords    = $_seo_proj . ', interior design project, modular furniture project, bosk furniture portfolio india';
$page_canonical   = $_seo_path;
$page_breadcrumbs = [
    ['name' => 'Home',     'url' => '/'],
    ['name' => 'Projects', 'url' => '/projects'],
    ['name' => $_seo_proj, 'url' => $_seo_path]
];
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
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
                    <h1 class="text-center"><?php echo $project_name;?></h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="/">Home</a><span>»</span><span>PROJECT DETAILS</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->
        <?php
        include_once"connect.php";
        $cmd="select * from projects where id='$decoded_id'";
        $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
               $row = mysqli_fetch_assoc($result);                        
                $id = $row['id'];
                $project_name=$row['project_name'];
                $pro_desc=$row['pro_desc'];
                $interior_detail=$row['interior_detail'];
                $img1=$row['img1'];
                $img2=$row['img2'];
                                     
        ?>
        <!-- START SECTION PROJECTS SINGLE -->
        <section class="service-details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 project-info">
                        <div class="row">
                            <div class="col-md-12 hover-effect">
                                <figure><img src="admin/project_image/<?php echo $img1;?>" alt="<?php echo htmlspecialchars(isset($project_name) ? $project_name : 'Bosk Furniture project', ENT_QUOTES, 'UTF-8'); ?> - Design planning by Bosk Furniture" loading="eager" decoding="async"></figure>
                                <div class="project-text">
                                    <h3 class="mt-3">Design Planning</h3>
                                    
                                    <p class="mb-4"><?php echo $pro_desc;?></p>

                                    <h3 class="mt-4">Interior Detail</h3>
                                    <img src="admin/project_image/<?php echo $img2;?>" class="mb-3" alt="<?php echo htmlspecialchars(isset($project_name) ? $project_name : 'Bosk Furniture project', ENT_QUOTES, 'UTF-8'); ?> - Interior detail by Bosk Furniture" loading="lazy" decoding="async">
                                    <p class="mb-4"><?php echo $interior_detail;?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <aside class="col-lg-3 col-md-12">
                        <div class="widget-service-details car">
                           
                            <div class="business-service py-5">
                                <h5 class="font-weight-bold mb-4">Recent Works</h5>
                                <?php
                                 include_once"connect.php";
                                 $count=0;
                                  $cmd="select * from projects order by id desc limit 12";
                                  $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                  while($row=mysqli_fetch_array($result))
                                  {     
                                      $id = $row['id'];
                                      $count=$count+1;
                                      $project_name=$row['project_name'];
                                      $pro_desc=$row['pro_desc'];
                                      $interior_detail=$row['interior_detail'];
                                      $img1=$row['img1'];
                                      $img2=$row['img2'];
                                      $encode_project_id=base64_encode($id);
                                     
                                  ?>
                                <div class="recent-main">
                                    <div class="recent-img">
                                        <a href="<?php echo url_project($row['slug']); ?>"><img src="admin/project_image/<?php echo $img1;?>" alt="<?php echo htmlspecialchars($project_name, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture project" loading="lazy" decoding="async"></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="<?php echo url_project($row['slug']); ?>"><h6><?php echo $project_name;?></h6></a>
                                        <a style="text-decoration:underline;" href="<?php echo url_project($row['slug']); ?>"><b>Learn More</b></a>
                                    </div>
                                </div><br/>
                                <?php
                                  }
                                ?>
                               
                               
                            </div>
                            <div class="business-service">
                                <h5 class="font-weight-bold mb-4">Popolar Tags</h5>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Renovation</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Interior</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Building</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Electrician</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Exterior Design</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Plumber</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Carpenter</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Construction</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Remodeling</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Painting</a></span>
                                </div>
                            </div>
                            </div>
                    </aside>
                </div>
            </div>
        </section>
        <!-- END SECTION PROJECTS SINGLE -->

       <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->
</body>

</html>

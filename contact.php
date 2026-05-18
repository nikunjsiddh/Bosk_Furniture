<?php
$page_title       = 'Contact Bosk Furniture | Get a Free Furniture Quote in India';
$page_description = 'Contact Bosk Furniture for modular kitchens, wardrobes, sofas and custom interior furniture. Request a free quote, design consultation or visit our showroom across India.';
$page_keywords    = 'contact bosk furniture, furniture quote india, modular furniture consultation, interior design enquiry, furniture showroom india';
$page_canonical   = '/contact.php';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ContactPage",
      "name": "Contact Bosk Furniture",
      "url": "https://www.boskfurniture.com/contact.php",
      "description": "Get in touch with Bosk Furniture for quotes, consultations and support.",
      "mainEntity": {
        "@type": "Organization",
        "name": "Bosk Furniture",
        "url": "https://www.boskfurniture.com",
        "contactPoint": {
          "@type": "ContactPoint",
          "contactType": "customer service",
          "areaServed": "IN",
          "availableLanguage": ["English","Hindi"]
        }
      },
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {"@type":"ListItem","position":1,"name":"Home","item":"https://www.boskfurniture.com/"},
          {"@type":"ListItem","position":2,"name":"Contact Us","item":"https://www.boskfurniture.com/contact.php"}
        ]
      }
    }
    </script>
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
                    <h1 class="text-center">CONTACT US</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>CONTACT US</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        <!-- START SECTION CONTACT -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="section-title ml-3">
                    <h3>Have a Question?</h3>
                    <h2>CONTACT US</h2>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <form class="contact-form" onsubmit="return contact_us(this);" id="MyForm" method="post"
                            novalidate>


                            <div class="form-group">
                                <input type="text" required class="form-control input-custom input-full" name="name"
                                    placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control input-custom input-full" name="email"
                                    placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control input-custom input-full" name="phone"
                                    placeholder="Contact Number">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control textarea-custom input-full" id="ccomment" name="msg"
                                    required rows="8" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control input-custom input-full" name="img">
                            </div>
                            <div class="box bg-3">
                                <button type="submit" name="submit" id="submit-contact"
                                    style="color:white;background-color:#532A1A;border:2px solid #532A1A;"
                                    class="mt-5 btn btn-primary btn-lg">Submit</button>
                            </div>
                        </form>
                        <div id="return"></div>
                    </div>
                    <div class="col-md-4 info-touch">
                        <h4>Keep In Touch</h4>
                        <div class="my-info">
                            <div class="in1">
                                <div class="address">
                                    <p style="line-height:1.3rem;"><i class="fa fa-map-marker"
                                            aria-hidden="true"></i>5,Aryamaan Complex,</p>
                                    <p style="line-height:1.3rem;margin-top:-3.2rem;margin-left:4.0rem;"><br />Near
                                        Meghani Circle,<br />Sir Patanni
                                        Road,<br />Bhavnagar-364001,<br />Gujarat,India.</p>
                                </div>
                                <div class="email">
                                    <p><i class="fa fa-envelope" aria-hidden="true"></i>boskinfracon@gmail.com</p>
                                </div>
                            </div>
                            <div class="in1">
                                <div class="phone">
                                    <p><i class="fa fa-phone" aria-hidden="true"></i>+91 8866647777</p>
                                </div>
                                <div class="whatssap">
                                    <p><i class="fa fa-whatsapp" aria-hidden="true"></i>+91 9737817777</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION CONTACT -->

        <!-- START SECTION GOOGLE MAP -->
        <div class="container-fluid">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3705.3028986343984!2d72.1515687748684!3d21.76853506196049!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395f5a632fce3c6b%3A0xb282e0e99abdf9db!2sBosk%20Furniture!5e0!3m2!1sen!2sin!4v1699514789660!5m2!1sen!2sin"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <!-- END SECTION GOOGLE MAP -->

        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8kOYB_m_UPPC2xnEd7ddYKww8jO1819k"></script>
        <script src="js/map.js"></script>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>


    </div>
    <!-- Wrapper / End -->
    <script src="js/add/contact.js"></script>
</body>

</html>
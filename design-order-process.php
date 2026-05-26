<?php
$page_title       = 'How to Order Custom Furniture | Bosk Furniture';
$page_description = 'Step-by-step guide to ordering custom and modular furniture from Bosk Furniture — design consultation, manufacturing, delivery and installation in India.';
$page_keywords    = 'custom furniture process, how to order furniture, furniture design process, bosk furniture ordering';
$page_canonical   = '/design-order-process';
$page_breadcrumbs = [
    ['name' => 'Home',         'url' => '/'],
    ['name' => 'How It Works', 'url' => '/design-order-process']
];
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Sora:wght@100;200;300;400;500;600;700&display=swap");
body {
    background: #fafafa;
}
.accordion {
    display: flex;
    flex-direction: column;
    font-family: "Sora", sans-serif;
    max-width: 1310px;
    min-width: 320px;
    margin: 50px auto;
    padding: 0 50px;
}
.accordion h1 {
    font-size: 32px;
    text-align: center;
}
.accordion-item {
    margin-top: 16px;
    border: 1px solid #fcfcfc;
    border-radius: 6px;
    background: #ffffff;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
}
.accordion-item .accordion-item-title {
    position: relative;
    margin: 0;
    display: flex;
    width: 100%;
    font-size: 18px;
    cursor: pointer;
    justify-content: space-between;
    flex-direction: row-reverse;
    padding: 14px 20px;
    box-sizing: border-box;
    align-items: center;
}
.accordion-item .accordion-item-desc {
    display: none;
    font-size: 18px;
    line-height: 47px;
    font-weight: 300;
    color: #444;
    border-top: 1px dashed #ddd;
    padding: 10px 20px 20px;
    box-sizing: border-box;
}
.accordion-item input[type="checkbox"] {
    position: absolute;
    height: 0;
    width: 0;
    opacity: 0;
}
.accordion-item input[type="checkbox"]:checked ~ .accordion-item-desc {
    display: block;
}
.accordion-item
    input[type="checkbox"]:checked
    ~ .accordion-item-title
    .icon:after {
    content: "-";
    font-size: 20px;
}
.accordion-item input[type="checkbox"] ~ .accordion-item-title .icon:after {
    content: "+";
    font-size: 20px;
}
.accordion-item:first-child {
    margin-top: 0;
}
.accordion-item .icon {
    margin-left: 14px;
}

@media screen and (max-width: 767px) {
    .accordion {
        padding: 0 16px;
    }
    .accordion h1 {
        font-size: 22px;
    }
}
    </style>
</head>

<body class="inner-page">
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->
        <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <section class="headings">
            <div class="text-heading">
                <div class="container">
                    <h1 class="text-center">How It Works</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>How It Works</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        <!-- START SECTION ABOUT -->
        <section class="who-we-are">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-6 who-1">
                        <div>
                            <h2 class="text-left mb-4">How It Works</h2>
                        </div>
                        <div  class="pftext">
                            <p style="line-height: 45px;">Your exciting project is about to begin! Together, <br/><b>we'll bring your vision and requirements to reality.</b></p>

                            <p style="line-height: 45px;">We recognize the importance of managing both your time and budget effectively. Having access to comprehensive information simplifies the process of making significant decisions. Despite the seemingly daunting nature of a customized project, our proficient team will manage every aspect seamlessly. Below, you'll discover a thorough breakdown of each stage within our order and design process, starting from initial contact to final installation. This overview ensures clarity on what to anticipate should you opt for Bosk to spearhead your project.
                            </p>
                        </div>
                       
                    </div>
                    <div class="col-md-6 who">
                        <img src="images/bg/1.png" alt="Bosk Furniture design and order process - end-to-end project workflow" loading="eager" decoding="async">
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION ABOUT -->

        <!-- START SECTION SERVICES -->
        <section class="all-services bg-white-2">
            <div class="container-fluid">
                <div class="accordion">
                <div class="accordion-item">
                    <input type="checkbox" id="accordion1">
                    <label for="accordion1" class="accordion-item-title"><span class="icon"></span><b>Step 1: Enquiry</b></label>
                    <div class="accordion-item-desc">Please provide further details about your project by completing our inquiry form. Our team will reach out to you at a time that suits you best to delve deeper into your requirements. <br/>If you're unsure about specific design details right now, don't fret. We'll guide you through these during subsequent discussions, including during site visits and design development stages. <br/>Need some inspiration? Explore our portfolio for ideas.</div>
                </div>
            
                <div class="accordion-item">
                    <input type="checkbox" id="accordion2">
                    <label for="accordion2" class="accordion-item-title"><span class="icon"></span><b>Step 2: Estimate and Quote Confirmation</b></label>
                    <div class="accordion-item-desc">After your initial discussion with our team, your project undergoes internal review by our designer-makers. We offer any relevant design insights or suggestions, along with an estimated cost for your project based on our discussions and an outline of our current timeline.<br/>Following this, you can schedule another call or arrange a visit to our showroom. During your visit, we can take you on a tour of our workshop where you'll have the chance to meet some of our team members and view any ongoing projects. We'll address any further inquiries you might have and delve deeper into your project details. Additionally, we'll finalize the specifics for your formal quote, which will be provided after our meeting.<br/>This quote will include:<br/>
                    • A transparent breakdown of costs, including potential delivery and installation fees<br/>
                    • Detailed project notes that have been confirmed<br/>
                    • Lead times, calculated from the date of deposit receipt and contingent upon our workshop's current capacity and availability, as well as the project's scope.<br/>Any additional charges arising during the project will be communicated clearly in advance, empowering you to make informed decisions that align with your budget.</div>
                </div>
            
                <div class="accordion-item">
                    <input type="checkbox" id="accordion3">
                   <label for="accordion3" class="accordion-item-title"><span class="icon"></span><b>Step 3: Invoice and Deposit</b></label>
                    <div class="accordion-item-desc">Having selected Bosk for your project and upon acceptance of your quote, we'll generate your deposit invoice. Payments will be structured in installments to facilitate cash flow management throughout the project's progression. Please review the breakdown below.<br/>• 30% deposit: includes site visit (if applicable), design submission, and development<br/>
                    • 30% upon design confirmation<br/>
                    • 30% during manufacturing<br/>
                    • 10% balance post-delivery/installation<br/>Please note that installment arrangements may vary for projects totaling.<br/>Kindly verify that all details on the invoice are accurate, as it serves as a contract between you and Bosk. While financing options are not currently available, we're open to discussing tailored payment terms on a case-by-case basis. Timely settlement of each invoice is crucial to maintaining the project's schedule.</div>
                </div>
            
                <div class="accordion-item">
                    <input type="checkbox" id="accordion4">
                    <label for="accordion4" class="accordion-item-title"><span class="icon"></span><b>Step 4: Site Visit</b></label>
                    <div class="accordion-item-desc">Upon receipt of your deposit payment, you'll be paired with one of our skilled designer-makers who will accompany you through the next phase of your journey. Site visit bookings can be made once the deposit is processed, typically scheduled within 2-4 weeks, depending on project size and our current workload.<br/>Pre-Site Visit Preparations:<br/>
                    • Ensure the space is reasonably complete (e.g., minimum re-plastering) for the visit<br/>
                    • Maintain a clear, tidy environment; inform us of any ongoing works<br/>
                    • If the site isn't ready or accessible, we may need to reschedule the visit<br/>
                    • Initial design drafts require the site to be ready as mentioned above<br/>
                    • Failure to prepare the site adequately may result in additional costs.<br/>During the Visit:<br/>
                    • Thorough and precise measurements of the space will be conducted<br/>
                    • Comprehensive photos will be taken, noting specific details crucial for design integration<br/>
                    • Your designer-maker will continue the design dialogue, offering guidance and support to ensure your satisfaction with the outcome.</div>
                </div>
            
                <div class="accordion-item">
                    <input type="checkbox" id="accordion5">
                    <label for="accordion5" class="accordion-item-title"><span class="icon"></span><b>Step 5: Design Submission</b></label>
                    <div class="accordion-item-desc">After our site visit, your designated designer-maker will initiate the development of the preliminary concepts discussed. You can anticipate receiving the initial designs within 2-4 weeks of the site visit, adjusted according to your project's scope and intricacy. These designs will incorporate detailed drawings to help you envision the final result, encompassing all aspects of your space and furniture.<br/>Depending on the specifics of your project, we might offer multiple variations. Your feedback on these initial designs is highly valued.</div>
                </div>
                <div class="accordion-item">
                    <input type="checkbox" id="accordion6">
                    <label for="accordion6" class="accordion-item-title"><span class="icon"></span><b>Step 6: Design Development</b></label>
                    <div class="accordion-item-desc">Watch as your envisioned furniture transforms into reality! Our collaborative design discussions and refinement of your furniture concept are in full swing. We'll diligently accommodate any adjustments, customizing the 2D designs to align with your preferences while ensuring compatibility with our production procedures. The duration of this stage naturally varies based on your project's size, complexity, your feedback, and the number of iterations required.<br/>• For Type I projects, expect 2-3 rounds of design revisions<br/>
                    • For Type II projects, anticipate 2-5 rounds of design revisions<br/> Should additional revisions or a complete redesign of previously discussed and agreed-upon details be necessary, an additional fee per round will apply.<br/>Upon receiving your final approval on the design(s) and the 'Design Confirmation' payment, your project will be queued for manufacturing. Any delays in design confirmation may impact the manufacturing as well as the delivery and installation timelines.</div>
                </div>
                <div class="accordion-item">
                    <input type="checkbox" id="accordion7">
                    <label for="accordion7" class="accordion-item-title"><span class="icon"></span><b>Step 7: Manufacturing</b></label>
                    <div class="accordion-item-desc">All our projects are meticulously crafted at our Work/Shop located on 5,Aryamaan Complex,Near Meghani Circle,Sir Patannni Road,Bhavnagar-364001. We employ the finest quality raw materials, ethically sourced, to bring your vision to life. Our production manager will keep you updated on the project's progress and lead times from this point onward.<br/>• Your project now progresses to the digital phase of manufacturing, where parts and components are developed.<br/>
                    • Upon completion of this digital phase, we allocate the necessary raw materials for your project. Your 'Manufacturing' payment is now due, advancing your project into physical production.<br/>
                    • Your designated designer-maker collaborates closely with our skilled artisans at the Work/Shop, ensuring meticulous attention to detail and craftsmanship.<br/>
                    • Manufacturing lead times typically range between 12-16 weeks, subject to the project's size and complexity.<br/>
                    • Given the nature of our designs, prototyping certain features may be necessary before final manufacturing, potentially extending lead times. We'll communicate any such requirements during this stage.<br/>
                    • As your project nears completion of this stage, approximately 1-2 weeks in advance, we'll reach out to schedule delivery and installation.</div>
                </div>
                <div class="accordion-item">
                    <input type="checkbox" id="accordion8">
                    <label for="accordion8" class="accordion-item-title"><span class="icon"></span><b>Step 8: Delivery</b></label>
                    <div class="accordion-item-desc">Depending on your preferences, we offer two delivery options: either by our team or collection by you, the client.<br/>
                    • An estimated delivery cost can be included in the original quote (refer to Step 2).<br/>
                    • For deliveries within Bhavnagar: We collaborate with a trusted shipping team to ensure the safe delivery of your project.<br/>
                    • Deliveries outside of Bhavnagar: Depending on the location, we may need to engage an external provider for delivery.<br/>
                    • If you opt for collection, kindly ensure you bring protective materials like cardboard or blankets as packing is not included in the furniture cost.<br/>
                    • If you arrange your own collection, we cannot be held responsible for any resulting issues.<br/>
                    • For international shipping, we offer tailored quotes upon submission of an enquiry form.</div>
                </div>
                <div class="accordion-item">
                    <input type="checkbox" id="accordion9">
                    <label for="accordion9" class="accordion-item-title"><span class="icon"></span><b>Step 9: Installation</b></label>
                    <div class="accordion-item-desc">Your journey with us is reaching its final phase. Our skilled in-house team handles all installations, ensuring your project is completed to perfection. Some settling of the furniture may occur in the weeks following installation, and we provide appropriate after-care services to address any issues. We undertake any necessary adjustments to ensure your utmost satisfaction with your new furniture. Upon completion, we'll issue your 'Balance' invoice, due for payment within the following week.<br/>Thank you for entrusting us with your journey. We hope you adore your new furniture, and we look forward to welcoming you back soon for your next exciting project.</div>
            </div><br/>
            <center>
            <a href="contact.php"><button type="button" style="background-color:#532A1A !important;color:#ffffff !important;"  class="btn btn-primary btn-lg ">Start Your Project</button></a>
            </center>
            </div>
        </section><hr/>
        <!-- END SECTION SERVICES -->
        <!-- <section  class="who-we-are">-->
        <!--    <div style="margin-top:-5.8vw;" class="container-fluid">-->
        <!--        <div class="row">-->
                    
                   
        <!--            <div class="col-md-12 who">-->
        <!--                <img src="images/bg/about-us.jpg" alt="">-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</section>-->
        

       <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->
</body>

</html>

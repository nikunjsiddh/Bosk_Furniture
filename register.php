<?php
$page_title       = 'Register | Create Your Bosk Furniture Account';
$page_description = 'Create your free Bosk Furniture account to shop premium furniture online, save your favourites, track orders and get exclusive offers across India.';
$page_keywords    = 'bosk furniture register, create account, furniture signup india, new customer';
$page_canonical   = '/register.php';
$page_robots      = 'noindex, follow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        :root {
	 --color-white: #fff;
	 --color-light: #f1f5f9;
	 --color-black: #121212;
	 --color-night: #001632;
	 --color-red: #f44336;
	 --color-blue: #1a73e8;
	 --color-gray: #80868b;
	 --color-grayish: #dadce0;
	 --shadow-normal: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
	 --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
	 --shadow-large: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
 html {
	 font-size: 100%;
	 font-size-adjust: 100%;
	 box-sizing: border-box;
	 scroll-behavior: smooth;
}
 *, *::before, *::after {
	 padding: 0;
	 margin: 0;
	 box-sizing: inherit;
	 list-style: none;
	 list-style-type: none;
	 text-decoration: none;
	 -webkit-font-smoothing: antialiased;
	 -moz-osx-font-smoothing: grayscale;
	 text-rendering: optimizeLegibility;
}
 body {
     background-image:url(images/interior/p-2.png)!important;
     background-repeat:no-repeat!important;
     background-size:cover!important;
	 font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
	 font-size: 1rem;
	 font-weight: normal;
	 line-height: 1.5;
	 color: var(--color-black);
	 background: var(--color-light);
}
 a, button {
	 font-family: inherit;
	 font-size: inherit;
	 line-height: inherit;
	 cursor: pointer;
	 border: none;
	 outline: none;
	 background: none;
	 text-decoration: none;
}
 img {
	 display: block;
	 width: 100%;
	 height: auto;
	 object-fit: cover;
}
 .container {
	 display: flex;
	 justify-content: center;
	 align-items: center;
	 max-width: 80rem;
	 
	 width: 100%;
	 padding: 0 2rem;
	 margin: 0 auto;
}
 .ion-logo-apple {
	 font-size: 1.65rem;
	 line-height: inherit;
	 margin-right: 0.5rem;
	 color: var(--color-black);
}
 .ion-logo-google {
	 font-size: 1.65rem;
	 line-height: inherit;
	 margin-right: 0.5rem;
	 color: var(--color-red);
}
 .ion-logo-facebook {
	 font-size: 1.65rem;
	 line-height: inherit;
	 margin-right: 0.5rem;
	 color: var(--color-blue);
}
 .text {
	 font-family: inherit;
	 line-height: inherit;
	 text-transform: unset;
	 text-rendering: optimizeLegibility;
}
 .text-large {
	 font-size: 2rem;
	 font-weight: 600;
	 color: var(--color-black);
}
 .text-normal {
	 font-size: 1rem;
	 font-weight: 400;
	 color: var(--color-black);
}
 .text-links {
	 font-size: 1rem;
	 font-weight: 400;
	 color: var(--color-blue);
}
 .text-links:hover {
	 text-decoration: underline;
}
 .main .wrapper {
	 max-width: 28rem;
	 width: 100%;
	 margin: 2rem auto;
	 padding: 2rem 2.5rem;
	 border: none;
	 outline: none;
	 border-radius: 0.25rem;
	 color: var(--color-black);
	 background: var(--color-white);
	 box-shadow: var(--shadow-large);
}
 .main .wrapper .form {
	 width: 100%;
	 height: auto;
	 margin-top: 2rem;
}
 .main .wrapper .form .input-control {
	 display: flex;
	 align-items: center;
	 justify-content: space-between;
	 margin-bottom: 1.25rem;
}
 .main .wrapper .form .input-field {
	 font-family: inherit;
	 font-size: 1rem;
	 font-weight: 400;
	 line-height: inherit;
	 width: 100%;
	 height: auto;
	 padding: 0.75rem 1.25rem;
	 border: none;
	 outline: none;
	 border-radius: 2rem;
	 color: var(--color-black);
	 background: var(--color-light);
	 text-transform: unset;
	 text-rendering: optimizeLegibility;
}
 .main .wrapper .form .input-submit {
	 font-family: inherit;
	 font-size: 1rem;
	 font-weight: 500;
	 line-height: inherit;
	 cursor: pointer;
	 min-width: 40%;
	 height: auto;
	 padding: 0.65rem 1.25rem;
	 border: none;
	 outline: none;
	 border-radius: 2rem;
	 color: var(--color-white);
	 background: var(--color-blue);
	 box-shadow: var(--shadow-medium);
	 text-transform: capitalize;
	 text-rendering: optimizeLegibility;
}
 .main .wrapper .striped {
	 display: flex;
	 flex-direction: row;
	 justify-content: center;
	 align-items: center;
	 margin: 1rem 0;
}
 .main .wrapper .striped-line {
	 flex: auto;
	 flex-basis: auto;
	 border: none;
	 outline: none;
	 height: 2px;
	 background: var(--color-grayish);
}
 .main .wrapper .striped-text {
	 font-family: inherit;
	 font-size: 1rem;
	 font-weight: 500;
	 line-height: inherit;
	 color: var(--color-black);
	 margin: 0 1rem;
}
 .main .wrapper .method-control {
	 margin-bottom: 1rem;
}
 .main .wrapper .method-action {
	 font-family: inherit;
	 font-size: 0.95rem;
	 font-weight: 500;
	 line-height: inherit;
	 display: flex;
	 justify-content: center;
	 align-items: center;
	 width: 100%;
	 height: auto;
	 padding: 0.35rem 1.25rem;
	 outline: none;
	 border: 2px solid var(--color-grayish);
	 border-radius: 2rem;
	 color: var(--color-black);
	 background: var(--color-white);
	 text-transform: capitalize;
	 text-rendering: optimizeLegibility;
	 transition: all 0.35s ease;
}
 .main .wrapper .method-action:hover {
	 background: var(--color-light);
}
 
    </style>
</head>

<body class="homepage-1 int_white_bg">
    <!-- Wrapper -->
    <div id="wrapper">
     
    
        <div class="clearfix"></div>
        <!-- Header Container / End -->

      
        <main class="main">
	<div class="container">
		<section class="wrapper">
			<div class="heading">
				<h1 class="text text-large">Register</h1>
				<p class="text text-normal">Elevate Your Space: Join the Furniture Revolution!</span>
				</p>
			</div>
			<form onsubmit="return register(this);" id="myform" method="post" class="form">
			    <label for="email"> <b>First Name</b></label>
                 <input type="text" class="form-control" placeholder="Enter First Name" name="firstname" id="firstname" required>
                 <label for="email"> <b>Last Name</b></label>
                 <input type="text" class="form-control" placeholder="Enter Last Name" name="lastname" id="lastname" required>
				 <label for="email"> <b>Email</b></label>
                 <input type="text" class="form-control" placeholder="Enter Email" name="email" id="email" required>
                 <label for="password"><b>Password</b></label>
                 <input type="text" class="form-control" placeholder="Enter Password" name="password" id="password" required>
                 <label for="password"><b>Confirm Password</b></label>
                 <input type="text" class="form-control" placeholder="Enter Confirm Password" name="cpassword" id="cpassword" required>
                 <div  id="CheckPasswordMatch"></div>
				<center>
				<div class="input-control mt-2">
				
					<button type="submit" name="submit" class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">Register</button>
				</div>
				</center>
			</form>
		<div id="return"></div>
		</section>
	</div>
</main>
       
       

      

        <!-- START FOOTER -->
        <footer class="first-footer ">
            
            <div class="second-footer bg-white-3">
                <div class="container">
                    <p>2023 © Copyright - All Rights Reserved.</p>
                    <p>Powered <i class="fa fa-heart" aria-hidden="true"></i> By <a href="https://softwingz.com/" style="color:black !important;">SOFTWINGZ INFOTECH</a></p>
                </div>
            </div>
        </footer>

       
        <!-- END FOOTER -->

        <!-- START PRELOADER -->
        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
        <!-- END PRELOADER -->

        <!-- ARCHIVES JS -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mmenu.min.js"></script>
        <script src="js/mmenu.js"></script>
        <script src="js/aos.js"></script>
        <script src="js/aos2.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/slick.js"></script>
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/typed.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/lightcase.js"></script>
        <script src="js/owl.carousel.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        
        <script>
            $('.home5-right-slider').owlCarousel({
                loop: true,
                margin: 30,
                dots: false,
                nav: true,
                rtl: false,
                autoplayHoverPause: false,
                autoplay: false,
                singleItem: true,
                smartSpeed: 1200,
                navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
                responsive: {
                    0: {
                        items: 1,
                        center: false
                    },
                    480: {
                        items: 1,
                        center: false
                    },
                    520: {
                        items: 2,
                        center: false
                    },
                    600: {
                        items: 2,
                        center: false
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 5
                    },
                    1366: {
                        items: 5
                    },
                    1400: {
                        items: 5
                    }
                }
            });

        </script>
        
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>
        
        <script>
        var typed = new Typed('.typed', {
            strings: ["House ^2000", "Apartment ^2000", "Plaza ^4000"],
            smartBackspace: false,
            loop: true,
            showCursor: true,
            cursorChar: "|",
            typeSpeed: 50,
            backSpeed: 30,
            startDelay: 800
        });

    </script>

        <!-- Slider Revolution scripts -->
        <script src="revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.carousel.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.migration.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.parallax.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.video.min.js"></script>

        <!-- MAIN JS -->
        <script src="js/script.js"></script>
        
        <script src="js/add/register.js"></script>
          <script>
            $(document).ready(function () {
           $("#cpassword").on('keyup', function(){
            var password = $("#password").val();
            var confirmPassword = $("#cpassword").val();
            if (password != confirmPassword)
                $("#CheckPasswordMatch").html("Password does not match !").css("color","red");
            else
                $("#CheckPasswordMatch").html("Password match !").css("color","green");
           });
        });
</script>
        <script src="toastr/toastr.min.js"></script>
    </div>
    <!-- Wrapper / End -->
</body>

</html>

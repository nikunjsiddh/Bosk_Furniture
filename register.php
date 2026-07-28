<?php
$page_title       = 'Register | Create Your Bosk Furniture Account';
$page_description = 'Create your free Bosk Furniture account to shop premium furniture online, save your favourites, track orders and get exclusive offers across India.';
$page_keywords    = 'bosk furniture register, create account, furniture signup india, new customer';
$page_canonical   = '/register';
$page_robots      = 'noindex, follow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        :root{ --bf-brand:#532A1A; --bf-brand2:#7a4128; --bf-accent:#b8763f; }
        .bosk-auth *{box-sizing:border-box;}
        body{margin:0;}
        .bosk-auth{
            min-height:100vh; display:flex; align-items:center; justify-content:center; padding:48px 16px;
            font-family:'Poppins',"Segoe UI",Tahoma,sans-serif;
            background:
                linear-gradient(135deg, rgba(83,42,26,.72), rgba(38,19,11,.80)),
                url('images/about/bosk-furniture-shoppe.jpg') center center / cover no-repeat fixed;
        }
        .bosk-auth-card{
            width:100%; max-width:980px; display:grid; grid-template-columns:1fr 1.05fr;
            background:#fff; border-radius:22px; overflow:hidden;
            box-shadow:0 30px 70px rgba(83,42,26,.25);
            animation:bf-rise .6s cubic-bezier(.2,.7,.2,1) both;
        }
        @keyframes bf-rise{from{opacity:0;transform:translateY(26px) scale(.985);}to{opacity:1;transform:none;}}

        /* ---- Left brand panel ---- */
        .bosk-auth-left{
            position:relative; padding:46px 42px; color:#fff; overflow:hidden;
            background:linear-gradient(155deg,var(--bf-brand) 0%,var(--bf-brand2) 55%,var(--bf-accent) 135%);
            display:flex; flex-direction:column; justify-content:space-between; gap:26px;
        }
        .bosk-auth-left::before{content:"";position:absolute;width:340px;height:340px;right:-130px;top:-130px;background:radial-gradient(circle,rgba(255,255,255,.16),transparent 70%);border-radius:50%;}
        .bosk-auth-left::after{content:"";position:absolute;width:280px;height:280px;left:-110px;bottom:-120px;background:radial-gradient(circle,rgba(0,0,0,.18),transparent 70%);border-radius:50%;}
        .bf-logo{position:relative;z-index:2;width:150px;background:#fff;border-radius:14px;padding:12px 16px;box-shadow:0 12px 26px rgba(0,0,0,.22);}
        .bf-logo img{width:100%;height:auto;display:block;}
        .bf-welcome{position:relative;z-index:2;}
        .bf-welcome h2{font-size:30px;font-weight:700;line-height:1.22;margin:0 0 12px;}
        .bf-welcome p{opacity:.92;font-size:14.5px;line-height:1.7;margin:0;}
        .bf-points{list-style:none;padding:0;margin:22px 0 0;position:relative;z-index:2;}
        .bf-points li{display:flex;align-items:center;gap:11px;margin-bottom:13px;font-size:14px;opacity:.96;}
        .bf-points li i{flex:0 0 26px;width:26px;height:26px;border-radius:50%;background:rgba(255,255,255,.20);display:flex;align-items:center;justify-content:center;font-size:11px;}

        /* ---- Right form panel ---- */
        .bosk-auth-right{padding:44px 46px;}
        .bosk-auth-right h1{font-size:27px;font-weight:700;color:#1f1a17;margin:0 0 6px;}
        .bosk-auth-right .sub{color:#8a7d75;font-size:14px;margin:0 0 24px;}
        .bf-row2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
        .bf-field{margin-bottom:16px;}
        .bf-field label{display:block;font-size:12.5px;font-weight:600;color:#6c5a4e;margin-bottom:7px;}
        .bf-wrap{position:relative;}
        .bf-wrap > i{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#b8a99e;font-size:15px;}
        .bf-field input{
            width:100%;height:50px;padding:0 44px;border:1.6px solid #e7ddd4;border-radius:12px;
            font-size:14.5px;color:#3a2f28;background:#faf6f2;outline:none;transition:border-color .2s,box-shadow .2s,background .2s;
        }
        .bf-field input::placeholder{color:#bcaea3;}
        .bf-field input:focus{border-color:var(--bf-accent);background:#fff;box-shadow:0 0 0 4px rgba(184,118,63,.15);}
        .bf-err{color:#e23b3b;font-size:12px;margin-top:6px;line-height:1.35;display:flex;align-items:center;gap:5px;}
        .bf-field input.is-invalid{border-color:#e23b3b !important;background:#fff6f5;box-shadow:0 0 0 4px rgba(226,59,59,.12);}
        .bf-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;filter:none;}
        .bf-toggle{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#b8a99e;font-size:15px;padding:8px;}
        .bf-toggle:hover{color:var(--bf-brand);}
        .bf-submit{
            width:100%;height:52px;border:none;border-radius:12px;color:#fff;font-size:15.5px;font-weight:600;letter-spacing:.3px;margin-top:6px;cursor:pointer;
            background:linear-gradient(135deg,var(--bf-brand),var(--bf-accent));
            box-shadow:0 12px 24px rgba(83,42,26,.30);transition:transform .18s,box-shadow .18s,filter .18s;
        }
        .bf-submit:hover{transform:translateY(-2px);box-shadow:0 18px 32px rgba(83,42,26,.38);filter:brightness(1.06);}
        .bf-submit:active{transform:translateY(0);}
        .bf-alt{text-align:center;margin-top:20px;color:#8a7d75;font-size:14px;}
        .bf-alt a{color:var(--bf-brand);font-weight:600;}
        .bf-alt a:hover{color:var(--bf-accent);text-decoration:underline;}
        #return{margin-top:14px;}
        #return h4{font-size:14px;}
        @media(max-width:860px){
            .bosk-auth-card{grid-template-columns:1fr;max-width:460px;}
            .bosk-auth-left{display:none;}
            .bosk-auth-right{padding:38px 30px;}
        }
        @media(max-width:480px){ .bf-row2{grid-template-columns:1fr;} }
    </style>
</head>

<body class="homepage-1 int_white_bg">

    <main class="bosk-auth">
        <div class="bosk-auth-card">

            <!-- Brand panel -->
            <div class="bosk-auth-left">
                <div class="bf-logo"><img src="images/logo-black.png" alt="Bosk Furniture"></div>
                <div class="bf-welcome">
                    <h2>Create your<br>Bosk Furniture account</h2>
                    <p>Join Bosk Furniture to shop premium handcrafted furniture, save your favourite designs, and track your orders — all in one place.</p>
                    <ul class="bf-points">
                        <li><i class="fa fa-check"></i> Free account, takes a minute</li>
                        <li><i class="fa fa-check"></i> Wishlist &amp; order history</li>
                        <li><i class="fa fa-check"></i> Members-only offers</li>
                    </ul>
                </div>
            </div>

            <!-- Form panel -->
            <div class="bosk-auth-right">
                <h1>Create Account</h1>
                <p class="sub">Already a member? <a href="login" style="color:var(--bf-brand);font-weight:600;">Sign in here</a></p>

                <form onsubmit="return register(this);" id="myform" method="post" class="form">
                    <div class="bf-row2">
                        <div class="bf-field">
                            <label for="firstname">First Name</label>
                            <div class="bf-wrap">
                                <i class="fa fa-user-o"></i>
                                <input type="text" name="firstname" id="firstname" placeholder="First name" required>
                            </div>
                        </div>
                        <div class="bf-field">
                            <label for="lastname">Last Name</label>
                            <div class="bf-wrap">
                                <i class="fa fa-user-o"></i>
                                <input type="text" name="lastname" id="lastname" placeholder="Last name" required>
                            </div>
                        </div>
                    </div>
                    <div class="bf-field">
                        <label for="email">Email Address</label>
                        <div class="bf-wrap">
                            <i class="fa fa-envelope-o"></i>
                            <input type="email" name="email" id="email" placeholder="you@example.com" required>
                        </div>
                    </div>
                    <div class="bf-field">
                        <label for="password">Password</label>
                        <div class="bf-wrap">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Create a password" required>
                            <button type="button" class="bf-toggle" onclick="bfTogglePwd('password',this)" aria-label="Show password"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="bf-field">
                        <label for="cpassword">Confirm Password</label>
                        <div class="bf-wrap">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="cpassword" id="cpassword" placeholder="Re-enter password" required>
                            <button type="button" class="bf-toggle" onclick="bfTogglePwd('cpassword',this)" aria-label="Show password"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="bf-submit">Create Account</button>
                </form>

                <div id="return"></div>
                <p class="bf-alt">By creating an account you agree to our terms &amp; care policy.</p>
            </div>

        </div>
    </main>

    <!-- START FOOTER -->
    <?php include_once"design/footer.php";?>
    <!-- END FOOTER -->

    <!-- JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/add/register.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>
    <script>
        function bfTogglePwd(id, btn){
            var f = document.getElementById(id);
            var hidden = (f.type === 'password');
            f.type = hidden ? 'text' : 'password';
            btn.querySelector('i').className = hidden ? 'fa fa-eye-slash' : 'fa fa-eye';
        }
    </script>
</body>

</html>

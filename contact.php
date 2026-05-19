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
    <style>
        /* ============ CONTACT PAGE REDESIGN ============ */
        #contact.contact { padding: 70px 0 80px; background: #faf7f5; }
        #contact .section-title h2 { letter-spacing: 1.5px; }

        /* Form card */
        #contact .contact-form-wrap {
            background: #fff;
            padding: 36px 36px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(83, 42, 26, 0.08);
        }
        #contact .contact-form { margin: 0; }
        #contact .contact-form .form-group {
            position: relative;
            margin-bottom: 22px;
        }
        #contact .contact-form label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #532A1A;
            margin-bottom: 6px;
            letter-spacing: .3px;
            text-transform: uppercase;
        }
        #contact .contact-form label .req { color: #c0392b; margin-left: 2px; }

        #contact .contact-form .input-wrap {
            position: relative;
        }
        #contact .contact-form .input-wrap i {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #b89e92;
            font-size: 16px;
            pointer-events: none;
            transition: color .25s ease;
        }
        #contact .contact-form .input-wrap.textarea i {
            top: 18px;
            transform: none;
        }
        #contact .contact-form input.form-control,
        #contact .contact-form textarea.form-control {
            width: 100%;
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            color: #333;
            background: #fafafa;
            border: 1.5px solid #e8ddd6 !important;
            border-radius: 10px;
            outline: none;
            box-shadow: none !important;
            transition: border-color .3s ease, background .3s ease, box-shadow .3s ease;
        }
        #contact .contact-form textarea.form-control {
            padding: 14px 16px 14px 42px;
            resize: vertical;
            min-height: 140px;
            line-height: 1.5;
        }
        #contact .contact-form input.form-control:focus,
        #contact .contact-form textarea.form-control:focus {
            border-color: #532A1A !important;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(83, 42, 26, 0.08) !important;
        }
        #contact .contact-form input.form-control:focus ~ i,
        #contact .contact-form textarea.form-control:focus ~ i,
        #contact .contact-form .input-wrap:focus-within i {
            color: #532A1A;
        }
        #contact .contact-form input.form-control::placeholder,
        #contact .contact-form textarea.form-control::placeholder {
            color: #b0a39c;
        }

        /* File upload */
        #contact .contact-form .file-wrap {
            position: relative;
            border: 1.5px dashed #d6c3b8;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: border-color .3s ease, background .3s ease;
        }
        #contact .contact-form .file-wrap:hover {
            border-color: #532A1A;
            background: #fff;
        }
        #contact .contact-form .file-wrap input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        #contact .contact-form .file-wrap .file-label {
            color: #777;
            font-size: 13px;
        }
        #contact .contact-form .file-wrap .file-label i {
            color: #532A1A;
            font-size: 18px;
            margin-right: 6px;
            vertical-align: middle;
        }
        #contact .contact-form .file-wrap .file-name {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #532A1A;
            font-weight: 600;
        }

        /* Error styling */
        #contact .contact-form .form-group.has-error input.form-control,
        #contact .contact-form .form-group.has-error textarea.form-control {
            border-color: #c0392b !important;
            background: #fcf3f3;
        }
        #contact .contact-form .form-group.has-error .input-wrap i { color: #c0392b; }
        #contact .contact-form .error-msg {
            display: none;
            margin-top: 6px;
            font-size: 12px;
            color: #c0392b;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-4px);
            transition: opacity .25s ease, transform .25s ease;
        }
        #contact .contact-form .form-group.has-error .error-msg {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        #contact .contact-form .form-group.has-error .error-msg::before {
            content: "⚠  ";
            color: #c0392b;
        }

        /* Submit button */
        #contact .contact-form .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #6b3823 0%, #532A1A 60%, #3a1c10 100%) !important;
            color: #fff !important;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 13px 32px !important;
            border-radius: 10px !important;
            border: 0 !important;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(83, 42, 26, 0.28);
            transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
        }
        #contact .contact-form .btn-submit::after {
            content: "→";
            transition: transform .3s ease;
        }
        #contact .contact-form .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(83, 42, 26, 0.4);
        }
        #contact .contact-form .btn-submit:hover::after { transform: translateX(5px); }
        #contact .contact-form .btn-submit:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        /* Success message */
        #contact #return:not(:empty) {
            margin-top: 18px;
            padding: 14px 18px;
            background: #ecf7ed;
            border: 1.5px solid #b6dfb9;
            color: #1f6d28;
            border-radius: 10px;
            font-size: 14px;
        }

        /* Contact info card */
        #contact .info-touch {
            padding-left: 30px;
        }
        #contact .info-card {
            background: linear-gradient(135deg, #6b3823 0%, #532A1A 60%, #3a1c10 100%);
            color: #fff;
            padding: 36px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(83, 42, 26, 0.25);
            height: 100%;
        }
        #contact .info-card h4 {
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 22px;
            letter-spacing: .5px;
        }
        #contact .info-card .info-row {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        #contact .info-card .info-row:last-child { border-bottom: 0; }
        #contact .info-card .info-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            transition: background .3s ease, transform .3s ease;
        }
        #contact .info-card .info-row:hover .info-icon {
            background: #fff;
            color: #532A1A;
            transform: scale(1.08);
        }
        #contact .info-card .info-text {
            flex: 1;
            font-size: 14px;
            line-height: 1.5;
        }
        #contact .info-card .info-label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2px;
        }
        #contact .info-card .info-text a {
            color: #fff;
            text-decoration: none;
            transition: opacity .25s ease;
        }
        #contact .info-card .info-text a:hover { opacity: .8; }

        @media (max-width: 991px) {
            #contact .info-touch { padding-left: 15px; margin-top: 30px; }
        }
        @media (max-width: 575px) {
            #contact .contact-form-wrap { padding: 24px 20px 22px; }
            #contact .info-card { padding: 26px 22px; }
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
                    <div class="col-lg-8 col-md-7">
                        <div class="contact-form-wrap">
                            <form class="contact-form" onsubmit="return validateAndSubmitContact(this);" id="MyForm" method="post" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" data-field="name">
                                            <label for="cf-name">Full Name<span class="req">*</span></label>
                                            <div class="input-wrap">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <input type="text" id="cf-name" class="form-control" name="name" placeholder="Enter your full name" autocomplete="name">
                                            </div>
                                            <small class="error-msg"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" data-field="email">
                                            <label for="cf-email">Email Address<span class="req">*</span></label>
                                            <div class="input-wrap">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                <input type="email" id="cf-email" class="form-control" name="email" placeholder="you@example.com" autocomplete="email">
                                            </div>
                                            <small class="error-msg"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" data-field="phone">
                                    <label for="cf-phone">Contact Number<span class="req">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <input type="tel" id="cf-phone" class="form-control" name="phone" placeholder="10-digit mobile number" autocomplete="tel" maxlength="10" inputmode="numeric">
                                    </div>
                                    <small class="error-msg"></small>
                                </div>

                                <div class="form-group" data-field="msg">
                                    <label for="cf-msg">Your Message<span class="req">*</span></label>
                                    <div class="input-wrap textarea">
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <textarea id="cf-msg" class="form-control" name="msg" rows="6" placeholder="Tell us about your project, requirements or query..."></textarea>
                                    </div>
                                    <small class="error-msg"></small>
                                </div>

                                <div class="form-group" data-field="img">
                                    <label>Attach a Reference Image <small style="text-transform:none;font-weight:400;color:#888;">(optional, max 5MB, JPG/PNG)</small></label>
                                    <div class="file-wrap" id="cf-file-wrap">
                                        <span class="file-label">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                            Click to upload or drag a file here
                                        </span>
                                        <span class="file-name" id="cf-file-name"></span>
                                        <input type="file" id="cf-img" name="img" accept="image/jpeg,image/jpg,image/png">
                                    </div>
                                    <small class="error-msg"></small>
                                </div>

                                <button type="submit" name="submit" id="submit-contact" class="btn-submit">
                                    Send Message
                                </button>
                            </form>
                            <div id="return"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 info-touch">
                        <div class="info-card">
                            <h4>Keep In Touch</h4>
                            <div class="info-row">
                                <div class="info-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                <div class="info-text">
                                    <span class="info-label">Visit Us</span>
                                    5, Aryamaan Complex, Near Meghani Circle, Sir Patanni Road, Bhavnagar-364001, Gujarat, India.
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                <div class="info-text">
                                    <span class="info-label">Email</span>
                                    <a href="mailto:boskinfracon@gmail.com">boskinfracon@gmail.com</a>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                <div class="info-text">
                                    <span class="info-label">Call Us</span>
                                    <a href="tel:+918866647777">+91 88666 47777</a>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fa fa-whatsapp" aria-hidden="true"></i></div>
                                <div class="info-text">
                                    <span class="info-label">WhatsApp</span>
                                    <a href="https://wa.me/919737817777" target="_blank" rel="noopener">+91 97378 17777</a>
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
    <script>
    (function () {
        const form = document.getElementById('MyForm');
        if (!form) return;

        const fileInput = document.getElementById('cf-img');
        const fileNameOut = document.getElementById('cf-file-name');

        // Show selected file name + size in the upload box
        if (fileInput) {
            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const f = this.files[0];
                    const kb = (f.size / 1024).toFixed(1);
                    fileNameOut.textContent = f.name + ' (' + kb + ' KB)';
                } else {
                    fileNameOut.textContent = '';
                }
                validateField('img', true);
            });
        }

        // Validation rules
        const rules = {
            name: function (v) {
                if (!v.trim()) return 'Please enter your name.';
                if (v.trim().length < 2) return 'Name must be at least 2 characters.';
                if (!/^[A-Za-z\s.'-]{2,60}$/.test(v.trim())) return 'Only letters, spaces and . \' - are allowed.';
                return '';
            },
            email: function (v) {
                if (!v.trim()) return 'Please enter your email address.';
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim())) return 'Please enter a valid email address.';
                return '';
            },
            phone: function (v) {
                if (!v.trim()) return 'Please enter your contact number.';
                if (!/^[6-9]\d{9}$/.test(v.trim())) return 'Enter a valid 10-digit Indian mobile number.';
                return '';
            },
            msg: function (v) {
                if (!v.trim()) return 'Please type a message.';
                if (v.trim().length < 10) return 'Message should be at least 10 characters.';
                if (v.trim().length > 1000) return 'Message must be under 1000 characters.';
                return '';
            },
            img: function () {
                const f = fileInput && fileInput.files && fileInput.files[0];
                if (!f) return ''; // optional
                const okTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (okTypes.indexOf(f.type) === -1) return 'Only JPG or PNG images are allowed.';
                if (f.size > 5 * 1024 * 1024) return 'File size must be under 5 MB.';
                return '';
            }
        };

        function getGroup(field) {
            return form.querySelector('.form-group[data-field="' + field + '"]');
        }

        function showError(field, msg) {
            const g = getGroup(field);
            if (!g) return;
            const errEl = g.querySelector('.error-msg');
            if (msg) {
                g.classList.add('has-error');
                if (errEl) errEl.textContent = msg;
            } else {
                g.classList.remove('has-error');
                if (errEl) errEl.textContent = '';
            }
        }

        function validateField(field, silent) {
            const rule = rules[field];
            if (!rule) return true;
            const input = form.querySelector('[name="' + field + '"]');
            const value = input ? (input.value || '') : '';
            const msg = rule(value);
            if (!silent || msg === '') showError(field, msg);
            return msg === '';
        }

        function validateAll() {
            let ok = true;
            Object.keys(rules).forEach(function (f) {
                if (!validateField(f)) ok = false;
            });
            return ok;
        }

        // Live validation: clear error on input, validate on blur
        Object.keys(rules).forEach(function (f) {
            const input = form.querySelector('[name="' + f + '"]');
            if (!input) return;
            input.addEventListener('input', function () {
                if (getGroup(f) && getGroup(f).classList.contains('has-error')) {
                    validateField(f);
                }
            });
            input.addEventListener('blur', function () {
                if (input.value.trim() !== '' || getGroup(f).classList.contains('has-error')) {
                    validateField(f);
                }
            });
        });

        // Hijack the existing onsubmit so contact_us only fires when valid
        window.validateAndSubmitContact = function (formEl) {
            if (!validateAll()) {
                // Focus the first invalid field
                const firstErr = form.querySelector('.form-group.has-error input, .form-group.has-error textarea');
                if (firstErr) firstErr.focus();
                return false;
            }
            // All valid → delegate to the existing AJAX submit
            if (typeof contact_us === 'function') {
                return contact_us(formEl);
            }
            return true;
        };
    })();
    </script>
</body>

</html>
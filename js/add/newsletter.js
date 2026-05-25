(function () {
    var TOASTR_OPTS = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    function $form()  { return document.getElementById('newsletter'); }
    function $email() { return document.getElementById('newsemail'); }
    function $btn()   { return document.getElementById('newsletter-submit'); }
    function $err()   { return document.querySelector('label.error[for="newsemail"]'); }
    function $ok()    { return document.querySelector('.subscription-success'); }

    function validateEmail(value) {
        var v = (value || '').trim();
        if (v === '')          return "Please enter your email address.";
        if (v.length > 80)     return "Email must be under 80 characters.";
        if (!EMAIL_RE.test(v)) return "Please enter a valid email address.";
        return '';
    }

    function showError(msg) {
        var f = $form(), e = $err(), o = $ok();
        if (f) f.classList.add('is-invalid');
        if (o) { o.classList.remove('is-visible'); o.textContent = ''; }
        if (e) { e.textContent = msg; e.classList.add('is-visible'); }
        if (window.toastr) {
            window.toastr.options = TOASTR_OPTS;
            window.toastr.error(msg, "Invalid Email");
        }
    }

    function clearError() {
        var f = $form(), e = $err();
        if (f) f.classList.remove('is-invalid');
        if (e) { e.textContent = ''; e.classList.remove('is-visible'); }
    }

    function showSuccess(msg) {
        clearError();
        var o = $ok();
        if (o) { o.textContent = msg; o.classList.add('is-visible'); }
        if (window.toastr) {
            window.toastr.options = TOASTR_OPTS;
            window.toastr.success(msg, "Subscribed");
        }
    }

    function attachLiveValidation() {
        var input = $email();
        if (!input) return;
        input.addEventListener('input', function () {
            var f = $form();
            if (f && f.classList.contains('is-invalid')) {
                if (validateEmail(input.value) === '') clearError();
            }
        });
    }

    function ajaxSubmit() {
        var form = $form(), email = $email(), btn = $btn();
        if (!form || !email) return;

        var origVal = btn ? btn.value : 'Subscribe';
        if (btn) { btn.disabled = true; btn.value = 'Sending…'; }

        var fd = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'back/newsletter.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) return;
            if (btn) { btn.disabled = false; btn.value = origVal; }

            if (xhr.status < 200 || xhr.status >= 300) {
                showError('Network error. Please try again in a moment.');
                return;
            }
            var raw = xhr.responseText || '';
            var res = null;
            try {
                // Tolerate stray PHP warnings before the JSON body.
                var m = raw.match(/\{[\s\S]*\}\s*$/);
                if (m) res = JSON.parse(m[0]);
            } catch (e) { /* fall through */ }

            if (res && res.success) {
                showSuccess(res.message || 'Subscribed successfully!');
                form.reset();
                var ret = document.getElementById('return1');
                if (ret) ret.innerHTML = '';
            } else if (res && res.message) {
                showError(res.message);
            } else {
                showError('Something went wrong. Please try again.');
            }
        };
        xhr.send(fd);
    }

    // Expose the handler for the form's inline onsubmit="return newsletter(this);"
    window.newsletter = function () {
        var input = $email();
        var msg = validateEmail(input ? input.value : '');
        if (msg) {
            showError(msg);
            if (input) input.focus();
            return false;
        }
        clearError();
        if ($btn() && $btn().disabled) return false;
        ajaxSubmit();
        return false;
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attachLiveValidation);
    } else {
        attachLiveValidation();
    }
})();

// Inline error helper (creates the error element on demand)
function bfFieldErr($input, msg) {
    var $wrap = $input.closest('.bf-field');
    var $err = $wrap.find('.bf-err');
    if (!$err.length) { $err = $('<div class="bf-err"></div>'); $wrap.append($err); }
    if (msg) {
        $err.html('<i class="fa fa-exclamation-circle"></i> ' + msg);
        $input.addClass('is-invalid');
    } else {
        $err.empty();
        $input.removeClass('is-invalid');
    }
}

function register() {
    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var $fn = $('#firstname'), $ln = $('#lastname'), $em = $('#email'),
        $pw = $('#password'), $cp = $('#cpassword');
    var fn = $.trim($fn.val()), ln = $.trim($ln.val()), em = $.trim($em.val()),
        pw = $pw.val(), cp = $cp.val();
    var ok = true, $first = null;

    if (fn === '') { bfFieldErr($fn, 'First name is required'); ok = false; $first = $first || $fn; } else { bfFieldErr($fn, ''); }
    if (ln === '') { bfFieldErr($ln, 'Last name is required'); ok = false; $first = $first || $ln; } else { bfFieldErr($ln, ''); }

    if (em === '') { bfFieldErr($em, 'Email is required'); ok = false; $first = $first || $em; }
    else if (!emailRe.test(em)) { bfFieldErr($em, 'Enter a valid email address'); ok = false; $first = $first || $em; }
    else { bfFieldErr($em, ''); }

    if (pw === '') { bfFieldErr($pw, 'Password is required'); ok = false; $first = $first || $pw; }
    else if (pw.length < 6) { bfFieldErr($pw, 'Use at least 6 characters'); ok = false; $first = $first || $pw; }
    else { bfFieldErr($pw, ''); }

    if (cp === '') { bfFieldErr($cp, 'Please confirm your password'); ok = false; $first = $first || $cp; }
    else if (cp !== pw) { bfFieldErr($cp, 'Passwords do not match'); ok = false; $first = $first || $cp; }
    else { bfFieldErr($cp, ''); }

    if (!ok) { if ($first) { $first.focus(); } return false; }

    var $btn = $('#myform').find('button[type=submit]');
    var data = new FormData($('#myform')[0]);
    $.ajax({
        url: 'back/register.php',
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () { $btn.prop('disabled', true).text('Creating...'); },
        success: function (resp) {
            $('#return').fadeIn().html(resp);
            $btn.prop('disabled', false).text('Create Account');
        },
        error: function () {
            $btn.prop('disabled', false).text('Create Account');
            $('#return').html('<p style="color:#e23b3b;margin:0;">Something went wrong. Please try again.</p>');
        }
    });
    return false;
}

// Live-clear errors while typing
$(document).ready(function () {
    $('#firstname, #lastname, #email, #password, #cpassword').on('input', function () {
        bfFieldErr($(this), '');
    });
});

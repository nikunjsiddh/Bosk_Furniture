$(document).ready(function () {

    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Show/clear an inline error under a field (error element is created on demand)
    function fieldErr($input, msg) {
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

    function validate() {
        var ok = true, $first = null;
        var $email = $('#email'), $pwd = $('#pwd');
        var email = $.trim($email.val()), pwd = $pwd.val();

        if (email === '') { fieldErr($email, 'Email is required'); ok = false; $first = $first || $email; }
        else if (!emailRe.test(email)) { fieldErr($email, 'Enter a valid email address'); ok = false; $first = $first || $email; }
        else { fieldErr($email, ''); }

        if (pwd === '') { fieldErr($pwd, 'Password is required'); ok = false; $first = $first || $pwd; }
        else { fieldErr($pwd, ''); }

        if (!ok && $first) { $first.focus(); }
        return ok;
    }

    // Live-clear errors while typing
    $('#email, #pwd').on('input', function () { fieldErr($(this), ''); });

    $('#signin').on('click', function (event) {
        event.preventDefault();
        if (!validate()) { return false; }

        var $btn = $('#signin');
        $.ajax({
            url: "back/signin.php",
            method: "POST",
            data: $('#myform').serialize(),
            beforeSend: function () { $btn.prop('disabled', true).text('Signing in...'); },
            success: function (data) {
                $('#return').fadeIn().html(data);
                $btn.prop('disabled', false).text('Sign In');
                setTimeout(function () { location.reload(true); }, 3000);
            },
            error: function () {
                $btn.prop('disabled', false).text('Sign In');
                $('#return').html('<p style="color:#e23b3b;margin:0;">Something went wrong. Please try again.</p>');
            }
        });
        return false;
    });
});

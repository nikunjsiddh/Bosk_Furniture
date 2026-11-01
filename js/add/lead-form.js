/* ============================================================
   Bosk Furniture - shared AJAX submit for enquiry forms
   (Contact page, Customize Furniture page, Blog comments)
   ------------------------------------------------------------
   boskSubmitLead(form, endpoint)  -> posts the form, shows a
       success / error card in #return, marks invalid fields.
   boskValidateLeadForm(form)      -> browser-side checks for
       forms that do not have their own validation script.
   The server (lib/bosk-leads.php) answers with JSON:
       { success, title, message, reference, errors{field:msg} }
   ============================================================ */
(function (window, document, $) {
    'use strict';

    var FALLBACK = 'Sorry, we could not send your message right now. Please call us at +91 88666 47777 or WhatsApp +91 97378 17777.';

    function esc(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function each(list, fn) {
        Array.prototype.forEach.call(list || [], fn);
    }

    function closestGroup(el) {
        while (el && el !== document) {
            if (el.classList && el.classList.contains('form-group')) return el;
            el = el.parentNode;
        }
        return null;
    }

    function parseResponse(raw) {
        if (raw && typeof raw === 'object') return raw;
        try { return JSON.parse(raw); } catch (e) { /* try below */ }
        // Tolerate stray PHP notices printed before the JSON body.
        var m = String(raw || '').match(/\{[\s\S]*\}\s*$/);
        if (m) {
            try { return JSON.parse(m[0]); } catch (e2) { /* give up */ }
        }
        return null;
    }

    function showAlert(box, ok, title, message) {
        if (!box) return;
        box.innerHTML =
            '<div class="bosk-alert ' + (ok ? 'bosk-alert--success' : 'bosk-alert--error') + '" role="' + (ok ? 'status' : 'alert') + '">' +
                '<span class="bosk-alert__icon" aria-hidden="true"><i class="fa ' + (ok ? 'fa-check' : 'fa-exclamation') + '"></i></span>' +
                '<div class="bosk-alert__body">' +
                    (title ? '<strong>' + esc(title) + '</strong>' : '') +
                    '<p>' + esc(message) + '</p>' +
                '</div>' +
            '</div>';
        box.style.display = '';
        var rect = box.getBoundingClientRect();
        var viewH = window.innerHeight || document.documentElement.clientHeight;
        if ((rect.top < 0 || rect.bottom > viewH) && box.scrollIntoView) {
            box.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function setFieldError(form, field, message) {
        var input = form.querySelector('[name="' + field + '"]');
        var group = closestGroup(input);
        if (!group) return;
        var msgEl = group.querySelector('.error-msg');
        if (!msgEl && message) {
            msgEl = document.createElement('small');
            msgEl.className = 'error-msg';
            group.appendChild(msgEl);
        }
        if (message) {
            group.classList.add('has-error');
            if (msgEl) msgEl.textContent = message;
        } else {
            group.classList.remove('has-error');
            if (msgEl) msgEl.textContent = '';
        }
    }

    function clearFieldErrors(form) {
        each(form.querySelectorAll('.form-group.has-error'), function (group) {
            group.classList.remove('has-error');
            var msgEl = group.querySelector('.error-msg');
            if (msgEl) msgEl.textContent = '';
        });
    }

    function setBusy(btn, busy) {
        if (!btn) return;
        if (busy) {
            btn.setAttribute('data-label', btn.innerHTML);
            btn.disabled = true;
            btn.classList.add('is-sending');
            btn.innerHTML = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sending&hellip;';
        } else {
            btn.disabled = false;
            btn.classList.remove('is-sending');
            if (btn.hasAttribute('data-label')) {
                btn.innerHTML = btn.getAttribute('data-label');
                btn.removeAttribute('data-label');
            }
        }
    }

    /* ---------- Browser-side validation (Customize Furniture page) ---------- */
    var RULES = {
        name: function (v) {
            v = v.trim();
            if (!v) return 'Please enter your name.';
            if (v.length < 2) return 'Name must be at least 2 characters.';
            if (!/^[A-Za-zÀ-ɏ\s.'-]{2,60}$/.test(v)) return "Only letters, spaces and . ' - are allowed.";
            return '';
        },
        email: function (v) {
            v = v.trim();
            if (!v) return 'Please enter your email address.';
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v)) return 'Please enter a valid email address.';
            return '';
        },
        phone: function (v) {
            var d = v.replace(/\D/g, '');
            if (!d) return 'Please enter your contact number.';
            if (d.length === 12 && d.indexOf('91') === 0) d = d.slice(2);
            if (d.length === 11 && d.charAt(0) === '0') d = d.slice(1);
            if (!/^[6-9]\d{9}$/.test(d)) return 'Enter a valid 10-digit Indian mobile number.';
            return '';
        },
        msg: function (v) {
            v = v.trim();
            if (!v) return 'Please type your message.';
            if (v.length < 10) return 'Message should be at least 10 characters.';
            if (v.length > 2000) return 'Message must be under 2000 characters.';
            return '';
        }
    };

    function validateField(form, field) {
        var input = form.querySelector('[name="' + field + '"]');
        if (!input || !RULES[field]) return true;
        var message = RULES[field](input.value || '');
        setFieldError(form, field, message);
        return message === '';
    }

    window.boskValidateLeadForm = function (form) {
        if (!form) return false;
        var ok = true;
        Object.keys(RULES).forEach(function (field) {
            if (!validateField(form, field)) ok = false;
        });

        if (!form.getAttribute('data-live-validate')) {
            form.setAttribute('data-live-validate', '1');
            Object.keys(RULES).forEach(function (field) {
                var input = form.querySelector('[name="' + field + '"]');
                if (!input) return;
                input.addEventListener('input', function () {
                    var group = closestGroup(input);
                    if (group && group.classList.contains('has-error')) validateField(form, field);
                });
            });
        }

        if (!ok) {
            var first = form.querySelector('.form-group.has-error input, .form-group.has-error textarea');
            if (first) first.focus();
        }
        return ok;
    };

    /* ---------- AJAX submit ---------- */
    window.boskSubmitLead = function (form, endpoint) {
        if (!form || form.nodeType !== 1) form = document.getElementById('MyForm');
        if (!form || form.getAttribute('data-sending') === '1') return false;

        var box = document.getElementById('return');
        var btn = form.querySelector('[type="submit"]');

        form.setAttribute('data-sending', '1');
        setBusy(btn, true);
        if (box) box.innerHTML = '';

        $.ajax({
            url: endpoint,
            type: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'text',
            timeout: 90000
        }).done(function (raw) {
            var res = parseResponse(raw);
            if (res && res.success) {
                form.reset();
                clearFieldErrors(form);
                each(form.querySelectorAll('.file-name'), function (el) { el.textContent = ''; });
                showAlert(box, true, res.title, res.message);
            } else if (res) {
                if (res.errors) {
                    Object.keys(res.errors).forEach(function (field) {
                        setFieldError(form, field, res.errors[field]);
                    });
                }
                showAlert(box, false, res.title || 'Please check the form', res.message || FALLBACK);
            } else {
                showAlert(box, false, 'Something went wrong', FALLBACK);
            }
        }).fail(function (xhr) {
            var res = parseResponse(xhr && xhr.responseText);
            showAlert(box, false, (res && res.title) || 'Connection problem', (res && res.message) || FALLBACK);
        }).always(function () {
            form.removeAttribute('data-sending');
            setBusy(btn, false);
        });

        return false;
    };
})(window, document, window.jQuery);

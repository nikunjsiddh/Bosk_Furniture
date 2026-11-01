/* Contact page form -> back/contact.php
   Called by validateAndSubmitContact() in contact.php after the
   field checks pass. Sending + feedback: js/add/lead-form.js */
function contact_us(form) {
    return boskSubmitLead(form, 'back/contact.php');
}

/* Blog comment form (details.php) -> back/comment.php
   Called by validateAndSubmitComment() in details.php after the
   field checks pass. Sending + feedback: js/add/lead-form.js */
function contact_us(form) {
    return boskSubmitLead(form, 'back/comment.php');
}

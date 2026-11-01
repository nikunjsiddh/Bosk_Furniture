/* Customize Furniture form (ex-customize_furniture.php) -> back/modest_customize.php
   Validation, sending + feedback: js/add/lead-form.js */
function modest_customize(form) {
    if (!boskValidateLeadForm(form)) {
        return false;
    }
    return boskSubmitLead(form, 'back/modest_customize.php');
}

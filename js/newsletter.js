/*----------------------------------
//---- NEWSLETTER SUBSCRIPTION ----//
-----------------------------------*/
(function () {
    $('.mailchimp').ajaxChimp({
        callback: mailchimpCallback,
        //replace bellow url with your own mailchimp form post url inside the url: "---".
        //to learn how to get your own URL, please check documentation file.
        url: "http://phponly.us7.list-manage.com/subscribe/post?u=5a6a6d8aad4d7f65f096c2cd0&amp;id=9d9fd270d8"
    });

    function mailchimpCallback(resp) {
        if (resp.result === 'success') {
            $('.subscription-success').html('<i class="fa fa-check"></i>' + resp.msg).fadeIn(1000);
            $('.subscription-error').fadeOut(500);

        } else if (resp.result === 'error') {
            $('.subscription-error').html('<i class="fa fa-times"></i>' + resp.msg).fadeIn(1000);
        }
    }
}());

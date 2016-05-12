$(document).ready(function () {
    $('#formNewsletter button').click(function () {

        $.post(Routing.generate('web_newsletter'), $(this).parents('form').serialize(), function (data) {
            if (data.success) {
                var message = $.templates('#alert-message').render({
                    type: 'success',
                    message: data.message
                });
                $('#formNewsletter').find('.showmessage').prepend(message);
            } else {
                errorMessageForm('formNewsletter', data.errors);
            }

            return false;
        });

        return false;
    });

    $('#formNewsletter form').submit(function () {
        return false;
    })
});

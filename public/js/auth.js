let authForm = $("#regPopup #authForm"),
    authFormErrorBox = authForm.find('.alert-danger');


authForm.submit(function (e) {
    e.preventDefault();

    if(authForm.hasClass('processing')) {
        return;
    }

    authForm.addClass('processing');

    authFormErrorBox.addClass('hide');

    let authPhone = authForm.find('input[name="authPhone"]').val().replace(/\s|\(|\)|\+/g, ''),
        authPassword = authForm.find('input[name="authPassword"]').val(),
        needToSave = (authForm.find('#needToSaveCheckbox.checkbox.active').length === 1 ? 1 : 0),
        target = (authForm.find('#targetCheckbox.checkbox.active').length === 1 ? 'administrator' : 'user');


    if(authPhone === '') {
        authFormErrorBox.removeClass('hide');
        authFormErrorBox.text('Необходимо указать номер телефона');
        authForm.removeClass('processing');
        return;
    }

    if(authPassword === '') {
        authFormErrorBox.removeClass('hide');
        authFormErrorBox.text('Необходимо указать пароль');
        authForm.removeClass('processing');
        return;
    }

    $.post('/app/api/Authorization.php', {
        operation: 'auth',
        target,
        phone: authPhone,
        password: authPassword,
        needToSave
    }).done(function () {
        location.reload();
    }).fail(function (error) {
        authFormErrorBox.removeClass('hide');
        authFormErrorBox.text(error.responseText);
        authForm.removeClass('processing');
    });
})
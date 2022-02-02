let regForm = $("#regPopup #regForm"),
    regFormSuccessBox = regForm.find('.alert-success'),
    regFormErrorBox = regForm.find('.alert-danger');

regForm.submit(function (e) {
    e.preventDefault();

    if(regForm.hasClass('processing')) {
        return;
    }

    regForm.addClass('processing');

    regFormErrorBox.addClass('hide');
    regFormSuccessBox.addClass('hide');

    let regPhone = regForm.find('input[name="regPhone"]').val().replace(/\s|\(|\)|\+/g, ''),
        regPassword = regForm.find('input[name="regPassword"]').val(),
        regConfirmPassword = regForm.find('input[name="regConfirmPassword"]').val(),
        rulesIsConfirmed = (regForm.find('.checkbox.active').length === 1 ? 1 : 0);

    if(regPhone === '') {
        regFormErrorBox.removeClass('hide');
        regFormErrorBox.text('Необходимо указать номер телефона');
        regForm.removeClass('processing');
        return;
    }

    if(regPassword === '') {
        regFormErrorBox.removeClass('hide');
        regFormErrorBox.text('Необходимо указать пароль');
        regForm.removeClass('processing');
        return;
    }

    if(regPassword !== regConfirmPassword) {
        regFormErrorBox.removeClass('hide');
        regFormErrorBox.text('Пароли не совпадают');
        regForm.removeClass('processing');
        return;
    }

    if(rulesIsConfirmed !== 1) {
        regFormErrorBox.removeClass('hide');
        regFormErrorBox.text('Для регистрации необходимо согласиться с условиями пользования');
        regForm.removeClass('processing');
        return;
    }

    $.post('/app/api/Authorization.php', {
        operation: 'reg',
        params: {
            phone: regPhone,
            password: regPassword
        }
    }).done(function () {
        regFormSuccessBox.removeClass('hide');
        regFormSuccessBox.text('Аккаунт успешно создан');
        setTimeout(function () {
            location.assign('/cab');
        }, 2000);
    }).fail(function (error) {
        regFormErrorBox.removeClass('hide');
        regFormErrorBox.text(error.responseText);
        regForm.removeClass('processing');
    });
});
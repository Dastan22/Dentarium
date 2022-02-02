let saveEditingButton = $("#saveEditingButton"),
    cabContentErrorBox = $("#cabContent .alert-danger"),
    cabContentSuccessBox = $("#cabContent .alert-success"),
    inputs = $("#cabPersonalInfo .input-container input");



inputs.on('input', allowToUpdate);

function allowToUpdate() {
    saveEditingButton.removeClass('not-allowed');
    inputs.off('input', allowToUpdate);
}

saveEditingButton.click(updateUserData);

function updateUserData() {
    if($( this ).hasClass('not-allowed')) {
        return;
    }

    saveEditingButton.addClass('not-allowed');
    cabContentErrorBox.hide();
    cabContentSuccessBox.hide();

    let data = getFieldForUserUpdating(),
        fields = Object.keys(data);

    if(fields.length === 0) {
        saveEditingButton.removeClass('not-allowed');
        return;
    }

    $.post('/app/api/User.php', {
        operation: 'update',
        data: JSON.stringify(data),
        fields
    }).done(function () {
        cabContentSuccessBox.show();
        cabContentSuccessBox.text('Изменения успешно применены');
        setTimeout(function () {location.reload()}, 2000);
    }).fail(function (error) {
        cabContentErrorBox.show();
        cabContentErrorBox.text(error.responseText);
        saveEditingButton.removeClass('not-allowed');
    });
}

function getFieldForUserUpdating() {
    let out = {},
        inputs = $("#cabPersonalInfo .input-container input");

    for (let i = 0; i < inputs.length; i++) {
        if(inputs[i].hasAttribute('data-original-value')) {
            if($(inputs[i]).attr('data-original-value') !== ($(inputs[i]).attr('data-field') === 'phone' ? $(inputs[i]).val().replace(/\s|\(|\)|\+/g, '') : $(inputs[i]).val())) {
                console.log(123);
                out[$(inputs[i]).attr('data-field')] = $(inputs[i]).attr('data-field') === 'phone' ? $(inputs[i]).val().replace(/\s|\(|\)|\+/g, '') : $(inputs[i]).val();
            }
        }
    }

    return out;
}
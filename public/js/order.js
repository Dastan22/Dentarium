let orderForm = $("#orderForm"),
    orderFormErrorBox = orderForm.find('#errorBox'),
    orderFormSuccessBox = orderForm.find('#successBox'),
    arrangeOrderButton = $("#arrangeOrderButton");

orderForm.submit(function (e) {
    e.preventDefault();

    arrangeOrderButton.attr('disabled', 'disabled');
    orderFormErrorBox.hide();
    orderFormSuccessBox.hide();

    let deliveryType = $( this ).find('input[name="deliveryType"]:checked').val(),
        orderAddress = $( this ).find('input[name="orderAddress"]').val(),
        orderName = $( this ).find('input[name="orderName"]').val(),
        orderComment = $( this ).find('textarea[name="orderComment"]').val(),
        paymentType = $( this ).find('input[name="paymentType"]:checked').val();

    if(deliveryType === '' || deliveryType === undefined) {
        orderFormErrorBox.show();
        orderFormErrorBox.text('Не указан тип доставки');
        arrangeOrderButton.removeAttr('disabled');
        return;
    }

    if(orderAddress === '' || orderAddress === undefined) {
        orderFormErrorBox.show();
        orderFormErrorBox.text('Не указан адрес доставки');
        arrangeOrderButton.removeAttr('disabled');
        return;
    }

    if(orderName === '' || orderName === undefined) {
        orderFormErrorBox.show();
        orderFormErrorBox.text('Не указано ФИО');
        arrangeOrderButton.removeAttr('disabled');
        return;
    }

    if(paymentType === '' || paymentType === undefined) {
        orderFormErrorBox.show();
        orderFormErrorBox.text('Не указан тип оплаты');
        arrangeOrderButton.removeAttr('disabled');
        return;
    }

    $.post('/app/api/Order.php', {
        operation: 'save',
        deliveryType: parseInt(deliveryType),
        address: orderAddress,
        name: orderName,
        message: orderComment,
        paymentType: parseInt(paymentType)
    }).done(function () {
        orderFormSuccessBox.show();
        orderFormSuccessBox.text('Заказ успешно оформлен');
        setTimeout(function () {
            location.replace('/');
        }, 1500);
    }).fail(function (error) {
        orderFormErrorBox.show();
        orderFormErrorBox.text(error.responseText);
        arrangeOrderButton.removeAttr('disabled');
    });
});
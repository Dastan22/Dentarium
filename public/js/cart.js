let cartContainer = $("#cartPopup .cart-products-container");

setListeners();

cartPopup.find('#arrangeCart:not(.not-allowed)').click(function () {
    location.replace('/order');
});

function addToCart(productId = 0, addButton = $(``)) {
    if(productId === 0) {
        alert('Не удалось обнаружить айди товара');
        return;
    }

    $.post('/app/api/Cart.php', {
        operation: 'add',
        productId
    }).done(function (data) {
        renderCart(JSON.parse(data));
        addButton.removeClass('processing');
    }).fail(function (error) {
        alert(error.responseText);
    });
}

function removeFromCart(productId = 0) {
    if(productId === 0) {
        alert('Не удалось обнаружить айди товара');
        return;
    }

    $.post('/app/api/Cart.php', {
        operation: 'delete',
        productId
    }).done(function (data) {
        renderCart(JSON.parse(data));
    }).fail(function (error) {
        alert(error.responseText);
    });
}

function plusIntoCart(productId = 0) {
    if(productId === 0) {
        alert('Не удалось обнаружить айди товара');
        return;
    }

    $.post('/app/api/Cart.php', {
        operation: 'plus',
        productId
    }).done(function (data) {
        renderCart(JSON.parse(data));
    }).fail(function (error) {
        alert(error.responseText);
    });
}

function minusIntoCart(productId = 0) {
    if(productId === 0) {
        alert('Не удалось обнаружить айди товара');
        return;
    }

    $.post('/app/api/Cart.php', {
        operation: 'minus',
        productId
    }).done(function (data) {
        renderCart(JSON.parse(data));
    }).fail(function (error) {
        alert(error.responseText);
    });
}

function renderCart(cart = []) {
    cartContainer.find('.cart-item').remove();
    cartContainer.find('.empty-cart').remove();
    cartPopup.find('#arrangeCart').removeClass('not-allowed');
    cartPopup.find('.products-amount').html(`${cart.length} товара`);
    cartPopup.find('#arrangeCart').off();
    showCartPopupButton.find('span').html(cart.length);

    if(cart.length === 0) {
        cartContainer.append($(`<div class="empty-cart user-select-none text-muted mt-5 hide">В корзине пусто</div>`));
        cartPopup.find('#arrangeCart').addClass('not-allowed');
        cartPopup.find('.cart-total').html(`Итого: <span class="ml-2" style="font-size: 1.3rem; font-weight: 700; color: #292929">0 тг</span>`);
    } else {
        let totalPrice = 0;

        $.each(cart, function (i, v) {
            totalPrice += parseInt(v['price']);
            cartContainer.append($(
                `<div class="d-flex align-items-center cart-item py-1 py-sm-3" data-product-id="${v['id']}">
                    <div class="bg-contain cart-item-image mr-3" style="background-image: url(/public/img/products/${v['image']})"></div>
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center w-100">
                        <div class="cart-item-title mr-auto mb-2 mb-sm-0 user-select-none">${v['title']}</div>
                        <div class="d-flex align-items-center">
                            <div class="cart-item-minus cursor-pointer icon ml-sm-4" style="background-image: url(/public/img/dark-minus-icon.png); min-width: 25px; min-height: 25px"></div>
                            <div class="cart-item-amount mx-2">${v['amount']}</div>
                            <div class="cart-item-plus cursor-pointer icon" style="background-image: url(/public/img/dark-plus-icon.png); min-width: 25px; min-height: 25px"></div>
                            <div class="cart-item-price ml-0 ml-2 ml-sm-4 user-select-none">${number_format(v['price'], 0, '.', ' ')} тг</div>
                        </div>
                    </div>
                    <div class="cart-item-delete cursor-pointer d-flex justify-content-center align-items-center ml-2 ml-sm-4">
                        <div class="icon" style="background-image: url(/public/img/grey-cross-icon.png); width: 15px; height: 15px"></div>
                    </div>
                </div>`
            ));
        });

        setListeners();

        cartPopup.find('.cart-total').html(`Итого: <span class="ml-2" style="font-size: 1.3rem; font-weight: 700; color: #292929">${number_format(totalPrice)} тг</span>`);

        cartPopup.find('#arrangeCart').click(function () {
            location.assign('/order');
        });
    }
}

function setListeners() {
    cartContainer.find('.cart-item-minus').click(function () {
        if($( this ).hasClass('processing')) {
            return;
        }

        $( this ).addClass('processing');
        minusIntoCart(parseInt($( this ).parent().parent().parent().attr('data-product-id')));
    });

    cartContainer.find('.cart-item-plus').click(function () {
        if($( this ).hasClass('processing')) {
            return;
        }

        $( this ).addClass('processing');

        plusIntoCart(parseInt($( this ).parent().parent().parent().attr('data-product-id')));
    });

    cartContainer.find('.cart-item-delete').click(function () {
        if($( this ).hasClass('processing')) {
            return;
        }

        $( this ).addClass('processing');

        removeFromCart(parseInt($( this ).parent().attr('data-product-id')));
    });
}
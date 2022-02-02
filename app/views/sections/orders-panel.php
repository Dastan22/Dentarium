<div id="panelOrders" class="container-fluid h-100 d-flex flex-column">
    <form class="row mb-3" action="/panel//" method="get">
        <input type="text" name="search" class="w-100 h-100 px-4 py-3" value="<?= $_GET['search'] ?? '' ?>" placeholder="Поиск по номеру заказа, телефона">
    </form>
    <div id="ordersContainer" class="row d-flex flex-column flex-nowrap">
        <?php foreach ($this->data['orders'] ?? [] as $order): ?>
            <div class="order-item d-flex align-items-center mb-2" data-order-id="<?= $order['id'] ?>">
                <div class="order-id text-dark user-select-none mr-4">№ <?= $order['id'] ?></div>
                <div class="order-arrange-time user-select-none mr-auto">Дата оформления:&ensp;<span class="text-dark" style="font-weight: 500"><?= $order['arrange_time'] ?></span></div>
                <div class="order-more-button user-select-none cursor-pointer">Подробнее</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    $("#ordersContainer .order-item .order-more-button").click(getInfoAboutOrder);

    function getInfoAboutOrder() {
        $("#ordersContainer .order-item .order-more-button").text('Подробнее');

        if($( this ).hasClass('active')) {
            $("#ordersContainer .order-data").remove();
            $( this ).removeClass('active');
            return;
        }

        $("#ordersContainer .order-item .order-more-button").removeClass('active');

        let orderId = $( this ).parent().attr('data-order-id'), currentOrderCard = $( this ).parent();

        $( this ).addClass('not-allowed');
        $( this ).addClass('active');
        $( this ).text('Идёт загрузка...');

        if(orderId === '' || orderId === undefined) {
            alert('Не удалось определить айди заказа');
            location.reload();
            return;
        }

        $("#ordersContainer .order-data").remove();

        $.post('/app/api/Order.php', {
            operation: 'getInfo',
            orderId,
            entity: 'administrator'
        }).done(function (data) {
            let info = [];

            try {
                info = JSON.parse(data);
            } catch (e) {
                return;
            }

            currentOrderCard
                .find('.order-more-button')
                .removeClass('not-allowed');
            currentOrderCard
                .find('.order-more-button')
                .text('Скрыть информацию');

            let productsList = ``;

            $.each((info['products'] || '').split('~'), function (i, v) {
                if(v === '') {
                    return false;
                }
                productsList += `<p class="mb-1">${i + 1}. ${v.split('%')[0]} (${v.split('%')[1]} шт) <br /> ${number_format(v.split('%')[2])} тг</p>`;
            });

            currentOrderCard
                .after(
                    `<div class="order-data mt-2 mb-2 pl-3 py-3">
                         <div class="row pr-3">
                            <div class="col-6">
                                <p class="mb-1" style="color: #999999">ФИО:&ensp;<span class="text-dark" style="font-weight: 500">${info['full_name'] || 'Не определено' }</span></p>
                                <p class="mb-1" style="color: #999999">Номер:&ensp;<span class="text-dark" style="font-weight: 500">${'+ ' + phone_format(info['phone']) }</span></p>
                                <p class="mb-1" style="color: #999999">Адрес доставки:&ensp;<span class="text-dark" style="font-weight: 500">${info['delivery_address'] || 'Не определено' }</span></p>
                                <p class="mb-1" style="color: #999999">Тип доставки:&ensp;<span class="text-dark" style="font-weight: 500">${info['delivery_type'] || 'Не определено' }</span></p>
                                <p class="mb-1" style="color: #999999">Тип оплаты:&ensp;<span class="text-dark" style="font-weight: 500">${info['payment_type'] || 'Не определено' }</span></p>
                                <p class="mb-1" style="color: #999999">Стоимость заказа:&ensp;<span class="text-dark" style="font-weight: 500">${number_format(info['total_cost'])} тг</span></p>
                                <p class="mb-0" style="color: #999999">Статус заказа:&ensp;<span class="text-dark" style="font-weight: 500">${info['status'] || 'Не определено' }</span></p>
                             </div>
                             <div class="col-6">
                                <p style="color: #999999">Товары в заказе</p>
                                ${ productsList }
                             </div>
                         </div>
                     </div>`
                );
        }).fail(function (error) {
            alert(error.responseText);
            $( this ).removeClass('not-allowed');
            currentOrderCard
                .find('.order-more-button')
                .text('Подробнее');
        });
    }
</script>
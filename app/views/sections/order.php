<section id="order" class="py-3 px-3">
    <div class="container h-100 px-4 px-sm-3">
        <?php if(($this->data['isAuth'] ?? false) and count($this->data['cart'] ?? []) !== 0): ?>
        <div class="row h-100">
            <form id="orderForm" class="col h-100 mr-lg-5 mb-4 mb-lg-0">
                <div class="container-fluid h-100 p-0 d-flex flex-column">
                    <div class="row"><h3 class="user-select-none">Способ доставки</h3></div>
                    <div id="deliveryTypes" class="row mb-3">
                        <label class="col-12 col-md order-custom-radio py-4 text-center cursor-pointer user-select-none mr-3 active">
                            <input type="radio" name="deliveryType" class="position-absolute" value="1" checked>
                            Доставка до двери
                        </label>
                        <label class="col-12 col-md order-custom-radio py-4 text-center cursor-pointer user-select-none">
                            <input type="radio" name="deliveryType" class="position-absolute" value="2">
                            Самовывоз
                        </label>
                    </div>
                    <div class="row"><h3 class="user-select-none">Покупатель</h3></div>
                    <div class="row mb-2">
                        <input type="text" name="orderAddress" placeholder="Адрес" value="<?= $this->data['userData']['address'] ?? '' ?>" class="col-12 py-1 order-custom-input">
                    </div>
                    <div class="row mb-2">
                        <input type="text" name="orderName" placeholder="ФИО" value="<?= $this->data['userData']['name'] ?? '' ?>" class="col-12 py-1 order-custom-input">
                    </div>
                    <div class="row mb-4">
                        <textarea placeholder="Примечания покупателя" name="orderComment" rows="3" class="col-12 py-1 order-custom-input"></textarea>
                    </div>
                    <div class="row"><h3 class="user-select-none">Способ оплаты</h3></div>
                    <div id="paymentTypes" class="row mb-auto">
                        <label class="col-12 col-md order-custom-radio py-4 text-center cursor-pointer user-select-none mr-md-3 active">
                            <input type="radio" name="paymentType" class="position-absolute" value="1" checked>
                            Наличными
                        </label>
                        <label class="col-12 col-md order-custom-radio py-4 text-center cursor-pointer user-select-none mr-md-3">
                            <input type="radio" name="paymentType" class="position-absolute" value="2">
                            Картой
                        </label>
                        <label class="col-12 col-md order-custom-radio py-4 text-center cursor-pointer user-select-none">
                            <input type="radio" name="paymentType" class="position-absolute" value="3">
                            Курьеру
                        </label>
                    </div>
                    <div class="row">
                        <button id="arrangeOrderButton" class="mt-2 mt-lg-0 col-12 col-lg-auto mr-4 user-select-none" type="submit">Оформить</button>
                        <div id="errorBox" class="col order-first order-lg-2 alert alert-danger mb-0 user-select-none" style="display: none"></div>
                        <div id="successBox" class="col order-first order-lg-3 alert alert-success mb-0 user-select-none" style="display: none"></div>
                    </div>
                </div>
            </form>
            <div id="orderInfo" class="col-12 col-lg-auto h-100">
                <div class="container-fluid  h-100 py-3 d-flex flex-column">
                    <div class="row d-flex align-items-center pb-3" style="border-bottom: 2px solid #999999">
                        <h3 class="mr-auto user-select-none">Товары в заказе</h3>
                        <span class="user-select-none"><?= count($this->data['cart'] ?? []) ?> товара</span>
                    </div>
                    <div class="row order-items-container mb-auto">
                        <?php $totalPrice = 0 ?>
                        <?php foreach ($this->data['cart'] ?? [] as $v): ?>
                            <?php $totalPrice += intval($v->price) ?>
                            <div class="p-3 d-flex align-items-center order-item w-100">
                                <div class="order-item-image bg-contain mr-4" style="background-image: url(/public/img/products/<?= $v->image ?>)"></div>
                                <div class="d-flex flex-column w-100 mr-4">
                                    <div class="order-item-title user-select-none mb-1"><?= $v->title ?></div>
                                    <div class="order-item-amount user-select-none"><?= $v->amount ?> шт</div>
                                </div>
                                <div class="order-item-price user-select-none"><?= number_format($v->price, 2, '.', ' ') ?> тг</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row d-flex align-items-end mt-3">
                        <a href="/" class="mr-auto user-select-none" style="color: #292929; font-size: 0.8rem; font-weight: 500">< Назад</a>
                        <div class="user-select-none order-total-price" style="color: #999999; font-size: 0.8rem; font-weight: 500">Итого: &nbsp;<span style="color: #292929; font-size: 1.2rem; font-weight: 600"><?= number_format($totalPrice, 2, '.', ' ') ?> тг</span></div>
                    </div>
                </div>
            </div>
        </div>
        <?php elseif(count($this->data['cart'] ?? []) === 0): ?>
            <div class="alert alert-danger">В корзине отсутствуют товары</div>
        <?php else: ?>
            <div class="alert alert-danger">Чтобы оформить заказ необходимо <a href="" id="authFormErrorButton" class="user-select-none cursor-pointer">авторизоваться</a></div>
        <?php endif; ?>
    </div>
</section>


<script type="text/javascript">
    let deliveryTypes = $("#deliveryTypes label"),
        paymentTypes = $("#paymentTypes label");

    deliveryTypes.click(function () {
        if($( this ).hasClass('active')) {
            return;
        }

        deliveryTypes.removeClass('active');
        $( this ).addClass('active');
    });

    paymentTypes.click(function () {
        if($( this ).hasClass('active')) {
            return;
        }

        paymentTypes.removeClass('active');
        $( this ).addClass('active');
    });
</script>
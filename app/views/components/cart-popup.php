<?php $cart =  $this->data['cart'] ?? [] ?>
<?php $totalPrice = 0 ?>
<section id="cartPopup" class="fixed-top w-100 h-100 hide">
    <div class="container-fluid h-100 p-0">
        <div class="col-auto h-100 ml-auto popup-content p-4 d-flex flex-column">
            <div class="d-flex popup-header align-items-center pb-3">
                <h3 class="mr-4 mb-0 user-select-none" style="font-size: 1.6rem; font-weight: 600; color: #292929">Корзина</h3>
                <div class="products-amount mr-auto user-select-none" style="font-size: 0.9rem; font-weight: 500"><?= count($cart) ?> товара</div>
                <span class="icon close-popup cursor-pointer" style="background-image: url(../../../public/img/cross-icon.png); width: 20px; height: 20px"></span>
            </div>
            <div class="d-flex flex-column cart-products-container mb-3 pt-3 pt-sm-0">
                <?= (count($cart) === 0) ? '<div class="empty-cart user-select-none text-muted mt-5 hide">В корзине пусто</div>' : '' ?>
                <?php foreach ($cart as $v): ?>
                <?php $totalPrice += intval($v->price) ?>
                <div class="d-flex align-items-center cart-item py-1 py-sm-3" data-product-id="<?= $v->id ?>">
                    <div class="bg-contain cart-item-image mr-3" style="background-image: url(/public/img/products/<?= $v->image ?>)"></div>
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center w-100">
                        <div class="cart-item-title mr-auto mb-2 mb-sm-0 user-select-none"><?= $v->title ?></div>
                        <div class="d-flex align-items-center">
                            <div class="cart-item-minus cursor-pointer icon ml-sm-4" style="background-image: url(/public/img/dark-minus-icon.png); min-width: 25px; min-height: 25px"></div>
                            <div class="cart-item-amount mx-2"><?= $v->amount ?></div>
                            <div class="cart-item-plus cursor-pointer icon" style="background-image: url(/public/img/dark-plus-icon.png); min-width: 25px; min-height: 25px"></div>
                            <div class="cart-item-price ml-0 ml-2 ml-sm-4 user-select-none"><?= number_format($v->price, 0, '.', ' ') ?> тг</div>
                        </div>
                    </div>
                    <div class="cart-item-delete cursor-pointer d-flex justify-content-center align-items-center ml-2 ml-sm-4">
                        <div class="icon" style="background-image: url(/public/img/grey-cross-icon.png); width: 15px; height: 15px"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-auto d-flex flex-column flex-sm-row align-items-sm-center user-select-none">
                <div class="ml-auto mr-4 cart-total mb-2 mb-sm-0">Итого: <span class="ml-2" style="font-size: 1.3rem; font-weight: 700; color: #292929"><?= number_format($totalPrice, 2, '.', ' ') ?> тг</span></div>
                <div id="arrangeCart" class="cursor-pointer text-center <?= (count($cart) === 0) ? 'not-allowed' : '' ?>">Оформить заказ</div>
            </div>
        </div>
    </div>
</section>
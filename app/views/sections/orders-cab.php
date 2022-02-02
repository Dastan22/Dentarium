<div id="cabOrders" class="container-fluid h-100 d-flex flex-column">
    <?php if(count($this->data['orders'] ?? []) === 0): ?>
    <div class="text-muted" style="font-size: 0.9rem; font-weight: 500">Вы не оформили ещё ни одного заказа</div>
    <?php endif; ?>
    <?php foreach ($this->data['orders'] ?? [] as $order): ?>
    <div class="row order-item d-flex mb-3">
        <div class="col-auto order-item-id d-flex align-items-center">№ <?= $order['id'] ?></div>
        <div class="col-auto order-item-date d-flex align-items-center mr-auto mr-md-0 user-select-none"><?= $order['arrange_time'] ?></div>
        <div class="col-12 col-md order-last order-md-0 p-0 order-items-products-slider d-flex flex-nowrap mr-md-auto align-items-center user-select-none">
            <?php foreach (explode('~', $order['products'] ?? '') as $product): ?>
            <a href="/product/?id=<?= explode('%', $product)[1] ?>" target="_blank" class="order-slider-item mr-3 bg-contain" style="background-image: url(/public/img/products/<?= explode('%', $product)[0] ?>); min-width: 100px; height: 90%"></a>
            <?php endforeach; ?>
        </div>
        <div class="col-auto order-item-price d-flex align-items-center user-select-none"><?= number_format($order['price'], 2, '.', ' ') ?> тг</div>
        <div class="col-auto order-item-status d-flex align-items-center user-select-none" style="color: #211F20"><?= $order['status'] ?></div>
    </div>
    <?php endforeach; ?>
</div>
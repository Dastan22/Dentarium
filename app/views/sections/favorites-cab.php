<div id="cabFavorites" class="container-fluid h-100">
    <?php if(count($this->data['favorites'] ?? []) === 0): ?>
    <div class="text-muted" style="font-size: 0.9rem; font-weight: 500">Вы не добавили в избранное ещё ни одного товара</div>
    <?php endif; ?>
    <div class="row">

        <?php foreach (($this->data['favorites'] ?? []) as $v): ?>
            <a href="/product/?id=<?= $v['id'] ?>" class="col product-card d-flex flex-column p-2" data-product-id="<?= $v['id'] ?>">
                <div class="product-card-image bg-contain mb-3" style="background-image: url(/public/img/products/<?= $v['image'] ?>)"></div>
                <div class="product-card-title mb-1"><?= $v['title'] ?? 'Название не найдено' ?></div>
                <div class="product-card-status d-flex align-items-center mb-3 mt-auto mt-auto">
                    <?php if(($v['amount'] ?? 0) === 0): ?>
                        <span class="icon mr-2" style="background-image: url(../../../public/img/red-dot.png); width: 7px; height: 7px"></span>
                        <span class="user-select-none" style="color: #999999">Нет в наличии</span>
                    <?php else: ?>
                        <span class="icon mr-2" style="background-image: url(../../../public/img/green-dot.png); width: 7px; height: 7px"></span>
                        <span class="user-select-none" style="color: #4DBE18">В наличии</span>
                    <?php endif; ?>
                </div>
                <div class="product-card-rate d-flex mb-2">
                    <img src="../../../public/img/grey-star.png" alt="grey-star" style="width: 15px; height: 15px" class="mr-1">
                    <img src="../../../public/img/grey-star.png" alt="grey-star" style="width: 15px; height: 15px" class="mr-1">
                    <img src="../../../public/img/grey-star.png" alt="grey-star" style="width: 15px; height: 15px" class="mr-1">
                    <img src="../../../public/img/grey-star.png" alt="grey-star" style="width: 15px; height: 15px" class="mr-1">
                    <img src="../../../public/img/grey-star.png" alt="grey-star" style="width: 15px; height: 15px" class="mr-1">
                    <img src="../../../public/img/green-star.png" alt="green-star" style="width: 15px; height: 15px" class="hide mr-1">
                    <img src="../../../public/img/green-star.png" alt="green-star" style="width: 15px; height: 15px" class="hide mr-1">
                    <img src="../../../public/img/green-star.png" alt="green-star" style="width: 15px; height: 15px" class="hide mr-1">
                    <img src="../../../public/img/green-star.png" alt="green-star" style="width: 15px; height: 15px" class="hide mr-1">
                    <img src="../../../public/img/green-star.png" alt="green-star" style="width: 15px; height: 15px" class="hide">
                </div>
                <div class="d-flex">
                    <div class="product-card-price mr-auto"><?= number_format($v['price'] ?? 0, 2, '.', ' ') ?> тг</div>
                    <div class="product-card-like">
                        <div class="icon cursor-pointer" style="background-image: url(../../../public/img/red-heart.png); width: 20px; height: 20px"></div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    $("#cabOrders .product-card .product-card-like").click(function (e) {
        e.preventDefault();

        if($( this ).hasClass('processing')) return;

        $( this ).addClass('processing');

        let icon = $( this );

        $.post('/app/api/Product.php', {
            operation: 'addIntoFavorites',
            productId: parseInt($( this ).parents('.product-card').attr('data-product-id'))
        }).done(function () {
            icon.parents('.product-card').remove();
        }).fail(function (error) {
            alert(error.responseText);
            icon.removeClass('processing');
        });
    })
</script>
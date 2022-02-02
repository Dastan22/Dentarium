<?php
/**
 * @var $product
 */
?>

<a href="/product/?id=<?= $product['id'] ?>" data-product-id="<?= $product['id'] ?>" class="col product-card d-flex flex-column p-2">
    <div class="product-card-image bg-contain mb-3" style="background-image: url(<?= '/public/img/products/' . $product['image'] ?>)"></div>
    <div class="product-card-title mb-1"><?= $product['title'] ?? 'Название товара' ?></div>
    <div class="product-card-status d-flex align-items-center mb-3 mt-auto mt-auto">
        <?php if(intval($product['amount'] ?? '0') === 0): ?>
        <span class="icon mr-2" style="background-image: url(/public/img/red-dot.png); width: 7px; height: 7px"></span>
        <span class="user-select-none" style="color: #999999">Нет в наличии</span>
        <?php else: ?>
        <span class="icon mr-2" style="background-image: url(/public/img/green-dot.png); width: 7px; height: 7px"></span>
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
        <div class="product-card-price mr-auto"><?= number_format($product['price'], 2, '.', ' ') ?? 0 ?> тг</div>
        <div class="product-card-like <?= ($product['isFavorite'] ?? 0) === '1' ? 'is-favorite' : '' ?>">
            <div class="icon non-active cursor-pointer" style="background-image: url(../../../public/img/grey-heart.png); width: 20px; height: 20px"></div>
            <div class="icon active red cursor-pointer" style="background-image: url(../../../public/img/red-heart.png); width: 20px; height: 20px"></div>
        </div>
    </div>
</a>
<section id="productInfo" class="mt-3 mb-5">
    <div class="container-fluid px-4">
        <div class="row mb-4">
            <div id="productImagesSlider" class="col-12 col-md-6 mr-md-4 pr-md-0">
                <div class="swiper-container h-100 mw-100">
                    <div class="swiper-wrapper">
                        <?php foreach (explode('~', $this->data['productInfo']['images'] ?? '') as $image): ?>
                        <div class="swiper-slide d-flex justify-content-center align-items-center">
                            <div class="h-75 w-75 bg-contain" style="background-image: url(<?= '/public/img/products/' . $image ?>)"></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div id="productShortInfo" class="col mt-3 mt-md-0 pl-md-0 d-flex flex-column">
                <div class="product-goto-category mb-3">
                    <a href="/catalog/?id=<?= $this->data['productInfo']['category_id'] ?? '0' ?>" class="user-select-none">< <?= $this->data['productInfo']['category'] ?? 'Категория не найдена' ?></a>
                </div>
                <div class="d-flex align-items-start w-100 mb-3">
                    <h4 class="mr-auto product-title mw-75"><?= $this->data['productInfo']['title'] ?? 'Название на найдено' ?></h4>
                    <div class="product-info-like ml-3 <?= ($this->data['productInfo']['isFavorite'] ?? 0) === '1' ? 'is-favorite' : '' ?>">
                        <div class="icon cursor-pointer active" style="background-image: url(../../../public/img/red-heart.png); min-width: 24px; min-height: 24px"></div>
                        <div class="icon cursor-pointer non-active" style="background-image: url(../../../public/img/grey-heart.png); min-width: 24px; min-height: 24px"></div>
                    </div>
                </div>
                <div class="short-info-content mb-3">
                    <div class="product-attribute mb-3 pb-1 d-flex justify-content-between">
                        <span class="user-select-none">Артикул :</span>
                        <span><?= $this->data['productInfo']['vendor_code'] ?? 'Артикул не найден' ?></span>
                    </div>
                    <div class="product-attribute mb-3 pb-1 d-flex justify-content-between">
                        <span class="user-select-none">Производитель :</span>
                        <span><?= $this->data['productInfo']['brand'] ?? 'Бренд не найден' ?></span>
                    </div>
                    <div class="product-attribute mb-3 pb-1 d-flex justify-content-between">
                        <span class="user-select-none">Страна :</span>
                        <span><?= $this->data['productInfo']['country'] ?? 'Страна производителя не найдена' ?></span>
                    </div>
                    <div class="product-short-description mt-5"></div>
                </div>
                <div class="mt-auto" style="border: 1px solid; background: #000000"></div>
                <div class="product-price mt-3 user-select-none"><?= number_format($this->data['productInfo']['price'] ?? 0, 2, '.', ' ') ?> тг</div>
                <div class="d-flex mt-3">
                    <div id="addToCartButton" class="text-center user-select-none cursor-pointer" data-product-id="<?= $this->data['productInfo']['id'] ?? '0' ?>">Добавить в корзину</div>
                </div>
            </div>
        </div>
        <div id="productMoreInfo" class="row mx-0 mb-3">
                <div class="col-6 col-md-auto px-md-5 py-3 text-center product-more-info-tab active user-select-none cursor-pointer">Описание</div>
                <div class="col-6 col-md-auto px-md-5 py-3 text-center product-more-info-tab user-select-none cursor-pointer">Характеристики</div>
                <div class="col-6 col-md-auto px-md-5 py-3 text-center product-more-info-tab user-select-none cursor-pointer">Приминение</div>
                <div class="col-6 col-md-auto px-md-5 py-3 text-center product-more-info-tab user-select-none cursor-pointer">Особенности</div>
        </div>
        <div id="productMoreInfoContent" class="row mx-0">
            <div class="col-12 p-0 product-more-info-content">
                <?= isset($this->data['productInfo']['description']) ? ($this->data['productInfo']['description'] ?: 'Описание не указано') : 'Описание не указано' ?>
            </div>
            <div class="col-12 p-0 product-more-info-content hide">
                <?= isset($this->data['productInfo']['characters']) ? ($this->data['productInfo']['characters'] ?: 'Характеристики не указаны') : 'Характеристики не указаны' ?>
            </div>
            <div class="col-12 p-0 product-more-info-content hide">
                <?= isset($this->data['productInfo']['usage']) ? ($this->data['productInfo']['usage'] ?: 'Применение не указано') : 'Применение не указано' ?>
            </div>
            <div class="col-12 p-0 product-more-info-content hide">
                <?= isset($this->data['productInfo']['features']) ? ($this->data['productInfo']['features'] ?: 'Особенности не указаны') : 'Особенности не указаны' ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    new Swiper('#productInfo #productImagesSlider .swiper-container', {
        slidesPerView: 1,
        slidesPerGroup: 1,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
            el: '#productInfo #productImagesSlider .swiper-container .swiper-pagination',
            clickable: true
        }
    });
</script>

<script type="text/javascript">
    let imageSlider = $("#productInfo #productImagesSlider");

    $(window).resize(imagesSliderSizeControl);

    imagesSliderSizeControl();

    function imagesSliderSizeControl() {
        imageSlider.css('height', imageSlider[0].clientWidth);
    }
</script>

<script type="text/javascript">
    let productMoreIngoTabs = $("#productMoreInfo .product-more-info-tab"),
        productMoreInfoContentParts = $("#productMoreInfoContent .product-more-info-content");

    productMoreIngoTabs.click(function () {
        if($( this ).hasClass('active')) {
            return;
        }

        let tabIndex = productMoreIngoTabs.index($( this ));

        $.each(productMoreIngoTabs, function (i,v) {
            $(v).removeClass('active');
        });

        $( this ).addClass('active');

        $.each(productMoreInfoContentParts, function (i,v) {
            $(v).addClass('hide');
        });

        $(productMoreInfoContentParts[tabIndex]).removeClass('hide');
    });

</script>

<script type="text/javascript">
    $("#addToCartButton").click(function () {
        if($( this ).hasClass('processing')) {
            return;
        }

        $( this ).addClass('processing');
        addToCart(parseInt($( this ).attr('data-product-id')), $( this ));
    });
</script>

<script type="text/javascript">
    $("#productShortInfo .product-info-like").click(function (e) {
        if($( this ).hasClass('processing')) return;

        $( this ).addClass('processing');

        let icon = $( this );

        $.post('/app/api/Product.php', {
            operation: 'addIntoFavorites',
            productId: parseInt($("#addToCartButton").attr('data-product-id'))
        }).done(function () {
            icon.toggleClass('is-favorite');
            icon.removeClass('processing');
        }).fail(function (error) {
            alert(error.responseText);
            icon.removeClass('processing');
        });
    })
</script>
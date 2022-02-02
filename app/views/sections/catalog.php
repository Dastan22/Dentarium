<section id="catalogBlock" class="pt-5">
    <div class="container-fluid px-4">
        <div class="row px-3">

            <div id="catalogProductsCol" class="col p-0">
                <div class="catalog-breadcrumb pb-2 d-none d-md-flex justify-content-end align-items-end user-select-none mb-3">
                    <span class="mr-1">Главная</span>
<!--                    >-->
<!--                    <span class="mx-1">Товары для зубов</span>-->
<!--                    >-->
<!--                    <span class="ml-1">Зубные щетки</span>-->
                </div>
                <div id="productsContainer">
                    <div class="container-fluid">
                        <div class="row products-container">
                            <?php

                            $products = $this->data['products'] ?? [];
                            $prices = [0];

                            ?>

                            <?php foreach ($products as $product): ?>
                                <?php $prices[] = $product['price'] ?>
                                <?php include __DIR__ . '/../components/product-card.php' ?>

                            <?php endforeach; ?>
                        </div>

                        <div class="row">
                            <?php if(count($products) === 0):  ?>
                                <div class="text-muted" style="font-size: 0.9rem; font-weight: 600"><?= isset($_GET['search']) ? 'По запросу ничего не найдено' : 'В категории отсутствуют товары' ?></div>
                            <?php else: ?>
                                <div id="showMoreProductsButton" class="col-12 py-2 d-flex justify-content-center align-items-center mt-3 user-select-none cursor-pointer">
                                    <div class="icon mr-2" style="background-image: url(../../../public/img/reload-icon.png); width: 13px; height: 13px"></div>
                                    <p class="mb-0">Показать ещё</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="catalogNavCol" class="col-12 col-md-auto p-0 mr-4 order-first">
                <div class="catalog-title d-flex align-items-end pb-2 user-select-none mb-3">
                    Каталог (<?= $this->data['currentCategory'] ?? (isset($_GET['search']) ? 'Поиск' :  'Популярное') ?>)
                </div>
                <div class="d-none d-md-block container-fluid p-0">
                    <h3 class="mb-4 user-select-none">Категории</h3>

                    <?php foreach ($this->data['categories'] as $i => $v): ?>
                        <a href="/catalog/?id=<?= explode('%', $i)[1] ?>" class="row category-item user-select-none cursor-pointer p-0" data-title="<?= $i ?>" data-active="no">
                            <div class="col-10 mr-auto"><?= explode('%', $i)[0] ?></div>
                            <div class="col-auto icon mr-2" style="background-image: url(../../../public/img/grey-plus-icon.png); width: 13px; height: 13px"></div>
                        </a>
                    <?php endforeach; ?>

                    <hr style="background: #000000" />

                    <h3 class="mb-3 user-select-none">Цена</h3>

                    <div id="priceFilter" class="d-flex align-items-center">
                        <label class="my-0 mr-2">
                            <input type="text" name="minPrice" class="p-2 text-center" value="<?= min($prices) ?>">
                        </label>
                        <div class="line"></div>
                        <label class="my-0 mr-auto ml-2">
                            <input type="text" name="maxPrice" class="p-2 text-center" value="<?= max($prices) ?>">
                        </label>
                        <div style="font-size: 1.1rem;font-weight: 500">&#8376;</div>
                    </div>
                    <div id="searchByFiltersButton" class="text-center py-2 user-select-none cursor-pointer mt-4" style="background-color: #000000; color: #ffffff; font-size: 0.9rem">Применить</div>
                </div>
            </div>

        </div>
    </div>
</section>

<script type="text/javascript">
    $("#productsContainer .product-card .product-card-like").click(addIntoFavorites);

    function addIntoFavorites(e) {
        e.preventDefault();

        if($( this ).hasClass('processing')) return;

        $( this ).addClass('processing');

        let icon = $( this );

        $.post('/app/api/Product.php', {
            operation: 'addIntoFavorites',
            productId: parseInt($( this ).parents('.product-card').attr('data-product-id'))
        }).done(function () {
            icon.toggleClass('is-favorite');
            icon.removeClass('processing');
        }).fail(function (error) {
            alert(error.responseText);
            icon.removeClass('processing');
        });
    }
</script>

<script type="text/javascript">
    $("#priceFilter input").change(function () {
        if($( this ).val() === '') {
            $( this ).val(0);
        }
    });
</script>

<script src="/public/js/categories.js"></script>
<script src="/public/js/showMoreProducts.js"></script>
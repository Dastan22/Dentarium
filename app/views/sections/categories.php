<section id="categoriesSection" class="mt-4 d-none d-md-block">
    <div class="container-fluid px-4">
        <div class="bg bg-image">
            <div class="row">
                <a href="/catalog/?id=2" class="category-card col px-4 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Ортодонтия</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: <?= $this->data['mainCategoriesProductCount']['first'] ?? 0 ?></p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-01.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=4" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Ортопедия</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-02.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=3" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Оборудование</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-03.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=5" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Вращающиеся инструменты</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-04.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=7" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Хирургия</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-05.png); width: 95%; height: 60%"></div>
                </a>
            </div>
            <div class="row">
                <a href="/catalog/?id=6" class="category-card col px-4 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Инструменты</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-06.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=1" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Терапия</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-07.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=8" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Пасты для зубов</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-08.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=41" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Наконечники</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-09.png); width: 95%; height: 60%"></div>
                </a>
                <a href="/catalog/?id=42" class="category-card col px-3 py-3 d-flex flex-column align-items-center">
                    <h5 class="mb-1 user-select-none align-self-start">Виниры</h5>
                    <p class="mb-auto user-select-none align-self-start">Товаров: 0</p>
                    <div class="bg-contain" style="background-image: url(/public/img/category-icon-09.png); width: 95%; height: 60%"></div>
                </a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    let categoryCards = $("#categoriesSection .category-card");

    $(window).resize(windowResize);

    windowResize();

    function windowResize() {
        let categoryCardWidth = categoryCards[0].clientWidth;

        $.each(categoryCards, function (i,v) {
            $(v).css('height', categoryCardWidth + 'px');
        });
    }

    $.post('/app/api/Category.php', {
        operation: 'getCountOfProductsOfMainCategories'
    }).done(function (data) {
        let parsedData = JSON.parse(data),
            categoriesNumSpans = $("#categoriesSection .category-card p"),
            i = 0;

        console.log(categoriesNumSpans);

        $.each(parsedData, function (index, v) {
            $(categoriesNumSpans[i]).text(`Товаров: ${v}`);
            i++;
        });
    });
</script>
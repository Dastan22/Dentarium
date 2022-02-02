let limit = 15,
    showMoreButton = $("#showMoreProductsButton"),
    productsContainer = $("#productsContainer .products-container"),
    searchByFiltersButton = $("#searchByFiltersButton");

showMoreButton.click(function () {
    if($( this ).hasClass('active')) {
        return;
    }

    limit += 15;
    getMoreProducts();
});

searchByFiltersButton.click(function () {
    searchByFiltersButton.removeClass('active');

    getMoreProducts();
})

function getMoreProducts() {
    let minPrice = $("#catalogNavCol input[name='minPrice']").val().replace(/-/g, ''),
        maxPrice = $("#catalogNavCol input[name='maxPrice']").val().replace(/-/g, ''),
        data = [];


    if(location.pathname === '/index/' && location.search.split('=')[0] === '?search') {
        data = {
            operation: 'fullTextSearch',
            limit,
            searchString: decodeURI(location.search.split('=')[1]),
            minPrice: parseInt(minPrice),
            maxPrice: parseInt(maxPrice)
        };
    } else if(location.pathname === '/index/' || location.pathname === '/') {
        data = {
            operation: 'getAll',
            limit,
            minPrice: parseInt(minPrice),
            maxPrice: parseInt(maxPrice)
        };
    } else if(location.pathname === '/catalog/') {
        data = {
            operation: 'getByCategory',
            limit,
            categoryId: parseInt(location.search.split('=')[1]),
            minPrice: parseInt(minPrice),
            maxPrice: parseInt(maxPrice)
        };
    } else {
        alert('Произошла неизвестная ошибка');
        location.replace('/');
        return;
    }

    showMoreButton.addClass('active');
    showMoreButton
        .find('p')
        .text('Идёт загрузка товаров...');

    searchByFiltersButton
        .text('Идёт поиск...');

    $.post(
        '/app/api/Product.php',
        data
    ).done(function (data) {
        renderProducts(JSON.parse(data));
    }).fail(function (error) {
        alert(error.responseText);
        location.reload();
    });
}

function renderProducts(arr) {
    productsContainer.empty();
    $("#productsContainer .empty-product-container").remove();


    if(arr.length === 0) {
        $("#productsContainer .row:not(.products-container)")
            .prepend($(`
                <div class="text-muted empty-product-container" style="font-size: 0.9rem; font-weight: 600">Товаров не найдено</div>
            `));
    }

    searchByFiltersButton.removeClass('active');
    searchByFiltersButton
        .text('Применить');

    if(limit > arr.length) {
        showMoreButton.addClass('active');
        showMoreButton
            .find('p')
            .text('Показаны все товары');
    } else {
        showMoreButton.removeClass('active');
        showMoreButton
            .find('p')
            .text('Показать ещё');
    }

    $.each(arr, function (i, v) {
        let amountStatus;

        if(parseInt(v['amount']) === 0) {
            amountStatus = `
                <span class="icon mr-2" style="background-image: url(/public/img/red-dot.png); width: 7px; height: 7px"></span>
                <span class="user-select-none" style="color: #999999">Нет в наличии</span>
            `;
        } else {
            amountStatus = `
                 <span class="icon mr-2" style="background-image: url(/public/img/green-dot.png); width: 7px; height: 7px"></span>
                <span class="user-select-none" style="color: #4DBE18">В наличии</span>
            `;
        }

        productsContainer
            .append($(`
                <a href="/product/?id=${v['id']}" data-product-id="${v['id']}" class="col product-card d-flex flex-column p-2">
                    <div class="product-card-image bg-contain mb-3" style="background-image: url(${'/public/img/products/' + v['image']})"></div>
                    <div class="product-card-title mb-1">${v['title']}</div>
                    <div class="product-card-status d-flex align-items-center mb-3 mt-auto mt-auto">
                        ${ amountStatus }
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
                        <div class="product-card-price mr-auto">${number_format(v['price'])} тг</div>
                        <div class="product-card-like ${(v['isFavorite'] === '1') ? 'is-favorite' : ''}">
                            <div class="icon non-active cursor-pointer" style="background-image: url(/public/img/grey-heart.png); width: 20px; height: 20px"></div>
                            <div class="icon active red cursor-pointer" style="background-image: url(/public/img/red-heart.png); width: 20px; height: 20px"></div>
                        </div>
                    </div>
                </a>
            `));
    });

    $("#productsContainer .product-card .product-card-like").click(addIntoFavorites);
}
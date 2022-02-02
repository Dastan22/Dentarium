<div id="panelProducts" class="container-fluid h-100 d-flex flex-column">
    <form class="row mb-3" action="/panel/products/" method="get">
        <input type="text" name="searchString" class="w-100 h-100 px-4 py-3" value="<?= $_GET['searchString'] ?? '' ?>" placeholder="Поиск по категории, названию товара, артикулу и бренду">
    </form>

    <script type="text/javascript">
        $("#panelProducts form").submit(function (e) {
            if($( this ).find('input[name="searchString"]').val() === '') {
                e.preventDefault();
            }
        });
    </script>

    <div class="row">
        <?php foreach ($this->data['products'] ?? [] as $v): ?>
        <a href="/panel/edit/?id=<?= $v['id'] ?? 0 ?>" data-product-id="<?= $v['id'] ?? 0 ?>" class="col product-card d-flex flex-column p-2">
            <div class="product-card-image bg-contain mb-3" style="background-image: url(<?= '/public/img/products/' . $v['image'] ?? '' ?>)"></div>
            <div class="product-card-title mb-1"><?= $v['title'] ?? 'Название товара' ?></div>
            <div class="product-card-status d-flex align-items-center mb-3 mt-auto mt-auto">
                <?php if(1 === 0): ?>
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
                <div class="product-delete-btn">
                    <div class="icon cursor-pointer" style="background-image: url(/public/img/red-bin-icon.png); width: 20px; height: 20px"></div>
                </div>
            </div>
        </a>
        <?php endforeach;?>

        <?php if(count($this->data['products'] ?? []) === 0 AND isset($_GET['searchString'])): ?>
        <div style="font-size: 0.8rem; font-weight: 600; color: #999999">По Вашему запросу ничего не найдено...</div>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    $("#panelProducts .product-card .product-delete-btn").click(function (e) {
        e.preventDefault();

        if($( this ).hasClass('not-allowed')) {
            return;
        }

        $( this ).addClass('not-allowed');

        if(confirm('Вы дейстительно хотите удалить товар? \n\rПосле удаления товар невозможно будет восстановить!')) {
            $.post('/app/api/Product.php', {
                operation: 'delete',
                productId: parseInt($( this ).parents('.product-card').attr('data-product-id'))
            }).done(function () {
                alert('Товар успешно удален');
                location.reload();
            }).fail(function (error) {
                alert(error.responseText);
                $( this ).removeClass('not-allowed');
            });
        } else {
            $( this ).removeClass('not-allowed');
        }
    })
</script>
<div id="panelEditProduct" class="container-fluid h-100 d-flex flex-column">
    <h4 class="form-item-title user-select-none">Название товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productTitle" class="w-100 h-100 px-3" placeholder="Введите название" data-original-value="<?= $this->data['productInfo']['title'] ?? 'Название не найдено' ?>" value="<?= $this->data['productInfo']['title'] ?? 'Название не найдено' ?>">
    </label>

    <h4 class="form-item-title user-select-none">Артикул товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productVendor" class="w-100 h-100 px-3" placeholder="Введите артикул" data-original-value="<?= $this->data['productInfo']['vendor_code'] ?? 'Артикул не найден' ?>" value="<?= $this->data['productInfo']['vendor_code'] ?? 'Артикул не найден' ?>">
    </label>

    <h4 class="form-item-title user-select-none">Бренд товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productBrand" class="w-100 h-100 px-3" placeholder="Введите название бренда" data-original-value="<?= $this->data['productInfo']['brand'] ?? 'Бренд не найден' ?>" value="<?= $this->data['productInfo']['brand'] ?? 'Бренд не найден' ?>">
    </label>

    <h4 class="form-item-title user-select-none">Страна производителя товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productCountry" class="w-100 h-100 px-3" placeholder="Введите название производителя" data-original-value="<?= $this->data['productInfo']['country'] ?? 'Страна производителя не найдена' ?>" value="<?= $this->data['productInfo']['country'] ?? 'Страна производителя не найдена' ?>">
    </label>

    <h4 class="form-item-title user-select-none">Категория товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <select name="productCategory" class="w-100 h-100 px-3 cursor-pointer" data-original-value="<?= $this->data['productInfo']['category_id'] ?? '' ?>">
            <option value="<?= $this->data['productInfo']['category_id'] ?? '' ?>"><?= $this->data['productInfo']['category'] ?? '' ?></option>
            <?php foreach($this->data['categoriesTitles'] ?? [] as $v): ?>
                <?php if($v['id'] === $this->data['productInfo']['category_id']) {continue;} ?>
                <option value="<?= $v['id'] ?>"><?= $v['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <h4 class="form-item-title user-select-none">Описание товара</h4>
    <div class="form-item mb-4" style="height: auto">
        <div id="productDescription" class="w-100 h-100 px-3 py-4 cursor-pointer" data-original-value="<?= $this->data['productInfo']['description'] ?? '' ?>">
            <?= $this->data['productInfo']['description'] ?? '' ?>
        </div>
    </div>

    <h4 class="form-item-title user-select-none">Характеристики товара</h4>
    <div class="form-item mb-4" style="height: auto">
        <div id="productCharacters" class="w-100 h-100 px-3 py-4 cursor-pointer" data-original-value="<?= $this->data['productInfo']['characters'] ?? '' ?>">
            <?= $this->data['productInfo']['characters'] ?? '' ?>
        </div>
    </div>

    <h4 class="form-item-title user-select-none">Применение товара</h4>
    <div class="form-item mb-4" style="height: auto">
        <div id="productUsage" class="w-100 h-100 px-3 py-4 cursor-pointer" data-original-value="<?= $this->data['productInfo']['usage'] ?? '' ?>">
            <?= $this->data['productInfo']['usage'] ?? '' ?>
        </div>
    </div>

    <h4 class="form-item-title user-select-none">Особенности товара</h4>
    <div class="form-item mb-4" style="height: auto">
        <div id="productFeatures" class="w-100 h-100 px-3 py-4 cursor-pointer" data-original-value="<?= $this->data['productInfo']['features'] ?? '' ?>">
            <?= $this->data['productInfo']['features'] ?? '' ?>
        </div>
    </div>

    <h4 class="form-item-title user-select-none">Стоимость товара (тенге) <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productPrice" class="w-100 h-100 px-3" data-original-value="<?= $this->data['productInfo']['price'] ?? 0 ?>" value="<?= number_format($this->data['productInfo']['price'] ?? 0, 0, '.', ' ') ?>">
    </label>

    <script type="text/javascript">
        $("#panelEditProduct input[name='productPrice']").on('keyup', function (e) {
            $( this ).val(number_format(parseInt($( this ).val().replace(/\s/g, '')), 0));
        });
    </script>

    <h4 class="form-item-title user-select-none">Количество товара на складе <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-5">
        <input type="text" name="productAmount" class="w-100 h-100 px-3" data-original-value="<?= $this->data['productInfo']['amount'] ?? 0 ?>" value="<?= $this->data['productInfo']['amount'] ?? 0 ?>" placeholder="Введите количество">
    </label>

    <script type="text/javascript">
        $("#panelEditProduct input[name='productAmount']").on('keyup', function () {
            $( this ).inputmask('9{1,}');
        });
    </script>

    <div class="alert alert-danger" style="display: none"></div>
    <div class="alert alert-success" style="display: none"></div>
    <div id="saveProductButton" class="mb-4 user-select-none cursor-pointer py-3 text-center">Сохранить</div>

</div>


<div id="productDescriptionPopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productDescriptionEditor"><?= $this->data['productInfo']['description'] ?? '' ?></div>
    </div>
</div>
<div id="productCharactersPopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productCharactersEditor"><?= $this->data['productInfo']['characters'] ?? '' ?></div>
    </div>
</div>
<div id="productUsagePopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productUsageEditor"><?= $this->data['productInfo']['usage'] ?? '' ?></div>
    </div>
</div>
<div id="productFeaturesPopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productFeaturesEditor"><?= $this->data['productInfo']['features'] ?? '' ?></div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    let productDescriptionEditor,
        productCharactersEditor,
        productUsageEditor,
        productFeaturesEditor;

    ClassicEditor
        .create(document.querySelector('#productDescriptionEditor'))
        .then(editor => {
            productDescriptionEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#productCharactersEditor'))
        .then(editor => {
            productCharactersEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#productUsageEditor'))
        .then(editor => {
            productUsageEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#productFeaturesEditor'))
        .then(editor => {
            productFeaturesEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    let productDescriptionOutput = $("#panelEditProduct #productDescription"),
        productDescriptionPopup = $("#productDescriptionPopup"),
        productCharactersOutput = $("#panelEditProduct #productCharacters"),
        productCharactersPopup = $("#productCharactersPopup"),
        productUsageOutput = $("#panelEditProduct #productUsage"),
        productUsagePopup = $("#productUsagePopup"),
        productFeaturesOutput = $("#panelEditProduct #productFeatures"),
        productFeaturesPopup = $("#productFeaturesPopup");

    productDescriptionOutput.click(function () {
        productDescriptionPopup.show();
        productDescriptionPopup
            .find('.popup-container')
            .css('top', 0);
    });

    productDescriptionPopup.click(function (e) {
        if($(e.target).hasClass('popup')) {
            productDescriptionPopup.hide();
            productDescriptionPopup
                .find('.popup-container')
                .css('top', '400px');
            productDescriptionOutput.html(productDescriptionEditor.getData());
        }
    });

    productCharactersOutput.click(function () {
        productCharactersPopup.show();
        productCharactersPopup
            .find('.popup-container')
            .css('top', 0);
    });

    productCharactersPopup.click(function (e) {
        if($(e.target).hasClass('popup')) {
            productCharactersPopup.hide();
            productCharactersPopup
                .find('.popup-container')
                .css('top', '400px');
            productCharactersOutput.html(productCharactersEditor.getData());
        }
    });

    productUsageOutput.click(function () {
        productUsagePopup.show();
        productUsagePopup
            .find('.popup-container')
            .css('top', 0);
    });

    productUsagePopup.click(function (e) {
        if($(e.target).hasClass('popup')) {
            productUsagePopup.hide();
            productUsagePopup
                .find('.popup-container')
                .css('top', '400px');
            productUsageOutput.html(productUsageEditor.getData());
        }
    });

    productFeaturesOutput.click(function () {
        productFeaturesPopup.show();
        productFeaturesPopup
            .find('.popup-container')
            .css('top', 0);
    });

    productFeaturesPopup.click(function (e) {
        if($(e.target).hasClass('popup')) {
            productFeaturesPopup.hide();
            productFeaturesPopup
                .find('.popup-container')
                .css('top', '400px');
            productFeaturesOutput.html(productFeaturesEditor.getData());
        }
    });
</script>

<script type="text/javascript">
    // let productImages = $("#panelEditProduct .product-image");
    //
    // $(window).resize(windowResize);
    //
    // windowResize();
    //
    // function windowResize() {
    //     let productImagesWidth = productImages[0].clientWidth;
    //
    //     $.each(productImages, function (i,v) {
    //         $(v).css('height', productImagesWidth + 'px');
    //     });
    // }
</script>

<script type="text/javascript">
    // let productImageInputs = $("#panelEditProduct input[name='productImage']");
    //
    // productImageInputs.change(function (e) {
    //     let file = e.target.files[0],
    //         reader = new FileReader(),
    //         currentLabel = $( this ).parent();
    //
    //     if(file === undefined || file === '') {
    //         return;
    //     }
    //
    //     currentLabel.find('.delete-image').show();
    //     currentLabel.find('.empty-image').hide();
    //
    //     currentLabel.find('.delete-image').off();
    //     currentLabel.find('.delete-image').click(function (e) {
    //         e.preventDefault();
    //         deleteProductImage(currentLabel);
    //     });
    //
    //     reader.onload = function (f) {
    //         currentLabel.addClass('bg-contain');
    //         currentLabel.css('background-image', 'url("' + f.target.result + '")');
    //     };
    //
    //     reader.readAsDataURL(file);
    // });
    //
    // function deleteProductImage(label) {
    //     label.removeClass('bg-contain');
    //     label.css('background-image', '');
    //     label.find('.empty-image').show();
    //     label.find('.delete-image').hide();
    //     label.find('input[type="file"]').val('');
    // }
</script>

<script src="/public/js/editProductPanel.js"></script>
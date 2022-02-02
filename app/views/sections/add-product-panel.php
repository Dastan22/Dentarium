<div id="panelAddProduct" class="container-fluid h-100 d-flex flex-column">
    <h4 class="form-item-title user-select-none">Название товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productTitle" class="w-100 h-100 px-3" placeholder="Введите название">
    </label>

    <h4 class="form-item-title user-select-none">Артикул товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productVendor" class="w-100 h-100 px-3" placeholder="Введите артикул">
    </label>

    <h4 class="form-item-title user-select-none">Бренд товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productBrand" class="w-100 h-100 px-3" placeholder="Введите название бренда">
    </label>

    <h4 class="form-item-title user-select-none">Страна производителя товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productCountry" class="w-100 h-100 px-3" placeholder="Введите название производителя">
    </label>

    <h4 class="form-item-title user-select-none">Категория товара <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <select name="productCategory" class="w-100 h-100 px-3 cursor-pointer">
            <option value="">Выберете категорию</option>
            <?php foreach($this->data['categoriesTitles'] ?? [] as $v): ?>
                <option value="<?= $v['id'] ?>"><?= $v['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <h4 class="form-item-title user-select-none">Описание товара</h4>
    <div class="form-item-editor mb-4">
        <div id="productDescription" class="w-100 h-100 px-3 py-2 cursor-pointer" style="min-height: 60px;"></div>
    </div>

    <h4 class="form-item-title user-select-none">Характеристики товара</h4>
    <div class="form-item-editor mb-4">
        <div id="productCharacters" class="w-100 h-100 px-3 py-2 cursor-pointer" style="min-height: 60px;"></div>
    </div>

    <h4 class="form-item-title user-select-none">Применение товара</h4>
    <div class="form-item-editor mb-4">
        <div id="productUsage" class="w-100 h-100 px-3 py-2 cursor-pointer" style="min-height: 60px;"></div>
    </div>

    <h4 class="form-item-title user-select-none">Особенности товара</h4>
    <div class="form-item-editor mb-4">
        <div id="productFeatures" class="w-100 h-100 px-3 py-2 cursor-pointer" style="min-height: 60px;"></div>
    </div>

    <h4 class="form-item-title user-select-none">Стоимость товара (тенге) <span style="color: #ff0000">*</span></h4>
    <label class="form-item-editor mb-4">
        <input type="text" name="productPrice" class="w-100 h-100 px-3" value="0">
    </label>

    <script type="text/javascript">
        $("#panelAddProduct input[name='productPrice']").on('keyup', function (e) {
            $( this ).val(number_format(parseInt($( this ).val().replace(/\s/g, '')), 0));
        });
    </script>

    <h4 class="form-item-title user-select-none">Количество товара на складе <span style="color: #ff0000">*</span></h4>
    <label class="form-item mb-4">
        <input type="text" name="productAmount" class="w-100 h-100 px-3" value="0" placeholder="Введите количество">
    </label>

    <script type="text/javascript">
        $("#panelAddProduct input[name='productAmount']").on('keyup', function () {
            $( this ).inputmask('9{1,}');
        });
    </script>

    <h4 class="form-item-title user-select-none">Изображения товара <span style="color: #ff0000">*</span></h4>
    <div class="d-flex flex-wrap mb-5">
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
        <label class="product-image position-relative cursor-pointer d-flex justify-content-center align-items-center">
            <img src="/public/img/grey-camera-icon.png" alt="grey-camera-icon" class="empty-image" style="width: 45px; height: 45px">
            <img src="/public/img/grey-cross-icon.png" alt="red-cross-icon" class="delete-image cursor-pointer" style="display: none; width: 15px; position: absolute; top: -7px; right: -7px">
            <input type="file" name="productImage" style="width: 0; height: 0; opacity: 0" accept=".png, .jpg, .jpeg">
        </label>
    </div>

    <div class="alert alert-danger" style="display: none"></div>
    <div class="alert alert-success" style="display: none"></div>
    <div id="saveProductButton" class="mb-4 user-select-none cursor-pointer py-3 text-center">Сохранить</div>

</div>


<div id="productDescriptionPopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productDescriptionEditor"></div>
    </div>
</div>
<div id="productCharactersPopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productCharactersEditor"></div>
    </div>
</div>
<div id="productUsagePopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productUsageEditor"></div>
    </div>
</div>
<div id="productFeaturesPopup" class="popup justify-content-center align-items-center" style="display: none">
    <div class="popup-container">
        <div id="productFeaturesEditor"></div>
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

    let productDescriptionOutput = $("#panelAddProduct #productDescription"),
        productDescriptionPopup = $("#productDescriptionPopup"),
        productCharactersOutput = $("#panelAddProduct #productCharacters"),
        productCharactersPopup = $("#productCharactersPopup"),
        productUsageOutput = $("#panelAddProduct #productUsage"),
        productUsagePopup = $("#productUsagePopup"),
        productFeaturesOutput = $("#panelAddProduct #productFeatures"),
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
    let productImages = $("#panelAddProduct .product-image");

    $(window).resize(windowResize);

    windowResize();

    function windowResize() {
        let productImagesWidth = productImages[0].clientWidth;

        $.each(productImages, function (i,v) {
            $(v).css('height', productImagesWidth + 'px');
        });
    }
</script>

<script type="text/javascript">
    let productImageInputs = $("#panelAddProduct input[name='productImage']");

    productImageInputs.change(function (e) {
        let file = e.target.files[0],
            reader = new FileReader(),
            currentLabel = $( this ).parent();

        if(file === undefined || file === '') {
            return;
        }

        currentLabel.find('.delete-image').show();
        currentLabel.find('.empty-image').hide();

        currentLabel.find('.delete-image').off();
        currentLabel.find('.delete-image').click(function (e) {
            e.preventDefault();
            deleteProductImage(currentLabel);
        });

        reader.onload = function (f) {
            currentLabel.addClass('bg-contain');
            currentLabel.css('background-image', 'url("' + f.target.result + '")');
        };

        reader.readAsDataURL(file);
    });

    function deleteProductImage(label) {
        label.removeClass('bg-contain');
        label.css('background-image', '');
        label.find('.empty-image').show();
        label.find('.delete-image').hide();
        label.find('input[type="file"]').val('');
    }
</script>

<script src="/public/js/addProduct.js"></script>


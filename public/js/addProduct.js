let saveProductButton = $("#saveProductButton"),
    addProductErrorBox = $("#panelAddProduct .alert-danger"),
    addProductSuccessBox = $("#panelAddProduct .alert-success");

saveProductButton.click(function () {
    if($( this ).hasClass('not-allowed')) {
        return;
    }

    saveProductButton.addClass('not-allowed');
    addProductErrorBox.hide();
    addProductSuccessBox.hide();

    let productTitle = $("#panelAddProduct input[name='productTitle']").val(),
        productVendor = $("#panelAddProduct input[name='productVendor']").val(),
        productBrand = $("#panelAddProduct input[name='productBrand']").val(),
        productCountry = $("#panelAddProduct input[name='productCountry']").val(),
        productCategory = $("#panelAddProduct select[name='productCategory']").val(),
        productDescription = $("#panelAddProduct #productDescription").html(),
        productCharacters = $("#panelAddProduct #productCharacters").html(),
        productUsage = $("#panelAddProduct #productUsage").html(),
        productFeatures = $("#panelAddProduct #productFeatures").html(),
        productPrice = parseInt($("#panelAddProduct input[name='productPrice']").val().replace(/\s/g, '')),
        productAmount = parseInt($("#panelAddProduct input[name='productAmount']").val().replace(/\s/g, '')),
        productImages = $("#panelAddProduct input[name='productImage']"),
        formData = new FormData();

    if(productTitle === undefined || productTitle === '') {
        addProductErrorBox.show().text('Укажите название товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('productTitle', productTitle);

    if(productVendor === undefined || productVendor === '') {
        addProductErrorBox.show().text('Укажите артикул товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('productVendor', productVendor);

    if(productBrand === undefined || productBrand === '') {
        addProductErrorBox.show().text('Укажите бренд товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('productBrand', productBrand);

    if(productCountry === undefined || productCountry === '') {
        addProductErrorBox.show().text('Укажите страну производителя товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('productCountry', productCountry);

    if(productCategory === undefined || productCategory === '') {
        addProductErrorBox.show().text('Укажите категорию товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('productCategory', productCategory);

    if(productAmount === undefined) {
        addProductErrorBox.show().text('Укажите количество товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('productAmount', productAmount);
    formData.append('productDescription', productDescription);
    formData.append('productCharacters', productCharacters);
    formData.append('productUsage', productUsage);
    formData.append('productFeatures', productFeatures);
    formData.append('productPrice', productPrice);

    let productHasImage = false;

    $.each(productImages, function (i, v) {
        if($(v).val() !== undefined && $(v).val() !== '') {
            productHasImage = true;
            formData.append(i, $(v).prop('files')[0]);
        }
    });

    if(!productHasImage) {
        addProductErrorBox.show().text('Загрузите хотя бы одно изображение товара');
        saveProductButton.removeClass('not-allowed');
        return;
    }

    formData.append('operation', 'add');

    $.ajax({
        url: '/app/api/Product.php',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function() {
            addProductSuccessBox.show().text('Товар успешно добавлен');
            setTimeout(function () {
                location.reload();
            }, 2000);
        },
        error: function (error) {
            addProductErrorBox.show().text(error.responseText);
            saveProductButton.removeClass('not-allowed');
        }
    });
});
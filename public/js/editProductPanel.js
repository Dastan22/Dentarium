let saveProductButton = $("#saveProductButton"),
    updateProductErrorBox = $("#panelEditProduct .alert-danger"),
    updateProductSuccessBox = $("#panelEditProduct .alert-success");

saveProductButton.click(updateProductData);

function updateProductData() {
    if($( this ).hasClass('not-allowed')) {
        return;
    }

    $( this ).addClass('not-allowed');
    updateProductErrorBox.hide();
    updateProductSuccessBox.hide();

    let updateDate = defineDataForUpdate(),
        fields = Object.keys(updateDate);

    if(fields.length === 0) {
        saveProductButton.removeClass('not-allowed');
        return;
    }

    $.post('/app/api/Product.php', {
        operation: 'update',
        productId: parseInt(location.search.split('=')[1]),
        fields: JSON.stringify(fields),
        data: JSON.stringify(updateDate)
    }).done(function () {
        updateProductSuccessBox.show().text('Изменения успешно сохранены');
        setTimeout(function () {location.reload();}, 1500);
    }).fail(function (error) {
        updateProductErrorBox.show().text(error.responseText);
        saveProductButton.removeClass('not-allowed');
    });
}

function defineDataForUpdate() {
    let output = {};

    let productTitleInput = $("#panelEditProduct input[name='productTitle']");

    if(
        productTitleInput.val() !==
        productTitleInput.attr('data-original-value')
    ) {
        output['title'] = productTitleInput.val();
    }

    let productVendorInput = $("#panelEditProduct input[name='productVendor']");

    if(
        productVendorInput.val() !==
        productVendorInput.attr('data-original-value')
    ) {
        output['vendorCode'] = productVendorInput.val();
    }

    let productBrandInput = $("#panelEditProduct input[name='productBrand']");

    if(
        productBrandInput.val() !==
        productBrandInput.attr('data-original-value')
    ) {
        output['brand'] = productBrandInput.val();
    }

    let productCountyInput = $("#panelEditProduct input[name='productCountry']");

    if(
        productCountyInput.val() !==
        productCountyInput.attr('data-original-value')
    ) {
        output['country'] = productCountyInput.val();
    }

    let productCategorySelect = $("#panelEditProduct select[name='productCategory']");

    if(
        productCategorySelect.val() !==
        productCategorySelect.attr('data-original-value')
    ) {
        output['category'] = productCategorySelect.val();
    }

    if(
        $("#panelEditProduct #productDescription").attr('data-original-value').replace(/\s|&nbsp;/g, '') !==
        productDescriptionEditor.getData().replace(/\s|&nbsp;/g, '')
    ) {
        output['description'] = productDescriptionEditor.getData();
    }

    if(
        $("#panelEditProduct #productCharacters").attr('data-original-value').replace(/\s|&nbsp;/g, '') !==
        productCharactersEditor.getData().replace(/\s|&nbsp;/g, '')
    ) {
        output['characters'] = productCharactersEditor.getData();
    }

    if(
        $("#panelEditProduct #productUsage").attr('data-original-value').replace(/\s|&nbsp;/g, '') !==
        productUsageEditor.getData().replace(/\s|&nbsp;/g, '')
    ) {
        output['usage'] = productUsageEditor.getData();
    }

    if(
        $("#panelEditProduct #productFeatures").attr('data-original-value').replace(/\s|&nbsp;/g, '') !==
        productFeaturesEditor.getData().replace(/\s|&nbsp;/g, '')
    ) {
        output['features'] = productFeaturesEditor.getData();
    }

    let productPriceInput = $("#panelEditProduct input[name='productPrice']");

    if(
        productPriceInput.attr('data-original-value') !==
        productPriceInput.val().replace(/\s/g, '')
    ) {
        output['price'] = parseInt(productPriceInput.val().replace(/\s/g, ''));
    }

    let productAmountInput = $("#panelEditProduct input[name='productAmount']");

    if(
        productAmountInput.attr('data-original-value') !==
        productAmountInput.val().replace(/\s/g, '')
    ) {
        output['amount'] = parseInt(productAmountInput.val().replace(/\s/g, ''));
    }

    return output;
}
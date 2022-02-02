let innerCategoriesContainer = $("#innerCategoriesContainer"),
    showCategoryButton = $("#showCategoryButton"),
    showMobileCategoryButton = $("#showMobileCategoryButton"),
    dropdownCategoriesPopup = $("#dropdownCategories"),
    mobileDropdownCategoriesPopup = $("#dropdownMobileCategories");

$("#mainCategoriesContainer .category-item").mouseenter(function () {
    if($( this ).hasClass('active')) {
        return;
    }

    $("#mainCategoriesContainer .category-item").removeClass('active');
    $( this ).addClass('active');

    renderInnerCategories($( this ).attr('data-category'));
});

renderInnerCategories(
    $("#mainCategoriesContainer .category-item:first-child").attr('data-category') !== undefined
        ? $("#mainCategoriesContainer .category-item:first-child").attr('data-category')
        : ''
);

function renderInnerCategories(category) {
    innerCategoriesContainer
        .find('.col')
        .html('');

    let colNum = 1;

    $.each(categories[category], function (i, v) {
        let innerContainer = innerCategoriesContainer.find('.col:nth-child(' + colNum + ')');

        innerContainer
            .append($(`<a href="/catalog/?id=${i.split('%')[1]}" class="category-header user-select-none">${i.split('%')[0]}</a>`));

        if(categories[category][i].length === 0) {
            innerContainer
                .append($(`<div class="user-select-none">Категории отсутствуют</div>`));
        }

        $.each(categories[category][i], function (i2, v2) {
            innerContainer
                .append($(`<a href="/catalog/?id=${v2.split('%')[1]}" class="user-select-none">${v2.split('%')[0]}</a>`));
        });

        innerContainer
            .append($(`<div class="line"></div>`));

        colNum++;

        if(colNum > 3) {
            colNum = 1;
        }
    });
}

showCategoryButton.click(showDropdownCategoriesPopup);

function showDropdownCategoriesPopup() {
    if(dropdownCategoriesPopup.is(':visible')) {
        dropdownCategoriesPopup.hide();
        $("body").css('overflow', 'auto');
        showCategoryButton
            .find('p')
            .text('Каталог категорий');
    } else {
        dropdownCategoriesPopup.show();
        $("body").css('overflow', 'hidden');
        showCategoryButton
            .find('p')
            .text('Закрыть каталог');
    }
}

$("#dropdownMobileCategories .category-item").click(function (e) {
    renderMobileInnerCategories($( this ), $( this ).attr('data-title'), 2, e);
});

function renderMobileInnerCategories(clickedCategory, parentCategory, level, event) {
    if($(event.target).hasClass('icon')) {
        event.preventDefault();
    } else {
        return;
    }

    if(clickedCategory.attr('data-active') === 'yes') {
        hideMobileCategoriesList(clickedCategory, level);
        return;
    }

    clickedCategory.attr('data-active', 'yes');
    clickedCategory.find('.icon').css('transform', 'rotate(45deg)');

    if(level === 2) {
        let categoriesList = categories[parentCategory];

        if(categoriesList.length === 0) {
            clickedCategory.after($(
                `<div class="row category-item user-select-none p-0" data-parent="${clickedCategory.attr('data-title')}" data-active="no">
                    <div class="col-10 mr-auto ml-2">Подкатегории отсутствуют</div>
                </div>`
            ));
            return;
        }

        $.each(categoriesList, function (i, v) {
            let newCategoryItem = $(
                `<div class="d-flex category-item user-select-none cursor-pointer p-0" data-title="${i}" data-parent="${clickedCategory.attr('data-title')}" data-active="no">
                    <a href="/catalog/?id=${i.split('%')[1]}"  class="ml-3 mr-auto">${i.split('%')[0]}</a>
                    <div class="icon ml-2" style="background-image: url(/public/img/grey-plus-icon.png); width: 13px; height: 13px"></div>
                </div>`
            );

            newCategoryItem.click(function (e) {
                renderMobileInnerCategories($( this ), clickedCategory.attr('data-title'), 3, e);
            });

            clickedCategory.after(newCategoryItem);
        });
    } else if(level === 3) {
        let  categoriesList = categories[parentCategory][clickedCategory.attr('data-title')];

        if(categoriesList.length === 0) {
            clickedCategory.after($(
                `<div class="category-item user-select-none p-0" data-first-parent="${parentCategory}" data-parent="${clickedCategory.attr('data-title')}">
                    <div class="empty col-10 mr-auto ml-4">Подкатегории отсутствуют</div>
                </div>`
            ));
            return;
        }

        $.each(categoriesList, function (i, v) {
            let newCategoryItem = $(
                `<div class="category-item user-select-none cursor-pointer p-0" data-first-parent="${parentCategory}" data-parent="${clickedCategory.attr('data-title')}">
                    <a href="/catalog/?id=${v.split('%')[1]}" class="col-10 mr-auto ml-4">${v.split('%')[0]}</a>
                </div>`
            );

            clickedCategory.after(newCategoryItem);
        });
    } else {
        alert('Не удалось определить уровень категории');
    }
}

function hideMobileCategoriesList(clickedCategory, level) {
    $("#dropdownMobileCategories .category-item[data-parent=\"" + clickedCategory.attr('data-title') + "\"]").remove();

    if(level === 2) {
        $("#dropdownMobileCategories .category-item[data-first-parent=\"" + clickedCategory.attr('data-title') + "\"]").remove();
    }

    clickedCategory.attr('data-active', 'no');
    clickedCategory.find('.icon').css('transform', 'rotate(0)');
}

showMobileCategoryButton.click(showMobileDropdownCategoriesPopup);

function showMobileDropdownCategoriesPopup() {
    if(mobileDropdownCategoriesPopup.is(':visible')) {
        mobileDropdownCategoriesPopup.hide();
        $("body").css('overflow', 'auto');
    } else {
        mobileDropdownCategoriesPopup.show();
        $("body").css('overflow', 'hidden');
    }
}
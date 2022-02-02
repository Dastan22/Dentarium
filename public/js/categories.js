$("#catalogBlock .category-item").click(function (e) {
    showCategoriesList($( this ), $( this ).attr('data-title'), 2, e);
});

function showCategoriesList(clickedCategory, parentCategory, level, event) {
    if($(event.target).hasClass('icon')) {
        event.preventDefault();
    } else {
        return;
    }

    if(clickedCategory.attr('data-active') === 'yes') {
        hideCategoriesList(clickedCategory, level);
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
                `<a href="/catalog/?id=${i.split('%')[1]}" class="row category-item user-select-none cursor-pointer p-0" data-title="${i}" data-parent="${clickedCategory.attr('data-title')}" data-active="no">
                    <div class="col-10 mr-auto ml-2">${i.split('%')[0]}</div>
                    <div class="col-auto icon mr-2" style="background-image: url(/public/img/grey-plus-icon.png); width: 13px; height: 13px"></div>
                </a>`
            );

            newCategoryItem.click(function (e) {
                showCategoriesList($( this ), clickedCategory.attr('data-title'), 3, e);
            });

            clickedCategory.after(newCategoryItem);
        });
    } else if(level === 3) {
        let  categoriesList = categories[parentCategory][clickedCategory.attr('data-title')];

        if(categoriesList.length === 0) {
            clickedCategory.after($(
                `<div class="row category-item user-select-none p-0" data-first-parent="${parentCategory}" data-parent="${clickedCategory.attr('data-title')}">
                    <div class="col-10 mr-auto ml-4">Подкатегории отсутствуют</div>
                </div>`
            ));
            return;
        }

        $.each(categoriesList, function (i, v) {
            let newCategoryItem = $(
                `<a href="/catalog/?id=${v.split('%')[1]}" class="row category-item user-select-none cursor-pointer p-0" data-first-parent="${parentCategory}" data-parent="${clickedCategory.attr('data-title')}">
                    <div class="col-10 mr-auto ml-4">${v.split('%')[0]}</div>
                </a>`
            );

            clickedCategory.after(newCategoryItem);
        });
    } else {
        alert('Не удалось определить уровень категории');
    }
}

function hideCategoriesList(clickedCategory, level) {
    $("#catalogBlock .category-item[data-parent=\"" + clickedCategory.attr('data-title') + "\"]").remove();

    if(level === 2) {
        $("#catalogBlock .category-item[data-first-parent=\"" + clickedCategory.attr('data-title') + "\"]").remove();
    }

    clickedCategory.attr('data-active', 'no');
    clickedCategory.find('.icon').css('transform', 'rotate(0)');
}
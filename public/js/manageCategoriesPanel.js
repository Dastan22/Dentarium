let firstLevelCategoriesContainer = $("#firstLevelCategories"),
    secondLevelCategoriesContainer = $("#secondLevelCategories"),
    thirdLevelCategoriesContainer = $("#thirdLevelCategories");

renderFirstLevel();

function renderFirstLevel() {
    firstLevelCategoriesContainer.html('');

    if(categories.length === 0) {
        firstLevelCategoriesContainer
            .append($(`
                <div class="empty user-select-none">Категории отсутствуют</div>
            `));
    }

    $.each(categories, function (i, v) {
        firstLevelCategoriesContainer
            .append($(`
                <div class="category-item d-flex align-items-center" data-category="${i}">
                    <span class="user-select-none cursor-pointer mr-auto">${i.split('%')[0]}</span>
                    <div class="icon edit-btn cursor-pointer ml-3 mr-2" style="min-width: 15px; min-height: 15px"></div>
                    <div class="icon delete-btn cursor-pointer" style="min-width: 17px; min-height: 17px"></div>
                </div>
            `));
    });

    firstLevelCategoriesContainer
        .find('.category-item span')
        .click(function () {
            if($( this ).parent().hasClass('active')) {
                return;
            }

            firstLevelCategoriesContainer.attr(
                'data-current-category',
                $( this ).parent().attr('data-category')
            );

            firstLevelCategoriesContainer
                .find('.category-item')
                .removeClass('active');

            $( this ).parent().addClass('active');

            renderSecondLevel();
        });

    firstLevelCategoriesContainer
        .find('.category-item .delete-btn')
        .click(removeCategory);

    firstLevelCategoriesContainer
        .find('.category-item .edit-btn')
        .click(updateCategory);

    firstLevelCategoriesContainer.attr('data-current-category', Object.keys(categories)[0] !== undefined ? Object.keys(categories)[0] : '');

    firstLevelCategoriesContainer
        .find('.category-item:first-child')
        .addClass('active');

    renderSecondLevel();
}

function renderSecondLevel() {
    secondLevelCategoriesContainer.html('');

    let secondLevelCategories =
        (categories[firstLevelCategoriesContainer.attr('data-current-category')] !== undefined)
            ? categories[firstLevelCategoriesContainer.attr('data-current-category')]
            : [];

    if(secondLevelCategories.length === 0) {
        secondLevelCategoriesContainer
            .append($(`
                <div class="empty user-select-none">Дочерние категории отсутствуют</div>
            `));
    }

    $.each(secondLevelCategories, function (i, v) {
        secondLevelCategoriesContainer
            .append($(`
                <div class="category-item d-flex align-items-center" data-category="${i}">
                    <span class="user-select-none cursor-pointer mr-auto">${i.split('%')[0]}</span>
                    <div class="icon edit-btn cursor-pointer ml-3 mr-2" style="min-width: 15px; min-height: 15px"></div>
                    <div class="icon delete-btn cursor-pointer" style="min-width: 17px; min-height: 17px"></div>
                </div>
            `));
    });

    secondLevelCategoriesContainer
        .find('.category-item span')
        .click(function () {
            if($( this ).parent().hasClass('active')) {
                return;
            }

            secondLevelCategoriesContainer.attr(
                'data-current-category',
                $( this ).parent().attr('data-category')
            );

            secondLevelCategoriesContainer
                .find('.category-item')
                .removeClass('active');

            $( this ).parent().addClass('active');

            renderThirdLevel();
        });

    secondLevelCategoriesContainer
        .find('.category-item .delete-btn')
        .click(removeCategory);

    secondLevelCategoriesContainer
        .find('.category-item .edit-btn')
        .click(updateCategory);

    secondLevelCategoriesContainer.attr('data-current-category', Object.keys(secondLevelCategories)[0] !== undefined ? Object.keys(secondLevelCategories)[0] : '');
    secondLevelCategoriesContainer
        .find('.category-item:first-child')
        .addClass('active');

    renderThirdLevel();
}

function renderThirdLevel() {
    thirdLevelCategoriesContainer.html('');

    let thirdLevelCategories = categories[firstLevelCategoriesContainer.attr('data-current-category')][secondLevelCategoriesContainer.attr('data-current-category')] !== undefined
        ? categories[firstLevelCategoriesContainer.attr('data-current-category')][secondLevelCategoriesContainer.attr('data-current-category')]
        : [];

    if(thirdLevelCategories.length === 0) {
        thirdLevelCategoriesContainer
            .append($(`
                <div class="empty user-select-none">Дочерние категории отсутствуют</div>
            `));
    }

    $.each(thirdLevelCategories, function (i, v) {
        thirdLevelCategoriesContainer
            .append($(`
                <div class="category-item d-flex align-items-center" data-category="${v}">
                    <span class="user-select-none mr-auto">${v.split('%')[0]}</span>
                    <div class="icon edit-btn cursor-pointer ml-3 mr-2" style="min-width: 15px; min-height: 15px"></div>
                    <div class="icon delete-btn cursor-pointer" style="min-width: 17px; min-height: 17px"></div>
                </div>
            `));
    });

    thirdLevelCategoriesContainer
        .find('.category-item .delete-btn')
        .click(removeCategory);

    thirdLevelCategoriesContainer
        .find('.category-item .edit-btn')
        .click(updateCategory);
}

$("#panelCategories .add-btn").click(addNewCategory);

function addNewCategory() {
    if($( this ).hasClass('not-allowed')) {
        return;
    }

    $( this ).addClass('not-allowed');

    let parentId = 0, categoryTitle = '', level = $( this ).attr('data-level'), clickedBtn = $( this );

    if(level === 'first') {
        parentId = 0;
    } else if(level === 'second') {
        parentId = parseInt(firstLevelCategoriesContainer.attr('data-current-category').split('%')[1]);
    } else if(level === 'third') {
        parentId = parseInt(secondLevelCategoriesContainer.attr('data-current-category').split('%')[1]);
    } else {
        alert('Не удалось определить уровень родительской категории');
        return;
    }

    while (true) {
        categoryTitle = prompt('Введите название категории');

        if(categoryTitle === null) {
            $( this ).removeClass('not-allowed');
            break;
        }

        if(categoryTitle === undefined || categoryTitle === '') {
            alert('Некорректное название категории');
            continue;
        }

        $.post('/app/api/Category.php', {
            operation: 'add',
            parentId,
            title: categoryTitle
        }).done(function () {
            alert('Новая категория успешно добавлена');
            location.reload();
        }).fail(function (error) {
            alert(error.responseText);
            clickedBtn.removeClass('not-allowed');
        });

        break;
    }
}

function removeCategory() {
    if($( this ).hasClass('not-allowed')) {
        return;
    }

    $( this ).addClass('not-allowed');

    let categoryId = parseInt($( this ).parent().attr('data-category').split('%')[1]), clickedBtn = $( this );

    $.post('/app/api/Category.php', {
        operation: 'getConnected',
        categoryId
    }).done(function (data) {
        let message = '"' + clickedBtn.parent().attr('data-category').split('%')[0] + '", ';

        data = JSON.parse(data)

        $.each(data, function (i, v) {
            message += '"' + v['title'] + '"';

            if(i < data.length - 1) {
                message += ', ';
            }
        });

        if(confirm('Следующие категории станут недоступными: ' + message + '?')) {
            $.post('/app/api/Category.php', {
                operation: 'delete',
                categoryId
            }).done(function () {
                alert('Категория успешно удалена');
                clickedBtn
                    .parent()
                    .remove();
            }).fail(function (error) {
                alert(error.responseText);
                clickedBtn.removeClass('not-allowed');
            });
        } else {
            clickedBtn.removeClass('not-allowed');
        }
    }).fail(function (error) {
        alert(error.responseText);
        clickedBtn.removeClass('not-allowed');
    });
}

function updateCategory() {
    if($( this ).hasClass('not-allowed')) {
        return;
    }

    $( this ).addClass('not-allowed');

    let categoryId = parseInt($( this ).parent().attr('data-category').split('%')[1]), categoryUpdatedTitle, clickedBtn = $( this );

    while(true) {
        categoryUpdatedTitle = prompt('Введите новое название категории для "' + $( this ).parent().find('span').text() + '"');

        if(categoryUpdatedTitle === null) {
            $( this ).removeClass('not-allowed');
            break;
        }

        if(categoryUpdatedTitle === undefined || categoryUpdatedTitle === '') {
            alert('Некорректное название категории');
            continue;
        }

        $.post('/app/api/Category.php', {
            operation: 'update',
            categoryId,
            newTitle: categoryUpdatedTitle
        }).done(function () {
            alert('Название категории успешно обновлено');
            clickedBtn
                .parent()
                .find('span')
                .text(categoryUpdatedTitle);
            clickedBtn.removeClass('not-allowed');
        }).fail(function (error) {
            alert(error.responseText);
            clickedBtn.removeClass('not-allowed');
        });

        break;
    }
}
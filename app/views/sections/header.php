<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="https://translate.google.com/translate_a/element.js?cb=TranslateInit"></script>

<header>
    <div class="container-fluid pt-4 pt-md-2 px-4">
        <div class="row">
            <div class="col header-section d-none d-md-flex align-items-center">
                <div id="showCategoryButton" class="d-flex align-items-center cursor-pointer user-select-none">
                    <span class="icon mr-2" style="background: url(../../../public/img/categories-icon-01.png); width: 16px; height: 16px"></span>
                    <p class="mb-0">Каталог категорий</p>
                </div>
            </div>
            <div class="col col-md-auto header-section header-logo mx-auto p-0 d-flex justify-content-center">
                <a href="/"><img src="../../../public/img/main-logo.png" alt="main-logo"></a>
            </div>
            <div class="col header-section d-none d-md-flex align-items-center justify-content-end">
                <form id="searchField" class="d-flex align-items-center cursor-pointer mr-4 mb-0 user-select-none">
                    <svg width="16px" height="16px" viewBox="0 0 16 16" class="bi bi-search mx-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    </svg>
                    <input type="text" class="h-100 px-1" name="search" placeholder="Поиск" value="<?= $_GET['search'] ?? '' ?>">
                </form>
                <a href="<?= isset($this->data['isAuth']) ? ($this->data['isAuth'] ? '/cab' : '') : '' ?>" id="goCabinetButton" class="d-flex align-items-center cursor-pointer mr-3 mr-lg-4">
                    <svg width="25px" height="25px" viewBox="0 0 16 16" class="bi bi-person mr-1 mr-lg-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                </a>
                <div id="goFavoritesButton" class="d-flex align-items-center cursor-pointer mr-3 mr-lg-4 user-select-none">
                    <svg width="21px" height="21px" viewBox="0 0 16 16" class="bi bi-suit-heart mr-1 mr-lg-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 6.236l.894-1.789c.222-.443.607-1.08 1.152-1.595C10.582 2.345 11.224 2 12 2c1.676 0 3 1.326 3 2.92 0 1.211-.554 2.066-1.868 3.37-.337.334-.721.695-1.146 1.093C10.878 10.423 9.5 11.717 8 13.447c-1.5-1.73-2.878-3.024-3.986-4.064-.425-.398-.81-.76-1.146-1.093C1.554 6.986 1 6.131 1 4.92 1 3.326 2.324 2 4 2c.776 0 1.418.345 1.954.852.545.515.93 1.152 1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z"/>
                    </svg>
                    <span><?= $this->data['countOfFavorites'] ?? 0 ?></span>
                </div>
                <div id="goCartButton" class="d-flex align-items-center cursor-pointer mr-3 mr-lg-4 user-select-none">
                    <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-bag mr-1 mr-lg-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 1a2.5 2.5 0 0 0-2.5 2.5V4h5v-.5A2.5 2.5 0 0 0 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5H2z"/>
                    </svg>
                    <span><?= count($this->data['cart'] ?? []) ?></span>
                </div>
                <div id="changeLanguageButton" class="user-select-none" data-translate-code="en">
                    En
                </div>
            </div>
        </div>

        <div id="dropdownCategories" class="position-absolute w-100 px-3" style="display: none">
            <div class="row h-100 px-4 py-3">
                <div id="mainCategoriesContainer" class="col-auto mr-4 h-100 pl-4 pr-0 py-3">
                    <?php $itemNum = 0; ?>
                    <?php foreach($this->data['categories'] ?? [] as $i => $v): ?>
                        <div class="category-item <?= ($itemNum === 0) ? 'active' : '' ?> d-flex pl-3 py-2" data-category="<?= $i ?>">
                            <a href="/catalog/?id=<?= explode('%', $i)[1] ?>" class="mr-auto"><?= explode('%', $i)[0] ?></a>
                            <div class="icon ml-5" style="background-image: url(/public/img/right-arrow-02.png); min-width: 32px; min-height: 16px; width: 32px; height: 16px"></div>
                        </div>
                        <?php $itemNum++; ?>
                    <?php endforeach; ?>
                </div>
                <div id="innerCategoriesContainer" class="col h-100">
                    <div class="row mb-0 h-100">
                        <div class="col mb-0 mr-3 mr-lg-5 p-0 d-flex flex-column"></div>
                        <div class="col mb-0 mr-3 mr-lg-5 p-0 d-flex flex-column"></div>
                        <div class="col mb-0 p-0 d-flex flex-column"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="px-4 under-logo-line d-flex d-md-none justify-content-center mt-2">
    <span class="line"></span>
</div>

<section id="mobileNavbar" class="d-block d-md-none fixed-bottom pt-2 pb-3">
    <div class="container-fluid">
        <div id="dropdownMobileCategories" class="position-absolute w-100 px-3" style="display: none">
            <div class="h-100 py-4 d-flex flex-column">
                <div class="d-flex w-100 justify-content-center align-items-center pt-5 pb-2 mb-4" style="border-bottom: 2px solid #211F20;">
                    <span class="icon mr-2" style="background: url(../../../public/img/categories-icon-01.png); width: 16px; height: 16px"></span>
                    <p class="mb-0" style="font-weight: 500; font-size: 1.1rem">Категории</p>
                </div>
                <div class="categories-mobile-container d-flex flex-column h-100" style="overflow-y: scroll; overflow-x: hidden">
                    <?php foreach ($this->data['categories'] ?? [] as $i => $v): ?>
                        <div class="d-flex category-item user-select-none cursor-pointer p-0" data-title="<?= $i ?>" data-active="no">
                            <a href="/catalog/?id=<?= explode('%', $i)[1] ?>" class="mr-auto"><?= explode('%', $i)[0] ?></a>
                            <div class="icon" style="background-image: url(../../../public/img/grey-plus-icon.png); width: 13px; height: 13px"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <a href="/" class="col mobile-navbar-button d-flex flex-column justify-content-center align-items-center" style="color: #212529; text-decoration: none">
                <span class="icon mb-2" style="background: url(../../../public/img/home-icon.png); width: 16px; height: 16px"></span>
                Главная
            </a>
            <div id="showMobileCategoryButton" class="col mobile-navbar-button d-flex flex-column justify-content-center align-items-center">
                <span class="icon mb-2" style="background: url(../../../public/img/categories-icon-01.png); width: 16px; height: 16px"></span>
                Категории
            </div>
            <div id="goCartMobileButton" class="col mobile-navbar-button d-flex flex-column justify-content-center align-items-center">
                <span class="icon mb-2" style="background: url(../../../public/img/cart-icon-01.png); width: 16px; height: 16px"></span>
                Корзина
            </div>
            <a href="" id="goCabinetMobileButton" class="col mobile-navbar-button d-flex flex-column justify-content-center align-items-center">
                <span class="icon mb-2" style="background: url(../../../public/img/user-icon-01.png); width: 16px; height: 16px"></span>
                Профиль
            </a>
        </div>
    </div>
</section>

<script type="text/javascript">
    let changeLanguageButton = $("#changeLanguageButton");

    const googleTranslateConfig = {
        lang: "ru",
    };

    function TranslateInit() {

        let code = TranslateGetCode();

        if (code === googleTranslateConfig.lang) {
            TranslateClearCookie();
        }

        if(code === '/auto/ru' || code === 'ru') {
            changeLanguageButton.attr('data-translate-code', 'en');
            changeLanguageButton.text('En');
        } else {
            changeLanguageButton.attr('data-translate-code', 'ru');
            changeLanguageButton.text('Ru');
        }

        new google.translate.TranslateElement({
            pageLanguage: googleTranslateConfig.lang,
        });

        changeLanguageButton.click(function () {
            TranslateSetCookie($( this ).attr('data-translate-code'));
            if($( this ).attr('data-translate-code') === 'en') {
                $( this ).attr('data-translate-code', 'ru');
                $( this ).text('Ru');
            } else {
                $( this ).attr('data-translate-code', 'en');
                $( this ).text('En');
            }
            window.location.reload();
        });
    }

    function TranslateGetCode() {
        let lang = ($.cookie('googtrans') !== undefined && $.cookie('googtrans') !== "null") ? $.cookie('googtrans') : googleTranslateConfig.lang;
        return lang.substr(-2);
    }

    function TranslateClearCookie() {
        $.cookie('googtrans', null);
        $.cookie("googtrans", null, {
            domain: "." + document.domain,
        });
    }

    function TranslateSetCookie(code) {
        $.cookie('googtrans', "/auto/" + code);
        $.cookie("googtrans", "/auto/" + code, {
            domain: "." + document.domain,
        });
    }
</script>

<script type="text/javascript">let categories = <?= json_encode($this->data['categories'] ?? '[]') ?></script>
<script src="/public/js/dropdownCategoriesPopup.js"></script>
<script src="/public/js/searchProducts.js"></script>
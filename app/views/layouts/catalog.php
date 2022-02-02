<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/ico">
    <link rel="stylesheet" href="../../../public/lib/bootstrap.css">
    <link rel="stylesheet" href="../../../public/css/main.css">
    <link rel="stylesheet" href="../../../public/css/header.css">
    <link rel="stylesheet" href="../../../public/css/catalog.css">
    <link rel="stylesheet" href="../../../public/css/footer.css">
    <link rel="stylesheet" href="../../../public/css/reg-popup.css">
    <link rel="stylesheet" href="../../../public/css/cart-popup.css">
    <script src="../../../public/lib/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/jquery.inputmask@5.0.0-beta.87/dist/jquery.inputmask.min.js"></script>
    <script src="../../../public/js/main.js"></script>
    <title><?= $this->data['currentCategory'] ?? 'Dentarium.kz – Стоматологическое оборудование' ?></title>
</head>
<body>
    <?php require_once __DIR__ . '/../sections/header.php' ?>

    <section class="mt-3 d-block d-md-none">
        <style scoped="scoped">
            #mobileSearchField {
                height: 30px;
                border: 1px solid #000000;
                border-radius: 60px;
                color: #919191;
            }

            #mobileSearchField input {
                width: 100%;
                background: none;
                font-size: 0.9rem;
                font-weight: 300;
            }
        </style>
        <div class="container-fluid px-4">
            <form id="mobileSearchField" class="d-flex align-items-center cursor-pointer mb-0 user-select-none">
                <svg width="16px" height="16px" viewBox="0 0 16 16" class="bi bi-search mx-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                </svg>
                <input type="text" class="h-100 px-1" name="search" placeholder="Поиск" value="<?= $_GET['search'] ?? '' ?>">
            </form>
        </div>
        <script type="text/javascript">
            $("#mobileSearchField").submit(searchProducts);
        </script>
    </section>

    <?php require_once __DIR__ . '/../sections/catalog.php' ?>
    <?php require_once __DIR__ . '/../sections/footer.php' ?>
    <?php require_once __DIR__ . '/../components/reg-popup.php' ?>
    <?php require_once __DIR__ . '/../components/cart-popup.php' ?>

    <div class="d-md-none d-block" style="height: 84px"></div>

    <script type="text/javascript">
        let gotoCabinetButton = $("#goCabinetButton"),
            gotoCabinetMobileButton = $("#goCabinetMobileButton"),
            closeRegPopupButton = $("#regPopup .close-popup"),
            regPopup = $("#regPopup");

        gotoCabinetButton.click(showAuthPopup);
        gotoCabinetMobileButton.click(showAuthPopup);

        function showAuthPopup(e) {
            e.preventDefault();

            let link = $( this ).attr('href');

            if(link === '') {
                $("body").css('overflow', 'hidden');
                regPopup.removeClass('hide');
                setTimeout(function () {
                    regPopup.find('.col-auto').css('left', 0);
                }, 10);
            } else {
                location.assign(link);
            }
        }

        closeRegPopupButton.click(function () {
            regPopup.find('.col-auto').css('left', '350px');
            setTimeout(function () {
                regPopup.addClass('hide');
                $("body").css('overflow', 'auto');
            }, 400);
        });
    </script>

    <script type="text/javascript">
        let showCartPopupButton = $("#goCartButton"),
            showCartMobileButton = $("#goCartMobileButton"),
            closeCartPopupButton = $("#cartPopup .close-popup"),
            cartPopup = $("#cartPopup");

        showCartPopupButton.click(showCartPopup);
        showCartMobileButton.click(showCartPopup);

        function showCartPopup() {
            $("body").css('overflow', 'hidden');
            cartPopup.removeClass('hide');
            setTimeout(function () {
                cartPopup.find('.popup-content').css('left', 0);
            }, 10);
        }

        closeCartPopupButton.click(function () {
            cartPopup.find('.popup-content').css('left', '700px');
            setTimeout(function () {
                cartPopup.addClass('hide');
                $("body").css('overflow', 'auto');
            }, 400);
        });
    </script>

    <script src="../../../public/js/auth.js"></script>
    <script src="../../../public/js/reg.js"></script>
    <script src="../../../public/js/cart.js"></script>
</body>
</html>
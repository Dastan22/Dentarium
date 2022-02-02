<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/ico">
    <link rel="stylesheet" href="../../../public/lib/bootstrap.css">
    <link rel="stylesheet" href="../../../public/css/main.css">
    <link rel="stylesheet" href="../../../public/css/header.css">
    <link rel="stylesheet" href="../../../public/css/cab.css">
    <link rel="stylesheet" href="../../../public/css/private-info-cab.css">
    <link rel="stylesheet" href="../../../public/css/orders-cab.css">
    <link rel="stylesheet" href="../../../public/css/favorites-cab.css">
    <link rel="stylesheet" href="../../../public/css/cart-popup.css">
    <script src="../../../public/lib/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@4.0.9/dist/jquery.inputmask.bundle.min.js"></script>
    <title>Личный кабинет</title>
</head>
<body>
    <?php require_once __DIR__ . '/../sections/header.php' ?>

    <section id="cab" class="pt-4">
        <div class="container-fluid">
            <div class="row">
                <div id="cabNav" class="col-12 col-md-auto mb-4 mb-md-0 px-3 px-md-4">
                    <h3 class="mb-4 user-select-none">Мой кабинет</h3>
                    <a href="/cab" class="cab-nav-item <?= ($this->data['content'] ?? '') === '' ? 'active' : '' ?> d-flex align-items-center py-2">
                        <div class="icon" style="background-image: url(../../../public/img/grey-user-icon.png); width: 20px; height: 20px"></div>
                        <p class="mb-0 ml-3 user-select-none">Личный данные</p>
                    </a>

                    <a href="/cab/favorites" class="cab-nav-item <?= ($this->data['content'] ?? '') === 'favorites' ? 'active' : '' ?> d-flex align-items-center py-2">
                        <div class="icon" style="background-image: url(../../../public/img/grey-heart.png); width: 20px; height: 20px"></div>
                        <p class="mb-0 ml-3 user-select-none">Список желаемого</p>
                    </a>

                    <a href="/cab/orders" class="cab-nav-item <?= ($this->data['content'] ?? '') === 'orders' ? 'active' : '' ?> d-flex align-items-center py-2">
                        <div class="icon" style="background-image: url(../../../public/img/grey-cart.png); width: 20px; height: 20px"></div>
                        <p class="mb-0 ml-3 user-select-none">Мои заказы</p>
                    </a>
                </div>
                <div id="cabContent" class="col-12 col-md py-5 px-3 px-md-5">
                    <?php
                    switch ($this->data['content']) {
                        case 'orders':
                            require __DIR__ . '/../sections/orders-cab.php';
                            break;
                        case 'favorites':
                            require __DIR__ . '/../sections/favorites-cab.php';
                            break;
                        default:
                            require __DIR__ . '/../sections/private-info-cab.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../components/cart-popup.php' ?>

    <div class="d-md-none d-block" style="height: 84px"></div>

    <script type="text/javascript">
        $("#cabPersonalInfo input[name='userPhone']").inputmask('+7 (999) 999 9999');
    </script>

    <script type="text/javascript">
        $("#exitFromAccountButton").click(function () {
            if(confirm('Вы уверены что хотите выйти из аккаунта?')) {
                $.post('/app/api/Authorization.php', {
                    operation: 'exit',
                    target: 'user'
                }).done(function () {
                    location.replace('/');
                }).fail(function (error) {
                    alert(error.responseText);
                });
            }
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

    <script src="/public/js/updateUserData.js"></script>
    <script src="../../../public/js/cart.js"></script>
</body>
</html>
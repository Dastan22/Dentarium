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
    <link rel="stylesheet" href="../../../public/css/order.css">
    <link rel="stylesheet" href="../../../public/css/reg-popup.css">
    <script src="../../../public/lib/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/RobinHerbots/jquery.inputmask@5.0.0-beta.87/dist/jquery.inputmask.min.js"></script>
    <title>Оформление заказа</title>
</head>
<body>
    <?php require_once __DIR__ . '/../sections/header.php' ?>
    <?php require_once __DIR__ . '/../sections/order.php' ?>
    <?php require_once __DIR__ . '/../components/reg-popup.php' ?>

    <div class="d-md-none d-block" style="height: 84px"></div>

    <script type="text/javascript">
        let gotoCabinetButton = $("#goCabinetButton"),
            gotoCabinetMobileButton = $("#goCabinetMobileButton"),
            closeRegPopupButton = $("#regPopup .close-popup"),
            regPopup = $("#regPopup");

        gotoCabinetButton.click(showAuthPopup);
        gotoCabinetMobileButton.click(showAuthPopup);
        $("#authFormErrorButton").click(showAuthPopup);

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

    <script src="../../../public/js/auth.js"></script>
    <script src="../../../public/js/reg.js"></script>
    <script src="../../../public/js/order.js"></script>
</body>
</html>
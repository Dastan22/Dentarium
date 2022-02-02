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
    <link rel="stylesheet" href="../../../public/css/index.css">
    <link rel="stylesheet" href="../../../public/css/header.css">
    <link rel="stylesheet" href="../../../public/css/panel.css">
    <link rel="stylesheet" href="../../../public/css/add-product-panel.css">
    <link rel="stylesheet" href="../../../public/css/products-panel.css">
    <link rel="stylesheet" href="../../../public/css/categories-panel.css">
    <link rel="stylesheet" href="../../../public/css/populars-panel.css">
    <link rel="stylesheet" href="../../../public/css/edit-product-panel.css">
    <link rel="stylesheet" href="../../../public/css/orders-panel.css">
    <link rel="stylesheet" href="../../../public/css/banners-panel.css">
    <script src="/public/js/main.js"></script>
    <script src="../../../public/lib/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@4.0.9/dist/jquery.inputmask.bundle.min.js"></script>
    <title>Dentarium.kz – панель администрирования</title>
</head>
<body>
<?php require_once __DIR__ . '/../sections/header.php' ?>

<section id="panel" class="pt-4">
    <div class="container-fluid pl-4">
        <div class="row">
            <div id="panelNav" class="col-auto pr-4">
                <h3 class="mb-4 user-select-none">Админ-панель</h3>
                <a href="/panel" class="panel-nav-item <?= ($this->data['content'] ?? '') === '' ? 'active' : '' ?> d-flex align-items-center py-2">
                    <p class="mb-0 ml-3 user-select-none">Управление заказами</p>
                </a>
                
                <a href="/panel/products" class="panel-nav-item <?= (($this->data['content'] ?? '') === 'products' or ($this->data['content'] ?? '') === 'edit') ? 'active' : '' ?> d-flex align-items-center py-2">
                    <p class="mb-0 ml-3 user-select-none">Управление товарами</p>
                </a>

                <a href="/panel/categories" class="panel-nav-item <?= ($this->data['content'] ?? '') === 'categories' ? 'active' : '' ?> d-flex align-items-center py-2">
                    <p class="mb-0 ml-3 user-select-none">Управление категориями</p>
                </a>

                <a href="/panel/banners" class="panel-nav-item <?= ($this->data['content'] ?? '') === 'banners' ? 'active' : '' ?> d-flex align-items-center py-2">
                    <p class="mb-0 ml-3 user-select-none">Управление банерами</p>
                </a>

                <a href="/panel/add-product" class="panel-nav-item <?= ($this->data['content'] ?? '') === 'add-product' ? 'active' : '' ?> d-flex align-items-center py-2">
                    <p class="mb-0 ml-3 user-select-none">Добавление товаров</p>
                </a>
            </div>
            <div id="panelContent" class="col px-5 pt-5">
                <?php
                switch ($this->data['content'] ?? '') {
                    case 'products':
                        require __DIR__ . '/../sections/products-panel.php';
                        break;
                    case 'categories':
                        require __DIR__ . '/../sections/categories-panel.php';
                        break;
                    case 'populars':
                        require __DIR__ . '/../sections/populars-panel.php';
                        break;
                    case 'edit':
                        require __DIR__ . '/../sections/edit-product-panel.php';
                        break;
                    case 'add-product':
                        require __DIR__ . '/../sections/add-product-panel.php';
                        break;
                    case 'banners':
                        require __DIR__ . '/../sections/banners-panel.php';
                        break;
                    default:
                        require __DIR__ . '/../sections/orders-panel.php';
                }
                ?>
            </div>
        </div>
    </div>
</section>
</body>
</html>
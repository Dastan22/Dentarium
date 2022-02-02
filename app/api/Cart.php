<?php


namespace app\api;


class Cart
{
    /**
     * Добавляет товара в корзину
     * @param int $productId
     */
    public static function add(int $productId): void
    {
        if($productId === 0) {
            http_response_code(406);
            echo 'Не указан айди товара';
            die();
        }

        try {
            \app\traits\Cart::add($productId);

            echo $_SESSION['cart'] ?? '[]';
        } catch (\Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Прибавляет единицу товара в корзине
     * @param int $productId
     */
    public static function plus(int $productId = 0): void
    {
        if($productId === 0) {
            http_response_code(406);
            echo 'Не указан айди товара';
            die();
        }

        try {
            \app\traits\Cart::plus($productId);

            echo $_SESSION['cart'] ?? '[]';
        } catch (\Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Убирает единицу товара из корзины
     * @param int $productId
     */
    public static function minus(int $productId = 0): void
    {
        if($productId === 0) {
            http_response_code(406);
            echo 'Не указан айди товара';
            die();
        }

        try {
            \app\traits\Cart::minus($productId);

            echo $_SESSION['cart'] ?? '[]';
        } catch (\Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Удаляет товара из корзины
     * @param int $productId
     */
    public static function delete(int $productId = 0): void
    {
        if($productId === 0) {
            http_response_code(406);
            echo 'Не указан айди товара';
            die();
        }

        try {
            \app\traits\Cart::delete($productId);

            echo $_SESSION['cart'] ?? '[]';
        } catch (\Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require_once __DIR__ . '/../autoload.php';

session_start();

switch ($_POST['operation'] ?? '') {
    case 'add':
        (new Cart())::add(
            $_POST['productId'] ?? 0
        );
        break;
    case 'plus':
        (new Cart())::plus(
            $_POST['productId'] ?? 0
        );
        break;
    case 'minus':
        (new Cart())::minus(
            $_POST['productId'] ?? 0
        );
        break;
    case 'delete':
        (new Cart())::delete(
            $_POST['productId'] ?? 0
        );
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос';
        die();
}
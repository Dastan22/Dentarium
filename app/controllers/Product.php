<?php


namespace app\controllers;


use app\models\Category;
use app\traits\Access;
use Exception;

class Product
{
    public static function getData()
    {
        return [
            'productInfo' => self::getProductInfo($_GET['id'] ?? 0),
            'isAuth' => Access::check('user'),
            'cart' => self::getCart(),
            'categories' => Category::getAll()
        ];
    }

    /**
     * Возвращает данные товара по его айди
     * @param int $productId
     * @return mixed
     * @throws Exception
     */
    private static function getProductInfo(int $productId = 0)
    {
        if($productId === 0) {
            throw new Exception('Не указан айди товара');
        }

        return \app\models\Product::getOneById($productId)[0] ?? [];
    }

    /**
     * Получает корзину товаров
     * @return array
     */
    private static function getCart(): array
    {
        return json_decode($_SESSION['cart'] ?? '[]');
    }
}
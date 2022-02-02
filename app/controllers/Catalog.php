<?php


namespace app\controllers;


use app\models\Category;
use app\traits\Access;
use Exception;

class Catalog
{
    /**
     * Собирает и возвращает данные для представления
     * @return array
     * @throws Exception
     */
    public static function getData(): array
    {
        $data = [
            'categories' => self::getCategories(),
            'products' => self::getProducts(intval($_GET['id'] ?? 0)),
            'currentCategory' => self::getCurrentCategory(),
            'isAuth' => Access::check('user'),
            'cart' => self::getCart()
        ];

        if($data['isAuth']) {
            $data['countOfFavorites'] = \app\models\Product::getCountOfFavorites();
        }

        return $data;
    }

    /**
     * Получает все доступные категории товаров
     * @return array
     * @throws Exception
     */
    private static function getCategories(): array
    {
        return Category::getAll();
    }

    private static function getCurrentCategory(): string
    {
        return Category::getTitles([$_GET['id'] ?? 0])[0]['title'] ?? 'Название категории не найдено';
    }

    /**
     * Получает все товары по айди категории
     * @param int $categoryId
     * @return array
     * @throws Exception
     */
    private static function getProducts(int $categoryId = 0): array
    {
        return \app\models\Product::getByCategoryId(intval($_GET['id'] ?? 0), 15, 0, -1);
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
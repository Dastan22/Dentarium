<?php


namespace app\controllers;


use app\models\Category;
use app\models\User;
use app\traits\Layout;
use Exception;

class Cab
{
    public static function getData(): array
    {
        $data = [
            'user' => self::getUser(),
            'content' => self::defineContent(),
            'countOfFavorites' => \app\models\Product::getCountOfFavorites(),
            'categories' => self::getCategories(),
            'cart' => self::getCart()
        ];

        if($data['content'] === 'orders') {
            $data['orders'] = self::getOrders();
        }

        if($data['content'] === 'favorites') {
            $data['favorites'] = self::getFavorites();
        }

        return $data;
    }

    /**
     * Получает данные о пользователе
     * @return array
     * @throws Exception
     */
    private static function getUser(): array
    {
        return User::get();
    }

    /**
     * Определяет запрашиваемую секцию кабинета
     * @return string
     */
    private static function defineContent(): string
    {
        return Layout::getUriAsArray()[1] ?? '';
    }

    /**
     * Возвращает заказы пользователя
     * @return array
     * @throws Exception
     */
    private static function getOrders(): array
    {
        return \app\models\Order::getByUserId();
    }

    private static function getFavorites(): array
    {
        return \app\models\Product::getFavorites();
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

    /**
     * Получает корзину товаров
     * @return array
     */
    private static function getCart(): array
    {
        return json_decode($_SESSION['cart'] ?? '[]');
    }
}
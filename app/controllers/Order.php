<?php


namespace app\controllers;


use app\models\User;
use app\traits\Access;

class Order
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getData(): array
    {
        $data = [
            'cart' => json_decode($_SESSION['cart'] ?? '[]'),
            'isAuth' => Access::check('user')
        ];

        if($data['isAuth']) {
            $data['countOfFavorites'] = \app\models\Product::getCountOfFavorites();
            $data['userData'] = User::get();
        }

        return $data;
    }
}
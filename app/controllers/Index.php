<?php


namespace app\controllers;


use app\models\Banner;
use app\models\Category;
use app\traits\Access;
use Exception;

class Index
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
            'isAuth' => Access::check('user'),
            'cart' => self::getCart(),
            'banners' => self::getBanners()
        ];

        if($data['isAuth']) {
            $data['countOfFavorites'] = \app\models\Product::getCountOfFavorites();
        }

        if(isset($_GET['search'])) {
            $data['products'] = self::searchProducts();
        } else {
            $data['products'] = self::getPopularProducts();
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

    /**
     * Получает популярные товары
     * @return array
     * @throws Exception
     */
    private static function getPopularProducts(): array
    {
        return \app\models\Product::getAll(15, 0, -1);
    }

    /**
     * Получает корзину товаров
     * @return array
     */
    private static function getCart(): array
    {
        return json_decode($_SESSION['cart'] ?? '[]');
    }

    /**
     * Ищет товары по поисковому запросу
     * @return array
     * @throws Exception
     */
    private static function searchProducts(): array
    {
        return \app\models\Product::fullTextSearch($_GET['search'], 15, 0, -1);
    }

    /**
     * Получат все баннеры
     * @return array
     * @throws Exception
     */
    private static function getBanners(): array
    {
        $allBanners = Banner::getAll();
        $output = [
            'desktop' => [],
            'mobile' => []
        ];

        foreach ($allBanners as $banner) {
            if(intval($banner['is_mobile']) === 0) {
                $output['desktop'][] = $banner;
            } else {
                $output['mobile'][] = $banner;
            }
        }

        return $output;
    }
}
<?php


namespace app\controllers;


use app\models\Banner;
use app\models\Category;
use app\traits\Layout;
use Exception;

class Panel
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getData()
    {
        $data = [
            'content' => self::defineContent(),
            'categories' => Category::getAll()
        ];

        if($data['content'] === '') {
            $data['orders'] = \app\models\Order::getAll(15, $_GET['search'] ?? '');
        }

        if($data['content'] === 'products' AND isset($_GET['searchString'])) {
            $data['products'] = \app\models\Product::fullTextSearch(htmlspecialchars($_GET['searchString']));
        }

        if($data['content'] === 'edit') {
            $data['productInfo'] = \app\models\Product::getOneById($_GET['id'] ?? 0)[0] ?? [];
            $data['categoriesTitles'] = Category::getTitles();
        }

        if($data['content'] === 'add-product') {
            $data['categoriesTitles'] = Category::getTitles();
        }

        if($data['content'] === 'banners') {
            $data['banners'] = self::getBanners();
        }

        return $data;
    }

    /**
     * Определяет запрашиваемую секцию админ-панели
     * @return string
     */
    private static function defineContent(): string
    {
        return Layout::getUriAsArray()[1] ?? '';
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
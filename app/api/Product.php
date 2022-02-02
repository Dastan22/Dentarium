<?php


namespace app\api;


use app\traits\Access;
use Exception;
use Throwable;

class Product
{
    /**
     * Добавляет или удаляет товар в избранное
     * @param int $productId
     * @throws Exception
     */
    public static function addIntoFavorites(int $productId): void
    {
        if($productId === 0) {
            http_response_code(406);
            echo 'Не удалось получить айди товара';
            die();
        }

        try {
            if(!Access::check('user')) {
                http_response_code(401);
                echo 'Для добавления товаров в избранное необходимо авторизоваться';
                die();
            }

            if(\app\models\Product::isFavorite($productId)) {
                \app\models\Product::removeFromFavorites($productId);
            } else {
                \app\models\Product::addIntoFavorites($productId);
            }
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    public static function add(): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к добавлению новых товаров';
            die();
        }

        try {
            \app\models\Product::add([
                'productVendor' => $_POST['productVendor'] ?? '',
                'productBrand' => $_POST['productBrand'] ?? '',
                'productCountry' => $_POST['productCountry'] ?? '',
                'productAmount' => intval($_POST['productAmount'] ?? 0),
                'productTitle' => $_POST['productTitle'] ?? '',
                'productCategory' => $_POST['productCategory'] ?? 0,
                'productDescription' => $_POST['productDescription'] ?? '',
                'productCharacters' => $_POST['productCharacters'] ?? '',
                'productUsage' => $_POST['productUsage'] ?? '',
                'productFeatures' => $_POST['productFeatures'] ?? '',
                'productPrice' => $_POST['productPrice'] ?? 0
            ]);
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Удаляет товар
     * @param int $productId
     */
    public static function delete(int $productId = 0): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к удалению товаров';
            die();
        }

        try {
            \app\models\Product::delete($productId);
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Обновляет данные товара
     * @param int $productId
     * @param array $fields
     * @param array $data
     */
    public static function update(int $productId = 0, array $fields = [], array $data = []): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к редактированию товаров';
            die();
        }

        try {
            \app\models\Product::update(
                $productId,
                $fields[0],
                array($data[0])
            );
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Получает все товары
     * @param int $limit
     * @param int $minPrice
     * @param int $maxPrice
     */
    public static function getAll(int $limit = 15, int $minPrice = 0, int $maxPrice = 0): void
    {
        try {
            $r = \app\models\Product::getAll($limit, $minPrice, $maxPrice);

            echo json_encode($r);
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Ищет товар по поисковому запросу
     * @param int $limit
     * @param string $searchString
     * @param int $minPrice
     * @param int $maxPrice
     */
    public static function fullTextSearch(int $limit = 15, string $searchString = '', int $minPrice = 0, int $maxPrice = 0): void
    {
        try {
            $r = \app\models\Product::fullTextSearch($searchString, $limit, $minPrice, $maxPrice);

            echo json_encode($r);
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    public static function getByCategory(int $limit = 15, int $categoryId = 0, int $minPrice = 0, int $maxPrice = -1): void
    {
        try {
            $r = \app\models\Product::getByCategoryId($categoryId, $limit, $minPrice, $maxPrice);

            echo json_encode($r);
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require_once __DIR__ . '/../autoload.php';

switch ($_POST['operation'] ?? '') {
    case 'addIntoFavorites':
        Product::addIntoFavorites($_POST['productId'] ?? 0);
        break;
    case 'add':
        Product::add();
        break;
    case 'delete':
        Product::delete($_POST['productId'] ?? 0);
        break;
    case 'update':
        Product::update(
            $_POST['productId'] ?? 0,
            array(json_decode($_POST['fields'] ?? '[]')),
            array(json_decode($_POST['data'] ?? '[]'))
        );
        break;
    case 'getAll':
        Product::getAll(
            $_POST['limit'] ?? 0,
            $_POST['minPrice'] ?? 0,
            $_POST['maxPrice'] ?? 0
        );
        break;
    case 'fullTextSearch':
        Product::fullTextSearch(
            $_POST['limit'] ?? 0,
            $_POST['searchString'] ?? '',
            $_POST['minPrice'] ?? 0,
            $_POST['maxPrice'] ?? -1
        );
        break;
    case 'getByCategory':
        Product::getByCategory(
            $_POST['limit'] ?? 0,
            $_POST['categoryId'] ?? 0,
            $_POST['minPrice'] ?? 0,
            $_POST['maxPrice'] ?? -1
        );
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос';
        die();
}
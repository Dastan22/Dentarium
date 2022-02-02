<?php


namespace app\api;


use app\traits\Access;
use Throwable;

class Category
{
    /**
     * Добавляет новую категорию
     * @param int $parentId
     * @param string $title
     */
    public static function add(int $parentId = 0, string $title = ''): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к добавлению новых категорий';
            die();
        }

        try {
            \app\models\Category::add(
                $parentId,
                $title
            );
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Обновляет название категории
     * @param int $categoryId
     * @param string $newTitle
     */
    public static function update(int $categoryId = 0, string $newTitle = ''): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к редактированию категорий';
            die();
        }

        try {
            \app\models\Category::update(
                $categoryId,
                $newTitle
            );
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Получение связанных категорий
     * @param int $categoryId
     */
    public static function getConnected(int $categoryId = 0): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к получению связанных категорий';
            die();
        }

        try {
            echo json_encode(\app\models\Category::getConnected($categoryId));
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Удаляет категорию
     * @param int $categoryId
     */
    public static function delete(int $categoryId = 0): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'У вас нет доступа к удалению категорий';
            die();
        }

        try {
            \app\models\Category::delete($categoryId);
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Получает кол-во товаров основных категорий
     */
    public static function getCountOfProductsOfMainCategories(): void
    {
        try {
            echo json_encode(\app\models\Category::getCountOfProductsOfMainCategories());
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require_once __DIR__ . '/../autoload.php';

switch ($_POST['operation'] ?? '') {
    case 'add':
        Category::add(
            $_POST['parentId'] ?? 0,
            $_POST['title'] ?? ''
        );
        break;
    case 'update':
        Category::update(
            $_POST['categoryId'] ?? 0,
            $_POST['newTitle'] ?? ''
        );
        break;
    case 'getConnected':
        Category::getConnected($_POST['categoryId'] ?? 0);
        break;
    case 'delete':
        Category::delete($_POST['categoryId'] ?? 0);
        break;
    case 'getCountOfProductsOfMainCategories':
        Category::getCountOfProductsOfMainCategories();
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос';
        die();
}
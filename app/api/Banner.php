<?php


namespace app\api;


use app\traits\Access;

class Banner
{
    /**
     * Добавляет новый баннер
     * @param int $isMobile
     * @param string $link
     */
    public static function add(int $isMobile = 0, string $link = '/'): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'Необходима авторизация';
            die();
        }

        try {
            \app\models\Banner::add(
                $isMobile,
                $link
            );
        } catch (\Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Удаляет баннер
     * @param int $bannerId
     */
    public static function delete(int $bannerId = 0): void
    {
        if(!Access::check('administrator')) {
            http_response_code(401);
            echo 'Необходима авторизация';
            die();
        }

        try {
            \app\models\Banner::delete(
                $bannerId
            );
        } catch (\Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require __DIR__ . '/../autoload.php';

switch ($_POST['operation'] ?? '') {
    case 'add':
        (new Banner())::add(
            $_POST['isMobile'] ?? 0,
            $_POST['link'] ?? '/'
        );
        break;
    case 'delete':
        (new Banner())::delete(
            $_POST['bannerId'] ?? 0
        );
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос' . $_POST['operation'];
        die();
}
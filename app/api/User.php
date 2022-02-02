<?php


namespace app\api;


use app\traits\Access;
use Throwable;

class User
{
    /**
     * Обновляет данные пользователя
     * @param array $fields
     * @param array $data
     */
    public static function update(array $fields, array $data): void
    {
        if(count($fields) === 0) {
            http_response_code(406);
            echo 'Принят пустой массив с полями для редактирования';
            die();
        }

        if(count($data) === 0) {
            http_response_code(406);
            echo 'Принят пустой массив с данными для редактирования';
            die();
        }

        if(!Access::check('user')) {
            http_response_code(401);
            echo 'Пользователь не авторизован';
            die();
        }

        try {
            \app\models\User::edit(
                $fields,
                $data
            );
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require_once __DIR__ . '/../autoload.php';

switch ($_POST['operation'] ?? '') {
    case 'update':
        User::update(
            $_POST['fields'] ?? [],
            array (json_decode($_POST['data'] ?? '[]'))
        );
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос';
        die();
}
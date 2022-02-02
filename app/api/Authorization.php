<?php


namespace app\api;


use app\models\Administrator;
use app\models\User;
use Exception;
use Throwable;

class Authorization
{
    /**
     * Авторизовывает пользователя
     * @param string $target
     * @param string $phone
     * @param string $password
     * @param int $needToSave
     */
    public static function auth(string $target, string $phone, string $password, int $needToSave): void
    {
        try {
            if($target === 'user') {
                User::auth(
                    $phone,
                    $password,
                    $needToSave
                );
            } else if($target === 'administrator') {
                Administrator::auth(
                    $phone,
                    $password,
                    $needToSave
                );
            } else {
                throw new Exception('Не удалось определить тип пользователя');
            }
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Регистрирует новый аккаунт
     * @param string $target
     * @param array $params
     */
    public static function reg(string $target, array $params): void
    {
        try {
            if($target === 'user') {
                User::reg(
                    $params['phone'] ?? '',
                    $params['password'] ?? ''
                );
            } else {
                throw new Exception('Не удалось определить тип пользователя');
            }
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Выходит из аккаунта
     * @param string $target
     */
    public static function exitFromAccount(string $target): void
    {
        try {
            if($target === 'user') {
                User::exitFromAccount();
            } else {
                throw new Exception('Не удалось определить тип пользователя');
            }
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require_once __DIR__ . '/../autoload.php';

switch ($_POST['operation'] ?? '') {
    case 'auth':
        (new Authorization())::auth(
            $_POST['target'] ?? '',
            $_POST['phone'] ?? '',
            $_POST['password'] ?? '',
            $_POST['needToSave'] ?? 0
        );
        break;
    case 'reg':
        (new Authorization())::reg(
            $_POST['target'] ?? 'user',
            $_POST['params'] ?? []
        );
        break;
    case 'exit':
        (new Authorization())::exitFromAccount(
            $_POST['target'] ?? ''
        );
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос';
        die();
}
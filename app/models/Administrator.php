<?php


namespace app\models;


use app\traits\Access;
use Exception;

class Administrator
{
    /**
     * Авторизовывает администратора по номеру телефона и паролю.
     * Выкидывает исключение, если что-то пошло не так.
     * @param string $phone
     * @param string $password
     * @param int $needToSave
     * @throws Exception
     */
    public static function auth(string $phone = '', string $password = '', int $needToSave = 0): void
    {
        if($phone === '') {
            throw new Exception('Не указан номер телефона');
        }

        if($password === '') {
            throw new Exception('Не указан пароль');
        }

        Access::auth($phone, $password, $needToSave, 'administrator');
    }
}
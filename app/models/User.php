<?php


namespace app\models;

use app\Db;
use app\traits\Access;
use Exception;

class User
{
    /**
     * Авторизовывает пользователя по номеру телефона и паролю.
     * Выкидывает исключение, если что-то пошло не так.
     * @param string $phone (номер телефон)
     * @param string $password (пароль)
     * @param int $needToSave (необходимо ли сохранять вход: 0 - нет; 1 - да)
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

        Access::auth($phone, $password, $needToSave, 'user');
    }

    /**
     * Регистрирует нового пользователя.
     * Выкидывает исключение, если чьл-то пошло не так.
     * @param string $phone (номер телефона)
     * @param string $password (пароль)
     * @throws Exception
     */
    public static function reg(string $phone, string $password): void
    {
        if(strlen($phone) < 10) {
            throw new Exception('Номер телефона должен быть не короче 10-и цифр');
        }

        if(strlen($password) < 8) {
            throw new Exception('Пароль должен быть длинее 7-и символов');
        }

        Access::reg('user', ['phone' => $phone, 'password' => $password]);
    }

    /**
     * Удаляет куки авторизации
     */
    public static function exitFromAccount(): void
    {
        setcookie('dentarium_userId', '', time() - 604800, '/');
        setcookie('dentarium_sessionToken', '', time() - 604800, '/');
    }

    /**
     * Получает данные о пользователе
     * @return array
     * @throws Exception
     */
    public static function get(): array
    {
        $get__sql = 'SELECT
                     id,
                     IF(full_name IS NOT NULL, full_name, \'Не указано\') as name,
                     phone,
                     IF(address IS NOT NULL, address, \'Не указано\') as address,
                     IF(email IS NOT NULL, email, \'Не указано\') as email
                     FROM users WHERE id = :id';
        $get__data = [
            ':id' => self::getId()
        ];

        return (new Db())->query($get__sql, $get__data)[0] ?? [];
    }

    /**
     * Обновляет данные о пользователе
     * @param array $fields
     * @param array $data
     * @throws Exception
     */
    public static function edit(array $fields, array $data): void
    {
        $userId = self::getId();

        if($userId === 0) {
            throw new Exception('Не удалось определить айди пользователя');
        }

        foreach ($fields as $field) {
            switch ($field) {
                case 'name':
                    self::updateName($userId, $data[0]->name);
                    break;
                case 'address':
                    self::updateAddress($userId, $data[0]->address ?? '');
                    break;
                case 'email':
                    self::updateEmail($userId, $data[0]->email ?? '');
                    break;
                case 'phone':
                    self::updatePhone($userId, $data[0]->phone ?? '');
                    break;
                default:
                    throw new Exception('Не удалось определить поле для редактирования');
            }
        }
    }

    /**
     * Обновляет ФИО пользователя
     * @param int $userId
     * @param string $value
     * @throws Exception
     */
    private static function updateName(int $userId, string $value): void
    {
        if($value === '') {
            throw new Exception('Не удалось определить новое ФИО пользователя');
        }

        if(strlen($value) > 256) {
            throw new Exception('ФИО не может быть длинее 256-и символов');
        }

        $updateName__sql = 'UPDATE users SET full_name = :full_name WHERE id = :id';
        $updateName__data = [
            ':full_name' => $value,
            ':id'  => $userId
        ];

        (new Db())->execute($updateName__sql, $updateName__data);
    }

    /**
     * Обновляет адрес пользователя
     * @param int $userId
     * @param string $value
     * @throws Exception
     */
    private static function updateAddress(int $userId, string $value): void
    {
        if($value === '') {
            throw new Exception('Не удалось определить новый адрес пользователя');
        }

        if(strlen($value) > 256) {
            throw new Exception('Адрес не может быть длинее 256-и символов');
        }

        $updateAddress__sql = 'UPDATE users SET address = :address WHERE id = :id';
        $updateAddress__data = [
            ':address' => $value,
            ':id' => $userId
        ];

        (new Db())->execute($updateAddress__sql, $updateAddress__data);
    }

    /**
     * Обновляет email пользователя
     * @param int $userId
     * @param string $value
     * @throws Exception
     */
    private static function updateEmail(int $userId, string $value): void
    {
        if($value === '') {
            throw new Exception('Не удалось определить новый email пользователя');
        }

        if(strlen($value) > 128) {
            throw new Exception('Email не может быть длинее 128-и символов');
        }

        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Некорректный email');
        }

        $updateEmail__sql = 'UPDATE users SET email = :email WHERE id = :id';
        $updateEmail__data = [
            ':email' => $value,
            ':id' => $userId
        ];

        (new Db())->execute($updateEmail__sql, $updateEmail__data);
    }

    /**
     * Обновляет телефон пользователя
     * @param int $userId
     * @param string $value
     * @throws Exception
     */
    private static function updatePhone(int $userId, string $value): void
    {
        if($value === '') {
            throw new Exception('Не удалось определить новый телефон пользователя');
        }

        if(strlen($value) < 11) {
            throw new Exception('Телефон не может быть корече 11-и символов');
        }

        $updatePhone__sql = 'UPDATE users SET phone = :phone WHERE id = :id';
        $updatePhone__data = [
            ':phone' => $value,
            ':id' => $userId
        ];

        (new Db())->execute($updatePhone__sql, $updatePhone__data);
    }

    /**
     * Возвращает айди пользователя, если он авторизован.
     * Если нет, возвращает 0
     * @return int
     */
    public static function getId(): int
    {
        return intval(substr($_COOKIE['dentarium_userId'] ?? 00,0,-1));
    }
}
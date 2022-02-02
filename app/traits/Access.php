<?php


namespace app\traits;

use app\Db;
use Exception;
use Throwable;

/**
 * Реализовывает функицонал авторизвации и регистрации
 * @package app\traits
 */
trait Access
{
    /**
     * Авторизовывает пользователя по номеру телефона и паролю.
     * Выкидывает исключение, если что-то пошло не так.
     * @param string $phone
     * @param string $password
     * @param int $needToSave
     * @param string $target
     * @throws Exception
     */
    public static function auth(string $phone, string $password, int $needToSave, string $target): void
    {
        $id = self::checkByPhone($phone, $target);

        $id = self::checkByPassword($id, $phone, $password, $target);

        self::saveAccess($id, $target, $needToSave);
    }

    /**
     * Регистрирует нового пользователя.
     * Выкидывает исключение, если что-то пошло не так.
     * @param string $target
     * @param array $params
     * @throws Exception
     */
    public static function reg(string $target, array $params): void
    {
        $id = self::addNewUser($target, $params);

        self::saveAccess($id, $target, 0);
    }

    /**
     * Проверяет авторизвацию пользователя
     * @param string $target (тип пользователя: user)
     * @return bool
     */
    public static function check(string $target = ''): bool
    {
        try {
            if(!isset($_COOKIE['dentarium_userId']) or !isset($_COOKIE['dentarium_sessionToken'])) {
                throw new Exception('Куки не установлены');
            }

            if($target === '') {
                throw new Exception('Не указан тип пользователя');
            }

            self::checkAuthToken($target);

            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Выкенет исключение, если не удалось проверить токен.
     * @param string $target
     * @throws Exception
     */
    private static function checkAuthToken(string $target): void
    {
        $userId = intval(substr($_COOKIE['dentarium_userId'], 0, -1));
        $authHash = $_COOKIE['dentarium_sessionToken'];

        switch ($target) {
            case 'user':
                $checkAuthToken__sql = 'SELECT token
                                        FROM users_tokens
                                        WHERE user_id = :user_id AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(time_created) < time_valid
                                        ORDER BY id DESC LIMIT 1';
                $checkAuthToken__data = [
                    ':user_id' => $userId
                ];
                break;
            case 'administrator':
                $checkAuthToken__sql = 'SELECT token
                                        FROM administrators_tokens
                                        WHERE administrator_id = :administrator_id AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(time_created) < time_valid
                                        ORDER BY id DESC LIMIT 1';
                $checkAuthToken__data = [
                    ':administrator_id' => $userId
                ];
                break;
            default:
                throw new Exception('Неизвестный тип пользователя');
        }

        $db = new Db();

        $r = $db->query($checkAuthToken__sql, $checkAuthToken__data);

        if(count($r) === 0) {
            throw new Exception('Токен не найден');
        }

        $hashFromDB = hash('sha256', $_SERVER['HTTP_USER_AGENT'] . $r[0]['token']);

        if($authHash !== $hashFromDB) {
            throw new Exception('Токены не совпадают');
        }
    }

    /**
     * Добавляет нового пользователя в БД.
     * При успехе, возвращает айли новой записи.
     * @param string $target (тип пользователя: user)
     * @param array $params (данные для нового аккаунта)
     * @return int
     * @throws Exception
     */
    private static function addNewUser(string $target, array $params = []): int
    {
        switch ($target) {
            case 'user':
                self::checkByPhone($params['phone'], 'user', true);

                $addNewUser__sql = 'INSERT INTO users (phone, password)
                                    VALUES (:phone, :password)';
                $addNewUser__data = [
                    ':phone' => $params['phone'] ?? null,
                    ':password' => hash('sha256', $params['password'] ?? CustomString::getRandomString())
                ];
                break;
            default:
                throw new Exception('Не удалось определить тип пользователя при регистрации аккаунта');
        }

        $db = new Db();

        $db->execute($addNewUser__sql, $addNewUser__data);

        return $db->getLastInsertId();
    }

    /**
     * Возвращает айди пользователя по его номеру телефон.
     * Выкидывает исключение, если пользователя не существует.
     * @param string $phone
     * @param string $target
     * @param bool $checkForReg
     * @return int
     * @throws Exception
     */
    private static function checkByPhone(string $phone, string $target, bool $checkForReg = false): int
    {
        $checkByPhone__sql = 'SELECT id FROM ' . $target . 's WHERE phone = :phone';
        $checkByPhone__data = [
            ':phone' => $phone
        ];

        $db = new Db();

        $r = $db->query($checkByPhone__sql, $checkByPhone__data);

        if(!$checkForReg) {
            if(count($r) > 1) {
                throw new Exception('На этот номер зарегистрировано несколько аккаунтов! Для устранения проблемы обратитесь в поддержку магазина');
            }

            if(count($r) === 0) {
                throw new Exception('Пользователя с таким номером не существует');
            }

            return $r[0]['id'];
        } else {
            if(count($r) > 0) {
                throw new Exception('На этот номер уже зарегистрирован другой аккаунт');
            }

            return 0;
        }
    }

    /**
     * Возвращает айди пользователя по его номеру телефону и паролю.
     * Выкидывает исключение, если что-то пошло не так.
     * @param int $id
     * @param string $phone
     * @param string $password
     * @param string $target
     * @return int
     * @throws Exception
     */
    private static function checkByPassword(int $id, string $phone, string $password, string $target): int
    {
        $checkByPassword__sql = 'SELECT id FROM ' . $target . 's
                                 WHERE id = :id AND phone = :phone AND password = :password';
        $checkByPassword__data = [
            ':id' => $id,
            ':phone' => $phone,
            ':password' => hash('sha256', $password)
        ];

        $db = new Db();

        $r = $db->query($checkByPassword__sql, $checkByPassword__data);

        if(count($r) !== 1) {
            throw new Exception('Введенный пароль неверный');
        }

        return $r[0]['id'];
    }

    private static function saveAccess(int $id, string $target, int $needToSave): void
    {
        $randomToken = CustomString::getRandomString();

        self::setTokenInDatabase($id, $randomToken, $target, $needToSave);

        self::setTokenInCookie($id, $randomToken, $target, $needToSave);
    }

    /**
     * Добавляет токен авторизвации в БД
     * @param int $id
     * @param string $token
     * @param string $target
     * @param int $needToSave
     * @throws Exception
     */
    private static function setTokenInDatabase(int $id, string $token, string $target, int $needToSave): void
    {
        $setTokenInDatabase__sql = 'INSERT INTO ' . $target .'s_tokens (token, ' . $target .'_id, time_valid)
                                    VALUES (:token, :' . $target .'_id, :time_valid)';
        $setTokenInDatabase__data = [
            ':token' => $token,
            ':' . $target .'_id' => $id,
            ':time_valid' => ($needToSave === 0 ? 43200 : 604800)
        ];
        
        $db = new Db();
        
        $q = $db->execute($setTokenInDatabase__sql, $setTokenInDatabase__data);

        if(!$q) {
            throw new Exception('Не удалось добавить токен');
        }
    }

    /**
     * Устанавливает токен авторизации в куки
     * @param int $id
     * @param string $token
     * @param string $target
     * @param int $needToSave
     * @throws Exception
     */
    private static function setTokenInCookie(int $id, string $token, string $target, int $needToSave): void
    {
        if($target === 'user') {
            $value = $id . '1';
        } else if($target === 'administrator') {
            $value = $id . '2';
        } else {
            throw new Exception('Не удалось определить тип аккаунта');
        }

        setcookie(
            'dentarium_userId',
            $value,
            time() + ($needToSave === 0 ? 43200 : 604800),
            '/'
        );

        setcookie(
            'dentarium_sessionToken',
            hash('sha256', $_SERVER['HTTP_USER_AGENT'] . $token),
            time() + ($needToSave === 0 ? 43200 : 604800),
            '/'
        );
    }
}
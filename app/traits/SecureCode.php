<?php


namespace app\traits;


use Exception;

trait SecureCode
{
    /**
     * Устанавливает четырех значный код в сессию
     * @throws Exception
     */
    public static function set(): void
    {
        $_SESSION['secure_code'] = CustomString::getRandomString(4, 'numeric');
    }

    public static function check(string $code = ''): bool
    {
        $secureCode = $_SESSION['secure_code'] ?? '';

        if($code === '') {
            throw new Exception('Метод принят пустую строку');
        }

        if($secureCode === '') {
            throw new Exception('Код подтверждения не установлен');
        }

        if($secureCode === $code) {
            unset($_SESSION['secure_code']);
            return true;
        } else {
            return false;
        }
    }
}
<?php


namespace app\traits;

use Exception;

trait CustomString
{
    /**
     * Генерирует рандомную строку.
     * Выкидывает исключение, если что-то пошло не так.
     * @param int $len (длина строки)
     * @param string $allowCharacters (режим генерации: all - [A-Z-z0-9]; numeric - [0-9])
     * @return string
     * @throws Exception
     */
    public static function getRandomString(int $len = 16, string $allowCharacters = 'all'): string
    {
        $out = '';
        $i = 0;

        if($allowCharacters === 'all') {
            $a = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            while ($i < $len) {
                $i++;
                $out .= $a[rand(0, strlen($a) - 1)];
            }
        } else if($allowCharacters === 'numeric') {
            $a = '0123456789';

            while ($i < $len) {
                $i++;
                $out .= $a[rand(0, strlen($a) - 1)];
            }
        } else {
            throw new Exception('Не удалось определить режим генерации');
        }

        if($out === '') {
            throw new Exception('Возвращена пустая строка');
        }

        return $out;
    }
}
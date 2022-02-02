<?php


namespace app\traits;


trait Layout
{
    /**
     * Возвращает название запрашивоемой страницы
     * @return string
     */
    public static function defineLayout(): string
    {
        return strtolower(self::getUriAsArray()[0]) ?: 'index';
    }

    /**
     * Возвращает uri в виде массива
     * @return array
     */
    public static function getUriAsArray(): array
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        return array_splice($uri, 1);
    }

    /**
     * Возвращает путь для подключения страницы
     * @param string $type тип страницы (page, error)
     * @param string $name название файла страницы
     * @return array
     */
    public static function definePath(string $type = 'page', string $name = 'index'): array
    {
        $path = __DIR__ . '/../views/';

        if($type === 'page') {
            $path .= 'layouts/';
        } else if($type === 'error') {
            $path .= 'errors/';
        } else {
            $path .= 'layouts/';
        }

        $path .= $name . '.php';

        if(file_exists($path)) {
            return [
                'type' => 'page',
                'path' => $path
            ];
        } else {
            return [
                'type' => 'error',
                'path' => __DIR__ . '/../views/errors/404.php'
            ];
        }
    }
}
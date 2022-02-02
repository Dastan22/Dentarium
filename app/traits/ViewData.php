<?php


namespace app\traits;


trait ViewData
{
    /**
     * Возвращает данные для представления
     * Вслучае ошибки, вернет ошибку в виде массива
     * @param string $layout
     * @return array
     */
    public static function getViewData(string $layout = 'index'): array
    {
        $data = [];
        $isError = false;
        $controller = self::getControllerName($layout);

        if($controller) {
            $fullName = 'app\\controllers\\' . $controller;
            try {
                $data = $fullName::getData();
            } catch (\Throwable $e) {
                $isError = true;
                $data = [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ];
            }
        }

        return [
            'data' => $data,
            'isError' => $isError
        ];
    }

    /**
     * Получает название контроллера
     * Вернет null, если контроллера не найдено
     * @param string $layout
     * @return string|null
     */
    private static function getControllerName(string $layout)
    {
        $controllerPath = __DIR__ . '/../controllers/' . ucfirst($layout) . '.php';

        return file_exists($controllerPath) ? ucfirst($layout) : null;
    }
}
<?php


namespace app;


use app\traits\Access;
use app\traits\Layout;
use app\traits\ViewData;

class View
{
    /**
     * Страница для отображения
     * @var string
     */
    public string $layout = 'index';

    /**
     * Данные для представления
     * @var array
     */
    public array $data = [];

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->layout = Layout::defineLayout();
    }

    /**
     * Подключает файл представления
     */
    public function render(): void
    {
        self::checkAccess();

        $renderInfo = Layout::definePath('page', $this->layout);

        if($renderInfo['type'] === 'page') {
            $data = ViewData::getViewData($this->layout);
            $this->data = $data['data'];

            if($data['isError']) {
                $renderInfo = Layout::definePath('error', '500');
            }
        }

        require $renderInfo['path'];
    }

    /**
     * Проверяет доступ к запрашиваемой странице.
     * Делат подмену запроса на index в случае отсутствия доступа.
     * @return void
     */
    private function checkAccess(): void
    {
        if(array_key_exists($this->layout, (include __DIR__ . '/config.php')['layouts']['protected'])) {
            if(!Access::check((include __DIR__ . '/config.php')['layouts']['protected'][$this->layout])) {
                $this->layout = 'index';
            }
        }
    }
}
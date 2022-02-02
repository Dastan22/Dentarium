<?php


namespace app;


class App
{
    /**
     * Запускает web-приложение
     */
    public static function run(): void
    {
        (new View())->render();
    }
}
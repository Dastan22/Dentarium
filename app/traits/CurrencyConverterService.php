<?php


namespace app\traits;


trait CurrencyConverterService
{
    private static function defineCurrency(): string
    {
        return $_COOKIE['currency'] ?? 'tg';
    }

    public static function defineCourse(): float
    {
        $curlPath = 'https://data.egov.kz/api/v4/valutalar_bagamdary4/v708?apiKey=4755520baf0a45fb8c47721092551e0c';

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://data.egov.kz/api/v4/valutalar_bagamdary4/v708?apiKey=4755520baf0a45fb8c47721092551e0c');
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return $res;
    }
}
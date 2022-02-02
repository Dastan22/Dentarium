<?php


namespace app\traits;


use app\models\Product;
use Exception;

trait Cart
{
    /**
     * Добавляет новый товар в корзину.
     * Выкидывает исключение, если что-то пошло не так.
     * @param int $productId
     * @throws Exception
     */
    public static function add(int $productId): void
    {
        $wasUpdated = false;

        if(isset($_SESSION['cart'])) {
            $cart = json_decode($_SESSION['cart']);

            foreach ($cart as $v) {
                if($v->id === $productId) {
                    self::plus($productId);
                    $wasUpdated = true;
                }
            }
        }

        if(!$wasUpdated) {
            try {
                $dataForCart = Product::getForCart($productId);
            } catch (Exception $e) {
                throw new Exception('Не удалось получить данные о товаре');
            }

            $cartItem = [
                'id' => $productId,
                'amount' => 1,
                'price' => $dataForCart[0]['price'],
                'title' => $dataForCart[0]['title'],
                'image' => $dataForCart[0]['image']
            ];

            if(isset($_SESSION['cart'])) {
                $cart = json_decode($_SESSION['cart']);
                $cart[] = $cartItem;
                $_SESSION['cart'] = json_encode($cart);
            } else {
                $cart = [];
                $cart[] = $cartItem;
                $_SESSION['cart'] = json_encode($cart);
            }
        }

    }


    /**
     * Увеличивает на единицу конкретного товара в корзине.
     * Выкидывает исключение, если что-то пошло не так.
     * @param int $productId
     * @throws Exception
     */
    public static function plus(int $productId): void
    {
        if(!isset($_SESSION))
            throw new Exception('Не удалось открыть корзину');

        $cart = json_decode($_SESSION['cart']);
        $wasUpdated = false;

        foreach ($cart as $v) {
            if($v->id === $productId) {
                $wasUpdated = true;
                $productPrice = Product::getPriceById($productId);
                $v->amount++;
                $v->price = $v->amount * intval($productPrice);
            }
        }

        if($wasUpdated)
            $_SESSION['cart'] = json_encode($cart);
        else
            throw new Exception('Товара не найдено в корзине');

    }


    /**
     * Уменьшает на единице конкретного товара в корзине.
     * Выкидывает исключение, если что-то пошло не так.
     * @param int $productId
     * @throws Exception
     */
    public static function minus(int $productId): void
    {
        if(!isset($_SESSION['cart']))
            throw new Exception('Не удалось открыть корзину');

        $cart = json_decode($_SESSION['cart']);
        $wasUpdated = false;

        foreach ($cart as $i => $v) {
            if($v->id === $productId) {
                $wasUpdated = true;
                $productPrice = Product::getPriceById($productId);
                $v->amount--;
                $v->price = $v->amount * intval($productPrice);

                if($v->amount <= 0) {
                    unset($cart[$i]);
                    $cart = array_values($cart);
                }
            }
        }

        if($wasUpdated)
            $_SESSION['cart'] = json_encode($cart);
        else
            throw new Exception('Товара не найдено в корзине');
    }


    /**
     * Удаляет товар из корзины.
     * Выкидывает исключение, если что-то пошло не так.
     * @param int $productId
     * @throws Exception
     */
    public static function delete(int $productId)
    {
        if(!isset($_SESSION['cart']))
            throw new Exception('Не удалось открыть корзину');

        $cart = json_decode($_SESSION['cart']);
        $wasUpdated = false;

        foreach ($cart as $i => $v) {
            if($v->id === $productId) {
                $wasUpdated = true;
                unset($cart[$i]);
                $cart = array_values($cart);
            }
        }

        if($wasUpdated)
            $_SESSION['cart'] = json_encode($cart);
        else
            throw new Exception('Товара не найдено в корзине');
    }
}
<?php


namespace app\api;


use app\traits\Access;
use Throwable;

class Order
{
    public static function save(
        int $deliveryType,
        string $address,
        string $name,
        string $message,
        int $paymentType
    ): void
    {
        if(!Access::check('user')) {
            http_response_code(401);
            echo 'Необходимо авторизоваться';
            die();
        }

        try {
            \app\models\Order::save(
                $deliveryType,
                $address,
                $name,
                $message,
                $paymentType
            );
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }

    /** Получает информацию о заказе
     * @param int $orderId
     * @param string $entity
     */
    public static function getInfo(int $orderId = 0, string $entity = ''): void
    {
        if(!Access::check($entity)) {
            http_response_code(401);
            echo 'Необходимо авторизоваться';
            die();
        }

        try {
            echo json_encode(\app\models\Order::getInfo($orderId));
        } catch (Throwable $e) {
            http_response_code(520);
            echo $e->getMessage();
            die();
        }
    }
}

require_once __DIR__ . '/../autoload.php';

session_start();

switch ($_POST['operation'] ?? '') {
    case 'save':
        (new Order())::save(
            $_POST['deliveryType'] ?? 0,
            $_POST['address'] ?? '',
            $_POST['name'] ?? '',
            $_POST['message'] ?? '',
            $_POST['paymentType'] ?? 0
        );
        break;
    case 'getInfo':
        (new Order())::getInfo(
            $_POST['orderId'] ?? 0,
            $_POST['entity'] ?? ''
        );
        break;
    default:
        http_response_code(501);
        echo 'Неизвестный API запрос';
        die();
}
<?php


namespace app\models;


use app\Db;
use Exception;
use Throwable;

class Order
{
    public static function save(
        int $deliveryType = 0,
        string $address      = '',
        string $name         = '',
        string $message      = '',
        int $paymentType  = 0
    ): void
    {
        if($deliveryType === 0) {
            throw new Exception('Не указан тип доставки');
        }

        if($address === '') {
            throw new Exception('Не указан адрес доставки');
        }

        if($name === '') {
            throw new Exception('Не указано ФИО');
        }

        if($paymentType === 0) {
            throw new Exception('Не указан тип оплаты');
        }

        if(!isset($_SESSION['cart'])) {
            throw new Exception('Корзина не обнаружена');
        }

        if(count($_SESSION['cart']) === 0) {
            throw new Exception('Корзина пуста');
        }

        $orderId = self::setInDatabase($address, $message, $paymentType, $deliveryType);

        try {
            self::attachProducts($orderId);
            $_SESSION['cart'] = '[]';
        } catch (Throwable $e) {
            self::removeOrder($orderId);
        }
    }

    /**
     * Возвращает массив заказов пользователя
     * @return array
     * @throws Exception
     */
    public static function getByUserId(): array
    {
        $getAll__sql = 'SELECT o.id, total_cost as price, arrange_time,
                               GROUP_CONCAT(CONCAT(pi.image_path, \'%\', p.id) SEPARATOR \'~\') as products,
                               IF(canceled_time IS NOT NULL, \'Отменен\', IF(delivered_time IS NOT NULL, \'Выполнен\', IF(processed_time IS NOT NULL, \'У курьера\', IF(confirmed_time IS NOT NULL, \'Подтвержден\', \'Сформирован\')))) as status
                        FROM orders o
                        LEFT JOIN order_has_product ohp on o.id = ohp.order_id
                        LEFT JOIN products p on ohp.product_id = p.id
                        LEFT JOIN products_images pi on p.id = pi.product_id
                        WHERE user_id = :user_id
                        GROUP BY o.id, price, arrange_time, status';
        $getAll__data = [
            ':user_id' => User::getId()
        ];

        return (new Db())->query($getAll__sql, $getAll__data);
    }

    /**
     * Получает все заказы, либо ищет по id и user.phone
     * @param int $limit
     * @param string $searchString
     * @return array
     * @throws Exception
     */
    public static function getAll(int $limit = 15, string $searchString = ''): array
    {
        if($searchString === '') {
            $getAll__sql = 'SELECT o.id, DATE_FORMAT(o.arrange_time, \'%d.%m.%Y %k:%i\') as arrange_time
                            FROM orders o
                            ORDER BY id DESC
                            LIMIT 0, ' . $limit;
            $getAll__data = [];
        } else {
            $getAll__sql = 'SELECT o.id, DATE_FORMAT(o.arrange_time, \'%d.%m.%Y %k:%i\') as arrange_time
                            FROM orders o
                            JOIN users u on o.user_id = u.id
                            WHERE REPLACE(LOWER(CONCAT(o.id, u.phone)), \' \', \'\') LIKE REPLACE(LOWER(:search_string), \' \', \'\')   
                            ORDER BY o.id DESC
                            LIMIT 0, ' . $limit;
            $getAll__data = [
                ':search_string' => '%' . $searchString . '%'
            ];
        }

        return (new Db())->query($getAll__sql, $getAll__data);
    }

    /**
     * Получает информацию о заказе
     * @param int $orderId
     * @return array
     * @throws Exception
     */
    public static function getInfo(int $orderId = 0, string $entity = ''): array
    {
        if($orderId === 0) {
            throw new Exception('Не удалось определить айди заказа');
        }

        $getInfo__sql = 'SELECT
                                o.delivery_address,
                                o.user_message,
                                o.total_cost,
                                u.phone,
                                u.full_name,
                                dt.title as delivery_type,
                                pt.title as payment_type,
                                IF(canceled_time IS NOT NULL, \'Отменен\', IF(delivered_time IS NOT NULL, \'Выполнен\', IF(processed_time IS NOT NULL, \'У курьера\', IF(confirmed_time IS NOT NULL, \'Подтвержден\', \'Сформирован\')))) as status,
                                GROUP_CONCAT(CONCAT(pt2.title, \'%\', ohp.amount, \'%\', ohp.amount * pp.price) SEPARATOR \'~\') as products
                         FROM orders o
                         JOIN users u on o.user_id = u.id
                         JOIN delivery_types dt on o.delivery_type_id = dt.id
                         JOIN payment_types pt on o.payment_type_id = pt.id
                         LEFT JOIN order_has_product ohp on o.id = ohp.order_id
                         LEFT JOIN products p on ohp.product_id = p.id
                         LEFT JOIN products_titles pt2 on p.id = pt2.product_id and pt2.language_id = 1
                         LEFT JOIN products_prices pp on p.id = pp.product_id and pp.is_active = 1
                         WHERE o.id = :id' . ($entity === 'user' ? ' AND user_id = ' . User::getId() : '') . ' GROUP BY delivery_address, user_message, total_cost, phone, full_name, delivery_type, payment_type, status';
        $getInfo__data = [
            ':id' => $orderId
        ];

//        throw new Exception($getInfo__sql);

        return (new Db())->query($getInfo__sql, $getInfo__data)[0] ?? [];
    }

    /**
     * Возвращает полную стоимость заказа
     * @return int
     */
    private static function defineTotalPrice(): int
    {
        $total = 0;
        $cart = json_decode($_SESSION['cart'] ?? '[]');

        foreach ($cart as $v) {
            $total += intval($v->price);
        }

        return $total;
    }

    private static function setInDatabase(string $deliveryAddress = '', string $message = '', int $paymentType = 0, int $deliveryType = 0): int
    {
        if(strlen($deliveryAddress) > 256) {
            throw new Exception('Адрес доставки должен быть короче 256 символов');
        }

        if(strlen($message) > 256) {
            throw new Exception('Комментарий к заказу должен быть короче 256 символов');
        }

        $setInDatabase__sql = 'INSERT INTO orders
                               (user_id, delivery_address, user_message, total_cost, payment_type_id, delivery_type_id)
                               VALUES (:user_id, :delivery_address, :user_message, :total_cost, :payment_type_id, :delivery_type_id)';
        $setInDatabase__data = [
            ':user_id' => User::getId(),
            ':delivery_address' => $deliveryAddress,
            ':user_message' => $message,
            ':total_cost' => self::defineTotalPrice(),
            ':payment_type_id' => $paymentType,
            ':delivery_type_id' => $deliveryType
        ];

        $db = new Db();

        $db->execute($setInDatabase__sql, $setInDatabase__data);

        return $db->getLastInsertId();
    }

    /**
     * Удаляет заказ по айди
     * @param int $orderId
     * @throws Exception
     */
    private static function removeOrder(int $orderId = 0): void
    {
        $removeOrder__sql = 'DELETE FROM orders WHERE id = :id';
        $removeOrder__data = [
            ':id' => $orderId
        ];

        (new Db())->execute($removeOrder__sql, $removeOrder__data);
    }

    /**
     * Прикрепляет товары к заказу
     * @param int $orderId
     * @throws Exception
     */
    private static function attachProducts(int $orderId): void
    {
        $products = [];

        foreach (json_decode($_SESSION['cart'] ?? '[]') as $v) {
            $products[]  = [
                'id' => intval($v->id),
                'amount' => intval($v->amount)
            ];
        }

        $attachProducts_sql = 'INSERT INTO order_has_product
                               (order_id, product_id, amount)
                               VALUES (:order_id, :product_id, :amount)';
        $attachProducts_data = [
            ':order_id' => $orderId,
            ':product_id' => 0,
            ':amount' => 0
        ];

        $db = new Db();

        foreach ($products as $v) {
            $attachProducts_data[':product_id'] = $v['id'];
            $attachProducts_data[':amount'] = $v['amount'];
            $db->execute($attachProducts_sql, $attachProducts_data);
        }
    }
}
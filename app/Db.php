<?php


namespace app;

use PDO;
use Exception;

class Db
{
    /**
     * Соединение с БД
     * @var PDO
     */
    private PDO $conn;

    /**
     * Выполняет соединение с БД
     */
    public function __construct()
    {
        $config  = (include __DIR__ . '/config.php')['db'];

        $this->conn = new PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
            $config['user'],
            $config['passwd']
        );
    }

    /**
     * Выполняет запос (insert, update, delete) в БД
     * @param string $sql
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function execute(string $sql = '', array $data = []): bool
    {
        if($sql === '') {
            throw new Exception('Не указан SQL запрос');
        }

        $q = $this->conn->prepare($sql);

        return $q->execute($data);
    }

    /**
     * Выполняет запрос (select) в БД
     * @param string $sql
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function query(string $sql = '', array $data = []): array
    {
        if($sql === '') {
            throw new Exception('Не указан SQL запрос');
        }

        $q = $this->conn->prepare($sql);

        $q->execute($data);

        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает айди последней вставки в БД
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->conn->lastInsertId();
    }
}
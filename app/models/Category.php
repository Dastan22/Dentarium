<?php


namespace app\models;


use app\Db;
use Exception;

class Category
{
    /**
     * Получает все категории товаров
     * @return array
     * @throws Exception
     */
    public static function getAll(): array
    {
        $getParentCategories__sql = 'SELECT c.id, ct.title
                                     FROM categories c
                                     JOIN categories_titles ct ON ct.category_id = c.id AND ct.language_id = 1
                                     WHERE c.parent_category IS NULL';

        $db = new Db();
        $getParentCategories__r = $db->query($getParentCategories__sql, []);

        if(count($getParentCategories__r) === 0) {
            throw new Exception('Не найдено ни одной родительской категории');
        }

        foreach ($getParentCategories__r as $v) $getChildrenCategories__data[] = $v['id'];


        $getChildrenCategories__sql = 'SELECT c.parent_category, ct.id AS second_stage_id, ct.title AS category_of_second_stage,
                                            (
                                                SELECT GROUP_CONCAT(CONCAT(ct2.title, \'%\', c2.id) SEPARATOR \'~\')
                                                FROM categories c2
                                                JOIN categories_titles ct2 ON ct2.category_id = c2.id
                                                WHERE c2.parent_category = second_stage_id
                                            ) AS categories_of_third_stage
                                        FROM categories c
                                        JOIN categories_titles ct ON ct.category_id = c.id
                                        WHERE c.parent_category IN (' . str_repeat('?,', count($getParentCategories__r) - 1) . '?' . ') AND ct.language_id = 1';

        $db = new Db();
        $getChildrenCategories__r = $db->query($getChildrenCategories__sql, $getChildrenCategories__data);


        if(count($getChildrenCategories__r) > 0) {
            return self::representCategoriesForClient($getParentCategories__r, $getChildrenCategories__r);
        } else {
            throw new Exception('Не найдено ни одной категории');
        }
    }

    /**
     * Возвращает массив с категорями (id, title)
     * @param array $categoryId
     * @return array
     * @throws Exception
     */
    public static function getTitles(array $categoryId = []): array
    {
        if(count($categoryId) > 0) {
            $getTitles__sql = 'SELECT c.id, ct.title FROM categories c
                               JOIN categories_titles ct ON ct.category_id = c.id AND ct.language_id = 1
                               WHERE c.id IN (' . str_repeat('?,', count($categoryId) - 1) . '?)';
            $getTitles__data = $categoryId;
        } else {
            $getTitles__sql = 'SELECT c.id, ct.title FROM categories c
                               JOIN categories_titles ct ON ct.category_id = c.id AND ct.language_id = 1';
            $getTitles__data = [];
        }

        return (new Db())->query($getTitles__sql, $getTitles__data);
    }

    /**
     * Представляет полученные массивы категорий в клиентском виде.
     * @param array $arrWithParentCategories
     * @param array $arrWithChildrenCategories
     * @return array
     */
    private static function representCategoriesForClient(array $arrWithParentCategories, array $arrWithChildrenCategories)
    {
        foreach ($arrWithParentCategories as $i => $v) {
            $output[$v['title'] . '%' . $v['id']] = [];
            foreach ($arrWithChildrenCategories as $i2 => $v2) {
                if($v['id'] !== $v2['parent_category']) continue;
                if($v2['categories_of_third_stage']) {
                    $output[$v['title'] . '%' . $v['id']][$v2['category_of_second_stage'] . '%' . $v2['second_stage_id']] =
                        explode('~', $v2['categories_of_third_stage']);
                } else {
                    $output[$v['title'] . '%' . $v['id']][$v2['category_of_second_stage'] . '%' . $v2['second_stage_id']] = [];
                }
            }
        }

        return $output;
    }

    /**
     * Добавляет новую категорию
     * @param int $parentId
     * @param string $title
     * @throws Exception
     */
    public static function add(int $parentId = 0, string $title = ''): void
    {
        if($title === '') {
            throw new Exception('Название категории не может быть пустым');
        }

        if(strlen($title) > 128) {
            throw new Exception('Название категории не должно быть длинее 128 символов');
        }

        if(self::isExist($title)) {
            throw new Exception('Категория с таким названием уже существует');
        }

        $db = new Db();

        if($parentId === 0) {
            $add__sql = 'INSERT INTO categories () VALUES ()';
            $add__data = [];
        } else {
            $add__sql = 'INSERT INTO categories (parent_category) VALUES (:parent_category)';
            $add__data = [
                ':parent_category' => $parentId
            ];
        }

        $db->execute($add__sql, $add__data);

        $categoryId = $db->getLastInsertId();

        $addTitle__sql = 'INSERT INTO categories_titles (title, language_id, category_id) VALUES (:title, :language_id, :category_id)';
        $addTitle__data = [
            ':title' => $title,
            ':language_id' => 1,
            ':category_id' => $categoryId
        ];

        $db->execute($addTitle__sql, $addTitle__data);
    }

    /**
     * Обновляет название категории
     * @param int $categoryId
     * @param string $newTitle
     * @throws Exception
     */
    public static function update(int $categoryId = 0, string $newTitle = ''): void
    {
        if($categoryId === 0) {
            throw new Exception('Не удалось определить айди категории');
        }

        if($newTitle === '') {
            throw new Exception('Название категории не может быть пустым');
        }

        if(strlen($newTitle) > 128) {
            throw new Exception('Название категории не должно быть длинее 128 символов');
        }

        if(self::isExist($newTitle)) {
            throw new Exception('Категория с таким названием уже существует');
        }

        $update__sql = 'UPDATE categories_titles
                        SET title = :title
                        WHERE category_id = :category_id';
        $update__data = [
            ':title' => $newTitle,
            ':category_id' => $categoryId
        ];

        (new Db())->execute($update__sql, $update__data);
    }

    /**
     * Получает связанных категорий
     * @param int $categoryId
     * @return mixed
     * @throws Exception
     */
    public static function getConnected(int $categoryId = 0): array
    {
        $getConnected__sql = 'SELECT c2.id, ct.title
                              FROM categories c
                              JOIN categories c2 ON c2.parent_category = c.id
                              JOIN categories_titles ct on c2.id = ct.category_id
                              WHERE c.id = :category_id OR c.parent_category = :category_id';
        $getConnected__data = [
            ':category_id' => $categoryId
        ];

        return (new Db())->query($getConnected__sql, $getConnected__data);
    }

    /**
     * Удаляет категорию
     * @param int $categoryId
     * @throws Exception
     */
    public static function delete(int $categoryId = 0): void
    {
        if($categoryId === 0) {
            throw new Exception('Не удалось определить айди категории');
        }

        $delete__sql = 'DELETE FROM categories WHERE id = :id';
        $delete__data = [
            ':id' => $categoryId
        ];

        (new Db())->execute($delete__sql, $delete__data);
    }

    /**
     * Получает кол-во товаров основных категорий
     * @return array
     * @throws Exception
     */
    public static function getCountOfProductsOfMainCategories(): array
    {
        $getCountOfProductsOfMainCategories__sql = 'SELECT
                                                    SUM(IF(category_id = 2, +1, 0)) as first,
                                                    SUM(IF(category_id = 4, +1, 0)) as second,
                                                    SUM(IF(category_id = 3, +1, 0)) as third,
                                                    SUM(IF(category_id = 5, +1, 0)) as fourth,
                                                    SUM(IF(category_id = 7, +1, 0)) as fivth,
                                                    SUM(IF(category_id = 6, +1, 0)) as sixth,
                                                    SUM(IF(category_id = 1, +1, 0)) as seventh,
                                                    SUM(IF(category_id = 8, +1, 0)) as eighth,
                                                    SUM(IF(category_id = 41, +1, 0)) as ninth,
                                                    SUM(IF(category_id = 42, +1, 0)) as tenth
                                                    FROM product_has_category';
        $getCountOfProductsOfMainCategories__data = [];

        return (new Db())->query($getCountOfProductsOfMainCategories__sql, $getCountOfProductsOfMainCategories__data)[0] ?? [];
    }

    /**
     * Проверяет существует ли категория по названию
     * @param string $title
     * @return bool
     * @throws Exception
     */
    private static function isExist(string $title): bool
    {
        $isExist__sql = 'SELECT category_id FROM categories_titles
                         WHERE LOWER(REPLACE(title, \' \', \'\')) = LOWER(REPLACE(:title, \' \', \'\'))';
        $isExist__data = [
            ':title' => $title
        ];

        $r = (new Db())->query($isExist__sql, $isExist__data);

        return count($r) > 0;
    }
}
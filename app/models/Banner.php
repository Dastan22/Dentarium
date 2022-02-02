<?php


namespace app\models;


use app\Db;
use app\traits\CustomString;
use Exception;

class Banner
{
    /**
     * Получает все баннеры
     * @return array
     * @throws \Exception
     */
    public static function getAll(): array
    {
        $getAll__sql = 'SELECT id, image, is_mobile, link FROM banners ORDER BY id DESC';
        $getAll__data = [];

        return (new Db())->query($getAll__sql, $getAll__data);
    }

    /**
     * Добавляет новый баннер
     * @param int $isMobile
     * @param string $link
     * @throws Exception
     */
    public static function add(int $isMobile = 0, string $link = '/'): void
    {
        foreach ($_FILES as $image) {
            $ext = explode('.', $image['name'])[1];

            if(!($ext !== 'png' or $ext !== 'jpg' or $ext !== 'jpeg')) {
                throw new Exception('Загружен запрещенный формат файла');
            }

            while (true) {
                $newName = CustomString::getRandomString(10) . '.' . $ext;

                if(!file_exists(__DIR__ . '/../../public/img/banners/' . $newName)) {
                    break;
                }
            }

            if($image['size'] > 2000000) {
                throw new Exception('Изображение не может быть тяжелее 2 мб (' . $image['name'] . ')');
            }

            if(!move_uploaded_file($image['tmp_name'], __DIR__ . '/../../public/img/banners/' . $newName)) {
                throw new Exception('Изображение не было загружено на сервер (' . $image['name'] . ')');
            }

            $add_sql = 'INSERT INTO banners (image, is_mobile, link) VALUES (:image, :is_mobile, :link)';
            $add_data = [
                ':image' => $newName,
                ':is_mobile' => $isMobile,
                ':link' => $link
            ];

            (new Db())->execute($add_sql, $add_data);

            break;
        }
    }

    /**
     * Удаляет баннер
     * @param int $bannerId
     * @throws Exception
     */
    public static function delete(int $bannerId = 0): void
    {
        if($bannerId === 0) {
            throw new Exception('Не удалось определить айди баннера');
        }

        $delete__sql = 'DELETE FROM banners WHERE id = :id';
        $delete__data = [
            ':id' => $bannerId
        ];

        (new Db())->execute($delete__sql, $delete__data);
    }
}
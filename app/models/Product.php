<?php


namespace app\models;


use app\Db;
use app\traits\CustomString;
use Exception;

class Product
{
    /**
     * Возвращает все товары, связанные с указанной категорией
     * @param int $categoryId
     * @param int $limit
     * @param int $minPrice
     * @param int $maxPrice
     * @return array
     * @throws Exception
     */
    public static function getByCategoryId(int $categoryId = 0, int $limit = 15, int $minPrice = 0, int $maxPrice = -1): array
    {
        if($categoryId === 0) {
            throw new Exception('Не указан айди категории');
        }

        $getByCategoryId__sql = 'SELECT p.id, pt.title, pp.price, pi.image_path as image, p.amount, IF(f.id IS NOT NULL, 1, 0) as isFavorite
                                 FROM products p
                                 JOIN products_titles pt ON pt.product_id = p.id AND pt.language_id = 1
                                 JOIN products_prices pp ON p.id = pp.product_id AND pp.is_active = 1
                                 JOIN products_images pi on p.id = pi.product_id AND pi.is_main = 1
                                 JOIN product_has_category phc ON p.id = phc.product_id
                                 JOIN categories c ON c.id = phc.category_id
                                 LEFT JOIN favorites f on p.id = f.product_id AND user_id = :user_id
                                 WHERE (c.id IN (
                                                 SELECT c2.id
                                                 FROM categories c
                                                 JOIN categories c2 ON c2.parent_category = c.id
                                                 WHERE c.id = :category_id OR c.parent_category = :category_id
                                               ) OR c.id = :category_id) AND price >= :min_price' . ($maxPrice > -1 ? ' AND price <= :max_price' : '') . ' LIMIT 0, ' . $limit;
        $getByCategoryId_data = [
            ':category_id' => $categoryId,
            ':user_id' => User::getId(),
            ':min_price' => $minPrice
        ];

        if($maxPrice > -1) {
            $getByCategoryId_data[':max_price'] = $maxPrice;
        }

        $db = new Db();

        return $db->query($getByCategoryId__sql, $getByCategoryId_data);
    }

    /**
     * Возвращает товар по его айди
     * @param int $productId
     * @return mixed
     * @throws Exception
     */
    public static function getOneById(int $productId = 0): array
    {
        if($productId === 0) {
            throw new Exception('Не указан айди категории');
        }

        $getOneById__sql = 'SELECT p.id, pt.title, pp.price, p.vendor_code, p.brand, p.country, phc.category_id, ct.title as category,
                            pd.description, pc.characters, pu.usage, pf.features, p.amount,
                            GROUP_CONCAT(pi.image_path SEPARATOR \'~\') as images, IF(f.id IS NOT NULL, 1, 0) as isFavorite
                            FROM products p
                            JOIN products_titles pt ON pt.product_id = p.id AND pt.language_id = 1
                            JOIN products_prices pp ON p.id = pp.product_id AND pp.is_active = 1
                            JOIN products_images pi on p.id = pi.product_id
                            JOIN product_has_category phc on p.id = phc.product_id
                            JOIN categories_titles ct on phc.category_id = ct.id
                            LEFT JOIN products_descriptions pd on p.id = pd.product_id AND pd.language_id = 1
                            LEFT JOIN products_characters pc on p.id = pc.product_id AND pc.language_id = 1
                            LEFT JOIN products_usages pu on p.id = pu.product_id AND pu.language_id = 1
                            LEFT JOIN products_features pf on p.id = pf.product_id AND pf.language_id = 1
                            LEFT JOIN favorites f on p.id = f.product_id
                            WHERE p.id = :product_id
                            GROUP BY p.id, pt.title, pp.price, p.vendor_code, p.brand, p.country, phc.category_id, category, isFavorite,
                            pd.description, pc.characters, pu.usage, pf.features, p.amount';
        $getOneById__data = [
            ':product_id' => $productId
        ];

        $db = new Db();

        return $db->query($getOneById__sql, $getOneById__data);
    }

    /**
     * Получает все товары
     * @param int $limit
     * @param int $minPrice
     * @param int $maxPrice
     * @return array
     * @throws Exception
     */
    public static function getAll(int $limit = 15, int $minPrice = 0, int $maxPrice = -1): array
    {
        $getAll__sql = 'SELECT DISTINCT p.id, pt.title, pp.price, pi.image_path as image, p.amount, IF(f.id IS NOT NULL, 1, 0) as isFavorite FROM products p
                        JOIN products_titles pt ON pt.product_id = p.id AND pt.language_id = 1
                        JOIN products_prices pp ON p.id = pp.product_id AND pp.is_active = 1
                        JOIN products_images pi on p.id = pi.product_id AND pi.is_main = 1
                        LEFT JOIN favorites f on p.id = f.product_id
                        WHERE price >= :min_price' . ($maxPrice > -1 ? ' AND price <= :max_price' : '') .
                        ' LIMIT 0, ' . $limit;
        $getAll__data = [
            ':min_price' => $minPrice
        ];

        if($maxPrice > -1) {
            $getAll__data[':max_price'] = $maxPrice;
        }

        return (new Db())->query($getAll__sql, $getAll__data);
    }

    /**
     * Возвращает данные от товаре для корзины
     * @param int $productId
     * @return mixed
     * @throws Exception
     */
    public static function getForCart(int $productId = 0): array
    {
        if($productId === 0) {
            throw new Exception('Не указан айди товара');
        }

        $getForCart__sql = 'SELECT pt.title, pp.price, pi.image_path as image FROM products p
                            JOIN products_titles pt on pt.product_id = p.id AND pt.language_id = 1
                            JOIN products_images pi ON p.id = pi.product_id AND pi.is_main = 1
                            JOIN products_prices pp ON p.id = pp.product_id AND pp.is_active = 1
                            WHERE p.id = :product_id';
        $getForCart__data = [
            ':product_id' => $productId
        ];

        return (new Db())->query($getForCart__sql, $getForCart__data);
    }

    /**
     * Возвращает стоимость товара по его айди
     * @param int $productId
     * @return int
     * @throws Exception
     */
    public static function getPriceById(int $productId = 0): int
    {
        if($productId === 0) {
            throw new Exception('Не указан айди товара');
        }

        $getPriceById__sql = 'SELECT price FROM products_prices
                              WHERE is_active = 1 AND product_id = :product_id';
        $getPriceById__data = [
            ':product_id' => $productId
        ];

        return (new Db())->query($getPriceById__sql, $getPriceById__data)[0]['price'] ?? 0;
    }

    /**
     * Добавляет товар в избранное
     * @param int $productId
     * @throws Exception
     */
    public static function addIntoFavorites(int $productId = 0): void
    {
        $addIntoFavorites__sql = 'INSERT INTO favorites (user_id, product_id) VALUES (:user_id, :product_id)';
        $addIntoFavorites__data = [
            ':user_id' => User::getId(),
            ':product_id' => $productId
        ];

        (new Db())->query($addIntoFavorites__sql, $addIntoFavorites__data);
    }

    /**
     * Удаляет товар из избранных
     * @param int $productId
     * @throws Exception
     */
    public static function removeFromFavorites(int $productId = 0): void
    {
        $removeFromFavorites__sql = 'DELETE FROM favorites WHERE user_id = :user_id AND product_id = :product_id';
        $removeFromFavorites__data = [
            ':user_id' => User::getId(),
            ':product_id' => $productId
        ];

        (new Db())->query($removeFromFavorites__sql, $removeFromFavorites__data);
    }

    /**
     * Проверяет добавлен ли товар в избранное
     * @param int $productId
     * @return bool
     * @throws Exception
     */
    public static function isFavorite(int $productId = 0): bool
    {
        $isFavorite__sql = 'SELECT id FROM favorites WHERE user_id = :user_id AND product_id = :product_id';
        $isFavorite__data = [
            ':user_id' => User::getId(),
            ':product_id' => $productId
        ];

        $r = (new Db())->query($isFavorite__sql, $isFavorite__data);

        return count($r) > 0;
    }

    /**
     * Возвращает избранные товары
     * @return mixed
     * @throws Exception
     */
    public static function getFavorites(): array
    {
        $getFavorites__sql = 'SELECT p.id, pt.title, pp.price, p.vendor_code, p.brand, p.country, phc.category_id, ct.title as category, pi.image_path as image
                              FROM products p
                              JOIN products_titles pt ON pt.product_id = p.id AND pt.language_id = 1
                              JOIN products_prices pp ON p.id = pp.product_id AND pp.is_active = 1
                              JOIN products_images pi on p.id = pi.product_id AND pi.is_main = 1
                              JOIN product_has_category phc on p.id = phc.product_id
                              JOIN categories_titles ct on ct.category_id = phc.category_id
                              LEFT JOIN favorites f on p.id = f.product_id
                              WHERE f.user_id = :user_id';
        $getFavorites__data = [
            ':user_id' => User::getId()
        ];

        $db = new Db();

        return $db->query($getFavorites__sql, $getFavorites__data);
    }

    /**
     * Создает новый товар
     * @param array $param
     * @throws Exception
     */
    public static function add(array $param = []): void
    {
        if(!($param['productVendor'] ?? false)) {
            throw new Exception('Не указан артикул товара');
        }

        if(strlen($param['productVendor']) > 128) {
            throw new Exception('Артикул должен быть не длинее 128 символов');
        }

        if(!($param['productBrand'] ?? false)) {
            throw new Exception('Не указан бренд товара');
        }

        if(strlen($param['productBrand']) > 128) {
            throw new Exception('Название бренда должно быть не длинее 128 символов');
        }

        if(!($param['productCountry'] ?? false)) {
            throw new Exception('Не указана страна производителя товара');
        }

        if(strlen($param['productCountry']) > 64) {
            throw new Exception('Название страны производителя должно быть не длинее 64 символов');
        }

        if(!isset($param['productAmount'])) {
            throw new Exception('Не указано количество товара');
        }

        $add__sql = 'INSERT INTO products
                     (vendor_code, brand, country, amount)
                     VALUES (:vendor_code, :brand, :country, :amount)';
        $add__data = [
            ':vendor_code' => $param['productVendor'],
            ':brand' => $param['productBrand'],
            ':country' => $param['productCountry'],
            ':amount' => intval($param['productAmount'])
        ];

        $db = new Db();

        $db->execute($add__sql, $add__data);

        $productId = $db->getLastInsertId();

        try {
            self::setTitle($productId, $param['productTitle'] ?? '');
            self::setCategory($productId, $param['productCategory'] ?? 0);
            self::setDescription($productId, $param['productDescription'] ?? '');
            self::setCharacters($productId, $param['productCharacters'] ?? '');
            self::setUsage($productId, $param['productUsage'] ?? '');
            self::setFeatures($productId, $param['productFeatures'] ?? '');
            self::setPrice($productId, intval($param['productPrice'] ?? 0));
            self::setImages($productId);
        } catch (\Throwable $e) {
            self::delete($productId);
        }
    }

    /**
     * Удаляет товара
     * @param int $productId
     * @throws Exception
     */
    public static function delete(int $productId = 0): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        $delete__sql = 'DELETE FROM products WHERE id = :id';
        $delete__data = [
            ':id' => $productId
        ];

        (new Db())->execute($delete__sql, $delete__data);
    }

    /**
     * Поиск товара по категории, названию, бренду и артикулу
     * @param string $searchString
     * @param int $limit
     * @param int $minPrice
     * @param int $maxPrice
     * @return mixed
     * @throws Exception
     */
    public static function fullTextSearch(string $searchString = '', int $limit = 15, int $minPrice = 0, int $maxPrice = -1): array
    {
        $fullTextSearch__sql = 'SELECT products.id, pt.title, pi.image_path as image, amount, pp.price FROM products
                                JOIN products_titles pt ON products.id = pt.product_id
                                JOIN products_prices pp ON products.id = pp.product_id AND pp.is_active = 1
                                JOIN products_images pi ON products.id = pi.product_id AND pi.is_main = 1
                                LEFT JOIN product_has_category phc ON products.id = phc.product_id
                                JOIN categories_titles ct ON phc.category_id = ct.category_id
                                WHERE LOWER(REPLACE(CONCAT(ct.title, pt.title, vendor_code, brand), \' \', \'\')) LIKE LOWER(REPLACE(:search_string, \' \', \'\'))'
                                . ' AND price >= :min_price' . ($maxPrice > -1 ? ' AND price <= :max_price' : '') . ' LIMIT 0,' . $limit;
        $fullTextSearch__data = [
            ':search_string' => '%' . $searchString . '%',
            ':min_price' => $minPrice
        ];

        if($maxPrice > -1) {
            $fullTextSearch__data[':max_price'] = $maxPrice;
        }

        return (new Db())->query($fullTextSearch__sql, $fullTextSearch__data);
    }

    /**
     * Получает количество товаров в избранных
     * @return int
     * @throws Exception
     */
    public static function getCountOfFavorites(): int
    {
        $getCountOfFavorites__sql = 'SELECT COUNT(id) as sum FROM favorites WHERE user_id = :user_id';
        $getCountOfFavorites__data = [
            ':user_id' => User::getId()
        ];

        $db = new Db();

        return $db->query($getCountOfFavorites__sql, $getCountOfFavorites__data)[0]['sum'];
    }

    /**
     * Устанавливает название товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function setTitle(int $productId = 0, string $value = ''): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if($value === '') {
            throw new Exception('Необходимо указать название товара');
        }

        if(strlen($value) > 256) {
            throw new Exception('Название товара не должно быть длинее 256 символов');
        }

        $setTitle__sql = 'INSERT INTO products_titles
                          (title, language_id, product_id)
                          VALUES (:title, :language_id, :product_id)';
        $setTitle__data = [
            ':title' => $value,
            ':language_id' => 1,
            ':product_id' => $productId
        ];

        (new Db())->execute($setTitle__sql, $setTitle__data);
    }

    /**
     * Устанавливает категорию товара
     * @param int $productId
     * @param int $value
     * @throws Exception
     */
    private static function setCategory(int $productId = 0, int $value = 0): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if($value === 0) {
            throw new Exception('Не удалось определить категорию товара');
        }

        $setCategory__sql = 'INSERT INTO product_has_category
                             (product_id, category_id)
                             VALUES (:product_id, :category_id)';
        $setCategory__data = [
            ':product_id' => $productId,
            ':category_id' => $value
        ];

        (new Db())->execute($setCategory__sql, $setCategory__data);
    }

    /**
     * Устанавливает описание товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function setDescription(int $productId = 0, string $value = ''): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if(strlen($value) > 4096) {
            throw new Exception('Описание товара не должно быть длинее 4096 символов');
        }

        $setDescription__sql = 'INSERT INTO products_descriptions
                                (description, language_id, product_id)
                                VALUES (:description, :language_id, :product_id)';
        $setDescription__data = [
            ':description' => $value,
            ':language_id' => 1,
            ':product_id' => $productId
        ];

        (new Db())->execute($setDescription__sql, $setDescription__data);
    }

    /**
     * Устанавливает характеристики товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function setCharacters(int $productId = 0, string $value = ''): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if(strlen($value) > 4096) {
            throw new Exception('Характеристики товара не должны быть длинее 4096 символов');
        }

        $setCharacters__sql = 'INSERT INTO products_characters
                               (characters, language_id, product_id)
                               VALUES (:characters, :language_id, :product_id)';
        $setCharacters__data = [
            ':characters' => $value,
            ':language_id' => 1,
            ':product_id' => $productId
        ];

        (new Db())->execute($setCharacters__sql, $setCharacters__data);
    }

    /**
     * Устанавливает применение товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function setUsage(int $productId = 0, string $value = ''): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if(strlen($value) > 4096) {
            throw new Exception('Применение товара не должно быть длинее 4096 символов');
        }

        $setUsage__sql = 'INSERT INTO products_usages
                          (`usage`, language_id, product_id)
                          VALUES (:usage, :language_id, :product_id)';
        $setUsage__data = [
            ':usage' => $value,
            ':language_id' => 1,
            ':product_id' => $productId
        ];

        (new Db())->execute($setUsage__sql, $setUsage__data);
    }

    /**
     * Устанавливает особенности товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function setFeatures(int $productId = 0, string $value = ''): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if(strlen($value) > 4096) {
            throw new Exception('Особенности товара не должны быть длинее 4096 символов');
        }

        $setFeatures__sql = 'INSERT INTO products_features
                             (features, language_id, product_id)
                             VALUES (:features, :language_id, :product_id)';
        $setFeatures__data = [
            ':features' => $value,
            ':language_id' => 1,
            ':product_id' => $productId
        ];

        (new Db())->execute($setFeatures__sql, $setFeatures__data);
    }

    /**
     * Устанавливает стоимость товара
     * @param int $productId
     * @param int $value
     * @throws Exception
     */
    private static function setPrice(int $productId = 0, int $value = 0): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        $setPrice__sql = 'INSERT INTO products_prices
                          (product_id, price, price_type_id, is_active)
                          VALUES (:product_id, :price, :price_type_id, :is_active)';
        $setPrice__data = [
            ':product_id' => $productId,
            ':price' => $value,
            ':price_type_id' => 1,
            ':is_active' => 1
        ];

        (new Db())->execute($setPrice__sql, $setPrice__data);
    }

    /**
     * Устанавливает изображения товара
     * @param int $productId
     * @throws Exception
     */
    private static function setImages(int $productId = 0): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        $i = 0;
        $db = new Db();

        foreach ($_FILES as $image) {
            $ext = explode('.', $image['name'])[1];

            if(!($ext !== 'png' or $ext !== 'jpg' or $ext !== 'jpeg')) {
                throw new Exception('Загружен запрещенный формат файла');
            }

            while (true) {
                $newName = CustomString::getRandomString(10) . '.' . $ext;

                if(!file_exists(__DIR__ . '/../../public/img/products/' . $newName)) {
                    break;
                }
            }

            if($image['size'] > 500000) {
                throw new Exception('Изображение не может быть тяжелее 0.5 мб (' . $image['name'] . ')');
            }

            if(!move_uploaded_file($image['tmp_name'], __DIR__ . '/../../public/img/products/' . $newName)) {
                throw new Exception('Изображение не было загружено на сервер (' . $image['name'] . ')');
            }

            $setImage__sql = 'INSERT INTO products_images
                              (product_id, image_path, is_main)
                              VALUES (:product_id, :image_path, :is_main)';
            $setImage__data = [
                ':product_id' => $productId,
                ':image_path' => $newName,
                ':is_main' => ($i === 0) ? 1 : 0
            ];

            $db->execute($setImage__sql, $setImage__data);

            $i++;
        }
    }

    /**
     * Обновляет данные о товаре
     * @param int $productId
     * @param array $fields
     * @param array $data
     * @throws Exception
     */
    public static function update(int $productId, array $fields, array $data): void
    {
        if($productId === 0) {
            throw new Exception('Не удалось определить айди товара');
        }

        if(count($fields) === 0) {
            throw new Exception('Массив полей для редактирования пуст');
        }

        if(count($data) === 0) {
            throw new Exception('Массив данных для редактирования пуст');
        }

        foreach ($fields as $field) {
            switch ($field) {
                case 'title':
                    self::updateTitle($productId, $data[0]->title ?? '');
                    break;
                case 'vendorCode':
                    self::updateVendorCode($productId, $data[0]->vendorCode ?? '');
                    break;
                case 'brand':
                    self::updateBrand($productId, $data[0]->brand ?? '');
                    break;
                case 'country':
                    self::updateCountry($productId, $data[0]->country ?? '');
                    break;
                case 'category':
                    self::updateCategory($productId, $data[0]->category ?? 0);
                    break;
                case 'description':
                    self::updateDescription($productId,  $data[0]->description ?? '');
                    break;
                case 'characters':
                    self::updateCharacters($productId, $data[0]->characters ?? '');
                    break;
                case 'usage':
                    self::updateUsage($productId, $data[0]->usage ?? '');
                    break;
                case 'features':
                    self::updateFeatures($productId, $data[0]->features ?? '');
                    break;
                case 'price':
                    self::updatePrice($productId, $data[0]->price ?? 0);
                    break;
                case 'amount':
                    self::updateAmount($productId, $data[0]->amount ?? 0);
                    break;
                default:
                    throw new Exception('Не удалось определить поле для редактирования');
            }
        }
    }

    /**
     * Обновляет название товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateTitle(int $productId, string $value)
    {
        if($value === '') {
            throw new Exception('Название товара не может быть пустым');
        }

        if(strlen($value) > 256) {
            throw new Exception('Название товара не может быть длинее 256 символов');
        }

        $updateTitle__sql = 'UPDATE products_titles SET title = :title WHERE product_id = :product_id AND language_id = 1';
        $updateTitle__data = [
            ':title' => $value,
            ':product_id' => $productId
        ];

        (new Db())->execute($updateTitle__sql, $updateTitle__data);
    }

    /**
     * Обновляет артикул товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateVendorCode(int $productId, string $value): void
    {
        if($value === '') {
            throw new Exception('Артикул товара не может быть пустым');
        }

        if(strlen($value) > 128) {
            throw new Exception('Артикул товара не может быть длинее 128 символов');
        }

        $updateVendorCode__sql = 'UPDATE products SET vendor_code = :vendor_code WHERE id = :id';
        $updateVendorCode__data = [
            ':id' => $productId,
            ':vendor_code' => $value
        ];

        (new Db())->execute($updateVendorCode__sql, $updateVendorCode__data);
    }

    /**
     * Обновляет бренд товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateBrand(int $productId, string $value): void
    {
        if($value === '') {
            throw new Exception('Название бренда не может быть пустым');
        }

        if(strlen($value) > 128) {
            throw new Exception('Название бренда не может быть длинее 128 символов');
        }

        $updateBrand__sql = 'UPDATE products SET brand = :brand WHERE id = :id';
        $updateBrand__data = [
            ':id' => $productId,
            ':brand' => $value
        ];

        (new Db())->execute($updateBrand__sql, $updateBrand__data);
    }

    /**
     * Обновляет страну производителя товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateCountry(int $productId, string $value): void
    {
        if($value === '') {
            throw new Exception('Страна произодителя не может быть пустой');
        }

        if(strlen($value) > 128) {
            throw new Exception('Страна произодителя не может быть длинее 128 символов');
        }

        $updateCountry__sql = 'UPDATE products SET country = :country WHERE id = :id';
        $updateCountry__data = [
            ':id' => $productId,
            ':country' => $value
        ];

        (new Db())->execute($updateCountry__sql, $updateCountry__data);
    }

    /**
     * Обновляет категорию товара
     * @param int $productId
     * @param int $value
     * @throws Exception
     */
    private static function updateCategory(int $productId, int $value): void
    {
        if($value === 0) {
            throw new Exception('Не удалось определить категорию товара');
        }

        $updateCategory__sql = 'UPDATE product_has_category SET category_id = :category_id WHERE product_id = :product_id';
        $updateCategory__data = [
            ':product_id' => $productId,
            ':category_id' => $value
        ];

        (new Db())->execute($updateCategory__sql, $updateCategory__data);
    }

    /**
     * Обновляет описание товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateDescription(int $productId, string $value): void
    {
        if(strlen($value) > 4096) {
            throw new Exception('Описание товара не может быть длинее 4096 символов');
        }

        $updateDescription__sql = 'UPDATE products_descriptions SET description = :description WHERE product_id = :product_id AND language_id = :language_id';
        $updateDescription__data = [
            ':product_id' => $productId,
            ':description' => $value,
            ':language_id' => 1
        ];

        (new Db())->execute($updateDescription__sql, $updateDescription__data);
    }

    /**
     * Обновляет характеристики товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateCharacters(int $productId, string $value): void
    {
        if(strlen($value) > 4096) {
            throw new Exception('Характеристики товара не могут быть длинее 4096 символов');
        }

        $updateCharacters__sql = 'UPDATE products_characters SET characters = :characters WHERE product_id = :product_id AND language_id = :language_id';
        $updateCharacters__data = [
            ':product_id' => $productId,
            ':characters' => $value,
            ':language_id' => 1
        ];

        (new Db())->execute($updateCharacters__sql, $updateCharacters__data);
    }

    /**
     * Обновляет применение товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateUsage(int $productId, string $value): void
    {
        if(strlen($value) > 4096) {
            throw new Exception('Применение товара не может быть длинее 4096 символов');
        }

        $updateUsage__sql = 'UPDATE products_usages SET `usage` = :usage WHERE product_id = :product_id AND language_id = :language_id';
        $updateUsage__data = [
            ':product_id' => $productId,
            ':usage' => $value,
            ':language_id' => 1
        ];

        (new Db())->execute($updateUsage__sql, $updateUsage__data);
    }

    /**
     * Обновляет особенности товара
     * @param int $productId
     * @param string $value
     * @throws Exception
     */
    private static function updateFeatures(int $productId, string $value): void
    {
        if(strlen($value) > 4096) {
            throw new Exception('Особенности товара не могут быть длинее 4096 символов');
        }

        $updateFeatures__sql = 'UPDATE products_features SET features = :features WHERE product_id = :product_id AND language_id = :language_id';
        $updateFeatures__data = [
            ':product_id' => $productId,
            ':features' => $value,
            ':language_id' => 1
        ];

        (new Db())->execute($updateFeatures__sql, $updateFeatures__data);
    }

    /**
     * Обновялет стоимость товара
     * @param int $productId
     * @param int $value
     * @throws Exception
     */
    private static function updatePrice(int $productId, int $value): void
    {
        $updatePrice__sql = 'UPDATE products_prices SET price = :price WHERE product_id = :product_id AND is_active = :is_active';
        $updatePrice__data = [
            ':product_id' => $productId,
            ':price' => $value,
            ':is_active' => 1
        ];

        (new Db())->execute($updatePrice__sql, $updatePrice__data);
    }

    /**
     * Обновляет количество товара
     * @param int $productId
     * @param int $value
     * @throws Exception
     */
    private static function updateAmount(int $productId, int $value): void
    {
        $updateAmount__sql = 'UPDATE products SET amount = :amount WHERE id = :id';
        $updateAmount__data = [
            ':id' => $productId,
            ':amount' => $value
        ];

        (new Db())->execute($updateAmount__sql, $updateAmount__data);
    }
}
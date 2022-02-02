<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../public/lib/bootstrap.css">
    <title>Произошла неизвестная ошибка</title>
</head>
<body>
<div class="container pt-5">
    <?php if((include_once __DIR__ . '/../../config.php')['mode'] === 'dev'): ?>
    <div class="alert alert-danger"><pre><?php print_r($this->data) ?></pre></div>
    <?php else: ?>
    <div class="alert alert-danger">Произошла неизвестная ошибка... Мы уже работаем над ёё устранением</div>
    <?php endif; ?>
</div>
</body>
</html>
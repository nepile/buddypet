<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <p>Halo <?= session('name'); ?></p>

    <form action="/handle-logout" method="post">
        <?= csrf_field(); ?>
        <button type="submit">Keluar</button>
    </form>

</body>

</html>
what's up nigga <?= session('role'); ?>

<form action="/handle-logout" method="post">
    <?= csrf_field(); ?>
    <button type="submit">Keluar</button>
</form>
<?= $this->include('template/header'); ?>

<body>
    <?= $this->include('template/navbar'); ?>
    <div class="container-fluid">
        <?= $this->renderSection('content'); ?>
    </div>
</body>

<?= $this->include('template/footer'); ?>
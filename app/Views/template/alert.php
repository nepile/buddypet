<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error'); ?>
    </div>
<?php elseif (session()->has('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('success'); ?>
    </div>
<?php elseif (session()->has('info')) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session('info'); ?>
    </div>
<?php endif; ?>
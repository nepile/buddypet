<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<div class="container my-5">
    <div class="row">
        <h1 class="fs-4">Produk terbaik kami</h1>
    </div>

    <div class="row" style="row-gap: 25px;">
        <?php foreach ($products as $product) : ?>
            <a href="<?= base_url('/product-detail/' . $product['product_id']) ?>" class="col-xl-3 text-decoration-none">
                <div class="card">
                    <div class="card-body p-0" style="height: 30vh;">
                        <img src="<?= base_url('img/products/' . $product['image']); ?>" class="object-fit-cover rounded h-100 w-100" alt="">
                    </div>
                    <div class="card-footer">
                        <h5>
                            <?= $product['name']; ?>
                        </h5>
                        <div class="d-flex justify-content-between">
                            <span>Stok: <?= $product['stock']; ?></span>
                            <strong class="text-success">Rp <?= number_format($product['price'], 0, ',', '.') ?></strong>

                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>
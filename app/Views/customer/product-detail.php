<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-9 d-flex justify-content-between align-items-start mt-xl-5 mt-4">
            <div class="">
                <h4 style="font-weight: 800">Produk Detail</h4>
                <a href="/" class="btn p-0 mt-3 mb-2 border-0" style="text-decoration: none">
                    <p class="text-dark" style="font-size: 14px">&leftarrow; Kembali</p>
                </a>
            </div>

        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-xl-9 d-xl-flex justify-content-between align-items-start">
            <div class="col-xl-4 col-12 bg-light rounded" style="height: 55vh">
                <img src="<?= base_url('/img/products/' . $product['image']); ?>" class="rounded w-100 h-100 object-fit-cover border border-secondary" alt="">
            </div>
            <div class="col-xl-8 col-12 px-0 px-xl-3 p-3">
                <h1 style="font-weight: 800"><?= $product['name']; ?></h1>

                <p>
                    <?= $product['description']; ?>
                </p>

                <p class="text-secondary mt-3">Stok: <?= $product['stock']; ?></p>
                <p class="text-secondary mt-3">Diterbitkan: <?= date('D, d M Y', strtotime($product['created_at'])); ?> </p>
                <?= $this->include('template/alert') ?>
                <hr>

                <div class="mt-2 d-flex flex-xl-row flex-column justify-content-between">
                    <h2 style="color: #EE4E2E; font-weight: bold">Rp <?= number_format($product['price'], 0, ',', '.'); ?></h2>

                    <form action="<?= base_url('/add-to-cart') ?>" method="post" class="text-xl-end mt-xl-0 mt-4">
                        <?= csrf_field(); ?>

                        <!-- Kirim product_id sebagai hidden input -->
                        <input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">

                        <label for="quantity">Jumlah:</label>
                        <input type="number" class="w-25" name="quantity" id="quantity" value="1" min="1" required>
                        <!-- <a href="/"> -->
                        <button type="submit" class="btn btn-dark px-3">Tambah Keranjang</button>
                        <!-- </a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>
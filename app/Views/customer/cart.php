<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<div>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-9 d-flex justify-content-between align-items-start mt-xl-5 mt-4">
                <div class="">
                    <h4 style="font-weight: 800">Keranjang Belanja</h4>
                    <a href="/" class="btn p-0 mt-3 mb-2 border-0" style="text-decoration: none">
                        <p class="text-dark" style="font-size: 14px">&leftarrow; Kembali</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-xl-9 d-xl-flex flex-column justify-content-between align-items-start">
                <?php if (empty($cart_items)) : ?>
                    <p>Keranjang belanja Anda kosong.</p>
                <?php else : ?>
                    <?php foreach ($cart_items as $item) : ?>
                        <div class="col-xl-12 col-12 bg-light rounded p-3 mb-3">
                            <h5><?= $item['name']; ?></h5>
                            <p>Jumlah: <?= $item['quantity']; ?></p>
                            <p>Total: Rp <?= number_format($item['total_amount'], 0, ',', '.'); ?></p>

                            <!-- Tombol Tambah / Kurang -->
                            <form action="<?= site_url('/cart/update'); ?>" method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                <input type="hidden" name="quantity" value="<?= $item['quantity'] + 1; ?>">
                                <button type="submit" class="btn btn-sm btn-primary">+</button>
                            </form>

                            <form action="<?= site_url('/cart/update'); ?>" method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                <input type="hidden" name="quantity" value="<?= $item['quantity'] - 1; ?>">
                                <button type="submit" class="btn btn-sm btn-warning">-</button>
                            </form>

                            <!-- Tombol Hapus Produk -->
                            <a href="<?= site_url('/cart/remove/' . $item['product_id']); ?>" 
                            onclick="return confirm('Hapus produk ini dari keranjang?');" 
                            class="btn btn-sm btn-danger" style="margin-left: 10px;">
                                Hapus
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <h4>Total Belanja: Rp <?= number_format($total, 0, ',', '.'); ?></h4>
                    <!-- Tombol Checkout -->
                    <form action="<?= site_url('cart/checkout'); ?>" method="post">
                        <button type="submit" class="btn btn-success mt-3">Checkout</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
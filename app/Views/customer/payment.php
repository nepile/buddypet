<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-9 d-flex justify-content-between align-items-start mt-xl-5 mt-4">
            <div class="">
                <h4 style="font-weight: 800">Pembayaran</h4>
                <a href="/" class="btn p-0 mt-3 mb-2 border-0" style="text-decoration: none">
                    <p class="text-dark" style="font-size: 14px">&leftarrow; Kembali</p>
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-xl-9 d-xl-flex flex-column justify-content-between align-items-start">
            <h5>Silakan lakukan pembayaran ke rekening berikut:</h5>
            <p>Bank BCA: 1234567890 a.n. John Doe</p><br>
            <p>Total Pembayaran: Rp <?= number_format($total, 0, ',', '.'); ?></p>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <form action="<?= site_url('/payment/confirm'); ?>" method="post">
                <?= csrf_field(); ?>

                <!-- Payment method langsung dikirim otomatis -->
                <input type="hidden" name="payment_method" value="Transfer BCA - 1234567890 a.n. John Doe">

                <button type="submit" class="btn btn-success mt-3">Konfirmasi Pembayaran</button>
            </form>
        </div>
    </div>
<?= $this->endSection(); ?>
<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid mt-4" style="max-width: 1600px;">
    <h4>Histori Transaksi</h4>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= esc($order['product_name']); ?></td>
                        <td><?= esc($order['quantity']); ?></td>
                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($order['status'] == 'unpaid'): ?>
                                <span class="badge bg-warning text-dark">Belum Dibayar</span>
                            <?php else: ?>
                                <span class="badge bg-success">Sudah Dibayar</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $order['created_at']; ?></td>
                        <td>
                            <?php if ($order['status'] == 'unpaid'): ?>
                                <a href="<?= site_url('payment'); ?>" class="btn btn-sm btn-primary">Detail Pembayaran</a>
                                <form action="<?= site_url('transactions/delete/' . $order['order_id']); ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

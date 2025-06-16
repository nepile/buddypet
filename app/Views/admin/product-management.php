<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <?= $this->include('template/alert'); ?>
    <div class="card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Manajemen produk</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrderModal">Tambah produk</button>
        </div>

        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $key => $product) : ?>
                        <tr>
                            <td><?= ++$key; ?></td>
                            <td><?= $product['name']; ?></td>
                            <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td><?= $product['stock']; ?></td>
                            <td>
                                <a href="<?= base_url('/product-detail/' . $product['product_id']); ?>" class="btn btn-secondary btn-action btn-sm">Detail</a>

                                <button class="btn btn-info btn-action btn-sm" data-bs-toggle="modal" data-bs-target="<?= '#edit' . $product['product_id']; ?>">Edit</button>
                                <div class="modal fade" id="<?= 'edit' . $product['product_id']; ?>" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="<?= base_url('/product-update/' . $product['product_id']); ?>" method="post" enctype="multipart/form-data" class="modal-content">
                                            <?= csrf_field(); ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addOrderModalLabel">Tambah produk Baru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Produk</label>
                                                        <input type="text" class="form-control" name="name" value="<?= $product['name']; ?>" required placeholder="Masukkan nama produk" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Dekripsi</label>
                                                        <textarea name="description" id="description" required class="form-control" placeholder="Deskripsikan produk..."><?= $product['description']; ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Harga</label>
                                                        <input type="number" class="form-control" name="price" value="<?= $product['price']; ?>" placeholder="Tentukan harga produk" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Stok</label>
                                                        <input type="number" class="form-control" name="stock" value="<?= $product['stock']; ?>" placeholder="Tentukan jumlah produk" required />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Gambar Produk</label>
                                                        <input type="file" class="form-control" name="image" accept="image/*" />
                                                        <a href="<?= base_url('img/products/' . $product['image']); ?>">Pratinjau Gambar</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <button class="btn btn-danger btn-action btn-sm" data-bs-toggle="modal" data-bs-target="<?= '#delete' . $product['product_id']; ?>">Hapus</button>
                                <div class="modal fade" id="<?= 'delete' . $product['product_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Perhatian</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk menghapus?
                                            </div>
                                            <form action="<?= base_url('/product-delete/' . $product['product_id']); ?>" method="post" class="modal-footer">
                                                <?= csrf_field(); ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/product-store" method="post" enctype="multipart/form-data" class="modal-content">
            <?= csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="addOrderModalLabel">Tambah produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="name" required placeholder="Masukkan nama produk" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dekripsi</label>
                        <textarea name="description" id="description" required class="form-control" placeholder="Deskripsikan produk..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="price" placeholder="Tentukan harga produk" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stock" placeholder="Tentukan jumlah produk" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
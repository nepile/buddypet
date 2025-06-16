<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>
<div class="row bg-secondary">
    <div class="col bg-secondary" style="height: 8vh;">
        <div class="d-flex justify-content-center  position-relative" style="top: 15px;">
            <input type="text" class="form-control w-25 me-2" name="" id="" style="height: 50px;" placeholder="Cari nama produk">
            <button class="btn px-4 btn-warning">Cari</button>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <h1 class="fs-4">Produk terbaik kami</h1>
    </div>

    <div class="row" style="row-gap: 25px;">
        <a href="" class="col-xl-3 text-decoration-none">
            <div class="card">
                <div class="card-body p-0" style="height: 30vh;">
                    <img src="" class="object-fit-cover rounded h-100 w-100" alt="">
                </div>
                <div class="card-footer">
                    <h5>
                        Produk 1
                    </h5>
                    <div class="d-flex justify-content-between">
                        <span>Stok: 2</span>
                        <strong class="text-success">Rp 200.000</strong>

                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<?= $this->endSection(); ?>
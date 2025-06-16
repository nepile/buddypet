<?= $this->extend('template/main'); ?>

<?= $this->section('content'); ?>

<div class="row vh-100">
  <div class="col-md-6 p-0 d-none d-md-block">
    <img class="object-fit-cover h-100 w-100" src="<?= base_url('img/cat.jpg') ?>" alt="">
  </div>

  <div class="col-12 col-md-6 d-flex align-items-center justify-content-center bg-white">
    <div class="form-container p-4 p-md-5 mx-md-5">
      <h1 class="h2 fw-bold mb-3 text-dark"><a href="/" style="color: orangered;">Buddypet.</a> | Login</h1>
      <p class="text-muted mb-4">Silakan login untuk melanjutkan ke halaman utama. Jika belum punya akun, silakan daftar terlebih dahulu.</p>

      <?= $this->include('template/alert'); ?>

      <form action="/handle-login" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-3">
          <label for="email" class="form-label fw-semibold text-dark">
            Email <span class="text-danger">*</span>
          </label>
          <input type="email" required name="email" id="email" class="form-control" style="height: 50px;" placeholder="contoh@gmail.com">
        </div>

        <div class="mb-4 position-relative">
          <label for="password" class="form-label fw-semibold text-dark">
            Password <span class="text-danger">*</span>
          </label>
          <input type="password" required name="password" id="password" class="form-control" style="height: 50px;" placeholder="Masukkan password anda">
        </div>

        <div class="d-grid">
          <button type="submit" class="btn" style="background-color: orangered;">
            <strong class="text-light">Masuk</strong>
          </button>
        </div>
      </form>

      <div class="text-center mt-4">
        <p class="text-muted mb-0">
          Belum punya akun?
          <a href="/register" class="link-custom fw-semibold">
            Daftar disini
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
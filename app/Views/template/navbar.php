<?php if (!in_array(uri_string(), ['login', 'register'])) : ?>
    <nav class="navbar navbar-expand-lg w-100">
        <div class="container-fluid px-5 py-2">
            <a class="navbar-brand" href="#"><strong>Buddypet.</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="border border-start mx-3 d-xl-inline-block d-none"
                style="width: 1px; height: 30px; border-color: #ccc;">
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="gap: 30px;">
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == '' ? 'fw-bold' : '' ?>" aria-current="page" href="/">Beranda</a>

                    </li>
                    <?php if (session()->has('logged_in')) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Keranjang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Riwayat Transaksi</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex btn-menu" style="gap: 15px;">
                    <?php if (session()->has('logged_in')): ?>
                        <form action="/handle-logout" method="post">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>

                    <?php else : ?>

                        <a href="/login" class="btn btn-dark fw-medium">Login</a>
                        <a href="/register" class="btn border-dark fw-medium">Register</a>


                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>
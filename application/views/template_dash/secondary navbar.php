<style>
    .navbar-nav-link.active,
    .navbar-light .navbar-nav-link.show,
    .navbar-light .show>.navbar-nav-link {
        color: #fff !important;
        background-color: rgba(12, 140, 68, 255) !important;
    }
</style>
<!-- Secondary navbar -->
<div class="navbar navbar-expand-md navbar-light navbar-sticky">
    <div class="text-center d-md-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-navigation">
            <i class="icon-unfold mr-2"></i>
            Navigation
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-navigation">
        <ul class="navbar-nav">
            <!-- <li class="nav-item">
                <a href="<?= base_url(); ?>aktivitas/sendiri" class="navbar-nav-link">
                    <i class="icon-home4 mr-2"></i>
                    Dashboard
                </a>
            </li> -->

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle<?= (strpos(uri_string(), 'aktivitas') !== false) ? '  active' : ''; ?>" data-toggle="dropdown">
                    <i class="icon-copy mr-2"></i>
                    Kegiatan
                </a>

                <div class="dropdown-menu">

                    <a href="<?= base_url(); ?>aktivitas/lihat" class="dropdown-item"><i class="icon-copy"></i>Lihat
                        Kegiatan</a>
                    <a href="<?= base_url(); ?>aktivitas/sendiri" class="dropdown-item"><i class="icon-copy"></i>Lihat
                        Kegiatanku</a>
                    <a href="<?= base_url(); ?>aktivitas/tambah" class="dropdown-item"><i class="icon-file-plus"></i>Tambah
                        Kegiatan</a>

                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle<?= (strpos(uri_string(), 'absensi') !== false) ? '  active' : ''; ?>" data-toggle="dropdown">
                    <i class="icon-qrcode mr-2"></i>
                    Presensi
                </a>

                <div class="dropdown-menu">

                    <a href="<?= base_url(); ?>scan" class="dropdown-item"><i class="icon-qrcode"></i>Scan QR</a>
                    <a href="<?= base_url(); ?>absensi/absensiku" class="dropdown-item"><i class="icon-table"></i>Absensiku</a>
                    <a href="<?= base_url(); ?>absensi/absensi" class="dropdown-item"><i class="icon-table"></i>Rekap Absensi</a>
                    <a href="<?= base_url(); ?>qrcode_kegiatan" class="dropdown-item"><i class="icon-qrcode"></i>Buat QRcode</a>

                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle<?= (strpos(uri_string(), 'perjadin') !== false) ? '  active' : ''; ?>" data-toggle="dropdown">
                    <i class="icon-car2 mr-2"></i>
                    Perjadin
                </a>

                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>perjadin/dashboard" class="dropdown-item"><i class="icon-stats-dots"></i>Dashboard</a>
                    <a href="<?= base_url(); ?>perjadin/lihat" class="dropdown-item"><i class="icon-table"></i>Perjalan Dinas</a>
                    <a href="<?= base_url(); ?>perjadin/tambah" class="dropdown-item"><i class="icon-plus3"></i>Tambah Perjadin</a>

                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle<?= (strpos(uri_string(), 'rapat') !== false) ? '  active' : ''; ?>" data-toggle="dropdown">
                    <i class="icon-cup2 mr-2"></i>
                    Event
                </a>

                <div class="dropdown-menu">

                    <a href="<?= base_url(); ?>rapat/list" class="dropdown-item"><i class="icon-table"></i>List Event</a>
                    <a href="<?= base_url(); ?>rapat/tambah" class="dropdown-item"><i class="icon-plus3"></i>Tambah Event</a>

                </div>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>zoom" class="navbar-nav-link<?= (strpos(uri_string(), 'zoom') !== false) ? '  active' : ''; ?>">
                    <i class="icon-video-camera2 mr-2"></i>
                    Zoom
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?= base_url(); ?>surat" class="navbar-nav-link<?= (strpos(uri_string(), 'surat') !== false) ? '  active' : ''; ?>">
                    <i class="icon-mail5 mr-2"></i>
                    Surat
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?= base_url(); ?>lpp" class="navbar-nav-link<?= (strpos(uri_string(), 'lpp') !== false) ? '  active' : ''; ?>">
                    <i class="icon-file-text3 mr-2"></i>
                    LPP
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?= base_url(); ?>sk" class="navbar-nav-link<?= (strpos(uri_string(), 'sk') !== false) ? '  active' : ''; ?>">
                    <i class="icon-file-pdf mr-2"></i>
                    SK
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?= base_url(); ?>kerja_sama" class="navbar-nav-link<?= (strpos(uri_string(), 'kerja_sama') !== false) ? '  active' : ''; ?>">
                    <i class="icon-file-text3 mr-2"></i>
                    Kerja Sama
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-windows mr-2"></i>
                    Aplikasi Lain
                </a>

                <div class="dropdown-menu">

                    <a href="https://sites.google.com/view/abah-2023/home" class="dropdown-item"><i class="icon-file-text2"></i>ABAH</a>
                    <a href="https://sites.google.com/view/sikatacehlogin/beranda" class="dropdown-item"><i class="icon-folder-open"></i>SIKAT</a>
                    <a href="https://sites.google.com/view/keuanganlink" class="dropdown-item"><i class="icon-cash4"></i>Informasi Keuangan</a>
                </div>
            </li>

        </ul>

    </div>
</div>
<!-- /secondary navbar -->
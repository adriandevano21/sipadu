<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md align-self-start">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <span class="font-weight-semibold">Main sidebar</span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">
        <div class="card card-sidebar-mobile">

            <!-- Header -->
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Navigasi</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <!-- User menu -->
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            <a href="#"><img src="<?= $this->session->userdata('foto') ?>" width="38" height="38" class="rounded-circle" alt=""></a>
                        </div>

                        <div class="media-body">
                            <div class="media-title font-weight-semibold">
                                <?php echo $this->session->userdata('nama_pegawai'); ?></div>
                            <div class="font-size-xs opacity-50">
                                <!-- <i class="icon-pin font-size-sm"></i> &nbsp;Santa Ana, CA -->
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                            <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user menu -->


            <!-- Main navigation -->
            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header mt-0">
                        <div class="text-uppercase font-size-xs line-height-xs">Navigasi</div> <i class="icon-menu" title="Main"></i>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="<?= base_url(); ?>home" class="nav-link active">
                            <i class="icon-home4"></i>
                            <span>
                                Dashboard
                                <span class="d-block font-weight-normal opacity-50">No active orders</span>
                            </span>
                        </a>
                    </li> -->
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Kegiatanku</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="<?= base_url(); ?>aktivitas/lihat" class="nav-link">Lihat
                                    Kegiatan</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>aktivitas/sendiri" class="nav-link">Lihat
                                    Kegiatanku</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>aktivitas/tambah" class="nav-link">Tambah
                                    Kegiatan</a></li>

                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-qrcode"></i> <span>Absensi</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="<?= base_url(); ?>scan" class="nav-link">Scan QR</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>absensi/absensiku" class="nav-link">Absensiku</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>absensi/absensi" class="nav-link">Rekap Absensi</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>qrcode_kegiatan/" class="nav-link">Buat QRcode</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-car"></i> <span>Perjalanan Dinas</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="<?= base_url(); ?>perjadin/lihat" class="nav-link">Perjadin</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>perjadin/tambah" class="nav-link">Tambah Perjadin</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-cup2"></i> <span>Rapat</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="<?= base_url(); ?>rapat/list" class="nav-link">List Rapat</a></li>
                            <li class="nav-item"><a href="<?= base_url(); ?>rapat/tambah" class="nav-link">Tambah Rapat</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ">
                        <a href="<?= base_url(); ?>surat" class="nav-link">
                            <i class="icon-mail5"></i>
                            <span>
                                Surat
                            </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="<?= base_url(); ?>pendapatan" class="nav-link">
                            <i class="icon-cash"></i>
                            <span>
                                Gaji & Tukin
                            </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="https://sites.google.com/view/keuanganlink" class="nav-link">
                            <i class="icon-cash4"></i>
                            <span>
                               Keuangan
                            </span>
                        </a>
                    </li>

                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-windows"></i> <span>Aplikasi Lain</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                            <!--<li class="nav-item"><a-->
                            <!--        href="https://webapps.bps.go.id/aceh/serasi_bps_aceh/page_gaji_tukin/login.php"-->
                            <!--        class="nav-link">Gaji & Tukin</a></li>-->
                            <li class="nav-item"><a href="https://sites.google.com/view/abah2022login/beranda" class="nav-link">ABAH</a></li>
                            <li class="nav-item"><a href="https://webapps.bps.go.id/aceh/ngezoom/" class="nav-link">Ngezoom</a></li>
                            <li class="nav-item"><a href="https://sites.google.com/view/sikatacehlogin/beranda" class="nav-link">SIKAT</a></li>

                        </ul>
                    </li>
                    <a href="<?= base_url(); ?>logout" class="nav-link">
                        <i class="icon-switch2"></i>
                        <span>
                            Logout
                        </span>
                    </a>

                    <!-- /layout -->

                </ul>
            </div>
            <!-- /main navigation -->

        </div>
    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
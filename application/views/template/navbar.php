<style>
    .navbar-dark {
        color: rgba(255, 255, 255, .9);
        background-color: #0c8c44;
        border-bottom-color: rgba(255, 255, 255);
    }
</style>
<!-- Main navbar -->
<div class="navbar navbar-expand-md bg-teal-400">
    <div class="navbar-brand wmin-0 mr-5">
        <a href="<?= base_url(); ?>" class="d-inline-block">
            <img src="<?= base_url(); ?>/global_assets/images/logo_bps.png" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">


        <span class="navbar-text ml-md-3 mr-md-auto">

        </span>

        <ul class="navbar-nav">


            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" style="color: white">
                    <img src="<?= $this->session->userdata('foto') ?>" class="rounded-circle" alt="">
                    <span><?php echo $this->session->userdata('nama_pegawai'); ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">

                    <a href="<?= base_url(); ?>/logout" class="dropdown-item"><i class="icon-switch2"></i>
                        Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
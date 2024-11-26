<script src="<?= base_url(); ?>/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/editor_ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/uploader_bootstrap.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/gallery.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/media/fancybox.min.js"></script>
<?php
if ($this->session->flashdata('sukses') <> '') {
?>
    <div class="alert alert-success alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span><?php echo $this->session->flashdata('sukses'); ?></span>
    </div>
<?php
}
?>
<?php
if ($this->session->flashdata('gagal') <> '') {
?>
    <div class="alert alert-danger alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span><?php echo $this->session->flashdata('gagal'); ?></span>
    </div>
<?php
}
?>
<!-- Basic datatable -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Kumpulan Perjadin</h5>
        <a href="<?= base_url(); ?>/perjadin/tambah">
            <button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Perjadin</button>
        </a>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url(); ?>/perjadin/lihat">
            <div class="form-group row">
                <label class="col-form-label col-sm-1">Bulan</label>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <select name="bulan" class="form-control">
                                    <option value=<?= $bulan; ?>><?= $bulan; ?></option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="col-form-label col-sm-1">Tahun</label>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <select name="tahun" class="form-control">
                                    <option value=<?= $tahun; ?>><?= $tahun; ?></option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="icon-search4 mr-2"></i> Filter</button>
                </div>
            </div>

        </form>
    </div>

    <!--<table class="table">-->
        <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Tujuan/Tugas</th>
                <th>Tempat Tujuan</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($perjadin as $key => $value) {
            ?>
                <tr>
                    <td>
                        <?php echo $value['nama_pegawai']; ?>

                    </td>
                    <td class="text-center">
                        <?php echo $value['tanggal_pergi']; ?>
                    </td>
                    <td>
                        <?php echo $value['durasi']; ?> hari
                    </td>
                    <td>
                        <?php echo $value['judul']; ?>
                    </td>
                    <td>
                        <?php echo $value['nama_satker']; ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($value['status'] == "disetujui") { ?>
                            <span class="badge badge-flat border-primary text-primary-600"><?php echo $value['status']; ?></span>
                        <?php
                        } else if ($value['status'] == "selesai") { ?>
                            <span class="badge badge-flat border-success text-success-600"><?php echo $value['status']; ?></span>
                        <?php
                        } else if ($value['status'] == "diajukan") { ?>
                            <span class="badge badge-flat border-warning text-warning-600"><?php echo $value['status']; ?></span>
                        <?php
                        } else if ($value['status'] == "ditolak") { ?>
                            <span class="badge badge-flat border-danger text-danger-600"><?php echo $value['status']; ?></span>
                        <?php
                        } else if ($value['status'] == "laporan selesai") { ?>
                            <span class="badge badge-flat border-success text-success-600"><?php echo $value['status']; ?></span>
                        <?php
                        }
                        ?>
                    </td>
                    <td class="text-center">

                        <a href="<?= base_url(); ?>perjadin/detail/<?= $value['id_perjadin'] ?>" data-popup="tooltip" title="Lihat"><i class="icon-eye"></i></a>

                        <?php
                        if ($value['status'] == "ditolak" || $value['status'] == "disetujui"  || $value['status'] == "laporan selesai") {
                        } else if ($this->session->userdata('username') == "ahmadriswan") { ?>

                            <a href="#" data-toggle="modal" data-target="#modal_setujui" data-judul="<?php echo $value['judul']; ?>" data-id_perjadin="<?php echo $value['id_perjadin']; ?>" data-nama_pegawai="<?php echo $value['nama_pegawai']; ?>" data-tanggal_pergi="<?php echo $value['tanggal_pergi']; ?>" data-tanggal_pulang="<?php echo $value['tanggal_pulang']; ?>" data-durasi="<?php echo $value['durasi']; ?>" data-nama_satker="<?php echo $value['nama_satker']; ?>" data-deskripsi="<?php echo $value['deskripsi']; ?>" data-popup="tooltip" title="Setujui atau Tolak">
                                <i class="icon-checkmark text-warning"></i>
                            </a>
                        <?php } ?>

                        <?php if ($this->session->userdata('username') == $value["username"]  ) { ?>
                        <a href="<?= base_url(); ?>perjadin/input_laporan/<?= $value['id_perjadin'] ?>" data-judul="<?php echo $value['judul']; ?>" data-id_perjadin="<?php echo $value['id_perjadin']; ?>" data-popup="tooltip" title="Input Laporan">
                            <i class="icon-pencil" style="color:green"></i>
                        </a>
                        <?php } ?>
                        <a href="<?= base_url(); ?>perjadin/pdf/<?= $value['id_perjadin'] ?>" data-judul="<?php echo $value['judul']; ?>" data-id_perjadin="<?php echo $value['id_perjadin']; ?>" data-popup="tooltip" title="Generate PDF">
                            <i class="icon-file-pdf" style="color:orange"></i>
                        </a>
                        <?php
                        if (($value['username'] == $this->session->userdata('username') || $this->session->userdata('admin_zoom') == 1)) {
                        ?>
                            <a href="javascript:void(0)" data-popup="tooltip" title="Hapus Perjadin"><i class="icon-trash tombol_hapus" style="color:red" id="" data-id_perjadin="<?php echo $value['id_perjadin']; ?>"></i>
                            </a>
                        <?php } ?>



                    </td>

                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>




<!-- /vertical form modal -->
<!-- script untuk progress -->
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<!-- script untuk modal -->
<script type="text/javascript">
    
   

    $(document).ready(function() {
        function tanggal_indo(tanggal_full) {

            var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var xtahun = tanggal_full.substring(0, 4);
            var tanggal = tanggal_full.substr(8, 2);
            var xbulan = tanggal_full.substr(5, 2);

            var bulan = bulan[xbulan - 1];
            var tahun = (xtahun < 1000) ? xtahun + 1900 : xtahun;
            var tanggal_indo_ = (tanggal + ' ' + bulan + ' ' + tahun);
            return tanggal_indo_;
        }

       

    });
</script>


<script>
    $(document).ready(function() {
        
        
        $('.table tbody').on('click', '.tombol_hapus', function() {
        var id_perjadin = $(this).data('id_perjadin');
        var konfirmasi = confirm("Apakah Anda yakin hapus perjadin ini?");
        if (konfirmasi) {
            window.location.href = "<?= base_url(); ?>perjadin/hapus/" + id_perjadin; // Ganti dengan URL halaman tujuan
        } else {
            // Tindakan lain jika pengguna membatalkan
        }
    });
    });
</script>
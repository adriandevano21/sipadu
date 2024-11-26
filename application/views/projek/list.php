<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>
<script src="<?= base_url() ?>/dashboard/scheduler.min.js"></script>
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
        <h5 class="card-title">Kumpulan Projek</h5>
        <a href="<?= base_url(); ?>/projek/tambah">
            <button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Projek</button>
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

        <table class="table datatable-button-html5-basic">

            <thead>
                <tr>
                    <!-- 
                <th>Nama</th> -->
                    <th class="text-center">No</th>
                    <th class="text-center">Tim</th>
                    <th class="text-center">Projek</th>
                    <!-- <th>Status</th> -->
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($projek as $key => $value) {
                ?>
                    <tr>
                        <td class="text-center">
                            <?php echo ++$key; ?>
                        </td>
                        <td>
                            <?php echo $value['nama_tim']; ?>
                        </td>
                        <td>
                            <?php echo $value['nama_projek']; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url(); ?>projek/lihat/<?= $value['id_projek'] ?>" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="icon-eye"></i>
                            </a>
                            <a href="<?= base_url(); ?>projek/edit/<?= $value['id_projek'] ?>" data-toggle="tooltip" data-placement="top" title="Edit projek"><i class="icon-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Hapus Event"><i class="icon-trash tombol_hapus" style="color:red" id="tombol_hapus" data-id_projek="<?php echo $value['id_projek']; ?>"></i>
                            </a>
                        </td>

                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
</div>


<!-- script untuk progress -->
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>



<script>
    // $(document).ready(function() {
        $('.tombol_hapus').on('click', function() {
            var id_projek = $(this).data('id_projek');
            var konfirmasi = confirm("Apakah Anda yakin hapus projek ini?");
            if (konfirmasi) {
                window.location.href = "<?= base_url(); ?>projek/hapus/" + id_projek; // Ganti dengan URL halaman tujuan
            } else {
                // Tindakan lain jika pengguna membatalkan
            }
        });
    // });
</script>
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
        <h5 class="card-title">Kumpulan QRcode Kegiatan</h5>
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal_tambah"><i class="icon-plus2 mr-2"></i> QRcode</button>

        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>



    <table class="table datatable-responsive">

        <thead>
            <tr>

                <th class="text-center">Nama Kegiatan</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Username</th>
                <!--<th>QR Code</th>-->
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($kegiatan as $key => $value) {
            ?>
                <tr>
                    <td>
                        <?php echo $value['kegiatan']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['tanggal']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['username']; ?>

                    </td>
                    <!--<td>-->
                    <!--    <img style="width: 100px;" src="<?php echo base_url() . 'assetsQR/images/' . $value['nama_gambar']; ?>">-->

                    <!--</td>-->

                    <td class="text-center">
                        <?php
                        if ($value['username'] = $this->session->userdata('username') || $value['username'] = "ichsan.hasanudin") {
                        ?>
                            <div class="list-icons">
                                <div class="dropdown">


                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="<?= base_url(); ?>/qrcode_kegiatan/download/<?= $value['nama_gambar'] ?>" class="dropdown-item"><i class="icon-download"></i> Download</a>

                                        <!-- <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_selesai" data-aktivitas="<?php echo $value['nama_gambar']; ?>" data-id_aktivitas="<?php echo $value['nama_gambar']; ?>"><i class="icon-check"></i> Selesai</a> -->


                                        <!-- <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a> -->

                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </td>

                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>

<!-- Vertical form modal -->
<div id="modal_tambah" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post" action="<?= base_url(); ?>/qrcode_kegiatan/tambah">
                <input type="hidden" name="id_aktivitas" id="id_aktivitas">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kegiatan</label>
                                <input type="text" placeholder="Nama Kegiatan" class="form-control" id="selesai_output" name="kegiatan" required>
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Tanggal</label>
                                <input type="date" placeholder="Tanggal Kegiatan" class="form-control" id="selesai_output" name="tanggal" required>
                            </div>


                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>QR Code</label>
                                <input type="text" placeholder="isikan teks" class="form-control" id="selesai_output" name="qrcode" required>
                            </div>


                        </div>
                    </div> -->


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /vertical form modal -->

<!-- script untuk progress -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<!-- script untuk modal -->
<script type="text/javascript">
    $(document).ready(function() {

        $('#modal_selesai').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#selesai_aktivitas').val(div.data('aktivitas'));
            modal.find('#selesai_output').attr("value", div.data('output'));
            modal.find('#id_aktivitas').attr("value", div.data('id_aktivitas'));

            //modal.find('#email_to').attr("value",div.data(''));

        });

    });
</script>
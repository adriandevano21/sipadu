<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
        if ($this->session->flashdata('sukses') <> '') {
        ?>
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <p><?php echo $this->session->flashdata('sukses'); ?></p>
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
                <p><?php echo $this->session->flashdata('gagal'); ?></p>
            </div>
        <?php
        }
        ?>
    </div>

</div>



<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Input Kegiatan</h5>

                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('kegiatan/tambah'); ?>" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan:</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukan nama kegiatan">
                    </div>
                    <div class="form-group ">
                        <label class="col-form-label">Subtim:</label>
                        <select class="form-control select-minimum" name="kode_subtim" id="kode_subtim" required>
                            <option>Pilih Sub TIm</option>
                            <?php
                            foreach ($subtim as $key => $value) {
                            ?>
                                <option value="<?= $value['kode_subtim'] ?>"> [<?= $value['nama_tim'] ?>] <?= $value['nama_subtim'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i>
                        Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List Kegiatan</h5>

                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <!-- <a class="list-icons-item" data-action="reload"></a> -->
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table datatable-button-html5-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tim</th>
                            <th>SubTim</th>
                            <th>Nama Kegiatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($kegiatan as $item) : ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $item['nama_tim']; ?></td>
                                <td><?php echo $item['nama_subtim']; ?></td>
                                <td><?php echo $item['nama_kegiatan']; ?></td>
                                <td>
                                    <a href="<?php echo base_url('kegiatan/detail/' . $item['id_kegiatan']); ?>" class="btn btn-info">Detail</a>
                                    <a href="<?php echo base_url('kegiatan/edit/' . $item['id_kegiatan']); ?>" class="btn btn-warning">Edit</a>
                                    <a href="<?php echo base_url('kegiatan/hapus/' . $item['id_kegiatan']); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script src="<?= base_url() ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
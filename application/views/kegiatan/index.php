<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Menambahkan Master Kegiatan</h5>

                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <!-- <a class="list-icons-item" data-action="reload"></a> -->
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="<?= base_url(); ?>master_kegiatan/tambah" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kegiatan <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <!--<textarea rows="3" cols="3" name="aktivitas" class="form-control" required placeholder="Jika lebih dari 1 kegiatan, silahkan buat kegiatan baru"></textarea>-->
                            <input name="kegiatan" class="form-control" required placeholder="Masukan kegiatan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">PK <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select data-placeholder="PK" class="form-control select-minimum" data-fouc name="id_indikator_pk" id="id_indikator_pk">
                                <option></option>
                                <?php foreach ($indikator_pk
                                    as $key => $value) { ?>
                                    <option value="<?= $value["id"] ?>">[<?= $value["pk"] ?>] <?= $value["indikator"] ?></option>
                                <?php } ?>
                            </select>
                            <!-- <span class="form-text text-muted"> Optional <code>default = kosong</code></span> -->
                        </div>
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
                <h5 class="card-title">List Master Kegiatan</h5>

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
                            <th>
                                <center>No
                            </th>
                            <th>
                                <center>Kegiatan
                            </th>
                            <th>
                                <center>Indikator PK
                            </th>
                            <th>
                                <center>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($kegiatan as $row) { ?>
                            <tr>
                                <td>
                                    <center><?php echo $i++; ?>
                                </td>
                                <td><?php echo $row['kegiatan']; ?></td>
                                <td><?php echo $row['indikator']; ?></td>
                                <td>
                                    <center>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_edit" data-kegiatan="<?php echo $row['kegiatan']; ?>" data-id="<?php echo $row['id']; ?>">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal<?php echo $row['id']; ?>">Hapus</button>
                                </td>
                            </tr>
                            <!-- Modal untuk Hapus -->
                            <div class="modal fade" id="hapusModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusModalLabel">Hapus Kegiatan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin menghapus kegiatan ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <a href="<?php echo base_url('master_kegiatan/hapus/' . $row['id']); ?>" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Upload Surat-->
<div class="modal fade modal_edit" role="dialog" aria-hidden="true" id="modal_edit">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Kegiatan</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group ">
                    <form action="<?= base_url(); ?>master_kegiatan/edit" method="post" enctype="multipart/form-data" role="form">
                        <input type="hidden" value="" name="id" id="edit_id" />
                        <div class="form-group ">
                            <label class="col-sm-3 col-form-label">Kegiatan</label>
                            <input type="text" id="edit_kegiatan" name="kegiatan" required="" class="form-control" value="" required>
                        </div>
                </div>
                <div class="form-group ">
                    <label class="col-form-label ">PK <span class="text-danger">*</span></label>

                    <select data-placeholder="PK" class="form-control select-minimum" data-fouc name="id_indikator_pk" id="id_indikator_pk">
                        <option></option>
                        <?php foreach ($indikator_pk
                            as $key => $value) { ?>
                            <option value="<?= $value["id"] ?>">[<?= $value["pk"] ?>] <?= $value["indikator"] ?></option>
                        <?php } ?>
                    </select>
                    <!-- <span class="form-text text-muted"> Optional <code>default = kosong</code></span> -->

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>

        </div>
    </div>
</div>

<script src="<?= base_url(); ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>

<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.modal_edit').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#edit_id').attr("value", div.data('id'));
            modal.find('#edit_kegiatan').attr("value", div.data('kegiatan'));

        });

    });
</script>
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
<!-- Basic datatable -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Input Surat Masuk</h5>
                <!--<a href="<?= base_url(); ?>/aktivitas/tambah">-->
                <!--<button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Kegiatan</button>-->
                <!--</a>-->
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <!-- <a class="list-icons-item" data-action="reload"></a> -->
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url(); ?>surat_masuk/tambah" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">No surat</label>
                        <input type="text" id="no_surat" name="no_surat" required="" class="form-control" value="" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Sifat</label>
                        <select class="form-control select2 select2-danger" name="sifat_surat" id="sifat_surat" required>
                            <option value="biasa"> Biasa
                            </option>
                            <option value="rahasia"> Rahasia
                            </option>
                            <option value="segera"> Segera
                            </option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" required="" class="form-control" value="" max="<?= date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Pengirim</label>
                        <input type="text" id="pengirim" name="pengirim" required="" class="form-control" value="" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Tujuan</label>
                        <select class="form-control select2 select2-danger" name="tujuan" id="tujuan" required>
                            <?php
                            foreach ($tim as $key => $value) {
                            ?>
                                <option value="<?= $value['id'] ?>"> <?= $value['nama_tim'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Perihal</label>
                        <input type="text" id="perihal" name="perihal" required="" class="form-control" value="" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Ringkasan Isi Surat</label>
                        <input type="text" id="ringkasan" name="ringkasan" required="" class="form-control" value="" required>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-12 col-sm-12 label-align" for="first-name">Upload Surat
                        </label>
                        <input type="file" id="file_surat" name="file_surat" required="" class="form-control" value="" accept=".pdf">
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
                <h5 class="card-title">List Surat Masuk</h5>
                <!--<a href="<?= base_url(); ?>/aktivitas/tambah">-->
                <!--<button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Kegiatan</button>-->
                <!--</a>-->
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
                            <th width="1%">
                                <center> No
                            </th>
                            <th width="1%">
                                <center> Tanggal
                            </th>
                            <th>
                                <center> No Surat
                            </th>
                            <th>
                                <center> Perihal
                            </th>
                            <th>
                                <center> Tujuan
                            </th>
                            <th>
                                <center> Disposisi
                            </th>
                            <th>
                                <center> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($surat_masuk as $key => $q) {
                        ?>
                            <tr>
                                <td>
                                    <center><?php echo $no++ ?>
                                </td>
                                <td>
                                    <left><?php echo $q['tanggal_surat'] ?>
                                </td>
                                <td>
                                    <left>
                                        <?php echo $q['no_surat']; ?>
                                </td>
                                <td>
                                    <?php if ($q['sifat_surat'] == "rahasia") { ?>
                                        <left>perihal dirahasiakan
                                        <?php } else { ?>
                                            <left><?php echo $q['perihal'] ?>
                                            <?php } ?>
                                </td>
                                <td>
                                    <?php if ($q['sifat_surat'] == "rahasia") { ?>
                                        <left>tujuan dirahasiakan
                                        <?php } else { ?>
                                            <left><?php echo $q['nama_tim'] ?>
                                            <?php } ?>
                                </td>
                                <td>
                                    <?php
                                    $i = 0;
                                    foreach ($disposisi as $key => $value) {

                                        if ($value['id_surat_masuk'] == $q['id_surat_masuk']) {
                                            $i = $i + 1; ?>
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $value['nama_pegawai'] ?>"><img src="<?php echo $value['url_foto'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                        <?php }
                                        ?>
                                    <?php } ?>
                                    <?php if ($i < 3) {

                                    ?>
                                        <span data-toggle='modal' data-target='.modal_disposisi' data-id_surat_masuk="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat_surat="<?php echo $q['sifat_surat']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Berikan disposisi" class="btn btn-icon bg-transparent btn-sm border-slate-300 text-slate rounded-round border-dashed"><i class="icon-plus22"></i></a>
                                        </span>
                                    <?php } else {
                                    } ?>
                                </td>
                                <td>

                                    <?php
                                    if (!empty($q['tanggal_surat'] == date('Y-mm-dd')) && $this->session->userdata('username') == $q['username']) {
                                        // if (!empty($q['tanggal_surat'] != date('Y-mm-dd'))) {
                                    ?>
                                        <span data-toggle='modal' data-target='.modal_disposisi' data-id_surat="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat="<?php echo $q['awalan']; ?>" data-unit_kerja="<?php echo $q['unit_kerja']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>" data-kode="<?php echo $q['kode']; ?>" data-no="<?php echo $q['no']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="disposisi no surat"><i class="icon-pencil" style="color:coral"></i></a>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($q['file_surat'])) {
                                    ?>
                                        <span>
                                            <a href="<?= base_url(); ?>surat_masuk/download/<?= $q['file_surat'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"></i></a>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Surat-->
<div class="modal fade modal_disposisi" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Disposisi Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat_masuk/disposisi" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat_masuk" id="disposisi_id_surat_masuk" />
                    <input type="hidden" value="" name="no" id="disposisi_no" />
                    <!-- <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span> -->
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No Surat
                            <span class="required"></span>
                        </label>
                        <input type="text" id="disposisi_no_surat" name="no_surat" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Sifat</label>
                        <input type="text" id="disposisi_sifat_surat" name="sifat_surat" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Perihal</label>
                        <input type="text" id="disposisi_perihal" name="perihal" required="" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Tujuan</label>
                        <input type="text" id="disposisi_tujuan" name="tujuan" required="" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="col-form-label col-lg-3">Disposisi kepada </label>
                        <select data-placeholder="pilih nama pegawai" class="form-control select-minimum" data-fouc name="username" required>
                            <option></option>
                            <?php
                            foreach ($pegawai as $key => $value) { ?>
                                <option value="<?= $value['username']; ?>"><?= $value['nama_pegawai']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Catatan Disposisi</label>
                        <input type="text" id="disposisi_catatan" name="catatan" required="" class="form-control" value="" required>
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

<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>

<script type="text/javascript">
    var htmlobjek;
    $(document).ready(function() {

        $("#kategori").change(function() {
            var kategori = $("#kategori").val();
            if (kategori != "RB") {
                $('#unit_kerja').show();
            } else {
                $('#unit_kerja').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.modal_upload').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_surat').attr("value", div.data('id_surat'));
            modal.find('#no_surat').attr("value", div.data('no_surat'));
            //modal.find('#email_to').attr("value",div.data(''));

        });
        $('.modal_disposisi').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#disposisi_id_surat_masuk').attr("value", div.data('id_surat_masuk'));
            modal.find('#disposisi_no_surat').attr("value", div.data('no_surat'));
            modal.find('#disposisi_sifat_surat').attr("value", div.data('sifat_surat'));
            modal.find('#disposisi_perihal').attr("value", div.data('perihal'));
            modal.find('#disposisi_tujuan').attr("value", div.data('tujuan'));

            //modal.find('#email_to').attr("value",div.data(''));

        });

    });
</script>
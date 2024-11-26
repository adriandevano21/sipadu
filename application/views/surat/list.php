<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
        if ($this->session->flashdata('sukses') <> '') {
        ?>
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <p><?php echo $this->session->flashdata('sukses'); ?></p>
                ini no surat yang anda buat: <b>
                    <h2><?= $this->session->flashdata('no_surat_baru'); ?></h2>
                </b>
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
        <div class="card border-teal-400">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Membuat No Surat</h5>
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
                <form action="<?= base_url(); ?>surat/tambah_surat" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Sifat</label>
                        <!-- <div class="col-sm-10"> -->
                        <select class="form-control select2 select2-danger" name="sifat" id="sifat" require>

                            <option value="B-"> Biasa
                            </option>
                            <option value="R-"> Rahasia
                            </option>
                            <option value="S-"> Segera
                            </option>
                        </select>
                        <!-- </div> -->
                    </div>

                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Tanggal hari ini</label>
                        <!--<span>generate no surat sesuai tanggal hari ini</span>-->
                        <!-- <div class="col-sm-10"> -->
                        <input type="date" id="tanggal" name="tanggal" required="" class="form-control" value="" max="<?= date('Y-m-d'); ?>">
                        <!-- </div> -->

                    </div>


                    <div class="form-group " id="unit_kerja">

                        <label class="col-sm-3 col-form-label">Unit Kerja</label>
                        <!-- <div class="col-sm-10"> -->
                        <select class="form-control " name="unit_kerja" id="unit_kerja">
                            <option value="11000">BPS Provinsi Aceh</option>
                            <option value="11510">Bagian Umum</option>
                            <option value="11560">PST</option>
                            <option value="9200">Form Permintaan BPS Aceh</option>
                        </select>
                        <!-- </div> -->
                    </div>

                    <div class="form-group " id="klasifikasi">

                        <label class="col-sm-3 col-form-label">Klasifikasi

                        </label>
                        <a href="<?= base_url(); ?>surat/download_klasifikasi" data-toggle="tooltip" data-placement="top" title="download klasfikasi"><i class="icon-download" style="color:green"></i></a>
                        <!-- <div class="col-sm-10"> -->
                        <select class="form-control form-control-select2" name="klasifikasi" id="klasifikasi" required>
                            <option value="">Pilih Klasifikasi Surat</option>
                            <?php
                            foreach ($klasifikasi as $key => $value) {
                            ?>
                                <option value="<?= $value['kode'] . ',' . $value['id']; ?>">
                                    <?= "[" . $value['kode'] . "] "; ?><?= $value['klasifikasi']; ?>
                                </option>
                            <?php

                            }
                            ?>

                        </select>
                        <!-- </div> -->
                    </div>


                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Perihal</label>
                        <!-- <div class="col-sm-10"> -->
                        <input type="text" id="perihal" name="perihal" required="" class="form-control" value="" required>
                        <!-- </div> -->

                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Tujuan</label>
                        <!-- <div class="col-sm-10"> -->
                        <input type="text" id="tujuan" name="tujuan" required="" class="form-control" value="" required>
                        <!-- </div> -->

                    </div>

                    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i>
                        Submit</button>
                </form>

            </div>




        </div>
    </div>

    <div class="col-md-9">
        <div class="card border-teal-400">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List Surat</h5>
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
                <form method="get" action="<?= base_url(); ?>/surat">
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
                <table id="datatable-buttons" class="table datatable-button-html5-basic table-striped" style="width:100%">
                    <thead>
                        <tr class="bg-teal-400">
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
                            <th width="15%">
                                <center> User
                            </th>
                            <th>
                                <center> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($surat as $key => $q) {
                        ?>
                            <tr>
                                <td>
                                    <center><?php echo $no++ ?>
                                </td>
                                <td>
                                    <left><?php echo date("d-m-Y", strtotime($q['tanggal'])) ?>
                                </td>
                                <td>
                                    <!--  format RB: B-001/RB/BPS/1100/04/2021 format umum: B.001/BPS/11560/4/2021 -->
                                    <left>
                                        <?php echo $q['no_surat']; ?>
                                </td>
                                
                                <td>
                                    <?php if ($q['awalan'] == "R-") { ?>
                                        <left>Perihal dirahasiakan
                                        <?php } else { ?>
                                            <left><?php echo $q['perihal'] ?>
                                            <?php } ?>
                                </td>
                                <td>
                                    <?php if ($q['awalan'] == "R-") { ?>
                                        <left>Tujuan dirahasiakan
                                        <?php } else { ?>
                                            <left><?php echo $q['tujuan'] ?>
                                            <?php } ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($q['username'])) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $q['nama_pegawai'] ?>"><img src="<?php echo $q['url_foto'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($q['username2'])) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $q['nama_pegawai2'] ?>"><img src="<?php echo $q['url_foto2'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($q['username3'])) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $q['nama_pegawai3'] ?>"><img src="<?php echo $q['url_foto3'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <center>
                                        <span data-toggle='modal' data-target='.modal_lihat' data-id_surat="<?php echo $q['id_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat="<?php echo $q['awalan']; ?>" data-unit_kerja="<?php echo $q['unit_kerja']; ?>" 
                                        data-perihal="<?php echo ($q['awalan'] == "R-") ? "Perihal dirahasiakan" : $q['perihal']; ?>" data-tujuan="<?php echo ($q['awalan'] == "R-") ? "Tujuan dirahasiakan" : $q['tujuan']; ?>" 
                                        data-kode="<?php echo $q['kode']; ?>" data-no="<?php echo $q['no']; ?>" data-catatan1="<?php echo $q['catatan1']; ?>" data-catatan2="<?php echo $q['catatan2']; ?>" data-url_foto="<?php echo $q['url_foto']; ?>" data-url_foto2="<?php echo $q['url_foto2']; ?>" data-nama_pegawai="<?php echo $q['nama_pegawai']; ?>" data-nama_pegawai2="<?php echo $q['nama_pegawai2']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="lihat detail"><i class="icon-eye"></i></a>
                                        </span>
                                        <span data-toggle='modal' data-target='.modal_upload' data-id_surat="<?php echo $q['id_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="upload surat"><i class="icon-upload"></i></a>
                                        </span>
                                        <?php
                                        if ($q['tanggal'] == date('Y-m-d') && $this->session->userdata('username') == $q['username']) {
                                            // if (!empty($q['tanggal'] != date('Y-mm-dd'))) {
                                        ?>
                                            <span data-toggle='modal' data-target='.modal_edit' data-id_surat="<?php echo $q['id_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat="<?php echo $q['awalan']; ?>" data-unit_kerja="<?php echo $q['unit_kerja']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>" data-kode="<?php echo $q['kode']; ?>" data-no="<?php echo $q['no']; ?>">
                                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="edit no surat"><i class="icon-pencil" style="color:coral"></i></a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($this->session->userdata('username') == $q['username'] && empty($q['username2'])) { // untuk modal kirim draft
                                            // if (!empty($q['tanggal'] != date('Y-mm-dd'))) {
                                        ?>
                                            <span data-toggle='modal' data-target='.modal_kirim_draft' data-id_surat="<?php echo $q['id_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat="<?php echo $q['awalan']; ?>" data-unit_kerja="<?php echo $q['unit_kerja']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>" data-kode="<?php echo $q['kode']; ?>" data-no="<?php echo $q['no']; ?>">
                                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="kirim ke ketua tim"><i class="icon-paperplane" style="color:green"></i></a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($this->session->userdata('username') == $q['username'] && empty($q['username3'])) { // untuk modal revisi ke sekretaris
                                            // if (!empty($q['tanggal'] != date('Y-mm-dd'))) {
                                        ?>
                                            <span data-toggle='modal' data-target='.modal_kirim_draft' data-id_surat="<?php echo $q['id_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat="<?php echo $q['awalan']; ?>" data-unit_kerja="<?php echo $q['unit_kerja']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>" data-kode="<?php echo $q['kode']; ?>" data-no="<?php echo $q['no']; ?>">
                                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="kirim revisi ke ketua tim"><i class="icon-paperplane" style="color:green"></i></a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($this->session->userdata('username') == $q['username2'] && empty($q['username3'])) { // untuk modal kirim ke sekretaris
                                            // if (!empty($q['tanggal'] != date('Y-mm-dd'))) {
                                        ?>
                                            <span data-toggle='modal' data-target='.modal_kirim_sekre' data-id_surat="<?php echo $q['id_surat']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat="<?php echo $q['awalan']; ?>" data-unit_kerja="<?php echo $q['unit_kerja']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>" data-kode="<?php echo $q['kode']; ?>" data-no="<?php echo $q['no']; ?>">
                                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="kirim ke sekretaris"><i class="icon-paperplane" style="color:green"></i></a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($q['file_surat'])) {
                                        ?>
                                            <span>
                                                <a href="<?= base_url(); ?>surat/download/<?= $q['id_surat'] . "/" . $q['file_surat'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"></i></a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($q['link'])) {
                                        ?>
                                            <span>
                                                <a href="<?= $q['link'] ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="top" title="link draft surat"><i class="icon-link" style="color:blue"></i></a>
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
<div class="modal fade modal_upload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat/upload" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat" id="id_surat" />
                    <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No Surat
                            <span class="required"></span>
                        </label>
                        <div class="col-md-12 col-sm-12 ">
                            <input type="text" id="no_surat" name="no_surat" class="form-control" value="" readonly>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Upload Surat
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 ">
                            <input type="file" id="file_surat" name="file_surat" required="" class="form-control" value="" accept=".pdf">
                        </div>
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

<!-- Modal Upload Surat-->
<div class="modal fade modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit No Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat/edit" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat" id="edit_id_surat" />
                    <input type="hidden" value="" name="no" id="edit_no" />
                    <!-- <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span> -->
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No Surat
                            <span class="required"></span>
                        </label>
                        <input type="text" id="edit_no_surat" name="no_surat" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Sifat</label>
                        <select class="form-control select2 select2-danger" name="sifat" id="edit_sifat" required>
                            <option value="">Pilih Sifat Surat</option>
                            <option value="B-"> Biasa
                            </option>
                            <option value="R-"> Rahasia
                            </option>
                            <option value="S-"> Segera
                            </option>
                        </select>

                    </div>

                    <div class="form-group " id="unit_kerja">

                        <label class="col-sm-3 col-form-label">Unit Kerja</label>

                        <select class="form-control " name="unit_kerja" id="edit_unit_kerja" required>
                            <option value="">Pilih Unit Kerja</option>
                            <option value="11000">BPS Provinsi Aceh</option>
                            <option value="11510">Bagian Umum</option>
                            <option value="11560">PST</option>
                            <option value="9200">Form Permintaan BPS Aceh</option>
                        </select>

                    </div>

                    <div class="form-group " id="klasifikasi">

                        <label class="col-sm-3 col-form-label">Klasifikasi

                        </label>
                        <a href="<?= base_url(); ?>surat/download_klasifikasi" data-toggle="tooltip" data-placement="top" title="download klasfikasi"><i class="icon-download" style="color:green"></i></a>

                        <select class="form-control form-control-select2" name="klasifikasi" id="edit_klasifikasi" required>
                            <option value="">Pilih Klasifikasi Surat</option>
                            <?php
                            foreach ($klasifikasi as $key => $value) {
                            ?>
                                <option value="<?= $value['kode'] . ',' . $value['id']; ?>">
                                    <?= "[" . $value['kode'] . "] "; ?><?= $value['klasifikasi']; ?>
                                </option>
                            <?php

                            }
                            ?>

                        </select>

                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Perihal</label>

                        <input type="text" id="edit_perihal" name="perihal" required="" class="form-control" value="" required>


                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Tujuan</label>

                        <input type="text" id="edit_tujuan" name="tujuan" required="" class="form-control" value="" required>


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

<!-- Modal Upload Kirim Draft-->
<div class="modal fade modal_kirim_draft" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Kirim Draft Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>No Surat</td>
                        <td width="10%">:</td>
                        <td><span id="kirim_draft_no_surat"></span></td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td><span id="kirim_draft_perihal"></span></td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td><span id="kirim_draft_tujuan"></span></td>
                    </tr>
                </table>
                <form action="<?= base_url(); ?>surat/kirim_draft_surat" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat" id="kirim_draft_id_surat" />
                    <div class="form-group ">
                        <label class="col-form-label col-lg-3">Kirim kepada </label>
                        <select data-placeholder="pilih nama pegawai" class="form-control select-minimum" data-fouc name="username2" required>
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
                        <label class="col-sm-3 col-form-label">Link </label>
                        <input type="text" id="kirim_draft_link" name="link" required="" class="form-control" value="" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Catatan </label>
                        <input type="text" id="kirim_draft_catatan" name="catatan1" required="" class="form-control" value="" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Kirim ke sekre-->
<div class="modal fade modal_kirim_sekre" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Kirim Draft Surat Ke Sekretaris</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>No Surat</td>
                        <td width="10%">:</td>
                        <td><span id="kirim_sekre_no_surat"></span></td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td><span id="kirim_sekre_perihal"></span></td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td><span id="kirim_sekre_tujuan"></span></td>
                    </tr>
                </table>
                <form action="<?= base_url(); ?>surat/kirim_sekre" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat" id="kirim_sekre_id_surat" />
                    <div class="form-group ">
                        <label class="col-form-label col-lg-3">Kirim kepada </label>
                        <input type="text" readonly value="Seketaris" class="form-control">

                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Catatan </label>
                        <input type="text" id="kirim_sekre_catatan" name="catatan2" required="" class="form-control" value="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Kirim Draft-->
<div class="modal fade modal_lihat" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Detail Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>No Surat</td>
                        <td width="10%">:</td>
                        <td><span id="lihat_no_surat"></span></td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td><span id="lihat_perihal"></span></td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td><span id="lihat_tujuan"></span></td>
                    </tr>
                    <tr>
                        <td width="20%"><img id="lihat_username1" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                        <td>:</td>
                        <td><span id="lihat_catatan1"></span></td>
                    </tr>
                    <tr>
                        <td><img id="lihat_username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                        <td>:</td>
                        <td><span id="lihat_catatan2"></span></td>
                    </tr>

                </table>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>
</div>



<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/form_select2.js"></script>



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
        $('.modal_edit').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#edit_id_surat').attr("value", div.data('id_surat'));
            modal.find('#edit_no_surat').attr("value", div.data('no_surat'));
            modal.find('#edit_sifat').attr("selected", div.data('sifat'));
            modal.find('#edit_unit_kerja').attr("selected", div.data('unit_kerja'));
            modal.find('#edit_perihal').attr("value", div.data('perihal'));
            modal.find('#edit_tujuan').attr("value", div.data('tujuan'));
            modal.find('#edit_no').attr("value", div.data('no'));
            modal.find('#edit_kode option').attr("selected", div.data('kode'));

            //modal.find('#email_to').attr("value",div.data(''));

        });
        $('.modal_kirim_draft').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            modal.find('#kirim_draft_no_surat').text(div.data('no_surat'));
            modal.find('#kirim_draft_perihal').text(div.data('perihal'));
            modal.find('#kirim_draft_tujuan').text(div.data('tujuan'));
            // Isi nilai pada field
            modal.find('#kirim_draft_id_surat').attr("value", div.data('id_surat'));
            //modal.find('#email_to').attr("value",div.data(''));

        });

        $('.modal_kirim_sekre').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            modal.find('#kirim_sekre_no_surat').text(div.data('no_surat'));
            modal.find('#kirim_sekre_perihal').text(div.data('perihal'));
            modal.find('#kirim_sekre_tujuan').text(div.data('tujuan'));
            // Isi nilai pada field
            modal.find('#kirim_sekre_id_surat').attr("value", div.data('id_surat'));
            //modal.find('#email_to').attr("value",div.data(''));

        });
        $('.modal_lihat').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            modal.find('#lihat_no_surat').text(div.data('no_surat'));
            modal.find('#lihat_perihal').text(div.data('perihal'));
            modal.find('#lihat_tujuan').text(div.data('tujuan'));
            modal.find('#lihat_catatan1').text(div.data('catatan1'));
            modal.find('#lihat_catatan2').text(div.data('catatan2'));
            modal.find('#lihat_username1').attr("src", div.data('url_foto'));
            modal.find('#lihat_username2').attr("src", div.data('url_foto2'));
            // Isi nilai pada field

        });

    });
</script>
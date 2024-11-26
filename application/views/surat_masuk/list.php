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
                                <center>
                                    Status
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
                                    <left><?php echo date("d-m-Y", strtotime($q['tanggal_surat'])) ?>
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
                                    <center>
                                        <?php if ($q['status'] == 1) { ?>

                                            <span class="badge badge-primary badge-pill" style=" font-size:small ">
                                                terbuka

                                            </span>
                                        <?php
                                        }
                                        if ($q['status'] == 5) { ?>
                                            <span class="badge badge-success badge-pill" style=" font-size:small ">selesai</span>
                                        <?php
                                        } ?>
                                </td>
                                <!-- <td> disposisi -->
                                <td>
                                    <?php
                                    if (!empty($q['username1'])) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $q['nama_pegawai1'] ?>"><img src="<?php echo $q['url_foto1'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                    <?php
                                    }

                                    ?>

                                    <?php
                                    if (!empty($q['username2'])) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $q['nama_pegawai2'] ?>"><img src="<?php echo $q['url_foto2'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>

                                    <?php
                                    }
                                    if (empty($q['username2']) && $this->session->userdata('username') == $q['username1'] && $q['status'] == 1) { ?>
                                        <span data-toggle='modal' data-target='.modal_disposisi' data-id_surat_masuk="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat_surat="<?php echo $q['sifat_surat']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-ringkasan="<?php echo $q['ringkasan']; ?>" data-tujuan="<?php echo $q['nama_tim']; ?>" data-url_foto1="<?php echo $q['url_foto1']; ?>" data-url_foto2="<?php echo (!empty($q['url_foto2'])) ? $q['url_foto2'] : null; ?>" data-url_foto3="<?php echo (!empty($q['url_foto3'])) ? $q['url_foto3'] : null; ?>" data-catatan1="<?php echo $q['catatan1']; ?>" data-catatan2="<?php echo $q['catatan2']; ?>" data-catatan3="<?php echo $q['catatan3']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="disposisi no surat" class="btn btn-icon bg-transparent btn-sm border-slate-300 text-slate rounded-round border-dashed"><i class="icon-plus22"></i></a>
                                        </span>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if (!empty($q['username3'])) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?= $q['nama_pegawai3'] ?>"><img src="<?php echo $q['url_foto3'] ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                    <?php
                                    }
                                    if (empty($q['username3']) && $this->session->userdata('username') == $q['username2'] && $q['status'] == 1) { ?>
                                        <span data-toggle='modal' data-target='.modal_disposisi' data-id_surat_masuk="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat_surat="<?php echo $q['sifat_surat']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-ringkasan="<?php echo $q['ringkasan']; ?>" data-tujuan="<?php echo $q['nama_tim']; ?>" data-url_foto1="<?php echo $q['url_foto1']; ?>" data-url_foto2="<?php echo (!empty($q['url_foto2'])) ? $q['url_foto2'] : null; ?>" data-url_foto3="<?php echo (!empty($q['url_foto3'])) ? $q['url_foto3'] : null; ?>" data-catatan1="<?php echo $q['catatan1']; ?>" data-catatan2="<?php echo $q['catatan2']; ?>" data-catatan3="<?php echo $q['catatan3']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="disposisi no surat" class="btn btn-icon bg-transparent btn-sm border-slate-300 text-slate rounded-round border-dashed"><i class="icon-plus22"></i></a>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <center>
                                        <?php
                                        if (($this->session->userdata('username') == $q['username1'] || $this->session->userdata('username') == $q['username2'] || $this->session->userdata('username') == $q['username3']) && $q['status'] != 5) {

                                        ?>
                                            <span data-toggle='modal' data-target='.modal_selesai' data-id_surat_masuk="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat_surat="<?php echo $q['sifat_surat']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-ringkasan="<?php echo $q['ringkasan']; ?>" data-tujuan="<?php echo $q['nama_tim']; ?>" data-url_foto1="<?php echo $q['url_foto1']; ?>" data-url_foto2="<?php echo (!empty($q['url_foto2'])) ? $q['url_foto2'] : null; ?>" data-url_foto3="<?php echo (!empty($q['url_foto3'])) ? $q['url_foto3'] : null; ?>" data-catatan1="<?php echo $q['catatan1']; ?>" data-catatan2="<?php echo $q['catatan2']; ?>" data-catatan3="<?php echo $q['catatan3']; ?>">
                                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="selesaikan"><i class="icon-checkmark4"></i></a>
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
                                        <span data-toggle='modal' data-target='.modal_lihat' data-id_surat_masuk="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat_surat="<?php echo $q['sifat_surat']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-ringkasan="<?php echo $q['ringkasan']; ?>" data-tujuan="<?php echo $q['nama_tim']; ?>" data-url_foto1="<?php echo $q['url_foto1']; ?>" data-url_foto2="<?php echo (!empty($q['url_foto2'])) ? $q['url_foto2'] : null; ?>" data-url_foto3="<?php echo (!empty($q['url_foto3'])) ? $q['url_foto3'] : null; ?>" data-catatan1="<?php echo $q['catatan1']; ?>" data-catatan2="<?php echo $q['catatan2']; ?>" data-catatan3="<?php echo $q['catatan3']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="selesaikan"><i class="icon-eye" style="color:orange"></i></a>
                                        </span>
                                        <span data-toggle='modal' data-target='.modal_edit' data-id_surat_masuk="<?php echo $q['id_surat_masuk']; ?>" data-no_surat="<?php echo $q['no_surat']; ?>" data-sifat_surat="<?php echo $q['sifat_surat']; ?>" data-perihal="<?php echo $q['perihal']; ?>" data-pengirim="<?php echo $q['pengirim']; ?>" data-ringkasan="<?php echo $q['ringkasan']; ?>" data-tujuan="<?php echo $q['tujuan']; ?>" data-url_foto1="<?php echo $q['url_foto1']; ?>" data-url_foto2="<?php echo (!empty($q['url_foto2'])) ? $q['url_foto2'] : null; ?>" data-url_foto3="<?php echo (!empty($q['url_foto3'])) ? $q['url_foto3'] : null; ?>" data-catatan1="<?php echo $q['catatan1']; ?>" data-catatan2="<?php echo $q['catatan2']; ?>" data-catatan3="<?php echo $q['catatan3']; ?>">
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="edit"><i class="icon-pencil5" style="color:purple"></i></a>
                                        </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal lihat-->
<div class="modal fade modal_lihat" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Surat Masuk</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" name="id_surat_masuk" id="lihat_id_surat_masuk" />
                <!-- <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span> -->
                <table class="table">
                    <tr>
                        <td>No Surat</td>
                        <td width="10%">:</td>
                        <td><span id="lihat_no_surat"></span></td>
                    </tr>
                    <tr>
                        <td>Sifat Surat</td>
                        <td>:</td>
                        <td><span id="lihat_sifat_surat"></span></td>
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
                        <td>Ringkasan</td>
                        <td>:</td>
                        <td><span id="lihat_ringkasan"></span></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <td width="10%"><img id="lihat_username1" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                        <td><span id="lihat_catatan1"></span></td>
                    </tr>
                    <tr>
                        <td><img id="lihat_username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                        <td><span id="lihat_catatan2"></span></td>
                    </tr>
                    <tr>
                        <td><img id="lihat_username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                        <td><span id="lihat_catatan2"></span></td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>
<!-- Modal selesaikan-->
<div class="modal fade modal_selesai" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Selesaikan Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat_masuk/selesai" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat_masuk" id="selesai_id_surat_masuk" />
                    <!-- <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span> -->
                    <table class="table">
                        <tr>
                            <td>No Surat</td>
                            <td width="10%">:</td>
                            <td><span id="selesai_no_surat"></span></td>
                        </tr>
                        <tr>
                            <td>Sifat Surat</td>
                            <td>:</td>
                            <td><span id="selesai_sifat_surat"></span></td>
                        </tr>
                        <tr>
                            <td>Perihal</td>
                            <td>:</td>
                            <td><span id="selesai_perihal"></span></td>
                        </tr>
                        <tr>
                            <td>Tujuan</td>
                            <td>:</td>
                            <td><span id="selesai_tujuan"></span></td>
                        </tr>
                        <tr>
                            <td>Ringkasan</td>
                            <td>:</td>
                            <td><span id="selesai_ringkasan"></span></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td width="10%"><img id="selesai_username1" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                            <td><span id="selesai_catatan1"></span></td>
                        </tr>
                        <tr>
                            <td><img id="selesai_username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                            <td><span id="selesai_catatan2"></span></td>
                        </tr>
                        <tr>
                            <td><img id="selesai_username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                            <td><span id="selesai_catatan2"></span></td>
                        </tr>
                    </table>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Catatan</label>
                        <input type="text" id="selesai_catatan" name="catatan" required="" class="form-control" value="" required>
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

<!-- Modal disposisi-->
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
                    <table class="table">
                        <tr>
                            <td>No Surat</td>
                            <td width="10%">:</td>
                            <td><span id="disposisi_no_surat"></span></td>
                        </tr>
                        <tr>
                            <td>Sifat Surat</td>
                            <td>:</td>
                            <td><span id="disposisi_sifat_surat"></span></td>
                        </tr>
                        <tr>
                            <td>Perihal</td>
                            <td>:</td>
                            <td><span id="disposisi_perihal"></span></td>
                        </tr>
                        <tr>
                            <td>Tujuan</td>
                            <td>:</td>
                            <td><span id="disposisi_tujuan"></span></td>
                        </tr>
                        <tr>
                            <td>Ringkasan</td>
                            <td>:</td>
                            <td><span id="disposisi_ringkasan"></span></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td width="10%"><img id="username1" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                            <td><span id="catatan1"></span></td>
                        </tr>
                        <tr>
                            <td><img id="username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                            <td><span id="catatan2"></span></td>
                        </tr>
                        <tr>
                            <td><img id="username2" src="" class="rounded-circle" width="32" height="32" alt=""></td>
                            <td><span id="catatan2"></span></td>
                        </tr>
                    </table>
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

<!-- Modal edit-->
<div class="modal fade modal_edit" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat_masuk/edit" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat_masuk" id="edit_id_surat_masuk" />
                    <input type="hidden" value="" name="no" id="disposisi_no" />
                    <!-- <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span> -->
                    <table class="table">
                        <tr>
                            <td>No Surat</td>
                            <td width="10%">:</td>
                            <td><input type="text" id="edit_no_surat" name="no_surat" required="" class="form-control" value="" required></td>
                        </tr>
                        <tr>
                            <td>Sifat Surat</td>
                            <td>:</td>
                            <td>
                                <select class="form-control select2 select2-danger" name="sifat_surat" id="edit_sifat_surat" required>
                                    <option value="biasa"> Biasa
                                    </option>
                                    <option value="rahasia"> Rahasia
                                    </option>
                                    <option value="segera"> Segera
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td width="10%">:</td>
                            <td>
                                <input type="date" id="edit_tanggal" name="tanggal" required="" class="form-control" value="" max="<?= date('Y-m-d'); ?>" required>
                            </td>

                        </tr>
                        <tr>
                            <td>Pengirim</td>
                            <td>:</td>
                            <td><input type="text" id="edit_pengirim" name="pengirim" required="" class="form-control" value="" required></td>
                        </tr>

                        <tr>
                            <td>Tujuan</td>
                            <td>:</td>
                            <td>
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
                            </td>
                        </tr>
                        <tr>
                            <td>Perihal</td>
                            <td>:</td>
                            <td><input type="text" id="edit_perihal" name="perihal" required="" class="form-control" value="" required></td>
                        </tr>
                        <tr>
                            <td>Ringkasan</td>
                            <td>:</td>
                            <td><input type="text" id="edit_ringkasan" name="ringkasan" required="" class="form-control" value="" required></td>
                        </tr>
                        <tr>
                            <td>File Surat</td>
                            <td>:</td>
                            <td> <input type="file" id="file_surat" name="file_surat" required="" class="form-control" value="" accept=".pdf"></td>
                        </tr>


                    </table>


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
            // modal.find('#disposisi_no_surat').attr("value", div.data('no_surat'));
            modal.find('#disposisi_no_surat').text(div.data('no_surat'));
            modal.find('#disposisi_sifat_surat').text(div.data('sifat_surat'));
            modal.find('#disposisi_perihal').text(div.data('perihal'));
            modal.find('#disposisi_tujuan').text(div.data('tujuan'));
            modal.find('#disposisi_ringkasan').text(div.data('ringkasan'));

            modal.find('#catatan1').text(div.data('catatan1'));
            modal.find('#catatan2').text(div.data('catatan2'));
            modal.find('#catatan3').text(div.data('catatan3'));

            modal.find('#username1').attr("src", div.data('url_foto1'));
            modal.find('#username2').attr("src", div.data('url_foto2'));
            modal.find('#username3').attr("src", div.data('url_foto3'));


            //modal.find('#email_to').attr("value",div.data(''));

        });
        $('.modal_selesai').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            // Isi nilai pada field
            modal.find('#selesai_id_surat_masuk').attr("value", div.data('id_surat_masuk'));
            // modal.find('#disposisi_no_surat').attr("value", div.data('no_surat'));
            modal.find('#selesai_no_surat').text(div.data('no_surat'));
            modal.find('#selesai_sifat_surat').text(div.data('sifat_surat'));
            modal.find('#selesai_perihal').text(div.data('perihal'));
            modal.find('#selesai_tujuan').text(div.data('tujuan'));
            modal.find('#selesai_ringkasan').text(div.data('ringkasan'));
            modal.find('#selesai_catatan1').text(div.data('catatan1'));
            modal.find('#selesai_catatan2').text(div.data('catatan2'));
            modal.find('#selesai_catatan3').text(div.data('catatan3'));
            modal.find('#selesai_username1').attr("src", div.data('url_foto1'));
            modal.find('#selesai_username2').attr("src", div.data('url_foto2'));
            modal.find('#selesai_username3').attr("src", div.data('url_foto3'));
        });
        $('.modal_lihat').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            // Isi nilai pada field
            modal.find('#lihat_id_surat_masuk').attr("value", div.data('id_surat_masuk'));
            // modal.find('#disposisi_no_surat').attr("value", div.data('no_surat'));
            modal.find('#lihat_no_surat').text(div.data('no_surat'));
            modal.find('#lihat_sifat_surat').text(div.data('sifat_surat'));
            modal.find('#lihat_perihal').text(div.data('perihal'));
            modal.find('#lihat_tujuan').text(div.data('tujuan'));
            modal.find('#lihat_ringkasan').text(div.data('ringkasan'));
            modal.find('#lihat_catatan1').text(div.data('catatan1'));
            modal.find('#lihat_catatan2').text(div.data('catatan2'));
            modal.find('#lihat_catatan3').text(div.data('catatan3'));
            modal.find('#lihat_username1').attr("src", div.data('url_foto1'));
            modal.find('#lihat_username2').attr("src", div.data('url_foto2'));
            modal.find('#lihat_username3').attr("src", div.data('url_foto3'));
        });
        $('.modal_edit').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
            // Isi nilai pada field
            modal.find('#edit_id_surat_masuk').attr("value", div.data('id_surat_masuk'));
            // modal.find('#disposisi_no_surat').attr("value", div.data('no_surat'));
            modal.find('#edit_no_surat').attr("value", div.data('no_surat'));
            modal.find('#edit_sifat_surat').attr("value", div.data('sifat_surat'));
            modal.find('#edit_perihal').attr("value", div.data('perihal'));
            modal.find('#edit_tujuan').attr("value", div.data('tujuan'));
            modal.find('#edit_ringkasan').attr("value", div.data('ringkasan'));
            modal.find('#edit_pengirim').attr("value", div.data('pengirim'));
        });

    });
</script>
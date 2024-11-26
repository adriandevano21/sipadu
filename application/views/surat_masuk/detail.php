<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">No Surat <?= $detail[0]['no_surat'] ?></h5>
        <div class="header-elements">
            <a href="#" class="btn bg-blue btn-sm btn-icon"><i class="icon-plus2"></i></a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Detail Surat</h4>

                        <div class="row">
                            <div class='col-sm-6'><i class="icon-briefcase mr-2"></i> Sifat Surat:</div>
                            <div class='col-sm-6'><?= $detail[0]['sifat_surat'] ?></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-6'><i class="icon-circles2 mr-2"></i> Pengirim:</div>
                            <div class='col-sm-6'>
                                <?= $detail[0]['pengirim'] ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-6'><i class="icon-circles2 mr-2"></i> Tujuan:</div>
                            <div class='col-sm-6'>
                                <?= $detail[0]['tujuan'] ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-6'><i class="icon-history mr-2"></i> Perihal:</div>
                            <div class='col-sm-6'><?= $detail[0]['perihal'] ?></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-6'><i class="icon-file-check mr-2"></i> Ringkasan:</div>
                            <div class='col-sm-6'><?= $detail[0]['ringkasan'] ?></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-6'><i class="icon-file-pdf mr-2"></i></i> File Surat:</div>
                            <div class='col-sm-6'><a href="#" class="list-icons-item"><i class="icon-download"></i></a></div>
                        </div>
                        <br>

                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class=" mb-4">
                            <h4>Catatan Disposisi</h4>
                            <?php
                            foreach ($detail as $key => $value) { ?>
                                <div class="media flex-column flex-md-row">
                                    <div class="mr-md-3 mb-2 mb-md-0">
                                        <a href="#"><img src="<?= $value['url_foto'] ?>" class="rounded-circle" width="36" height="36" alt=""></a>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#" class="font-weight-semibold"><?= $value['nama_pegawai'] ?></a>
                                            <span class="font-size-sm text-muted ml-sm-2 mb-2 mb-sm-0 d-block d-sm-inline-block"><?= $value['created_at'] ?></span>
                                        </div>
                                        <p><?= $value['catatan'] ?></p>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                        </div>
                        <form action="<?= base_url(); ?>surat_masuk/disposisi" method="post" enctype="multipart/form-data" role="form">
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
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i>
                                Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>
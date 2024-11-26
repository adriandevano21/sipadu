<script src=".<?= base_url() ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/picker_date.js"></script>
<?php
if ($this->session->flashdata("sukses") != "") { ?>
    <div class="alert alert-success alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span><?php echo $this->session->flashdata("sukses"); ?></span>
    </div>
<?php } ?>
<?php if ($this->session->flashdata("gagal") != "") { ?>
    <div class="alert alert-danger alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span><?php echo $this->session->flashdata("gagal"); ?></span>
    </div>
<?php } ?>

<!-- Form validation -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Tambah Projek</h5>
        <div class="header-elements">
            <div class="list-icons">
                <!-- <a class="list-icons-item" data-action="collapse"></a> -->
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <!-- <a class="list-icons-item" data-action="remove"></a> -->
            </div>
        </div>
    </div>

    <div class="card-body">

        <form class="form-validate-jquery" method="post" action="">
            <fieldset class="mb-3">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tim Penyelenggara Kegiatan
                    </label>
                    <div class="col-lg-9">
                        <select class="form-control select" name="id_tim" required>
                            <option value="">Pilih Tim</option>
                            <option value="12">Umum </option>
                            <option value="13">Statistik Sosial</option>
                            <option value="14">Statistik Ekonomi</option>
                            <option value="15">Sensus</option>
                            <option value="16">Pengolahan dan TI</option>
                            <option value="17">Nerwilis</option>
                            <option value="18">Diseminasi dan Humas</option>
                            <option value="19">Transformasi Organisasi</option>
                            <option value="20">Statistik Sektoral</option>
                            <option value="99">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Nama Projek</label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="nama_projek" placeholder="masukan projek" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">IKU <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select data-placeholder="IKU" class="form-control select" data-fouc name="id_iku" id="id_iku">
                            <option></option>
                            <?php foreach ($iku
                                as $key => $value) { ?>
                                <option value="<?= $value["id"] ?>"> <?= $value["iku"] ?></option>
                            <?php } ?>
                        </select>
                        <span class="form-text text-muted"> Optional <code>default = kosong</code></span>
                    </div>
                </div>

            </fieldset>
            <div class="d-flex justify-content-end align-items-center">
                <button type="reset" class="btn btn-light" id="reset">Reset <i class="icon-reload-alt ml-2"></i></button>
                <button type="submit" class="btn btn-primary ml-3">Submit <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>

<!-- /form validation -->

<script src="<?= base_url() ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
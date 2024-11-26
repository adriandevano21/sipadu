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
        <h5 class="card-title">Tambah Rapat</h5>
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
                    <label class="col-form-label col-lg-3">Topik <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="topik" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal</label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="date" name="tanggal" min="<?= date("Y-m-d") ?>" required>
                        <!-- <span class="form-text text-muted"> Optional <code>default = today</code></span> -->
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Pukul</label>
                    <div class="col-lg-9 row">
                        <div class="col-lg-3">
                            <input class=" form-control" type="time" name="pukul" required>
                        </div>
                        <div class="col-lg-1">
                            <label class="col-form-label">sampai</label>
                        </div>
                        <div class="col-lg-3">
                            <input class=" form-control" type="time" name="selesai" required>
                        </div>
                        
                        <!-- <span class="form-text text-muted"> Optional <code>default = today</code></span> -->
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tempat <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select data-placeholder="tempat rapat" class="form-control select" data-fouc name="id_ruang_rapat" required>
                            <option></option>
                            <?php foreach (
                            	$master_ruang_rapat
                            	as $key => $value
                            ) { ?>
                                <option value="<?= $value["id"] ?>"><?= $value["nama_ruangan"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Pimpinan Rapat<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select data-placeholder="yang bertanda tangan di surat undangan" class="form-control select-minimum" data-fouc name="username_pengundang" required>
                            <option></option>
                            <?php foreach (
                            	$master_pegawai
                            	as $key => $value
                            ) { ?>
                                <option value="<?= $value[
                                	"username"
                                ] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Notulis/Narahubung <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select data-placeholder="yang membuat notulen" class="form-control select-minimum" data-fouc name="username_notulis" required>
                            <option></option>
                            <?php foreach (
                            	$master_pegawai
                            	as $key => $value
                            ) { ?>
                                <option value="<?= $value[
                                	"username"
                                ] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Peserta <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select multiple="multiple" data-placeholder="Peserta rapat" class="form-control form-control-sm select" data-container-css-class="select-sm" data-fouc name="username_peserta[]">
                            <option></option>
                            <?php foreach (
                            	$master_pegawai
                            	as $key => $value
                            ) { ?>
                                <option value="<?= $value[
                                	"username"
                                ] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Peserta Eksternal<span class="text-danger">*</span></label>
                    <div id="group1" class="fvrduplicate col-lg-9">
                        <div class="row entry ">
                            <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input class="form-control form-control-sm" name="nama_peserta_eksternal[]" type="text">
                            </div>
                            </div>
                            <div class=" col-lg-5">
                            <div class="form-group">
                                <label>Instansi</label>
                                <input class="form-control form-control-sm" name="instansi_peserta_eksternal[]" type="text">
                            </div>
                            </div>
                            <div class=" col-lg-1">
                            <div class="form-group">
                                <label>&nbsp; </label><br>
                                <button type="button" class="btn btn-success btn-sm btn-add">
                                <i class="icon-plus22"></i>
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span>* Pimpinan rapat dan notulis tidak perlu diinputkan ke dalam peserta rapat, karena sudah otomatis masuk ke dalam peserta rapat</span>
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


<script src="<?= base_url() ?>/global_assets/js/demo_pages/jquery.repeater.js"></script>
<script>
    $(function() {
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();
        var controlForm = $(this).closest('.fvrduplicate'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<i class="icon-dash"></i>');
    }).on('click', '.btn-remove', function(e) {
        $(this).closest('.entry').remove();
        return false;
    });
});
</script>


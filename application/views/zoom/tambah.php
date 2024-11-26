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


<!-- CKEditor default -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Jadwalkan Zoom</h5>
        <input type="button" value="Back" onclick="history.back(-1)" class="btn btn-primary" />
        <!-- <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div> -->
    </div>

    <div class="card-body">


        <form class="form-validate-jquery" method="post" action="" enctype="multipart/form-data">

            <h4>Notulen Rapat</h4>

            <div class="mb-3">
                <textarea name="notulen" id="editor-full" rows="4" cols="4" required><?= $detail_rapat["notulen"] ?></textarea>
            </div>
            <h4>Foto Dokumentasi</h4>
            <div class="form-group row">

                <div class="col-lg-12">
                    <input type="file" name="upload_foto[]" multiple="multiple" class="file-input" data-show-caption="false" data-show-upload="false" data-fouc accept=".jpg, .png, .jpeg">
                    <span class="form-text text-muted">ukuran foto maksimal 300kb</span>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn bg-teal-400">
                    Submit Notulen <i class="icon-paperplane ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<!-- /CKEditor default -->

<script src="<?= base_url() ?>/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/editor_ckeditor.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/uploader_bootstrap.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>
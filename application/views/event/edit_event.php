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
        <h5 class="card-title">Edit Event</h5>
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
                    <label class="col-form-label col-lg-3">Jenis Kegiatan</label>
                    <div class="col-lg-9">
                        <select class="form-control select" name="id_jenis_kegiatan" id="jenis" data-placeholder="Jenis Kegiatan" required>

                            <option value="<?= $detail_rapat['id_jenis_kegiatan'] ?>"><?= $detail_rapat['jenis_kegiatan'] ?></option>
                            <?php foreach ($master_jenis_kegiatan
                                as $key => $value) { ?>
                                <option value="<?= $value["id"] ?>"><?= $value["jenis_kegiatan"] ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tim Penyelenggara Kegiatan
                    </label>
                    <div class="col-lg-9">
                        <select class="form-control select" name="id_tim" required>
                            <option value="<?= $detail_rapat['id_tim'] ?>"><?= $detail_rapat['nama_tim'] ?></option>
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
                    <label class="col-form-label col-lg-3">Topik/Nama Kegiatan </label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="topik" required value="<?= $detail_rapat['topik'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal dan pukul <span style="color:red">(isi ulang)</span></label>
                    <div class="input-group col-lg-9">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" name="range" id="range" class="form-control daterange-time" min="<?= date("Y-m-d") ?>">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tempat Kegiatan </label>
                    <div class="col-lg-9">
                        <select data-placeholder="tempat kegiatan" class="form-control select" data-fouc name="id_ruang_rapat" id="id_ruang_rapat" required>
                            <option value="<?= $detail_rapat['id_ruang_rapat'] ?>"><?= $detail_rapat['nama_ruangan'] ?></option>
                            <?php foreach ($master_ruang_rapat
                                as $key => $value) { ?>
                                <option value="<?= $value["id"] ?>"><?= $value["nama_ruangan"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row" id="lokasi">
                    <label class="col-form-label col-lg-3">Lokasi </label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="lokasi">
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
<script>
    $(document).ready(function() {
        $("#jenis").change(function() {
            var selectedValue = $(this).val();
            $("#pimpinan_rapat").hide();

            if (selectedValue === "1") {
                $("#pimpinan_rapat").show();
            } else {
                $("#pimpinan_rapat").hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#lokasi").hide();
        // Menggunakan event change pada select element
        $("#id_ruang_rapat").on("change", function() {
            // Memeriksa apakah nilai yang dipilih adalah 99
            if ($(this).val() === "99" || $(this).val() === "88") {
                // Jika nilai adalah 99, maka munculkan div dengan id "lokasi"
                $("#lokasi").show();
            } else {
                // Jika nilai bukan 99, maka sembunyikan div dengan id "lokasi"
                $("#lokasi").hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#range").on("change", function() {
            var range = $("#range").val();

            if (range) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('event/get_available_ruangan'); ?>",
                    data: {
                        range: range,
                    },
                    dataType: "json",

                    success: function(response) {
                        // Kosongkan elemen select
                        $("#id_ruang_rapat").empty();
                        // Tambahkan opsi-opsi baru berdasarkan response JSON
                        $.each(response, function(key, value) {
                            $("#id_ruang_rapat").append("<option value='" + value.id + "'>" + value.nama_ruangan + "</option>");
                        });
                    }

                });
            }
        });
    });
</script>
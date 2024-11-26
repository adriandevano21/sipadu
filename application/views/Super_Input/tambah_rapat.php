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

<style>
    .loader-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #3498db;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>


<!-- Form validation -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Tambah Event</h5>
        <div class="header-elements">
            <div class="list-icons">
                <!-- <a class="list-icons-item" data-action="collapse"></a> -->
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <!-- <a class="list-icons-item" data-action="remove"></a> -->
            </div>
        </div>
    </div>

    <div class="card-body">

        <form class="form-validate-jquery" method="post" action="" id="myForm">
            <fieldset class="mb-3">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Jenis Kegiatan</label>
                    <div class="col-lg-9">
                        <select class="form-control select" name="id_jenis_kegiatan" id="jenis" data-placeholder="Jenis Kegiatan" required>
                            <option></option>
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
                            <option value="">Pilih Tim</option>
                            <option value="12">Umum </option>
                            <option value="13">Statistik Sosial</option>
                            <option value="14">Statistik Ekonomi Distribusi</option>
                            <option value="15">Statistik Ekonomi Produksi</option>
                            <option value="16">Pengolahan dan TI</option>
                            <option value="17">Nerwilis</option>
                            <option value="18">Diseminasi dan Humas</option>
                            <option value="19">Transformasi & Budaya Organisasi</option>
                            <option value="20">Pembinaan Statistik Sektoral</option>
                            <option value="99">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Topik/Nama Kegiatan </label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="topik" required  onkeydown="preventSingleQuote(event)">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal dan pukul</label>
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
                            <option></option>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group row" id="lokasi">
                    <label class="col-form-label col-lg-3">Lokasi </label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="lokasi" onkeydown="preventSingleQuote(event)">
                    </div>
                </div>

                <div class="form-group row" id="pimpinan_rapat">
                    <label class="col-form-label col-lg-3">Pimpinan Rapat</label>
                    <div class="col-lg-9">
                        <select data-placeholder="yang bertanda tangan di surat undangan" class="form-control select-minimum" data-fouc name="username_pengundang" id="form_pimpinan_rapat">
                            <option></option>
                            <?php foreach ($master_pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Notulis </label>
                    <div class="col-lg-9">
                        <select data-placeholder="yang membuat notulen" class="form-control select-minimum" data-fouc name="username_notulis" required>
                            <option></option>
                            <?php foreach ($master_pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Peserta </label>
                    <div class="col-lg-9">
                        <select multiple="multiple" data-placeholder="Peserta Internal" class="form-control form-control-sm select" data-container-css-class="select-sm" data-fouc name="username_peserta" id="username_peserta">
                            <option></option>
                            <?php foreach ($master_pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!--<div class="form-group row">-->
                <!--    <label class="col-form-label col-lg-3">Peserta Eksternal</label>-->
                <!--    <div id="group1" class="fvrduplicate col-lg-9">-->
                <!--        <div class="row entry ">-->
                <!--            <div class="col-lg-6">-->
                <!--                <div class="form-group">-->
                <!--                    <label>Nama</label>-->
                <!--                    <input class="form-control form-control-sm" name="nama_peserta_eksternal" id="nama_peserta_eksternal" type="text">-->
                <!--                </div>-->
                <!--            </div>-->
                <!--            <div class=" col-lg-5">-->
                <!--                <div class="form-group">-->
                <!--                    <label>Instansi</label>-->
                <!--                    <input class="form-control form-control-sm" name="instansi_peserta_eksternal" id="instansi_peserta_eksternal" type="text">-->
                <!--                </div>-->
                <!--            </div>-->
                <!--            <div class=" col-lg-1">-->
                <!--                <div class="form-group">-->
                <!--                    <label>&nbsp; </label><br>-->
                <!--                    <button type="button" class="btn btn-success btn-sm btn-add">-->
                <!--                        <i class="icon-plus22"></i>-->
                <!--                    </button>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
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
<!-- Loader -->
<div class="loader-container d-none">
  <div class="loader"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin membuat rapat ini?
      </div>
      <div class="modal-footer">
          <div id="loading" class="d-none mr-2"><div class="loader"></div></div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="confirmSubmit">Saya Yakin</button>
        
      </div>
    </div>
  </div>
</div>

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

<script>
$(document).ready(function(){
    $('#jenis').change(function(){
        if($(this).val() === '1') {
            $('#form_pimpinan_rapat').prop('required', true);
        } else {
            $('#form_pimpinan_rapat').prop('required', false);
        }
    });
});
</script>
<script>
  $(document).ready(function(){
    $('#myForm').submit(function(e){
      e.preventDefault();
      $('#confirmationModal').modal('show');
    });

    $('#confirmSubmit').click(function(){
      $('.loader-container').removeClass('d-none');
      
        var selectedValues = $('#username_peserta').val();
        $('#myForm').find('select[name="username_peserta"]').remove();
        
        // var selectedValues_nama_peserta_eksternal = $('input[name="nama_peserta_eksternal"]').val();
        // $('#myForm').find('input[name="nama_peserta_eksternal"]').remove();
        
        // var selectedValues_instansi_peserta_eksternal = $('#instansi_peserta_eksternal').val();
        // $('#myForm').find('input[name="instansi_peserta_eksternal"]').remove();
        
        
        $('<input>').attr({
            type: 'hidden',
            name: 'username_peserta2',
            value: selectedValues.join(' ')
        }).appendTo('#myForm');
        
        // $('<input>').attr({
        //     type: 'hidden',
        //     name: 'nama_peserta_eksternal',
        //     value: selectedValues_nama_peserta_eksternal.join(' ')
        // }).appendTo('#myForm');
        
        // $('<input>').attr({
        //     type: 'hidden',
        //     name: 'instansi_peserta_eksternal',
        //     value: selectedValues_instansi_peserta_eksternal.join(' ')
        // }).appendTo('#myForm');
    
      $('#myForm').off('submit').submit();
    });
  });
</script>

<script>
        function preventSingleQuote(event) {
            if (event.key === "'") {
                event.preventDefault();
                alert("Tanda kutip tunggal tidak diizinkan");
            }
        }
    </script>


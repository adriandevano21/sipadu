

<?php
if ($this->session->flashdata('sukses') <> '') {
?>
    <div class="alert alert-success alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <span><?php echo $this->session->flashdata('sukses'); ?></span>
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
        <span><?php echo $this->session->flashdata('gagal'); ?></span>
    </div>
<?php
}
?>

<!-- Form validation -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Tambah Perjadin</h5>
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
                    <label class="col-form-label col-lg-3">Pelaksana Perjadin </label>
                    <div class="col-lg-9">
                        <select data-placeholder="Nama yang melaksanakkan perjalanan dinas" class="form-control select-minimum" data-fouc name="username" >
                            <option></option>
                            <?php foreach ($master_pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                        
                        <span class="form-text text-muted"> Optional <code>default = diri sendiri</code></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3"> Anggota Perjadin</label>
                    <div class="col-lg-9">
                        <select multiple="multiple" data-placeholder="   Anggota perjalanan dinas" class="form-control form-control-sm select" data-container-css-class="select-sm" data-fouc name="username_peserta" id="username_peserta">
                            <option></option>
                            <?php foreach ($master_pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                        
                        <span class="form-text text-muted"> Optional <code>kosongkan apabila pergi sendiri</code></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tujuan/Tugas <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="judul" placeholder="isikan judul perjalanan" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Deskripsi <span class="text-danger"></span></label>
                    <div class="col-lg-9">
                        <textarea rows="3" cols="3" name="deskripsi" class="form-control"  placeholder="isikan detail perjadin anda"></textarea>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">No Surat Tugas</span></label>
                    <div class="col-lg-9">
                        <input  name="no_st" class="form-control" type="text"  placeholder="isikan no surat tugas">
                    </div>
                </div>
                <div class="form-group row">
					<label class="col-form-label col-lg-3">Sumber Anggaran</label>
					<div class="col-lg-9">
    					<div class="form-check form-check-inline">
    						<label class="form-check-label">
    							<input type="radio" class="form-check-input-styled" checked data-fouc value="1" name="id_jenis_anggaran">
    							BPS Aceh - PPIS
    						</label>
    					</div>
    
    					<div class="form-check form-check-inline">
    						<label class="form-check-label">
    							<input type="radio" class="form-check-input-styled" data-fouc value="2" name="id_jenis_anggaran">
    							BPS Aceh - DUKMAN
    						</label>
    					</div>
    					<div class="form-check form-check-inline">
    						<label class="form-check-label">
    							<input type="radio" class="form-check-input-styled" data-fouc value="3" name="id_jenis_anggaran">
    							BPS RI
    						</label>
    					</div>
    					<div class="form-check form-check-inline">
    						<label class="form-check-label">
    							<input type="radio" class="form-check-input-styled" data-fouc value="4" name="id_jenis_anggaran">
    							BPS Kabupaten/Kota
    						</label>
    					</div>
    					<div class="form-check form-check-inline">
    						<label class="form-check-label">
    							<input type="radio" class="form-check-input-styled" data-fouc value="5" name="id_jenis_anggaran">
    							Non BPS
    						</label>
    					</div>
					</div>
				</div>
				<div class="form-group row">
                    <label class="col-form-label col-lg-3">Program yang membiayai <span class="text-danger"></span></label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="program" placeholder="isikan program" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Kegiatan <span class="text-danger"></span></label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="kegiatan" placeholder="isikan kegiatan" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Komponen <span class="text-danger"></span></label>
                    <div class="col-lg-9">
                        <input class=" form-control" type="text" name="komponen" placeholder="isikan komponen" >
                    </div>
                </div>
                <div class=" form-group row">
                    <label class="col-form-label col-lg-3">Waktu Pelaksanaan</label>
                    <div class="col-lg-4">
                        <input class=" form-control" type="date" name="tanggal_pergi"  required>
                        <!--<input class=" form-control" type="date" name="tanggal_pergi" min="<?= date('Y-m-d'); ?>" required>-->
                        <!-- <span class="form-text text-muted"> Optional <code>default = today</code></span> -->
                    </div>
                    <div class="col-lg-1 text-center">
                        <span>sampai</span>
                    </div>
                    <div class="col-lg-4">
                        <input class=" form-control" type="date" name="tanggal_pulang"   required>
                        <!-- <span class="form-text text-muted"> Optional <code>default = today</code></span> -->
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tempat Tujuan <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select data-placeholder="pilih tujuan" class="form-control select-minimum" data-fouc name="kode_tujuan" required>
                            <option></option>
                            <?php

                            foreach ($master_satker as $key => $value) { ?>
                                <option value="<?= $value['kode_satker']; ?>"><?= $value['nama_satker']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
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
        Apakah Anda yakin ingin membuat perjalanan ini?
      </div>
      <div class="modal-footer">
          <div id="loading" class="d-none mr-2"><div class="loader"></div></div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="confirmSubmit">Saya Yakin</button>
        
      </div>
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

<script>
  $(document).ready(function(){
    // $('#myForm').submit(function(e){
    //   e.preventDefault();
    //   $('#confirmationModal').modal('show');
    // });

    $('#myForm').submit(function(){
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

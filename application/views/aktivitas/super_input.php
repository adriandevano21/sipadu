
<script src=".<?= base_url() ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/picker_date.js"></script>
<style>
  .radio-group {
    display: flex;
    gap: 15px;
  }
  
  .radio-button {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    font-size: 16px;
  }
  
  .radio-button input {
    display: none;
  }

  .radio-custom {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #3498db;
    margin-right: 8px;
    position: relative;
    transition: all 0.3s ease;
  }

  .radio-button input:checked + .radio-custom {
    background-color: #3498db;
    border-color: #3498db;
  }

  .radio-custom::after {
    content: "";
    width: 10px;
    height: 10px;
    background-color: white;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.3s ease;
  }

  .radio-button input:checked + .radio-custom::after {
    transform: translate(-50%, -50%) scale(1);
  }
</style>
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

    <form class="ml-3 mt-3">
      <div class="radio-group">
        <label class="radio-button">
          <input type="radio" name="warna" value="merah">
          <span class="radio-custom"></span> Kegiatan
        </label>
        <label class="radio-button">
          <input type="radio" name="warna" value="biru">
          <span class="radio-custom"></span> Rapat
        </label>
        <label class="radio-button">
          <input type="radio" name="warna" value="hijau">
          <span class="radio-custom"></span> Perjadin
        </label>
      </div>
    </form>

<!-- Form validation -->
<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Tambah Kegiatan</h5>
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
                <div class="form-check">
                    <label class="form-check-label">
                        <!-- <input type="checkbox" class="form-check-input-styled-primary" data-fouc name="penugasan" id="cekPenugasan"> -->
                        <input type="checkbox" class="form-check-input-styled-primary" name="penugasan" id="cekPenugasan">
                        <b>Berikan Penugasan</b>
                    </label>
                </div>
                <div id="penugasan">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Pegawai yang ditugaskan <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select data-placeholder="pilih nama pegawai" class="form-control select-minimum" data-fouc name="username" id="nama_penugasan">
                                <option></option>
                                <?php
                                foreach ($pegawai as $key => $value) { ?>
                                    <option value="<?= $value['username']; ?>"><?= $value['nama_pegawai']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                </div>

                <!-- <legend class="text-uppercase font-size-sm font-weight-bold">Tambah Aktivitas</legend> -->
                <!--<div class="form-group row">-->
                <!--    <label class="col-form-label col-lg-3">Tanggal</label>-->
                <!--    <div class="col-lg-9">-->
                        <!--<input class=" form-control" type="date" name="tanggal" min="<?= date('Y-m-d'); ?>">-->
                <!--        <input class=" form-control" type="date" name="tanggal">-->
                <!--        <span class="form-text text-muted"> Optional <code>default = today</code></span>-->
                <!--    </div>-->
                <!--</div>-->
                
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal dan pukul</label>
                    <div class="col-lg-9">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" name="range" id="range" class="form-control " value="NULL">
                        
                    </div>
                    <span class="form-text text-muted"> Optional <code>default = today</code></span>
                    </div>
                    
                </div>

                
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Projek <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select data-placeholder="Projek" class="form-control select-minimum" data-fouc name="id_projek" id="id_projek">
                            <option></option>
                            <?php foreach ($projek
                                as $key => $value) { ?>
                                <option value="<?= $value["id_projek"] ?>">[<?= $value["nama_tim"] ?>] <?= $value["nama_projek"] ?></option>
                            <?php } ?>
                        </select>
                        <span class="form-text text-muted"> Optional <code>default = kosong</code></span>
                    </div>
                </div>
                <!-- Basic textarea -->
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Kegiatan <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <!--<textarea rows="3" cols="3" name="aktivitas" class="form-control" required placeholder="Jika lebih dari 1 kegiatan, silahkan buat kegiatan baru"></textarea>-->
                        <input name="aktivitas" class="form-control" required placeholder="Jika lebih dari 1 kegiatan, silahkan buat kegiatan baru">
                    </div>
                </div>
                <!-- /basic textarea -->
                <!-- Basic select -->
                <input type="hidden" name="status_kerja" value="WFO">
                <!--<div class="form-group row">-->
                <!--    <label class="col-form-label col-lg-3">WFH/WFO <span class="text-danger">*</span></label>-->
                <!--    <div class="col-lg-9">-->
                <!--        <select name="status_kerja" class="form-control" required>-->
                <!--            <option value="">Pilih WFH/WFO</option>-->

                <!--            <option value="WFO">WFO</option>-->
                <!--            <option value="WFH">WFH</option>-->

                <!--        </select>-->
                <!--    </div>-->
                <!--</div>-->
                <!-- /basic select -->

            </fieldset>

            <div class="d-flex justify-content-end align-items-center">
                <button type="reset" class="btn btn-light" id="reset">Reset <i class="icon-reload-alt ml-2"></i></button>
                <button type="submit" class="btn btn-primary ml-3">Submit <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- /form validation -->





<script src="<?= base_url(); ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>

<script>
    $(document).ready(function() {
        $("#penugasan").hide();
    });
    $('#cekPenugasan').change(function() {
        if (this.checked) {
            $("#penugasan").show();
            document.getElementById("nama_penugasan").required = true;
        } else {
            $("#penugasan").hide();
            document.getElementById("nama_penugasan").required = false;
        }

        // // alert('changed');
        // if ($("#cekPenugasan").attr(':checked')) {
        //     $("#penugasan").hide();
        //     alert("hilang");

        // } else {
        //     $("#penugasan").show();
        //     alert("muncul");

        // }
    });
</script>

<script>
    $(document).ready(function() {
        $('#range').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 5,
            startDate: moment().set({ hour: 8, minute: 0 }),
            endDate: moment().set({ hour: 16, minute: 0 }),
            locale: {
              format: 'DD-MM-YYYY HH:mm' // Format tanggal dan waktu
            }
          });
        
    //   $('#range').datetimepicker({
    //       defaultDate: moment().startOf('day').add(8, 'hours'),
    //       format: 'YYYY-MM-DD HH:mm',
    //       minDate: moment().startOf('day'),
    //       maxDate: moment().endOf('day')
    //   });
    });
  </script>


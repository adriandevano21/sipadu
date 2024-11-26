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


<script src=".<?= base_url() ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/picker_date.js"></script>
<!-- Form validation -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Edit Kegiatan</h5>
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
                <!-- <legend class="text-uppercase font-size-sm font-weight-bold">Tambah Aktivitas</legend> -->
                
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal dan pukul   </label>
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
                <!-- Basic textarea -->
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Kegiatan <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <!--<textarea rows="3" cols="3" name="aktivitas" class="form-control" required placeholder="Jika lebih dari 1 kegiatan, silahkan buat kegiatan baru"></textarea>-->
                        <input name="aktivitas" class="form-control" required value="<?= $data['aktivitas'] ?>">
                    </div>
                </div>
                <!--<div class="form-group row">-->
                <!--    <label class="col-form-label col-lg-3">Kegiatan <span class="text-danger">*</span></label>-->
                <!--    <div class="col-lg-9">-->
                <!--        <textarea rows="3" cols="3" name="aktivitas" class="form-control" required placeholder="Jika lebih dari 1 kegiatan, silahkan buat kegiatan baru"></textarea>-->
                <!--    </div>-->
                <!--</div>-->
                <!-- /basic textarea -->
                <!-- Basic select -->
                <!--<div class="form-group row">-->
                <!--    <label class="col-form-label col-lg-3">WFH/WFO <span class="text-danger">*</span></label>-->
                <!--    <div class="col-lg-9">-->
                <!--        <select name="status_kerja" class="form-control" required>-->
                <!--            <option value="<?= $data['status_kerja'] ?>"><?= $data['status_kerja'] ?></option>-->


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
        $('#range').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 5,
            startDate: moment().set({ hour: <?= substr($data['pukul'], 0,2) ?>, minute:<?= substr($data['pukul'], 3,2) ?> }),
            endDate: moment().set({ hour: <?= substr($data['selesai'], 0,2) ?>, minute: <?= substr($data['selesai'], 3,2) ?> }),
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


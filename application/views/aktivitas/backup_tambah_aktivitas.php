
<script src=".<?= base_url() ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/picker_date.js"></script>
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



public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');

        if ($this->form_validation->run()) {
            
            $aktivitas = $this->input->post('aktivitas');
            $status_kerja = $this->input->post('status_kerja');
            $id_pk  = (!empty($this->input->post('id_pk'))) ? $this->input->post('id_pk') : null;
            $id_projek = (!empty($this->input->post('id_projek'))) ? $this->input->post('id_projek') : null;
            
            if (!empty($this->input->post('penugasan'))) {
                $username = $this->input->post('username');
                $username_pemberi_aktivitas =
                    $this->session->userdata('username');
            } else {
                $username = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }
            
            if (!empty($this->input->post('range'))) {
                  $dateTimeRange = $this->input->post('range');
                  // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
                  // Memecah tanggal mulai dan selesai
                  list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);
                //   print_r($startDateTime) ;
                //   print_r($endDateTime) ;
                //   exit;
            
                  // Konversi format tanggal ke format yang sesuai untuk database
                  $startDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $startDateTime);
                  $endDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $endDateTime);
                  
                  // Mendapatkan tanggal mulai dan selesai
                  $startDate = $startDateTimeObj->format('Y-m-d');
                  $endDate = $endDateTimeObj->format('Y-m-d');
            
                  // Mendapatkan jam mulai dan selesai
                  $startTime = $startDateTimeObj->format('H:i:s');
                  $endTime = $endDateTimeObj->format('H:i:s');
                  // Mendapatkan tanggal dan waktu dalam format yang diinginkan
                  $tanggal = $startDate;
                  $pukul = $startTime;
                  $tanggal_selesai = $endDate;
                  $selesai = $endTime;
                  
                    $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'pukul'                 => $pukul,
                        'tanggal_selesai'      => $tanggal_selesai,
                        'selesai'                 => $selesai,
        
                    );
            } else {
                    $tanggal = date("Y-m-d");
                    $selesai = date("Y-m-d");
                    
                    $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'tanggal_selesai' => $selesai
        
                    );
            }
            
            // if (!empty($this->input->post('tanggal'))) {
            //     $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            // } else {
            //     $tanggal = date("Y-m-d");
            // }
            $this->master_model->insert("aktivitas", $params);

            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/tambah');
        } else {

            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $data['projek'] = $this->projek_model->get_all();
            $data['indikator_pk'] = $this->indikator_pk_model->get_all_aktif();
            $data['pk'] = $this->master_model->get_all('pk');
            $data['judul'] = 'Kegiatan';
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/tambah_aktivitas');
        }
    }


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

        <form class="form-validate-jquery" method="post" action="">
            <fieldset class="mb-3">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Pelaksana Perjadin </label>
                    <div class="col-lg-9">
                        <select data-placeholder="yang melaksanakkan perjalanan dinas" class="form-control select-minimum" data-fouc name="username" >
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

<script src="<?= base_url(); ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>


CONTROLLER

public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('kode_tujuan', 'kode_tujuan', 'required');

    if ($this->form_validation->run()) {

      $username =  (!empty($this->input->post('username'))) ? $this->input->post('username') : $this->session->userdata('username')  ;
      $tanggal_pergi = date("Y-m-d", strtotime($this->input->post('tanggal_pergi')));
      $tanggal_pulang = date("Y-m-d", strtotime($this->input->post('tanggal_pulang')));
      $date1 = date_create($tanggal_pergi);
      $date2 = date_create($tanggal_pulang);
      $kode_tujuan = $this->input->post('kode_tujuan');
      $no_st = $this->input->post('no_st');
      $komponen = $this->input->post('komponen');
      $program = $this->input->post('program');
      $kegiatan = $this->input->post('kegiatan');
      $status = "diajukan"; // status 0 baru
      $judul = $this->input->post('judul');
      $diff = date_diff($date1, $date2);
      $durasi = $diff->format("%a"); // pulang-pergi, satuan hari
      $deskripsi = $this->input->post('deskripsi');
      $id_jenis_anggaran = $this->input->post('id_jenis_anggaran');

      $params = array(
        'username'            => $username,
        'tanggal_pergi'       => $tanggal_pergi,
        'tanggal_pulang'      => $tanggal_pulang,
        'kode_tujuan'         => $kode_tujuan,
        'status'              => $status,
        'no_st'              => $no_st,
        'judul'               => $judul,
        'program'               => $program,
        'kegiatan'               => $kegiatan,
        'komponen'               => $komponen,
        'durasi'              => $durasi + 1,
        'deskripsi'           => $deskripsi,
        'id_jenis_anggaran'  => $id_jenis_anggaran,
        'username_created' => $this->session->userdata('username')
      );

      $id_perjadin = $this->master_model->insert("perjadin", $params);
    //   $this->kirim_undangan($id_perjadin);
      $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

      redirect('perjadin/lihat');
    } else {
        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $data['master_satker'] = $this->master_model->get_all('master_satker');
      
      $data['judul'] = 'Perjadin';
      $this->load->vars($data);
      $this->template->load('template/template', 'perjadin/tambah_perjadin');
    }
  }

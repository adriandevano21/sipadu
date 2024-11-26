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
		<h5 class="card-title">Input Notulen</h5>
		<input
			type="button"
			value="Back"
			onclick="history.back(-1)"
			class="btn btn-primary"
		/>
		<!-- <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div> -->
	</div>

	<div class="card-body">
		<div class="row col-lg-12">
            <div class="col-lg-6">
            <table class="table">
                    <tr>
                    <td width='10%'>Topik </td>
                <td width='5%'>: </td>
                <td><?= $detail_rapat['topik']; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: </td>
                <td><?= $detail_rapat['tanggal']; ?></td>
            </tr>
            <tr>
                <td>Pukul </td>
                <td>: </td>
                <td><?= $detail_rapat['pukul']; ?></td>
            </tr>
            <tr>
                <td>Ruangan </td>
                <td>: </td>
                <td><?= $detail_rapat['nama_ruangan']; ?> </td>
            </tr>
            <tr>
                <td>Pengundang </td>
                <td>: </td>
                <td><?= $detail_rapat['pengundang']; ?></td>
            </tr>
            <tr>
                <td>Notulis </td>
                <td>: </td>
                <td><?= $detail_rapat['notulis']; ?></td>

            </tr>
        </table>
        </div>
        <div class="col-lg-6">
            <table class="table">
            <tr>
            <td width='10%' colspan="3">File Pendukung </td>
                
            </tr>
            <tr>
                <td width='10%' >Undangan</td>
                <td width="1%">: </td>
                <td>
                    <?php
                    if (!empty($detail_rapat['nama_file_undangan'])) {
                    ?>
                        <span>
                            <a href="<?= base_url(); ?>rapat/download/<?= $detail_rapat['id'] . "/" . $detail_rapat['nama_file_undangan'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"> download</i></a>
                        </span>

                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Notulen </td>
                <td>: </td>
                <td>
                    <?php
                    if (!empty($detail_rapat['nama_file_notulen'])) {
                    ?>
                        <span>
                            <a href="<?= base_url(); ?>rapat/download/<?= $detail_rapat['id'] . "/" . $detail_rapat['nama_file_notulen'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"> download</i></a>
                        </span>

                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Berkas Lainnya </td>
                <td>: </td>
                <td>
                    <?php
                    if (!empty($detail_rapat['nama_file_berkas'])) {
                    ?>
                        <span>
                            <a href="<?= base_url(); ?>rapat/download/<?= $detail_rapat['id'] . "/" . $detail_rapat['nama_file_berkas'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green" > download</i></a>
                        </span>

                    <?php
                    }
                    ?>
                </td>
            </tr>
            
        </table>
        </div>
        </div>
		<h3>Peserta Rapat</h3>
		<form class="form-validate-jquery" method="post" action="" enctype="multipart/form-data">
			<div class="row col-lg-12">
				<div class="col-lg-6">
					<h4>Peserta Internal</h4>
					<div class="table-responsive table-scrollable">
					<table class="table">
						<tr>
							<td>&nbsp;</td>
							<td>Nama</td>
							<td>Status</td>
						</tr>
						<?php foreach ($peserta_rapat as $key => $value) { ?>
						<tr>
							<td>
								<input type="checkbox" class="form-check-input-styled-success" <?php echo ($value["status"] == "1")? "checked":"" ; ?>
								data-fouc name="hadir[]" value=<?= $value["id"] ?>>
							</td>
							<td><?= $value["nama_pegawai"] ?></td>
							<td>
								<?php if ($value["status"] == "1") { ?>
								<span class="badge badge-flat border-success text-success-600"
									>hadir</span
								>
								<?php } elseif ($value["status"] == "0") { ?>
								<span class="badge badge-flat border-danger text-danger-600"
									>tidak hadir</span
								>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</table>
					</div>
				</div>
				<div class="col-lg-6">
					<h4>Peserta Eksternal</h4>
					<div class="table-responsive table-scrollable">
					<table width="100%" class="table">
						<tr>
							<td></td>
							<td>Nama</td>
							<td>Instansi</td>
							<td>Status</td>
						</tr>
						<?php foreach ($peserta_rapat_eksternal as $key => $value) { ?>
						<tr>
							<td>
								<input type="checkbox" class="form-check-input-styled-success"
								data-fouc name="hadir_eksternal[]" value=<?= $value["id"]; ?>>
							</td>
							<td>
								<input type="hidden" name="id_peserta_eksternal[]" value="<?=$value['id'];?>" />
								<input type="text" class="form-control form-control-sm" name="nama_peserta_eksternal[]" value="<?=$value['nama'];?>" />
							</td>
							<td>
								<input type="text" class="form-control form-control-sm" name="instansi_peserta_eksternal[]" value="<?=$value['instansi'];?>" />
							</td>
							<td>
								<?php if ($value["status"] == "1") { ?>
								<span class="badge badge-flat border-success text-success-600"
									>hadir</span
								>
								<?php } elseif ($value["status"] == "0") { ?>
								<span class="badge badge-flat border-danger text-danger-600"
									>tidak hadir</span
								>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</table>
					</div>
				</div>
			</div>
			
			<br />
			<h4>Notulen Rapat</h4>

			<div class="mb-3">
				<textarea name="notulen" id="editor-full" rows="4" cols="4" required><?= $detail_rapat["notulen"] ?></textarea>
			</div>
			<h4>Dokumentasi Rapat Telah Terupload</h4>
            <div class="row">
                <?php foreach ($dokumentasi_rapat as $key => $value) {
                    
                ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-img-actions m-1">
                            <img class="card-img img-fluid" src="<?= base_url('upload_file/rapat/').$value['nama_file'] ?>" alt="">
                            <div class="card-img-actions-overlay card-img">
                                <a href="https://sipadu.bpsaceh.com/uploads/rapat/<?=$value['nama_file'] ?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                    <i class="icon-plus3"></i>
                                </a>
    
                                <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
    
                
            </div>
			
		
			<div class="form-group row">
				<div class="col-lg-6">
				    <h4>Foto Dokumentasi</h4>
					<input type="file" name="upload_foto[]" multiple="multiple" class="file-input" data-show-caption="false" data-show-upload="false" data-fouc accept=".jpg, .png, .jpeg" >
					<span class="form-text text-muted">ukuran foto maksimal 500kb</span>
				</div>
				<div class="col-lg-6">
				    <h4>Undangan</h4>
					<input type="file" name="upload_undangan"  class="file-input" data-show-caption="false" data-show-upload="false" data-fouc accept=".pdf" >
					<!--<span class="form-text text-muted">ukuran foto maksimal 300kb</span>-->
				</div>
				
			</div>
			<div class="form-group row">
			    <div class="col-lg-6">
				    <h4>PDF Notulen</h4>
					<input type="file" name="upload_notulen"  class="file-input" data-show-caption="false" data-show-upload="false" data-fouc accept=".pdf" >
					<!--<span class="form-text text-muted">ukuran foto maksimal 300kb</span>-->
				</div>
				<div class="col-lg-6">
				    <h4>Berkas Lainnya</h4>
					<input type="file" name="upload_berkas"  class="file-input" data-show-caption="false" data-show-upload="false" data-fouc accept=".pdf, .rar, .zip" >
					<!--<span class="form-text text-muted">ukuran foto maksimal 300kb</span>-->
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
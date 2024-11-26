	<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>
	
<script src=".<?= base_url() ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
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
	
	
	<!-- Kalender Kegiatan -->
	<div class="card border-teal-400">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Kalender Kegiatan <?= $aktivitas['0']['nama_pegawai']; ?></h5>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="collapse"></a>
					<a class="list-icons-item" data-action="reload"></a>
					<a class="list-icons-item" data-action="remove"></a>
				</div>
			</div>
		</div>

		<div class="card-body">
		    <div>
		        <form class="form-validate-jquery" method="post" action="">
		            <div class='row'>
		            <div class="col-sm-11">
		        <select name="username" class="form-control select-minimum">
		            <option value="<?= $aktivitas['0']['username']; ?>"><?= $aktivitas['0']['nama_pegawai']; ?> </option>
		            <?php foreach ($master_pegawai as $value)  { ?>
		            <option value="<?= $value['username']; ?>"><?= $value['nama_pegawai']; ?> </option>
		            <?php } ?>
		        </select>
		        </div>
		        <div class="col-sm-1">
		        <button type="submit" class="btn bg-teal-400 ml-3">Cari</button>
		        </div>
		        </div>
		        </form>
		    </div>
		    <br>

			<div id="calendar"></div>
		</div>
	</div>

	<script>
		$(document).ready(function() {

			var events = [
				<?php foreach ($aktivitas as $activity) : ?> {
				
				        title: "<?php echo str_replace('"' ,"" , str_replace ("\n","<br />", $activity["aktivitas"]) ) ; ?>", 
						start: '<?php echo $activity['tanggal']." ".$activity['pukul'] ; ?>',
						end: '<?php echo $activity['tanggal_selesai']." ".$activity['selesai'] ; ?>'
					},
				<?php endforeach; ?>
			];

			$('#calendar').fullCalendar({
				minTime: '07:00:00', // Batas waktu awal (7 pagi)
				maxTime: '19:00:00', // Batas waktu akhir (7 malam)
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,basicWeek,basicDay'
				},
				views: {
					month: {
						titleFormat: 'LL',
						columnFormat: 'dddd'
					},
					week: {
						titleFormat: 'MMM Do YY',
						columnFormat: 'ddd D'
					},
					day: {
						titleFormat: 'dddd',
						columnFormat: 'dddd'
					}
				},
				timeFormat: 'H:mm', // uppercase H for 24-hour clock
				// defaultDate: '2014-11-12',
				// editable: true,
				events: events,
				isRTL: $('html').attr('dir') == 'rtl' ? true : false
			});
		});
	</script>

	<!-- Vertical form modal -->
	<div id="modal_selesai" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Output Kegiatan</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form method="post" action="<?= base_url(); ?>/aktivitas/selesai">
					<input type="hidden" name="id_aktivitas" id="id_aktivitas">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Kegiatan</label>
									<textarea class="form-control" disabled id="selesai_aktivitas" rows="3"></textarea>
									<!-- <input type="text" class="form-control" disabled id="selesai_aktivitas"> -->
								</div>


							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Output</label>
									<input type="text" placeholder="output" class="form-control" id="selesai_output" name="output" required autofocus>
								</div>


							</div>
						</div>


					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /vertical form modal -->

	<!-- Vertical form modal -->
	<div id="modal_hapus" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Hapus Kegiatan</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form method="post" action="<?= base_url(); ?>/aktivitas/hapus">
					<input type="hidden" name="id_aktivitas" id="hapus_id_aktivitas">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Kegiatan</label>
									<textarea class="form-control" disabled id="hapus_aktivitas" rows="3"></textarea>
								</div>


							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /vertical form modal -->

	<!-- Vertical form modal -->
	<div id="modal_mood" class="modal fade" data-backdrop="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h5 class="modal-title text-center">Mood Anda Hari ini</h5>
					<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
				</div>

				<form method="post" action="<?= base_url(); ?>/aktivitas/mood">

					<div class="modal-body">
						<div class="row text-center">
							<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/1.png" alt="Chania" width="170" style="max-width:20%;" onclick="mood(1)">
							<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/2.png" alt="Chania" width="170" style="max-width:20%;" onclick="mood(2)">
							<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/3.png" alt="Chania" width="170" style="max-width:20%;" onclick="mood(3)">
							<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/4.png" alt="Chania" width="170" style="max-width:20%;" onclick="mood(4)">
							<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/5.png" alt="Chania" width="170" style="max-width:20%;" onclick="mood(5)">
						</div>
						<hr>

					</div>

					<!-- <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-primary">Submit</button>
                </div> -->
				</form>
			</div>
		</div>
	</div>
	<!-- /vertical form modal -->
	<!-- script untuk progress -->


<script src="<?= base_url(); ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>

	<!-- script untuk modal -->
	<script type="text/javascript">
		$(document).ready(function() {

			$('#modal_selesai').on('show.bs.modal', function(event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)

				// Isi nilai pada field
				modal.find('#selesai_aktivitas').val(div.data('aktivitas'));
				modal.find('#selesai_output').attr("value", div.data('output'));
				modal.find('#id_aktivitas').attr("value", div.data('id_aktivitas'));
				modal.find('#selesai_output').focus();


				//modal.find('#email_to').attr("value",div.data(''));

			});

		});

		$(document).ready(function() {

			$('#modal_hapus').on('show.bs.modal', function(event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)

				// Isi nilai pada field
				modal.find('#hapus_aktivitas').val(div.data('aktivitas'));
				modal.find('#hapus_id_aktivitas').attr("value", div.data('id_aktivitas'));


				//modal.find('#email_to').attr("value",div.data(''));

			});

		});
	</script>

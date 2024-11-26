	<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>
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
	<div class="card border-teal-400">
		<!-- <div class="card-header header-elements-inline">
        <h5 class="card-title">Kumpulan Aktivitas</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div> -->
		<br>
		<div id="chart">

		</div>
	</div>

	<!-- Basic datatable -->
	<div class="card border-teal-400">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Kumpulan Kegiatan <?= $this->session->userdata('nama_pegawai') ?></h5>

			<a href="<?= base_url(); ?>/aktivitas/tambah">
				<button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Kegiatan</button>
			</a>
			<a href="<?= base_url(); ?>/scan">
				<button type="button" class="btn btn-outline-primary"><i class="icon-qrcode mr-2"></i> Scan QR</button>
			</a>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="collapse"></a>
					<!-- <a class="list-icons-item" data-action="reload"></a> -->
					<a class="list-icons-item" data-action="remove"></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<form method="get" action="<?= base_url(); ?>/aktivitas/sendiri">
				<div class="form-group row">
					<label class="col-form-label col-sm-1">Bulan</label>
					<div class="col-sm-4">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group ">
									<select name="bulan" class="form-control">
										<option value=<?= $bulan; ?>><?= $bulan; ?></option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<label class="col-form-label col-sm-1">Tahun</label>
					<div class="col-sm-4">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group ">
									<select name="tahun" class="form-control">
										<option value=<?= $tahun; ?>><?= $tahun; ?></option>
										<option value="2022">2022</option>
										<option value="2023">2023</option>
										<option value="2024">2024</option>
										<option value="2025">2025</option>
										<option value="2026">2026</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-outline-primary"><i class="icon-search4 mr-2"></i> Filter</button>
					</div>
				</div>

			</form>
		</div>


		<table class="table datatable-button-html5-basic table-striped">

			<thead>
				<tr class="bg-teal-400">

					<!--<th>Nama</th>-->
					<th>Tanggal</th>
					<th>PK</th>
					<th>Kegiatan</th>
					<th>Output</th>

					<th>Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

				foreach ($aktivitas as $key => $value) {
				?>
					<tr>

						<td class="text-center">
							<?php echo date("d-m-Y", strtotime($value['tanggal'])) ?>
						</td>
						<td>
							<?php echo $value['pk']; ?>
						</td>

						<td>
							<?php echo $value['aktivitas']; ?>
						</td>
						<td>
							<?php echo $value['output']; ?>
						</td>

						<td class="text-center">
							<?php
							if ($value['status_aktivitas'] == "selesai") { ?>
								<span class="badge badge-flat border-success text-success-600"><?php echo $value['status_aktivitas']; ?></span>
							<?php
							} else if ($value['status_aktivitas'] == "progres") { ?>
								<span class="badge badge-flat border-primary text-primary-600"><?php echo $value['status_aktivitas']; ?></span>
							<?php
							} else if ($value['status_aktivitas'] == "batal") { ?>
								<span class="badge badge-flat border-danger text-danger-600"><?php echo $value['status_aktivitas']; ?></span>
							<?php

							}
							?>

						</td>
						<td class="text-center">
							<div class="list-icons">
								<div class="dropdown">

									<?php
									if ($value['status_aktivitas'] == "selesai" || $value['username'] != $this->session->userdata('username')) { ?>
									<?php
									} else { ?>
										<a href="#" class="list-icons-item" data-toggle="dropdown">
											<i class="icon-menu9"></i>
										</a>

										<div class="dropdown-menu dropdown-menu-right">

											<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_selesai" data-aktivitas="<?php echo $value['aktivitas']; ?>" data-id_aktivitas="<?php echo $value['id_aktivitas']; ?>"><i class="icon-check"></i>
												Selesai</a>

											<a href="<?= base_url(); ?>/aktivitas/edit/<?= $value['id_aktivitas'] ?>" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>

											<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_hapus" data-aktivitas="<?php echo $value['aktivitas']; ?>" data-id_aktivitas="<?php echo $value['id_aktivitas']; ?>"><i class="icon-eraser"></i>
												Hapus</a>

											<!-- <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a> -->
										<?php
									}
										?>
										</div>
								</div>
							</div>
						</td>

					</tr>
				<?php
				}
				?>

			</tbody>
		</table>
	</div>
	<!-- Kalender Kegiatan -->
	<div class="card border-teal-400">
		<div class="card-header header-elements-inline">
			<h5 class="card-title">Kalender Kegiatan</h5>
			<div class="header-elements">
				<div class="list-icons">
					<a class="list-icons-item" data-action="collapse"></a>
					<a class="list-icons-item" data-action="reload"></a>
					<a class="list-icons-item" data-action="remove"></a>
				</div>
			</div>
		</div>

		<div class="card-body">

			<div id="calendar"></div>
		</div>
	</div>

	<script>
		$(document).ready(function() {

			var events = [
				<?php foreach ($aktivitas as $activity) : ?> {
						title: '<?php echo $activity['aktivitas']; ?>',
						start: '<?php echo $activity['tanggal']; ?>',
						end: '<?php echo $activity['tanggal_selesai']; ?>'
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
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script>
		var options = {
			series: [{
				name: 'Telah Mengisi',
				data: [<?= $rekap['jumlah_pegawai_lapor'] ?>]
			}, {
				name: 'Belum Mengisi',
				data: [<?= $rekap['jumlah_pegawai'] - $rekap['jumlah_pegawai_lapor'] ?>]
			}],
			chart: {
				type: 'bar',
				height: 150,
				stacked: true,
				stackType: '100%'
			},
			plotOptions: {
				bar: {
					horizontal: true,
				},
			},
			// stroke: {
			//     width: 1,
			//     colors: ['#fff']
			// },
			// title: {
			//     text: '100% Stacked Bar'
			// },
			xaxis: {
				categories: ["<?= date("d-m-Y") ?>"],
			},
			tooltip: {
				y: {
					formatter: function(val) {
						return val
					}
				}
			},
			fill: {
				opacity: 1,
				// colors:['#F44336', '#E91E63', '#9C27B0']

			},
			legend: {
				position: 'top',
				horizontalAlign: 'center',
				// offsetX: 40
			}
		};

		var chart = new ApexCharts(document.querySelector("#chart"), options);
		chart.render();
	</script>

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

	<script>
		$(document).ready(function() {
			if (<?= $modal_mood; ?>) {
				$("#modal_mood").modal('show');
			} else {
				$("#modal_mood").modal('hide');
			}

		});

		function mood(mood) {


			// $.post("<?= base_url(); ?>mood/tambah", {
			//     mood: mood,
			//     username: <?= $this->session->userdata('username') ?>
			// }, function(result) {
			//     $("span").html(result);
			// });

			$.ajax({
				url: '<?= base_url(); ?>mood/tambah',
				type: 'POST',
				data: {
					mood: mood,

				},
				error: function() {
					alert('Something is wrong');
				},
				success: function(data) {
					$("#modal_mood").modal('hide');
				}
			});

		}
	</script>
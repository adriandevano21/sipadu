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
	<div class="card border-teal-400 row">
		
		<br>
		<div id="chart">

		</div>
	</div>
	<div class="row">
	<div class="card border-teal-400 col-sm-5  text-center" >
		<div class="row text-center">
		    <div style="max-width:20%;">
			<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/1.png" alt="Chania" width="170" >
			<br>
			<h2><?= $rekap_mood["mood1"] ?></h2>
			</div>
			<div style="max-width:20%;">
			<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/2.png" alt="Chania" width="170" >
			<br>
			<h2><?= $rekap_mood["mood2"] ?></h2>
			</div>
			<div style="max-width:20%;">
			<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/3.png" alt="Chania" width="170" >
			<br>
			<h2><?= $rekap_mood["mood3"] ?></h2>
			</div>
			<div style="max-width:20%;">
			<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/4.png" alt="Chania" width="170" >
			<br>
			<h2><?= $rekap_mood["mood4"] ?></h2>
			</div>
			<div style="max-width:20%;">
			<img class=" text-center img-fluid" src="<?= base_url(); ?>/global_assets/images/mood/5.png" alt="Chania" width="170" >
			<br>
			<h2><?= $rekap_mood["mood5"] ?></h2>
			</div>
			
			
		</div>

	</div>
	<div class="col-sm-1  " >
	    </div>
	<div class="card border-teal-400 col-sm-6  " >
<blockquote class="blockquote">
  <p class="mb-0"><h3><?php echo $quote['quote'] ?></h3></p>
  <!--<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
  <footer class="blockquote-footer"><?php echo $quote['sumber'] ?></footer>
</blockquote>
	</div>
	</div>
	
	<div class="" >
	    <div class="card border-teal-400 row">
		
		<img class="img-fluid" src="<?php echo $quran_verse['image']['secondary']; ?>" alt="Primary Image">
	
        <!--<p class="text-left" > <h2>  <?php echo $quran_verse['arab']; ?> </h2></p>-->
        <p class="text-right float-right">"<?php echo $quran_verse['translation']; ?>"</p>
        
        <audio controls>
            <source src="<?php echo $quran_verse['audio']['alafasy']; ?>" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
                    
            <p class="float-none">
            <h6 class="card-subtitle mb-2 text-muted">Tafsir Kemenag:</h6>
            <?php echo $quran_verse['tafsir']['kemenag']['short']; ?>
            </p>
		
	    </div>
	    
	</div>

	<!-- Basic datatable -->




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
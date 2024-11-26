	<style>
	    .modal {
	        display: none;
	        position: fixed;
	        z-index: 1;
	        left: 0;
	        top: 0;
	        width: 100%;
	        height: 100%;
	        overflow: auto;
	        background-color: rgba(0, 0, 0, 0.4);
	    }

	    .modal-content {
	        background-color: #fefefe;
	        margin: 10% auto;
	        padding: 20px;
	        border: 1px solid #888;
	        width: 80%;
	    }

	    .close {
	        color: #aaa;
	        float: right;
	        font-size: 28px;
	        font-weight: bold;
	    }

	    .close:hover,
	    .close:focus {
	        color: black;
	        text-decoration: none;
	        cursor: pointer;
	    }
	</style>
	<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>
	<!-- Basic datatable -->
	<div class="card">
	    <div class="card-header header-elements-inline">
	        <h5 class="card-title">List Event Pegawai</h5>
	        <a href="<?= base_url(); ?>/dashboard_event/list">
	            <button type="button" class="btn btn-outline-success"> Dashboard Event </button>
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
	        <form method="get" action="<?= base_url(); ?>/dashboard_event/pegawai">
	            <div class="form-group row">
	                <label class="col-form-label col-sm-1">Pegawai</label>
	                <div class="col-sm-3">
	                    <div class="row">
	                        <div class="col-md-12">
	                            <div class="form-group ">
	                                <select Data-placeholder="Nama Pegawai" class="form-control select-minimum" data-fouc name="username">
	                                    <option value=<?= ($pegawai['username'] ?? null); ?>><?= ($pegawai['nama_pegawai'] ?? null); ?></option>
	                                    <?php foreach ($master_pegawai
                                            as $key => $value) { ?>
	                                        <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
	                                    <?php } ?>
	                                </select>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <label class="col-form-label col-sm-1">Bulan</label>
	                <div class="col-sm-2">
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
	                <div class="col-sm-2">
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
	                <div class="col-sm-1">
	                    <button type="submit" class="btn btn-outline-primary"><i class="icon-search4 mr-2"></i> Filter</button>
	                </div>
	            </div>

	        </form>
	    </div>
	    <div id="calendar"></div>



	    <table class="table datatable-button-html5-basic">

	        <thead>
	            <tr>

	                <th class="text-center">Nama</th>
	                <th class="text-center">Tanggal</th>
	                <th class="text-center">Kegiatan</th>
	                <th class="text-center">Status</th>
	                <th class="text-center">Actions</th>
	            </tr>
	        </thead>
	        <tbody>
	            <?php

                foreach ($aktivitas as $key => $value) {
                ?>
	                <tr>
	                    <td>
	                        <?php echo $value['nama_pegawai']; ?>
	                    </td>
	                    <td class="text-center">
	                        <?php echo $value['tanggal']; ?>
	                    </td>

	                    <td>
	                        <?php echo $value['aktivitas']; ?>
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

	<!-- Vertical form modal -->
	<div id="eventModal" class="modal">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <!-- <h5 class="modal-title">Kegiatan</h5>
	                <button type="button" class="close" data-dismiss="modal">&times;</button> -->
	            </div>
	            <div class="modal-body">
	                Tanggal : <p id="event_tanggal"></p>
	                Kegiatan : <p id="eventTitle"></p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-link" id="close">Close</button>
	                <!-- <button type="submit" class="btn bg-primary">Submit</button> -->
	            </div>
	        </div>
	    </div>
	</div>
	<!-- /vertical form modal -->


	<!-- /vertical form modal -->
	<!-- script untuk progress -->
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>


	<script src="<?= base_url() ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

	<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_select2.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script>
	    $(document).ready(function() {

	        var events = [
	            <?php foreach ($aktivitas as $activity) : ?> {
	                    title: '<?php echo $activity['aktivitas']; ?>',
	                    start: '<?php echo $activity['tanggal']; ?>',
	                    tanggal: '<?php echo $activity['tanggal']; ?>'
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
	            eventClick: function(calEvent, jsEvent, view) {
	                // Saat acara di klik, tampilkan modal
	                $("#eventTitle").text(calEvent.title);
	                $("#event_tanggal").text(calEvent.tanggal);
	                $("#eventModal").css("display", "block");
	            },
	            timeFormat: 'H:mm', // uppercase H for 24-hour clock
	            // defaultDate: '2014-11-12',
	            // editable: true,
	            events: events,
	            isRTL: $('html').attr('dir') == 'rtl' ? true : false
	        });
	    });

	    $("#close").click(function() {
	        $("#eventModal").css("display", "none");
	    });
	</script>
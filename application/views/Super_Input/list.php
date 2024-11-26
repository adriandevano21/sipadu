<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>
<script src="<?= base_url() ?>/dashboard/scheduler.min.js"></script>
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
<!-- Basic datatable -->
<div class="card border-teal-400">
    <div class="card-header  header-elements-inline">
        <h5 class="card-title">Kumpulan Event</h5>
        <a href="<?= base_url(); ?>/event/tambah">
            <button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Event</button>
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
        <form method="get" action="<?= base_url(); ?>/event/list">
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
                <!-- 
                <th>Nama</th> -->
                <th class="text-center">Tanggal</th>
                <th class="text-center">Pukul</th>
                <th class="text-center">Tim</th>
                <th class="text-center">Nama Kegiatan</th>
                <th class="text-center">Tempat</th>
                 <th class="text-center">Peserta</th> 
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($rapat as $key => $value) {
            ?>
                <tr>
                    <td class="text-center">
                        <?php echo $value['tanggal']; ?>
                    </td>
                    <td class="text-center">
                        <center>
                            <?php echo substr($value['pukul'], 0, 5)  . " - " . substr($value['selesai'], 0, 5); ?>
                    </td>
                    <td>
                        <?php echo $value['nama_tim']; ?>
                    </td>
                    <td>
                       <b> <a href="<?= base_url(); ?>event/lihat/<?= $value['id_rapat'] ?>" data-toggle="tooltip" data-placement="top" title="Lihat Detail" style="color: black"><?php echo $value['topik']; ?></a> </b>
                    </td>
                    <td>
                        <?php echo (isset($value['lokasi'])) ? $value['lokasi'] : $value['nama_ruangan']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['peserta']; ?>
                    </td>

                    <td class="text-center">
                        <?php if ($value['username_created'] == $this->session->userdata('username')) { ?>
                        <a href="<?= base_url(); ?>event/edit/<?= $value['id_rapat'] ?>" data-toggle="tooltip" data-placement="top" title="Edit Event"><i class="icon-pencil" style="color:orange"></i>
                        </a>
                        <?php } ?>
                        <a href="<?= base_url(); ?>event/lihat/<?= $value['id_rapat'] ?>" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="icon-eye"></i>
                        </a>
                        
                        <?php if ($value['username_notulis'] == $this->session->userdata('username')) { ?>
                            <a href="<?= base_url(); ?>event/input_notulen/<?= $value['id_rapat'] ?>" data-toggle="tooltip" data-placement="top" title="Input Notulen"><i class="icon-pencil7" style="color:green"></i>
                            </a>
                        <?php } ?>
                        <?php
                        if (($value['username_created'] == $this->session->userdata('username') || $this->session->userdata('admin_zoom') == 1)) {
                        ?>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Hapus Event"><i class="icon-trash tombol_hapus" style="color:red" id="" data-id_rapat="<?php echo $value['id_rapat']; ?>"></i>
                            </a>
                        <?php } ?>

                    </td>

                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>
<!-- Kalender Kegiatan -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Kalender Event</h5>
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
        $('.tombol_hapus').on('click', function() {
            var id_rapat = $(this).data('id_rapat');
            var konfirmasi = confirm("Apakah Anda yakin hapus event ini?");
            if (konfirmasi) {
                window.location.href = "<?= base_url(); ?>event/hapus/" + id_rapat; // Ganti dengan URL halaman tujuan
            } else {
                // Tindakan lain jika pengguna membatalkan
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        var events = [
            <?php foreach ($rapat as $rapat) : ?> {
                    title: '<?php echo $rapat['topik']; ?>',
                    start: '<?php echo $rapat['tanggal'] . 'T' . $rapat['pukul']; ?>',
                    end: '<?php echo $rapat['tanggal_selesai'] . 'T' . $rapat['selesai']; ?>',
                    ruangan: '<?php echo (isset($rapat['lokasi'])) ? $rapat['lokasi'] : $rapat['nama_ruangan']; ?>',
                    narahubung: '<?php echo $rapat['nama_pegawai']; ?>',
                    id_ruangan: '<?php echo $rapat['id_ruangan']; ?>',
                    resourceId: '<?php echo $rapat['id_ruangan']; ?>',
                    url: '<?php echo base_url('event/lihat/') . $rapat['id_rapat'] ?>'
                },
            <?php endforeach; ?>
        ];

        $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: 'agendaDay', // Set default view to 'month'
            minTime: '07:00:00', // Batas waktu awal (7 pagi)
            maxTime: '19:00:00', // Batas waktu akhir (7 malam)
            // height: '800', // Atur tinggi kalender
            contentHeight: 800,
            slotEventOverlap: false, // Mencegah tumpang tindih acara

            eventRender: function(event, element) {

                // Customize the event rendering (optional)
                switch (event.id_ruangan) {
                    case '4':
                        element.css('background-color', 'Salmon'); // Red
                        break;
                    case '5':
                        element.css('background-color', 'LightSeaGreen'); // Green
                        break;
                    case '6':
                        element.css('background-color', 'RoyalBlue'); // Blue
                        break;
                    case '8':
                        element.css('background-color', 'orange'); // Blue
                        break;
                    case '9':
                        element.css('background-color', 'Plum'); // Blue
                        break;
                    case '99':
                        element.css('background-color', 'Chocolate'); // Blue
                        break;

                        //Add more cases for other "ruangan" values and their respective colors
                    default:
                        element.css('background-color', 'sky blue'); // Default color
                        break;
                };

                // For example, you can add event colors, tooltips, etc.
                element.find('.fc-title').append("<br><b>[" + event.narahubung.split(" ").slice(0, 2).join(" ") + "]</b>");
                element.find('.fc-title').append("<br><b>" + event.ruangan + "</b>");

            },


            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
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
                // day: {
                //     titleFormat: 'dddd',
                //     columnFormat: 'dddd'
                // }
            },
            resources: [
                <?php
                /* cek koneksi ke database */
                foreach ($ruang_rapat as $key => $value) {
                    // echo "{ title: '" . $value['nama_ruangan'] . "', id: '" . $value['id'] . "', eventColor: '" . $value['eventColor'] . "' } ";
                    echo "{ title: '" . $value['nama_ruangan'] . "', id: '" . $value['id'] . "', eventColor: 'red' }, ";
                }

                ?>
            ],

            select: function(start, end, jsEvent, view, resource) {
                console.log(
                    'select',
                    start.format(),
                    end.format(),
                    resource ? resource.id : '(no resource)'
                );
            },
            dayClick: function(date, jsEvent, view, resource) {
                console.log(
                    'dayClick',
                    date.format(),
                    resource ? resource.id : '(no resource)'
                );
            },
            // Event click callback
            // eventClick: function(calEvent, jsEvent, view) {

            //     // Set modal content with the event details
            //     $('#eventTitle').text(calEvent.title);
            //     $('#eventStart').text('Tanggal: ' + calEvent.start.format('YYYY-MM-DD'));

            //     // Show the modal
            //     $('#eventModal').modal('show');
            // },
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
                <h5 class="modal-title">Laporan Perjalanan Dinas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post" action="<?= base_url(); ?>/event/selesai">
                <input type="hidden" name="id" id="id_rapat">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Judul</label>
                                <textarea class="form-control" disabled id="judul" rows="3"></textarea>
                                <!-- <input type="text" class="form-control" disabled id="selesai"> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Permasalahan</label>
                                <textarea class="form-control" id="permasalahan" rows="3" required></textarea>
                                <!-- <input type="text" class="form-control" disabled id="selesai"> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Solusi</label>
                                <textarea class="form-control" id="solusi" rows="3" required></textarea>
                                <!-- <input type="text" class="form-control" disabled id="selesai"> -->
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
<div id="modal_lihat" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Perjalanan Dinas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post" action="<?= base_url(); ?>/event/selesai">
                <input type="hidden" name="id" id="id_rapat">
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><span id="nama_pegawai"></span></td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td><span id="judul"></span></td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <td><span id="deskripsi"></span></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td><span id="tanggal_pergi"></span> sampai <span id="tanggal_pulang"></span></td>
                        </tr>
                        <tr>
                            <td>Durasi</td>
                            <td>:</td>
                            <td><span id="durasi"></span></td>
                        </tr>
                        <tr>
                            <td>Tujuan</td>
                            <td>:</td>
                            <td><span id="nama_satker"></span></td>
                        </tr>
                        <tr>
                            <td>Permasalahan</td>
                            <td>:</td>
                            <td><span id="permasalahan"></span></td>
                        </tr>
                        <tr>
                            <td>Solusi</td>
                            <td>:</td>
                            <td><span id="solusi"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn bg-primary">Submit</button> -->
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
            <form method="post" action="<?= base_url(); ?>/event/hapus">
                <input type="hidden" name="id" id="hapus_id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kegiatan</label>
                                <textarea class="form-control" disabled id="hapus" rows="3"></textarea>
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

<!-- /vertical form modal -->
<!-- script untuk progress -->
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<!-- script untuk modal -->
<script type="text/javascript">
    $(document).ready(function() {

        $('#modal_selesai').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#judul').val(div.data('judul'));
            modal.find('#id_rapat').attr("value", div.data('id_rapat'));
            modal.find('#permasalahan').focus();


            //modal.find('#email_to').attr("value",div.data(''));

        });

    });

    $(document).ready(function() {

        $('#modal_hapus').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#hapus').val(div.data('rapat'));
            modal.find('#hapus_id').attr("value", div.data('id'));


            //modal.find('#email_to').attr("value",div.data(''));

        });

    });

    $(document).ready(function() {
        function tanggal_indo(tanggal_full) {

            var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var xtahun = tanggal_full.substring(0, 4);
            var tanggal = tanggal_full.substr(8, 2);
            var xbulan = tanggal_full.substr(5, 2);

            var bulan = bulan[xbulan - 1];
            var tahun = (xtahun < 1000) ? xtahun + 1900 : xtahun;
            var tanggal_indo_ = (tanggal + ' ' + bulan + ' ' + tahun);
            return tanggal_indo_;
        }

        $('#modal_lihat').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)


            // Isi nilai pada field
            modal.find('#judul').text(div.data('judul'));
            modal.find('#nama_pegawai').text(div.data('nama_pegawai'));
            modal.find('#deskripsi').text(div.data('deskripsi'));
            modal.find('#tanggal_pergi').text(tanggal_indo(div.data('tanggal_pergi')));
            modal.find('#tanggal_pulang').text(tanggal_indo(div.data('tanggal_pulang')));
            modal.find('#durasi').text(div.data('durasi'));
            modal.find('#nama_satker').text(div.data('nama_satker'));
            modal.find('#permasalahan').text(div.data('permasalahan'));
            modal.find('#solusi').text(div.data('solusi'));


            //modal.find('#email_to').attr("value",div.data(''));

        });

    });
</script>
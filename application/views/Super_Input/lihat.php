<script src="<?= base_url(); ?>/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/editor_ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/gallery.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/media/fancybox.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 1000;
        display: none; /* Mulai dengan tersembunyi */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        font-size: 3rem;
        color: #000; /* Ubah warna jika diperlukan */
    }
</style>


<!-- Overlay -->
    <div id="loading-overlay">
        <div class="spinner">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </div>
<!-- CKEditor default -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Detail Event</h5>
        <a href="<?= base_url(); ?>/event/kirim_ulang/<?= $detail_rapat['id']; ?>" id="kirim-wa-ulang-btn">
            <button type="button" class="btn btn-outline-success">
                <i class="icon-paperplane mr-2"></i> Kirim WA Ulang
            </button>
        </a>
        <input type="button" value="Back" onclick="history.back(-1)" class="btn btn-primary" />
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
                        
                        <td>
                            <?php if ($detail_rapat['tanggal'] == $detail_rapat['tanggal_selesai']) { ?>
                                <span id="tanggal"></span>
                            <?php } else { ?>
                                <span id="tanggal"></span> - <span id="tanggal_selesai"></span>
                            <?php } ?>

                        </td>
                       
                    </tr>
                    <tr>
                        <td>Pukul </td>
                        <td>: </td>
                        <td>
                            <?php echo substr($detail_rapat['pukul'], 0, 5)  . " - " . substr($detail_rapat['selesai'], 0, 5); ?>
                            WIB
                        </td>
                    </tr>
                    <tr>
                        <td>Lokasi Kegiatan </td>
                        <td>: </td>
                        <td><?= (isset($detail_rapat['lokasi'])) ? $detail_rapat['lokasi'] : $detail_rapat['nama_ruangan'];  ?> </td>
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
                        <td width='10%'>Undangan</td>
                        <td width="1%">: </td>
                        <td>
                            <?php
                            if (!empty($detail_rapat['nama_file_undangan'])) {
                            ?>
                                <span>
                                    <a href="<?= base_url(); ?>event/download_file/<?= $detail_rapat['id'] . "/" . $detail_rapat['nama_file_undangan'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"> download</i></a>
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
                                    <a href="<?= base_url(); ?>event/download_file/<?= $detail_rapat['id'] . "/" . $detail_rapat['nama_file_notulen'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"> download</i></a>
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
                                    <a href="<?= base_url(); ?>event/download_file/<?= $detail_rapat['id'] . "/" . $detail_rapat['nama_file_berkas'] ?>" data-toggle="tooltip" data-placement="top" title="download surat"><i class="icon-download" style="color:green"> download</i></a>
                                </span>

                            <?php
                            }
                            ?>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <h4>Peserta Event </h4>
        <div class="row col-lg-12">
            <div class="col-lg-6">
                <h4>Peserta Internal</h4>
                <div class="table-responsive table-scrollable">
                    <table class=" table ">
                        <tr>

                            <td>Nama</td>
                            <td>Status Hadir</td>
                            <td>Status Notif WA</td>
                        </tr>
                        <?php

                        foreach ($peserta_rapat as $key => $value) {
                        ?>
                            <tr>
                                <td><?= $value['nama_pegawai']; ?>

                                </td>
                                <td>
                                    <?php
                                    if ($value['status'] == "1") { ?>
                                        <span class="badge badge-flat border-success text-success-600">hadir</span>
                                    <?php

                                    } else if ($value['status'] == "0") { ?>
                                        <span class="badge badge-flat border-danger text-danger-600">tidak hadir</span>
                                    <?php

                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($value['notif_wa'] == "1") { ?>
                                        <span class="badge badge-flat border-success text-success-600">berhasil</span>
                                    <?php

                                    } else if ($value['notif_wa'] == "0") { ?>
                                        <span class="badge badge-flat border-danger text-danger-600">gagal</span>
                                    <?php

                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <h4>Peserta Eksternal</h4>
                <div class="table-responsive table-scrollable">
                    <table class="table">
                        <tr>

                            <td>Nama</td>
                            <td>Instansi</td>
                            <td>Status</td>
                        </tr>
                        <?php

                        foreach ($peserta_rapat_eksternal as $key => $value) {
                        ?>
                            <tr>
                                <td><?= $value['nama']; ?>

                                </td>
                                <td><?= $value['instansi']; ?>

                                </td>
                                <td>
                                    <?php
                                    if ($value['status'] == "1") { ?>
                                        <span class="badge badge-flat border-success text-success-600">hadir</span>
                                    <?php

                                    } else if ($value['status'] == "0") { ?>
                                        <span class="badge badge-flat border-danger text-danger-600">tidak hadir</span>
                                    <?php

                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <!-- <p class="mb-3">CKEditor is a ready-for-use HTML text editor designed to simplify web content creation. It's a WYSIWYG editor that brings common word processor features directly to your web pages. It benefits from an active community that is constantly evolving the application with free add-ons and a transparent development process.</p> -->
        <h4>Notulen Event </h4>
        <table width='100%'>
            <tr>
                <td>
                    <span>
                        <?= $detail_rapat['notulen']; ?>
                    </span>
                </td>
            </tr>
        </table>
        <h4>Dokumentasi Event </h4>
        <div class="row">
            <?php foreach ($dokumentasi_rapat as $key => $value) {

            ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-img-actions m-1">
                            <img class="card-img img-fluid" src="<?= base_url('upload_file/rapat/') . $value['nama_file'] ?>" alt="">
                            <div class="card-img-actions-overlay card-img">
                                <a href="https://sipadu.bpsaceh.com/uploads/rapat/<?= $value['nama_file'] ?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
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

    </div>
</div>
<!-- /CKEditor default -->

<script>
    $(document).ready(function() {
        // Mendapatkan tanggal saat ini
        var currentDate = new Date("<?= $detail_rapat['tanggal']; ?>");

        // Array nama bulan dalam bahasa Indonesia
        var namaBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        var day = currentDate.getDate();
        var month = namaBulan[currentDate.getMonth()];
        var year = currentDate.getFullYear();

        var formattedDate = day + ' ' + month + ' ' + year;

        // Menampilkan tanggal dengan format Indonesia di dalam elemen dengan id "tanggal"
        $("#tanggal").text(formattedDate);
    });
    $(document).ready(function() {
        // Mendapatkan tanggal saat ini
        var currentDate2 = new Date("<?= $detail_rapat['tanggal_selesai']; ?>");

        // Array nama bulan dalam bahasa Indonesia
        var namaBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        var day = currentDate2.getDate();
        var month = namaBulan[currentDate2.getMonth()];
        var year = currentDate2.getFullYear();

        var formattedDate2 = day + ' ' + month + ' ' + year;

        // Menampilkan tanggal dengan format Indonesia di dalam elemen dengan id "tanggal"
        $("#tanggal_selesai").text(formattedDate2);
    });
</script>

<script>
    $('#loading-overlay').hide(); // Tampilkan overlay
    $(document).ready(function() {
        $('#kirim-wa-ulang-btn').on('click', function(event) {
            event.preventDefault();
            $('#loading-overlay').show(); // Tampilkan overlay

            // Arahkan ke URL setelah 1 detik untuk memberikan waktu memuat overlay
            setTimeout(() => {
                window.location.href = $(this).attr('href');
            }, 500);
        });
    });
</script>


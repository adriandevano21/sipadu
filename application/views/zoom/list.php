<style>
    .badge {
        font-size: 12px !important;
    }
    
    
    .loader-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #3498db;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  
</style>

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
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Kumpulan Rapat</h5>
        <!-- <a href="<?= base_url(); ?>/zoom/tambah"> -->
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal_tambah"><i class="icon-plus2 mr-2"></i> Booking Zoom</button>
        <!-- </a> -->
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <table class="table datatable-button-html5-basic table-striped">

        <thead>
            <tr class="bg-teal-400">
                <th>
                    <center> NO
                </th>
                <th>
                    <center> TOPIK
                </th>
                <th>
                    <center> TANGGAL
                </th>
                <th>
                    <center> PUKUL (WIB)
                </th>
                <th>
                    <center> HOST
                </th>
                <th>
                    <center> STATUS
                </th>
                <th>
                    <center> AKSI
                </th>

            </tr>
        </thead>
        <tbody>
            <?php

            $i = 1;
            foreach ($zoom as $key => $q) {

            ?>
                <tr>
                    <td>
                        <center><?php echo $i++;
                                ?>
                    </td>
                    <td>
                        <left><?php echo $q['topic'] ?>
                    </td>
                    <td>
                        <center><?php echo substr($q['start_date'], 0, 10)  ?>
                    </td>
                    <td>
                        <center><?php echo substr($q['start_date'], 11, 5) . ' - ' . substr($q['end_date'], 11, 5) ?>
                    </td>

                    <td>
                        <center><?php echo implode(' ', array_slice(explode(' ', $q['nama_pegawai']), 0, 2)) ?>
                    </td>
                    <td>
                        <center><?php
                                switch ($q['status']) {
                                    case "1":
                                        echo "<span class='badge badge-flat badge-pill border-primary text-primary'>verifikasi</span>";
                                        break;
                                    case "2":
                                        echo "<span class='badge badge-flat badge-pill border-success text-success'>ok</span>";
                                        break;
                                    case "99":
                                        echo "<span class='badge badge-flat badge-pill border-danger text-danger'>batal</span>";
                                        break;
                                    default:
                                        echo "";
                                }
                                ?>
                            <?php
                            if ($this->session->userdata('admin_zoom') == 1 && !empty($q['id_akun_zoom'])) {
                            ?>
                                <span class='badge badge-flat badge-pill border-primary text-primary'>
                                    <?php echo $q['id_akun_zoom']; ?>
                                </span>
                            <?php
                            }
                            ?>
                    </td>

                    <td>
                        <center>
                            <?php
                            if (($q['username'] == $this->session->userdata('username') || $this->session->userdata('admin_zoom') == 1) && $q['status'] == 2) {
                            ?>

                                <span data-toggle='modal' data-target='.modal_detail' data-date="<?php echo substr($q['start_date'], 0, 10); ?>" data-time="<?php echo substr($q['start_date'], 11); ?>" data-duration="<?php echo $q['duration']; ?>" data-id_zoom="<?php echo $q['id_zoom']; ?>" data-password="<?php echo $q['password_zoom']; ?>" data-join_url="<?php echo $q['join_url']; ?>" data-topic="<?php echo $q['topic']; ?>" data-akun="<?php echo $q['id_akun_zoom']; ?>">
                                    <a data-toggle="tooltip" data-placement="top" title="detail zoom"><i class="icon icon-eye"></i></a>
                                </span>
                            <?php
                            }
                            ?>
                            <?php
                            if ($this->session->userdata('admin_zoom') == 1) {
                            ?>
                                <?php if ($q['status'] != '99') { ?>
                                    <span data-toggle='modal' data-target='.modal_verifikasi' data-date="<?php echo substr($q['start_date'], 0, 10); ?>" data-time="<?php echo substr($q['start_date'], 11); ?>" data-duration="<?php echo $q['duration']; ?>" data-password="<?php echo $q['password_zoom']; ?>" data-topic="<?php echo $q['topic']; ?>" data-id="<?php echo $q['id_zoom_meeting']; ?>" data-target_peserta="<?php echo $q['target_peserta']; ?>">
                                        <a data-toggle="tooltip" data-placement="top" title="verifikasi zoom"><i class="icon icon-pencil" style="color: orange"></i></a>
                                    </span>
                                <?php } ?>
                                <?php
                                if ($q['start_date'] > date("Y-m-d h:i:sa") && $q['status'] != '99') {
                                ?>
                                    <span data-toggle='modal' data-target='.modal_batal' data-date="<?php echo substr($q['start_date'], 0, 10); ?>" data-time="<?php echo substr($q['start_date'], 11); ?>" data-duration="<?php echo $q['duration']; ?>" data-password="<?php echo $q['password_zoom']; ?>" data-topic="<?php echo $q['topic']; ?>" data-id="<?php echo $q['id_zoom_meeting']; ?>" data-target_peserta="<?php echo $q['target_peserta']; ?>">
                                        <a data-toggle="tooltip" data-placement="top" title="batalkan zoom"><i class="icon icon-blocked" style="color: red"></i></a>
                                    </span>
                                <?php } ?>
                            <?php
                            }
                            ?>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal batal Kegiatan-->
<div class="modal fade modal_batal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Batalkan Zoom Meeting</h4>

            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>zoom/batal" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="id" id="batal_id">

                    <div class="form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">TOPIK

                        </label>

                        <input type="text" id="batal_topic" name="topic" required="" class="form-control" value="" readonly>

                    </div>
                    <div class=" form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">TANGGAL</label>

                        <input class="form-control" id='batal_date' type="text" name="date" required='required' readonly>

                    </div>
                    <div class=" form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">JAM</label>

                        <input class="form-control" id='batal_time' type="text" name="time" required='required' readonly>

                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">DURASI

                        </label>

                        <input type="text" id="batal_duration" name="duration" required="" class="form-control" value="" readonly>

                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">PASSWORD

                        </label>

                        <input type="text" id="batal_password" name="password" required="" class="form-control" value="" readonly>

                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">TARGET PESERTA

                        </label>

                        <input type="text" id="batal_target_peserta" name="target_peserta" required="" class="form-control" value="" readonly>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Batalkan</button>
            </div>
            </form>

        </div>
    </div>
</div>


<!-- Vertical form modal -->
<div id="modal_tambah" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h5 class="modal-title">Jadwalkan Zoom</h5>

            </div>

            <form method="post" action="<?= base_url(); ?>/zoom/buat" id="formTambah">


                <div class="card-body">
                    <div class="form-group form-group-float">
                        <label class="form-group-label animate is-visible">Topik</label>
                        <input type="text" class="form-control" name="topik" placeholder="Topik" required='required'>
                    </div>

                    <div class="form-group form-group-float">
                        <label class="form-group-label animate is-visible">Tanggal</label>
                        <input type="date" class="form-control" name="date" placeholder="Tanggal" required='required'>
                    </div>

                    <div class="form-group form-group-float">
                        <label class="form-group-label animate is-visible">Pukul</label>
                        <input class="form-control" class='time' type="time" name="start_time" required='required' placeholder="Pukul" id="inputA">
                        sampai
                        <input class="form-control" class='time' type="time" name="end_time" required='required' placeholder="Sampai" id="inputB">
                        <!-- <span class="form-text text-muted">Input helper text block</span> -->
                    </div>

                    <div class="form-group form-group-float">
                        <label class="form-group-label animate is-visible">Password</label>
                        <input type="text" class="form-control" name="password" placeholder="Password, maksimal 10 karakter" required='required' maxlength="10" minlength="3">
                    </div>

                    <div class="form-group form-group-float">
                        <label class="form-group-label animate is-visible">Jumlah Peserta</label>
                        <input type="number" class="form-control" name="target_peserta" placeholder="Jumlah Peserta" required='required'>
                    </div>

                    <div class="form-group form-group-float">
                        <label class="form-group-label animate is-visible">Peserta</label>
                        <input type="text" class="form-control" name="peserta" placeholder="Peserta" required='required'>
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

<!-- Loader -->
<div class="loader-container d-none">
  <div class="loader"></div>
</div>

<!-- Modal verifikasi Kegiatan-->
<div class="modal fade modal_verifikasi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Verifikasi Zoom Meeting</h4>

            </div>
            <div class="card-body">
                <form action="<?= base_url(); ?>zoom/verifikasi" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="id" id="verifikasi_id">

                    <div class="form-group form-group-float">
                        <label class="form-group-label" for="first-name">TOPIK

                        </label>

                        <input type="text" id="verifikasi_topic" name="topic" required="" class="form-control" value="" readonly>

                    </div>
                    <div class="form-group form-group-float">
                        <label class="form-group-label">TANGGAL</label>

                        <input class="form-control" id='verifikasi_date' type="text" name="date" required='required' readonly>

                    </div>
                    <div class="form-group form-group-float">
                        <label class="form-group-label">JAM</label>

                        <input class="form-control" id='verifikasi_time' type="text" name="time" required='required' readonly>

                    </div>
                    <div class="form-group form-group-float">
                        <label class="form-group-label" for="first-name">DURASI

                        </label>

                        <input type="text" id="verifikasi_duration" name="duration" required="" class="form-control" value="" readonly>

                    </div>
                    <div class="form-group form-group-float">
                        <label class="form-group-label" for="first-name">PASSWORD

                        </label>

                        <input type="text" id="verifikasi_password" name="password" required="" class="form-control" value="" readonly>

                    </div>
                    <div class="form-group form-group-float">
                        <label class="form-group-label" for="first-name">TARGET PESERTA

                        </label>

                        <input type="text" id="verifikasi_target_peserta" name="target_peserta" required="" class="form-control" value="" readonly>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Setujui</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal detail Kegiatan-->
<div class="modal fade modal_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Detail Meeting</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" value="" name="id_kegiatan" id="edit_id_kegiatan" />


                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">TOPIK

                    </label>
                    
                        <input type="text" id="detail_topic" name="detail_topic" class="form-control" value="" disabled>
                    
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">TANGGAL

                    </label>
                    
                        <input type="text" id="detail_date" name="detail_date" class="form-control" value="" disabled>
                    
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">JAM

                    </label>
                    
                        <input type="text" id="detail_time" name="detail_time" class="form-control" value="" disabled>
                    
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">DURASI

                    </label>
                    
                        <input type="text" id="detail_duration" name="detail_duration" class="form-control" value="" disabled>
                    
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">ID ZOOM

                    </label>
                    
                        <input type="text" id="detail_id_zoom" name="detail_id_zoom" class="form-control" value="" disabled>
                    
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">PASSWORD

                    </label>
                    
                        <input type="text" id="detail_password" name="detail_password" class="form-control" value="" disabled>
                    
                </div>
                <?php
                if ($this->session->userdata('admin_zoom') == 1) {

                ?>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">AKUN ZOOM

                        </label>
                        
                            <input type="text" id="detail_akun" name="detail_akun" class="form-control" value="" disabled>
                        
                    </div>

                <?php } ?>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align ">URL
                    </label>
                        <input class="form-control" id="detail_join_url" name="detail_join_url" value="" type="text">
                        <button onclick="myFunction()">Copy URL</button>
                </div>


            </div>
            <input class="form-control" id="detail_join_url2" name="detail_join_url" value="" type="text" >
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="myFunction2()">Copy Undangan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
            </div>


        </div>
    </div>
</div>

<!-- script untuk progress -->
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script src="<?= base_url(); ?>global_assets/js/demo_pages/form_floating_labels.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.modal_verifikasi').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#verifikasi_id').attr("value", div.data('id'));
            modal.find('#verifikasi_topic').attr("value", div.data('topic'));
            modal.find('#verifikasi_date').attr("value", div.data('date'));
            modal.find('#verifikasi_time').attr("value", div.data('time'));
            modal.find('#verifikasi_duration').attr("value", div.data('duration'));
            modal.find('#verifikasi_target_peserta').attr("value", div.data('target_peserta'));
            modal.find('#verifikasi_password').attr("value", div.data('password'));

        });

        $('.modal_batal').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#batal_id').attr("value", div.data('id'));
            modal.find('#batal_topic').attr("value", div.data('topic'));
            modal.find('#batal_date').attr("value", div.data('date'));
            modal.find('#batal_time').attr("value", div.data('time'));
            modal.find('#batal_duration').attr("value", div.data('duration'));
            modal.find('#batal_target_peserta').attr("value", div.data('target_peserta'));
            modal.find('#batal_password').attr("value", div.data('password'));

        });
        
        $('.modal_detail').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#detail_topic').attr("value", div.data('topic'));
            modal.find('#detail_date').attr("value", div.data('date'));
            modal.find('#detail_time').attr("value", div.data('time'));
            modal.find('#detail_duration').attr("value", div.data('duration'));
            modal.find('#detail_id_zoom').attr("value", div.data('id_zoom'));
            modal.find('#detail_password').attr("value", div.data('password'));
            modal.find('#detail_akun').attr("value", div.data('akun'));
            modal.find('#detail_join_url').attr("value", div.data('join_url'));
            modal.find('#detail_join_url2').attr("value", div.data('join_url'));
            $("#p").append(div.data('join_url'));
            //modal.find('#email_to').attr("value",div.data(''));

        });

        
    });
</script>
<script>

$("#detail_join_url2").hide();
    

    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("detail_join_url");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        // alert("Copied the text: " + copyText.value);
    }
    function myFunction2() {
        $("#detail_join_url2").show();
        /* Get the text field */
        var copyText = document.getElementById("detail_join_url2");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        // alert("Copied the text: " + copyText.value);
    }
</script>
<script>
    $(document).ready(function() {
      $('#formTambah').submit(function(event) {
        event.preventDefault(); // Menghentikan form dari mengirimkan data

        var timeA = $('#inputA').val();
        var timeB = $('#inputB').val();

        if (timeA >= timeB) {
            alert("Jam selesai harus lebih besar dari jam mulai");
            return false; // Menghentikan proses submit form
          
        } else {
        //   $('.error').remove(); // Menghapus pesan error sebelumnya (jika ada)
          // Lanjutkan dengan mengirimkan form atau melakukan tindakan lain
          $('#formTambah')[0].submit();
          $('.loader-container').removeClass('d-none');
        }
      });
    });
  </script>
  
 
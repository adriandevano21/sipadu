<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php
        if ($this->session->flashdata('sukses') <> '') {
        ?>
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <p><?php echo $this->session->flashdata('sukses'); ?></p>

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
                <p><?php echo $this->session->flashdata('gagal'); ?></p>
            </div>
        <?php
        }
        ?>
    </div>

</div>
<!-- Basic datatable -->

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">LPP <?= $this->session->userdata('nama_pegawai'); ?></h5>
        <!--<a href="<?= base_url(); ?>/aktivitas/tambah">-->
        <!--<button type="button" class="btn btn-outline-success"><i class="icon-plus2 mr-2"></i> Kegiatan</button>-->
        <!--</a>-->
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>

    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url(); ?>/lpp">
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
                    <a href="<?= base_url('lpp/pdf') . '?bulan=' . $bulan . '&tahun=' . $tahun ?>">
                        <button type="button" class="btn btn-outline-success"><i class="icon-download mr-2"></i> Pdf</button>
                    </a>
                </div>
            </div>

        </form>
        <form method="post" action="<?= base_url(); ?>/lpp/upload" enctype="multipart/form-data">
            <input type="hidden" value="<?= (!empty($isi_lpp[0]['id_lpp'])) ? $isi_lpp[0]['id_lpp'] : '';  ?>" name="id_lpp">
            <div class="form-group row">
                <label class="col-form-label col-sm-1">Upload File </label>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <input type="file" name="file_lpp">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <?php
                    if (empty($isi_lpp[0]['nama_file'])) { ?>
                        <button type="submit" class="btn btn-outline-success"><i class="icon-upload mr-2"></i> Upload</button>
                    <?php
                    } else { ?>
                        <a href="<?= base_url(); ?>/lpp/download/<?= $isi_lpp[0]['nama_file'] ?>"><button type="button" class="btn btn-outline-success"><i class="icon-download mr-2"></i> Download</button></a>
                    <?php
                    }
                    ?>

                </div>
                <?php
                if ($this->session->userdata('admin_lpp') == 1) { ?>
                    <div class="col-sm-5 text-right ">
                        <a href="<?= base_url('lpp/list_lpp') ?>">
                            <button type="button" class="btn btn-outline-warning"><i class="icon-upload mr-2"></i> Admin</button>
                        </a>
                    </div>
                <?php
                }
                ?>

            </div>
        </form>
        <form method="post" action="<?= base_url(); ?>/lpp/tambah" enctype="multipart/form-data">
            <input type="hidden" value="<?= (!empty($isi_lpp[0]['id_lpp'])) ? $isi_lpp[0]['id_lpp'] : '';  ?>" name="id_lpp">
            <input type="hidden" value="<?= $bulan;  ?>" name="bulan">
            <input type="hidden" value="<?= $tahun;  ?>" name="tahun">
            <table id="datatable-buttons" class="table " style="width:100%">
                <thead>
                    <tr>
                        <th width="1%">
                            <center> No
                        </th>
                        <th width="1%">
                            <center> Tanggal
                        </th>
                        <th>
                            <center> Jam Mulai
                        </th>
                        <th>
                            <center> Jam Selesai
                        </th>
                        <th>
                            <center> Kode Jenis Pekerjaan
                        </th>
                        <th>
                            <center> Pekerjaan yang Dilaksanakan
                        </th>
                        <th>
                            <center> Hasil yang Dicapai
                        </th>
                    </tr>
                </thead>
                <tbody id="group1" class="fvrduplicate">
                    <?php
                    $no = 1;
                    foreach ($isi_lpp as $key => $q) {
                    ?>
                        <tr>
                            <td>
                                <center><?php echo $no++ ?>
                            </td>
                            <td>
                                <center><?php echo $q['tanggal'] ?>
                            </td>
                            <td>
                                <center>
                                    <?php echo $q['jam_mulai']; ?>
                            </td>
                            <td>
                                <center>
                                    <?php echo $q['jam_selesai']; ?>
                            </td>
                            <td>
                                <center>
                                    <?php echo $q['id_jenis_pekerjaan']; ?>
                            </td>
                            <td>
                                <left>
                                    <?php echo $q['pekerjaan']; ?>
                            </td>
                            <td>
                                <left>
                                    <?php echo $q['output']; ?>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr class="entry ">
                        <td>
                            <center><?php ?>
                        </td>
                        <td>
                            <center>
                                <input type="date" class="form-control" name="tanggal[]">

                        </td>
                        <td>
                            <center>
                                <input type="time" name="jam_mulai[]" id="" class="form-control">
                        </td>
                        <td>
                            <center>
                                <input type="time" name="jam_selesai[]" id="" class="form-control">
                        </td>
                        <td>
                            <center>
                                <select name="id_jenis_pekerjaan[]" class="form-control" required>
                                    <option value="">Pilih jenis pekerjaan</option>
                                    <option value="1">Jumpa Pers/Wawancara</option>
                                    <option value="2">Rapat Internal</option>
                                    <option value="3">Rapat dengan Instansi Luar</option>
                                    <option value="4">Seminar/Sosialisasi</option>
                                    <option value="5">Penandatanganan MoU/Kerjasama/Kegiatan Teknis</option>
                                    <option value="6">Perjalanan Dinas/Pengecekan Lapangan</option>
                                    <option value="7">Kegiatan Lainnya</option>
                                </select>
                        </td>
                        <td>
                            <center>
                                <input type="text" name="pekerjaan[]" id="" class="form-control">
                        </td>
                        <td>
                            <div class="form-inline">
                                <input type="text" name="output[]" id="" class="form-control col-sm-10">
                                <button type="button" class="btn btn-success btn-sm btn-add col-sm-2">
                                    <i class="icon-plus22"></i>
                                </button>
                            </div>

                        </td>


                    </tr>

                </tbody>

            </table>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">Submit <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>


    </div>
</div>



<!-- Modal Upload Surat-->
<div class="modal fade modal_upload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat/upload" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat" id="id_surat" />
                    <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No Surat
                            <span class="required"></span>
                        </label>
                        <div class="col-md-12 col-sm-12 ">
                            <input type="text" id="no_surat" name="no_surat" class="form-control" value="" readonly>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Upload Surat
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-12 ">
                            <input type="file" id="file_surat" name="file_surat" required="" class="form-control" value="" accept=".pdf">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Upload Surat-->
<div class="modal fade modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit No Surat</h4>
                <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>-->
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(); ?>surat/edit" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" value="" name="id_surat" id="edit_id_surat" />
                    <input type="hidden" value="" name="no" id="edit_no" />
                    <!-- <span>Karena keterbatasan, harap kompres terlebih daulu surat yang akan di upload di <a hreff="https://www.ilovepdf.com/compress_pdf"> https://www.ilovepdf.com/compress_pdf</a></span> -->
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No Surat
                            <span class="required"></span>
                        </label>
                        <input type="text" id="edit_no_surat" name="no_surat" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Sifat</label>
                        <select class="form-control select2 select2-danger" name="sifat" id="edit_sifat" required>
                            <option value="">Pilih Sifat Surat</option>
                            <option value="B-"> Biasa
                            </option>
                            <option value="R-"> Rahasia
                            </option>
                            <option value="S-"> Segera
                            </option>
                        </select>

                    </div>

                    <div class="form-group " id="unit_kerja">

                        <label class="col-sm-3 col-form-label">Unit Kerja</label>

                        <select class="form-control " name="unit_kerja" id="edit_unit_kerja" required>
                            <option value="">Pilih Unit Kerja</option>
                            <option value="11000">BPS Provinsi Aceh</option>
                            <option value="11510">Bagian Umum</option>
                            <option value="11560">PST</option>
                            <option value="9200">Form Permintaan BPS Aceh</option>
                        </select>

                    </div>

                    <div class="form-group " id="klasifikasi">

                        <label class="col-sm-3 col-form-label">Klasifikasi

                        </label>
                        <a href="<?= base_url(); ?>surat/download_klasifikasi" data-toggle="tooltip" data-placement="top" title="download klasfikasi"><i class="icon-download" style="color:green"></i></a>

                        <select class="form-control form-control-select2" name="klasifikasi" id="edit_klasifikasi" required>
                            <option value="">Pilih Klasifikasi Surat</option>
                            <?php
                            foreach ($klasifikasi as $key => $value) {
                            ?>
                                <option value="<?= $value['kode'] . ',' . $value['id']; ?>">
                                    <?= "[" . $value['kode'] . "] "; ?><?= $value['klasifikasi']; ?>
                                </option>
                            <?php

                            }
                            ?>

                        </select>

                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Perihal</label>

                        <input type="text" id="edit_perihal" name="perihal" required="" class="form-control" value="" required>


                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Tujuan</label>

                        <input type="text" id="edit_tujuan" name="tujuan" required="" class="form-control" value="" required>


                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>

        </div>
    </div>
</div>

<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script src="<?= base_url() ?>/global_assets/js/demo_pages/jquery.repeater.js"></script>

<script type="text/javascript">
    var htmlobjek;
    $(document).ready(function() {

        $("#kategori").change(function() {
            var kategori = $("#kategori").val();
            if (kategori != "RB") {
                $('#unit_kerja').show();
            } else {
                $('#unit_kerja').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.modal_upload').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_surat').attr("value", div.data('id_surat'));
            modal.find('#no_surat').attr("value", div.data('no_surat'));
            //modal.find('#email_to').attr("value",div.data(''));

        });
        $('.modal_edit').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#edit_id_surat').attr("value", div.data('id_surat'));
            modal.find('#edit_no_surat').attr("value", div.data('no_surat'));
            modal.find('#edit_sifat').attr("selected", div.data('sifat'));
            modal.find('#edit_unit_kerja').attr("selected", div.data('unit_kerja'));
            modal.find('#edit_perihal').attr("value", div.data('perihal'));
            modal.find('#edit_tujuan').attr("value", div.data('tujuan'));
            modal.find('#edit_no').attr("value", div.data('no'));
            modal.find('#edit_kode option').attr("selected", div.data('kode'));

            //modal.find('#email_to').attr("value",div.data(''));

        });

    });
</script>


<script>
    $(function() {
        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
            var controlForm = $(this).closest('.fvrduplicate'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<i class="icon-dash"></i>');
        }).on('click', '.btn-remove', function(e) {
            $(this).closest('.entry').remove();
            return false;
        });
    });
</script>
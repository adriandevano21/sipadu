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
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">List Potongan Gaji</h5>
        
        <?php
        if ($this->session->userdata('level_user') == 1) {
        ?>
            <a href="<?= base_url(); ?>/upload_file/template_gaji.xlsx">
                <button type="button" class="btn bg-primary">Template Gaji</button>
            </a>
            <button type="button" class="btn bg-primary" data-toggle="modal" data-target="#modal_tambah">Upload Gaji</button>
        <?php
        }
        ?>

        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Bulan</th>
                <th>Nilai Bruto</th>
                <th>Zakat</th>
                <th>Simpanan Sukarela Kosikas</th>
                <th>Simpanan Wajib Kosikas</th>
                <th>Korpri</th>
                <th>Arisan DW</th>
                <th>Tabungan DW</th>
                <th>Sembako</th>
                <!--<th>Iuran TU</th>-->
                <th>Kosikas</th>
                <th>Rumah Dinas</th>
                <th>Bank</th>
                <th>Bruto & Pot Tanpa Bank</th>
                <th>Bruto & Pot Dengan Bank</th>
                <th>Netto</th>
                <!--<th>Uang DW</th>-->
                <!--<th>Netto 2</th>-->

            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($gaji as $key => $value) {
            ?>
                <tr>
                    <td>
                        <?php echo $value['nama']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['bulan'] . "/" . $value['tahun'];; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['nilai_bruto'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_zakat'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_sim_suk_kosikas'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_simpanan_wajib'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_korpri'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_arisan_dw'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_tabungan_dw'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_sembako'],0,",","."); ?>
                        
                    </td>
                    <!--<td class="text-center">-->
                    <!--    <?php echo $value['pot_iu_tu']; ?>-->
                    <!--</td>-->
                    <td class="text-center">
                        <?php echo number_format($value['pot_pinjaman_kosikas'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_rumah_dinas'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_bank'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['nilai_bruto_min_pot_tanpa_bank'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['nilai_bruto_min_pot_dengan_bank'],0,",","."); ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['nilai_netto_1'],0,",","."); ?>
                        
                    </td>
                    <!--<td class="text-center">-->
                    <!--    <?php echo $value['tambah_uang_dw']; ?>-->
                    <!--</td>-->
                    <!--<td class="text-center">-->
                    <!--    <?php echo $value['nilai_netto_2']; ?>-->
                    <!--</td>-->


                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>

<!-- Basic datatable -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">List Potongan Tukin</h5>
        <?php
        if ($this->session->userdata('level_user') == 1) {
        ?>
            <a href="<?= base_url(); ?>/upload_file/template_tukin.xlsx">
                <button type="button" class="btn bg-primary">Template Tukin</button>
            </a>
            <button type="button" class="btn bg-primary" data-toggle="modal" data-target="#modal_tambah_tukin">Upload Tukin</button>
        <?php
        }
        ?>

        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th rowspan=2>Nama</th>
                <th rowspan=2>Bulan</th>
                <th rowspan=2>Bruto</th>
                <th colspan=8><center>Potongan</th>
                <th rowspan=2>Netto</th>
            </tr>
            <tr>
                <th>Zakat</th>
                <th>Korpri</th>
                <th>Paguyuban</th>
                <th>Kosikas</th>
                <th>Kurban</th>
                <th>Bank</th>
                <th>Sosial</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($tukin as $key => $value) {
            ?>
                <tr>
                    <td>
                        <?php echo $value['nama']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['bulan'] . "/" . $value['tahun'];; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['nilai_bruto'],0,",","."); ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_zakat'],0,",","."); ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_korpri'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_paguyuban'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_kosikas'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_kurban'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_bank'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_sosial'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['pot_total'],0,",",".") ; ?>
                    </td>
                    <td class="text-center">
                        <?php echo number_format($value['nilai_netto'],0,",",".") ; ?>
                    </td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>

<!-- Vertical form modal -->
<div id="modal_tambah" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="<?= base_url(); ?>/pendapatan/upload_gaji" method="post" enctype="multipart/form-data" role="form">
                <input type="hidden" name="id_aktivitas" id="id_aktivitas">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Upload File Gaji</label>
                                <input type="file" class="form-control" id="selesai_output" name="template" required>
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
<div id="modal_tambah_tukin" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="<?= base_url(); ?>/pendapatan/upload_tukin" method="post" enctype="multipart/form-data" role="form">
                <input type="hidden" name="id_aktivitas" id="id_aktivitas">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Upload File Tukin</label>
                                <input type="file" class="form-control" id="selesai_output" name="template" required>
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

<!-- script untuk progress -->
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


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

            //modal.find('#email_to').attr("value",div.data(''));

        });

    });
</script>
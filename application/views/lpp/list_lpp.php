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
        <h5 class="card-title">Daftar List LPP</h5>
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
        <form method="get" action="<?= base_url(); ?>/lpp/list_lpp">
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
                        <th>
                            <center> Kode Satker
                        </th>
                        <th>
                            <center> Nama Satker
                        </th>
                        <th>
                            <center> Nama Pegawai
                        </th>
                        <th>
                            <center> Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($list_lpp as $key => $q) {
                    ?>
                        <tr>
                            <td>
                                <center><?php echo $no++ ?>
                            </td>
                            <td>
                                <center><?php echo $q['kode_satker'] ?>
                            </td>
                            <td>
                                <center>
                                    <?php echo $q['nama_satker']; ?>
                            </td>
                            <td>
                                <center>
                                    <?php echo $q['nama_pegawai']; ?>
                            </td>
                            <td>
                                <center>
                                    <a href="<?= base_url(); ?>/lpp/download/<?= $q['nama_file'] ?>"><button type="button" class="btn btn-outline-success"><i class="icon-download mr-2"></i> Download</button></a>
                            </td>

                        </tr>
                    <?php } ?>

                </tbody>

            </table>

        </form>


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
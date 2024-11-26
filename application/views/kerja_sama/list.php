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
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Upload Kerja Sama</h5>
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
                <form action="<?= base_url(); ?>kerja_sama/tambah_kerja_sama" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Jenis</label>
                        <!-- <div class="col-sm-10"> -->
                        <select class="form-control select2 select2-danger" name="jenis" id="jenis" require>
                            <option value=""> Pilih Jenis Kerja Sama
                            </option>
                            <option value="Mou"> MoU
                            </option>
                            <option value="PKS"> PKS
                            </option>
                        </select>
                        <!-- </div> -->
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Nomor</label>
                        <input type="text" id="no" name="no" required="" class="form-control" value="" placeholder="Nomor dokumen" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Judul</label>
                        <input type="text" id="judul" name="judul" required="" class="form-control" value="" placeholder="Judul Dokumen" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Instansi</label>
                        <input type="text" id="instansi" name="instansi" required="" class="form-control" value="" placeholder="Instansi Kerja Sama" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" required="" class="form-control" value="" placeholder="Tanggal" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">File</label>
                        <input type="file" name="upload_file" class="file-input" accept=".pdf" required>
                    </div>
                    <?php if ($this->session->userdata('admin_kerja_sama') == 1) { ?>
                        <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i>
                            Upload</button>
                    <?php
                    } ?>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List Kerja Sama</h5>
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
                <table id="datatable-buttons" class="table datatable-button-html5-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">
                                <center> Tanggal
                            </th>
                            <th>
                                <center> Nomor
                            </th>
                            <th>
                                <center> Judul
                            </th>
                            <th>
                                <center> Instansi
                            </th>
                            <th>
                                <center> Jenis
                            </th>
                            <th>
                                <center> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($kerja_sama as $key => $q) {
                        ?>
                            <tr>
                                <td>
                                    <left><?php echo $q['tanggal'] ?>
                                </td>
                                <td>
                                    <left>
                                        <?php echo $q['no']; ?>
                                </td>
                                <td>
                                    <left>
                                        <?php echo $q['judul']; ?>
                                </td>
                                <td>
                                    <left>
                                        <?php echo $q['instansi']; ?>
                                </td>
                                <td>
                                    <center>
                                        <?php echo $q['jenis']; ?>
                                </td>
                                <td>
                                    <center>
                                        <?php
                                        if (!empty($q['nama_file'])) {
                                        ?>
                                            <span>
                                                <a href="<?= base_url(); ?>kerja_sama/download/<?= $q['id_kerja_sama'] . "/" . $q['nama_file'] ?>" data-toggle="tooltip" data-placement="top" title="download file"><i class="icon-download" style="color:green"></i></a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($this->session->userdata('admin_kerja_sama') == 1) { ?>
                                            <span>
                                                <a href="<?= base_url(); ?>kerja_sama/hapus/<?= $q['id_kerja_sama'] ?>" onclick="return confirm(' Yakin mau hapus file?');" data-toggle="tooltip" data-placement="top" title="hapus file"><i class="icon-trash" style="color:red"></i></a>
                                            </span>
                                        <?php
                                        } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>
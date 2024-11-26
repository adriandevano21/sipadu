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
        <div class="card border-teal-400">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Upload SK</h5>
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
                <form action="<?= base_url(); ?>sk/tambah_sk" method="post" enctype="multipart/form-data" role="form">
                    <div class="form-group ">
                        <label class="col-sm-3 col-form-label">Sifat</label>
                        <!-- <div class="col-sm-10"> -->
                        <select class="form-control select2 select2-danger" name="sifat" id="sifat" require>
                            <option value=""> Pilih Sifat SK
                            </option>
                            <option value="umum"> Umum
                            </option>
                            <option value="pribadi"> Pribadi
                            </option>
                        </select>
                        <!-- </div> -->
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">Nama Pegawai</label>
                        <select data-placeholder="Diisi jika sifat SK milik pribadi" class="form-control select-minimum" data-fouc name="username">
                            <option></option>
                            <?php foreach ($master_pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
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
                        <label class="col-sm-12 col-form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" required="" class="form-control" value="" placeholder="Tanggal" required>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-12 col-form-label">File</label>
                        <input type="file" name="upload_file" class="file-input" accept=".pdf" required>
                    </div>
                    <?php if ($this->session->userdata('admin_sk') == 1) { ?>
                        <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-refresh"></i>
                            Upload</button>
                    <?php
                    } ?>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card border-teal-400">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List SK</h5>
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
                <table id="datatable-buttons" class="table datatable-button-html5-basic table-striped" style="width:100%">
                    <thead>
                        <tr class="bg-teal-400">
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
                                <center> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($sk as $key => $q) {
                            if (!empty($q['username']) && ($q['username'] == $this->session->userdata('username') || $this->session->userdata('admin_sk') == 1)) { ?>
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
                                        <center>
                                            <?php
                                            if (!empty($q['nama_file'])) {
                                            ?>
                                                <span>
                                                    <a href="<?= base_url(); ?>sk/download/<?= $q['id_sk'] . "/" . $q['nama_file'] ?>" data-toggle="tooltip" data-placement="top" title="download file"><i class="icon-download" style="color:green"></i></a>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($this->session->userdata('admin_sk') == 1) { ?>
                                                <span>
                                                    <a href="<?= base_url(); ?>sk/hapus/<?= $q['id_sk'] ?>" onclick="return confirm(' Yakin mau hapus file?');" data-toggle="tooltip" data-placement="top" title="hapus file"><i class="icon-trash" style="color:red"></i></a>
                                                </span>
                                            <?php
                                            } ?>
                                    </td>
                                </tr>
                            <?php } else if (empty($q['username'])) { ?>
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
                                        <center>
                                            <?php
                                            if (!empty($q['nama_file'])) {
                                            ?>
                                                <span>
                                                    <a href="<?= base_url(); ?>sk/download/<?= $q['id_sk'] . "/" . $q['nama_file'] ?>" data-toggle="tooltip" data-placement="top" title="download file"><i class="icon-download" style="color:green"></i></a>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($this->session->userdata('admin_sk') == 1) { ?>
                                                <span>
                                                    <a href="<?= base_url(); ?>sk/hapus/<?= $q['id_sk'] ?>" onclick="return confirm(' Yakin mau hapus file?');" data-toggle="tooltip" data-placement="top" title="hapus file"><i class="icon-trash" style="color:red"></i></a>
                                                </span>
                                            <?php
                                            } ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>

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

<script src="<?= base_url() ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
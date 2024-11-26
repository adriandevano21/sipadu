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
        <h5 class="card-title">Kumpulan Kegiatan</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url(); ?>/aktivitas/getAktivitasByDateAndUsername">
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

            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-1">Peserta </label>
                <div class="col-sm-9">
                    <select multiple="multiple" data-placeholder="Peserta Internal" class="form-control form-control-sm select" data-container-css-class="select-sm" data-fouc name="usernames[]">
                        <option></option>
                        <?php foreach ($master_pegawai
                            as $key => $value) { ?>
                            <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="icon-search4 mr-2"></i> Filter</button>
                </div>
            </div>


        </form>
    </div>


    <?php if ($result) : ?>
        <table class="table example table-striped">

            <thead>
                <tr class="bg-teal-400">
                    <th>Nama</th>
                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                        <th><?= $i ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $key => $value) : ?>
                    <tr>
                        <td><?= $value['nama_pegawai'] ?></td>
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                            <td><?php
                                if (!empty($value['tanggal_' . $i])) {
                                    $formatted_kegiatan = '';
                                    $kegiatan_array = explode(';', $value['tanggal_' . $i]);
                                    foreach ($kegiatan_array as $key => $item) {
                                        $formatted_kegiatan .= ($key + 1) . '. ' . $item . '<br>';
                                    }
                                    echo $formatted_kegiatan;
                                } else {
                                    echo "-";
                                }


                                // str_replace(';', '<br> - ', $value['tanggal_' . $i])  
                                ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Tidak ada data aktivitas.</p>
    <?php endif; ?>
</div>


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
<script>
    $(document).ready(function() {
        $('.example').DataTable({
            "scrollX": true,
            "responsive": false,
        });
    });
</script>
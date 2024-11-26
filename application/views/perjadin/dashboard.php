
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
        <h5 class="card-title">Dashboard Perjadin</h5>
        
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
                <th class="text-center">Kode</th>
                <th class="text-center">Tujuan</th>
                <th class="text-center">Januari</th>
                <th class="text-center">Februari</th>
                <th class="text-center">Maret</th>
                <th class="text-center">April</th>
                <th class="text-center">Mei</th>
                <th class="text-center">Juni</th>
                <th class="text-center">Juli</th>
                <th class="text-center">Agustus</th>
                <th class="text-center">September</th>
                <th class="text-center">Oktober</th>
                <th class="text-center">November</th>
                <th class="text-center">Desember</th>
                <th class="text-center">Total</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($perjadin as $key => $value) {
            ?>
                <tr>
                    <td class="text-center">
                        <?php echo $value['tujuan']; ?>

                    </td>
                    <td >
                        <?= ($value['nama_tujuan']==='pusat') ? 'Lainnya': $value['nama_tujuan'];  ?>
                        
                    </td>
                    <td class="text-center">
                        <?php echo $value['januari']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['februari']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['maret']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['april']; ?>
                    </td><td class="text-center">
                        <?php echo $value['mei']; ?>
                    </td><td class="text-center">
                        <?php echo $value['juni']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['juli']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['agustus']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['september']; ?>
                    </td><td class="text-center">
                        <?php echo $value['oktober']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['november']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['desember']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $value['total']; ?>
                    </td>
                    

                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>




<!-- /vertical form modal -->
<!-- script untuk progress -->
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

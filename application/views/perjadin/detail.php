<script src="<?= base_url(); ?>/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/editor_ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/gallery.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/media/fancybox.min.js"></script>
<!-- CKEditor default -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Detail Perjalanan Dinas</h5>
        <input type="button" value="Back" onclick="history.back(-1)" class=" btn btn-primary" />
        <!-- <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div> -->
    </div>
            

    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <table class="table">
                
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?= $detail_perjadin['nama_pegawai']; ?></td>
                    </tr>
                    <tr>
                        <td width='10%'>Judul </td>
                        <td width='5%'>: </td>
                        <td><?= $detail_perjadin['judul']; ?></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td><?= $detail_perjadin['deskripsi']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?= $tanggal ?></td>
                    </tr>
                    <tr>
                        <td>Durasi</td>
                        <td>:</td>
                        <td><?= $detail_perjadin['durasi']; ?> hari</td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td><?= $detail_perjadin['nama_satker']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-5">
                <table class="table">
                     <tr>
                        <th colspan="4"><center>Kalkulator Biaya Perjadin</th>
                        
                    </tr>
                    <tr>
                        <th><center>Keterangan</th>
                        <th><center>Nominal</th>
                        <th><center>Pengali</th>
                        <th><center>Total</th>
                    </tr>
                    
                    <?php
                    if($detail_perjadin['kode_tujuan'] > 1199 || $detail_perjadin['kode_tujuan'] < 1100 ){
                    ?>
                    <tr>
                        <td>Taksi di Tujuan</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_taksi'], 0, ',', '.'); ?></td>
                        <td><center>2</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_taksi'] * 2, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>Taksi di Aceh</td>
                        <td style="text-align: right"><?= number_format(127000, 0, ',', '.'); ?></td>
                        <td><center>2</td>
                        <td style="text-align: right"><?= number_format(127000 * 2, 0, ',', '.'); ?></td>
                    </tr>
                    <?php    
                    }
                    ?>
                    <?php
                    if($detail_perjadin['kode_tujuan'] == 1172 ){
                    ?>
                    <tr>
                        <td>Taksi</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_taksi'], 0, ',', '.'); ?></td>
                        <td><center>2</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_taksi'] * 2, 0, ',', '.'); ?></td>
                    </tr>
                    
                    <?php    
                    }
                    ?>
                    <tr>
                        <td>Transportasi</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_transportasi'], 0, ',', '.'); ?></td>
                        <td><center>2</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_transportasi'] * 2, 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                    $satker = array("1100", "1171", "1108" );

                    if (!in_array($detail_perjadin['kode_tujuan'], $satker)){
                    ?>
                    <tr>
                        <td>Hotel</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['sbm_hotel'], 0, ',', '.'); ?></td>
                        <td><center><?= $detail_perjadin['durasi'] - 1; ?></td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['sbm_hotel'] * ($detail_perjadin['durasi'] - 1), 0, ',', '.'); ?></td>
                    </tr>
                    <?php    
                    }
                    ?>
                    <?php
                    if($detail_perjadin['kode_tujuan'] <> 1100 ){
                    ?>
                    <tr>
                        <td>Uang Harian</td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_uang'], 0, ',', '.'); ?></td>
                        <td><center><?= $detail_perjadin['durasi']; ?></td>
                        <td style="text-align: right"><?= number_format($detail_perjadin['nominal_uang'] * $detail_perjadin['durasi'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php    
                    }
                    ?>
                    <tr>
                        <th colspan="3"><center>Total</th>
                        <?php
                        if($detail_perjadin['kode_tujuan'] > 1199 || $detail_perjadin['kode_tujuan'] < 1100 ){
                        ?>
                        <th style="text-align: right"><?= number_format( (127000*2) + ($detail_perjadin['nominal_taksi'] * 2) + ($detail_perjadin['nominal_transportasi'] * 2) + ($detail_perjadin['sbm_hotel'] * ($detail_perjadin['durasi'] - 1)) + ($detail_perjadin['nominal_uang'] * $detail_perjadin['durasi']), 0, ',', '.'); ?></th>
                        <?php    
                        } else if ($detail_perjadin['kode_tujuan'] == 1100){
                        ?>
                        <th style="text-align: right"><?= number_format(($detail_perjadin['nominal_transportasi'] * 2)  , 0, ',', '.'); ?></th>
                        <?php    
                        } else { ?>
                        <th style="text-align: right"><?= number_format(($detail_perjadin['nominal_taksi'] * 2) + ($detail_perjadin['nominal_transportasi'] * 2) + ($detail_perjadin['sbm_hotel'] * ($detail_perjadin['durasi'] - 1)) + ($detail_perjadin['nominal_uang'] * $detail_perjadin['durasi']), 0, ',', '.'); ?></th>
                        
                        <?php    
                        }
                        ?>
                    </tr>
                </table>

            </div>
        </div>
        
        <br>
        <!-- <p class="mb-3">CKEditor is a ready-for-use HTML text editor designed to simplify web content creation. It's a WYSIWYG editor that brings common word processor features directly to your web pages. It benefits from an active community that is constantly evolving the application with free add-ons and a transparent development process.</p> -->
        <?php 
        if (!empty($detail_perjadin['uraian_kegiatan'])) {
        ?>
        <h4>Uraian Kegiatan</h4>
        <table width='100%'>
            <tr>
                <td>
                    <span>
                        <?= $detail_perjadin['uraian_kegiatan']; ?>
                    </span>
                </td>
            </tr>
        </table>
        <h4>Dokumentasi telah Diupload</h4>
        <?php 
        if (!empty($detail_perjadin['caption1'])) {
        ?>
        <div class="row">
            
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-img-actions m-1">
                            <span><?= $detail_perjadin['caption1']; ?></span>
                            <img class="card-img img-fluid" src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto1']; ?>" alt="">
                            <div class="card-img-actions-overlay card-img">
                                <a href="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto1']; ?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                    <i class="icon-plus3"></i>
                                </a>
                                <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-img-actions m-1">
                            <span><?= $detail_perjadin['caption2']; ?></span>
                            <img class="card-img img-fluid" src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto2']; ?>" alt="">
                            <div class="card-img-actions-overlay card-img">
                                <a href="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto2']; ?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                    <i class="icon-plus3"></i>
                                </a>
                                <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                    <i class="icon-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        <?php 
        }
        ?>
        <?php 
        }
        ?>
    </div>
</div>
<!-- /CKEditor default -->
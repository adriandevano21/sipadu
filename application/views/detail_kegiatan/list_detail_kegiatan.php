<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List Dokumentasi Kegiatan</h5>

                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table datatable-button-html5-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th>
                                <center>Tim
                            </th>
                            <th>
                                <center>Subtim
                            </th>
                            <th>
                                <center>Nama Kegiatan
                            </th>
                            <th>
                                <center>Tanggal Mulai
                            </th>
                            <th>
                                <center>Tanggal Selesai
                            </th>
                            <th>
                                <center>Output
                            </th>
                            <th>
                                <center>Tujuan PK
                            </th>
                            <th>
                                <center>Kedeputian
                            </th>
                            <th>
                                <center>Kolaborasi
                            </th>
                            <th width="10%">
                                <center>Nama Pegawai
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail_kegiatan as $row) : ?>
                            <tr>
                                <td><?php echo $row['nama_tim']; ?></td>
                                <td><?php echo $row['nama_subtim']; ?></td>
                                <td><?php echo $row['nama_kegiatan']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($row['tanggal_mulai'])) ?></td>
                                <td><?php echo date("d-m-Y", strtotime($row['tanggal_selesai'])) ?></td>
                                <td><?php echo $row['output']; ?></td>
                                <td><?php echo $row['tujuan_pk']; ?></td>
                                <td><?php echo $row['kedeputian']; ?></td>
                                <td>
                                    <?php
                                    $array_nama_tim_kolab = explode(';', $row['nama_tim_kolab']);
                                    $array_nama_tim_kolab = array_unique($array_nama_tim_kolab);
                                    foreach ($array_nama_tim_kolab as $key => $value) { ?>
                                        <span class='badge badge-flat badge-pill border-primary text-primary'>
                                            <?php echo $value; ?>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $array_url_foto = explode(';', $row['url_foto']);
                                    $array_nama = explode(';', $row['nama_pegawai']);
                                    foreach ($array_url_foto as $key => $value) { ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?php echo $array_nama[$key]  ?>"><img src="<?php echo $value ?>" class="rounded-circle" width="32" height="32" alt=""></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Rekap Kegiatan Pegawai</h5>

                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table datatable-button-html5-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Pegawai</th>
                            <th>Jumlah Sebagai PJK</th>
                            <th>Jumlah Sebagai Anggota</th>
                            <th>Total</th>
                            <th>Kontribusi pada Tim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td><?php echo $row['nama_pegawai']; ?></td>
                                <td><?php echo $row['jumlah_sebagai_pjk']; ?></td>
                                <td><?php echo $row['jumlah_sebagai_anggota']; ?></td>
                                <td><?php echo $row['total']; ?></td>
                                <td><?php echo $row['kontribusi']; ?></td>
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
<script src="<?= base_url(); ?>global_assets/js/demo_pages/form_select2.js"></script>
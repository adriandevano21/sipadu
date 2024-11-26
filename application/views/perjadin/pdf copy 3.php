<style>
    table {
        border-collapse: collapse;
    }

    td {
        padding: 2px;
    }

    .tabel td:first-child {
        border-left: 1px solid black;
    }

    .tabel td:last-child {
        border-right: 1px solid black;
    }

    .tabel tr:first-child td {
        border-top: 1px solid black;
    }

    .tabel tr:last-child td {
        border-bottom: 1px solid black;
    }

    img {
        max-width: 350px;
        max-height: auto;
    }

    p {
        margin: 0;

    }
</style>
<div class="card">
    <div class="card-header header-elements-inline text-center">
        <h2 class="card-title" style="text-align: center;">Detail Perjalanan Dinas</h2>

    </div>


    <div class="card-body">
        <table class="tabel">
            <tr>
                <td colspan="3"><center><b style="text-align: center;">A. DATA UMUM</b></td>
                
            </tr>
            <tr>
                <td >1. Nama Pelaksana SPD</td>
                <td>:</td>
                <td><?= $detail_perjadin['nama_pegawai']; ?></td>
                
            </tr>
            <tr>
                <td width='30%'>2. Tujuan </td>
                <td width='3%'>: </td>
                <td><?= $detail_perjadin['judul']; ?></td>
            </tr>
            <tr>
                <td>3. Jadwal</td>
                <td>:</td>
                <td><?= $tanggal; ?> </td>
            </tr>
            <tr>
                <td>4. Program yang membiayai</td>
                <td>:</td>
                <td><?= $detail_perjadin['program']; ?></td>
            </tr>
            <tr>
                <td>5. Komponen</td>
                <td width='3%'>:</td>
                <td><?= $detail_perjadin['komponen']; ?></td>
            </tr>
            <tr>
                <td>6. Tanda Tangan Pelaksana SPD</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>

        <br>
        <table border="0" >
            <tr>
                <td colspan="2">
                    <center><b style="text-align: center;">B. RINGKASAN HASIL KEGIATAN</b></center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        
                        <?= $detail_perjadin['uraian_kegiatan']; ?>
                    </p>
                </td>
            </tr>
            
            
            <tr>
                        
                        <?php foreach ($dokumentasi_perjadin as $key => $value) {
                            echo count($dokumentasi_perjadin);
                        ?>
                            <td>
                                <br>
                            <center>
                            <img src="<?= base_url('upload_file/perjadin/') . $value['nama_file'] ?>" alt="" width="400" height="260"><br>
                            </center>
                            <i><span style="text-align: left !important;">Foto <?= $key+1 ?>. <?= $value['caption'] ?></span> </i><br>
                            
                            </td>
                        <?php } ?>
                    
            </tr>
            
            <tr>
                <td colspan="2">
                    
                        <center><b style="text-align: center;">C. PENGESAHAN</b>
                        </center>
                        <center>
                            <p>Mengetahui</p>
                            <?= $detail_perjadin['pengesahan']; ?>
                        </center>

                    
                </td>
            </tr>
        </table>

    </div>

</div>
</div>
<!-- /CKEditor default -->
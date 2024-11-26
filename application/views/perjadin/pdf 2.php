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
    .page_break { page-break-before: always; }
    
    div.footer {
      display: block;
      text-align: left;
      position: running(footer);
    }
    #footer { 
  position: fixed; 
  width: 100%; 
  bottom: 0; 
  left: 0;
  right: 0;
}

    @page {
        @top-center {
            content: element(header);
        }
    }
    @page {
        @bottom-center {
            content: element(footer);
        }
    }
</style>
<div class="card">
    <div class="card-header header-elements-inline text-center">
        <h2 class="card-title" style="text-align: center;">Detail Perjalanan Dinas</h2>

    </div>


    <div class="card-body">
        <table class="tabel" width="100%">
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
                <td>5. Kegiatan</td>
                <td>:</td>
                <td><?= $detail_perjadin['kegiatan']; ?></td>
            </tr>
            <tr>
                <td>6. Komponen</td>
                <td width='3%'>:</td>
                <td><?= $detail_perjadin['komponen']; ?></td>
            </tr>
            <tr>
                <td>7. Tanda Tangan Pelaksana SPD</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>

        <br>
        <table border="0" width="100%">
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
                <td colspan="2">
                    <center>
                        <br>
                    <b>Dokumentasi</b>
                    </center>
                </td>
            </tr>
            <tr>
            
                <td>
                
                <center>
                   
                <img src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto1'] ?>" alt="" width="400" height="250"><br>
                </center>
                <i><span style="text-align: left !important;">Foto 1. <?= $detail_perjadin['caption1'] ?></span> </i><br>
                </td>
                
                <td>
                
                <center>
                <img src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto2'] ?>" alt="" width="400" height="250"><br>
                </center>
                <i><span style="text-align: left !important;">Foto 2. <?= $detail_perjadin['caption2'] ?></span> </i><br>
                </td>
                       
                    
            </tr>
            </table>
            <div class="page_break"></div>
            <table border="0" width="100%">
            <tr>
                <td colspan="2">
                    <center><b style="text-align: center;">C. PEJABAT DAN TEMPAT YANG DIKUNJUNGI</b></center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        
                        
                        <?= $detail_perjadin['pejabat']; ?>
                    </p>
                </td>
            </tr>
            
            
            
            
            <tr>
                <td colspan="2">
                    <br>
                    
                        <center><b style="text-align: center;">D. PENGESAHAN</b>
                        </center>
                        <center>
                            <p>Mengetahui</p>
                            <?= $detail_perjadin['jabatan']; ?>
                            <br>
                            <br>
                            <br>
                            <br>
                            <?= $detail_perjadin['nama_pejabat']; ?><br>
                            NIP. <?= $detail_perjadin['nip_pejabat']; ?>
                        </center>

                    
                </td>
            </tr>
        </table>

    </div>

</div>
<div id="footer"> 
    <p>Laporan ini digenerate oleh SIPADU pada : <?php echo date('d-m-Y H:i:s') ?></p> 
</div> 
<!-- /CKEditor default -->
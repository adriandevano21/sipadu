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

    .page_break { 
        page-break-before: always; 
    }

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
        @bottom-center {
            content: element(footer);
        }
    }

    .content {
        display: flex;
        flex-wrap: wrap;
    }

    .content > div {
        flex: 1;
        padding: 10px;
    }

    .text-box {
        
        padding: 10px;
        margin-bottom: 10px;
    }
</style>
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      overflow:hidden;padding:2px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      font-weight:normal;overflow:hidden;padding:2px 5px;word-break:normal;}
    .tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
    .tg .tg-8jgo{border-color:#ffffff;text-align:center;vertical-align:top}
</style>

<div class="card">
    <div class="card-header header-elements-inline text-center">
        <h2 class="card-title" style="text-align: center;">Detail Perjalanan Dinas</h2>
    </div>

    <div class="card-body">
        <div style="border: 2px solid black;">
            <center><b style="text-align: center;">A. DATA UMUM</b></center>
            <table class="tg" width="100%">
                <thead>
                  <tr>
                    <th class="tg-8jgo" width='2%'>1. </th>
                    <th class="tg-zv4m" width='26%'>Nama Pelaksana SPD </th>
                    <th class="tg-zv4m" width='2%'>: </th>
                    <th class="tg-zv4m" colspan="3">
                        <?php if ($jumlah_rombongans > 1 ): ?>
                            <?php $count = 1; ?>
                            <?php foreach ($rombongans as $item): ?>
                                <?php echo $count ?>. <?php echo $item['nama_pegawai']; ?> <br>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach ($rombongans as $item): ?>
                                <?php echo $item['nama_pegawai']; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="tg-8jgo">2. </td>
                    <td class="tg-zv4m">Tujuan </td>
                    <td class="tg-zv4m">: </td>
                    <td class="tg-zv4m" colspan="3"><?= $detail_perjadin['judul']; ?></td>
                  </tr>
                  <tr>
                    <td class="tg-8jgo">3. </td>
                    <td class="tg-zv4m">Jadwal </td>
                    <td class="tg-zv4m">: </td>
                    <td class="tg-zv4m" colspan="3"><?= $tanggal; ?></td>
                  </tr>
                  <tr>
                    <td class="tg-8jgo">4. </td>
                    <td class="tg-zv4m">Program yang membiayai </td>
                    <td class="tg-zv4m">: </td>
                    <td class="tg-zv4m" colspan="3"><?= $detail_perjadin['program']; ?></td>
                  </tr>
                  <tr>
                    <td class="tg-8jgo">5. </td>
                    <td class="tg-zv4m">Kegiatan </td>
                    <td class="tg-zv4m">: </td>
                    <td class="tg-zv4m" colspan="3"><?= $detail_perjadin['kegiatan']; ?></td>
                  </tr>
                  <tr>
                    <td class="tg-8jgo">6. </td>
                    <td class="tg-zv4m">Komponen </td>
                    <td class="tg-zv4m">: </td>
                    <td class="tg-zv4m" colspan="3"><?= $detail_perjadin['komponen']; ?></td>
                  </tr>
                  <tr>
                    <td class="tg-8jgo" height='7%'>7. </td>
                    <td class="tg-zv4m">Tanda Tangan Pelaksana SPD </td>
                    <td class="tg-zv4m">: </td>
                    <?php if ($jumlah_rombongans > 1 ): ?>
                        <td class="tg-zv4m">1.</td>
                        <td class="tg-zv4m">2.</td>
                    <?php endif; ?>
                    <?php if ($jumlah_rombongans > 2 ): ?>
                        <td class="tg-zv4m">3.</td>
                    <?php endif; ?>
                  </tr>
                  <?php if ($jumlah_rombongans > 3 ): ?>
                      <tr>
                        <td class="tg-8jgo" height='7%'></td>
                        <td class="tg-zv4m"></td>
                        <td class="tg-zv4m"></td>
                        <td class="tg-zv4m">4.</td>
                        <?php if ($jumlah_rombongans > 4 ): ?>
                            <td class="tg-zv4m">5.</td>
                        <?php endif; ?>
                        <?php if ($jumlah_rombongans > 5 ): ?>
                            <td class="tg-zv4m">6.</td>
                        <?php endif; ?>
                      </tr>
                  <?php endif; ?>
                  <?php if ($jumlah_rombongans > 6 ): ?>
                      <tr>
                        <td class="tg-8jgo" height='7%'></td>
                        <td class="tg-zv4m"></td>
                        <td class="tg-zv4m"></td>
                        <td class="tg-zv4m">7.</td>
                        <?php if ($jumlah_rombongans > 7 ): ?>
                            <td class="tg-zv4m">8.</td>
                        <?php endif; ?>
                        <?php if ($jumlah_rombongans > 8 ): ?>
                            <td class="tg-zv4m">9.</td>
                        <?php endif; ?>
                      </tr>
                  <?php endif; ?>
                </tbody>
            </table>
        </div>

        <br>

        <div class="content">
            <div>
                <center><b style="text-align: center;">B. RINGKASAN HASIL KEGIATAN</b></center>
                <div class="text-box">
                    <p><?= $detail_perjadin['uraian_kegiatan']; ?></p>
                </div>
            </div>

            <!--<div class="page_break"></div>-->

                <table>
                    <tr>
                        <td colspan="2"><center><b style="text-align: center;">Dokumentasi</b></td>
                    </tr>
                
                    <tr>
                        <td>
                            <center>
                                <img src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto1'] ?>" alt="" ><br>
                                <i>Foto 1. <?= $detail_perjadin['caption1'] ?></i>
                            </center>
                        </td>
                        <td>
                            <center>
                                <img src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto2'] ?>" alt="" ><br>
                                <i>Foto 2. <?= $detail_perjadin['caption2'] ?></i>
                            </center>
                            
                        </td>
                    </tr>
                </table>
                
            

            <div class="page_break"></div>

            <div>
                <center><b style="text-align: center;">C. PEJABAT DAN TEMPAT YANG DIKUNJUNGI</b></center>
                <div class="text-box">
                    <p><?= $detail_perjadin['pejabat']; ?></p>
                </div>
            </div>

            <!--<div class="page_break"></div>-->

            <div>
                <center><b style="text-align: center;">D. PENGESAHAN</b></center>
                <center>
                    <p>Mengetahui</p>
                    <?= $detail_perjadin['jabatan']; ?><br>
                    <br><br><br><br>
                    <?= $detail_perjadin['nama_pejabat']; ?><br>
                    NIP. <?= $detail_perjadin['nip_pejabat']; ?>
                </center>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    <p>Laporan ini digenerate oleh SIPADU pada : <?php echo date('d-m-Y H:i:s') ?></p>
</div>

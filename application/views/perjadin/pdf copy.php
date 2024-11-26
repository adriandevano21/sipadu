<style>
    table {
        border-collapse: collapse;
    }

    td {
        padding: 8px;
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
                <td>1. Nama Pelaksana SPD</td>
                <td>:</td>
                <td><?= $detail_perjadin['nama_pegawai']; ?></td>
                <td>4. Program yang membiayai</td>
                <td>:</td>
                <td><?= $detail_perjadin['program']; ?></td>
            </tr>
            <tr>
                <td width='10%'>2. Tujuan </td>
                <td width='5%'>: </td>
                <td><?= $detail_perjadin['judul']; ?></td>
                <td>5. Komponen</td>
                <td>:</td>
                <td><?= $detail_perjadin['komponen']; ?></td>
            </tr>
            <tr>
                <td>3. Jadwal</td>
                <td>:</td>
                <td><?= $tanggal; ?> </td>
                <td>6. Tanda Tangan Pelaksana SPD</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>

        <br>
        <table border="0">
            <tr>
                <td>
                    <center><b>B. RINGKASAN HASIL KEGIATAN</b></center>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        A. PERMASALAHAN <br>
                        <?= $detail_perjadin['permasalahan']; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        B. SOLUSI/PEMECAHAN MASALAH <br>
                        <?= $detail_perjadin['solusi']; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        C. DUKUNGAN PROVINSI <br>
                        <?= $detail_perjadin['dukungan']; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <center>
                        <span style="text-align: center;"><b>Dokumentasi</b></span>

                        <br>
                        <?php foreach ($dokumentasi_perjadin as $key => $value) {
                        ?>
                            <img src="<?= base_url('upload_file/perjadin/') . $value['nama_file'] ?>" alt=""><br>
                            <span style="text-align: center;"><?= $value['caption'] ?></span><br>
                        <?php } ?>
                    </center>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <center><b>C. PEJABAT DAN TEMPAT YANG DIKUNJUNGI</b>
                        </center>
                        <br>
                        <?= $detail_perjadin['pejabat']; ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <center><b>D. PENGESAHAN</b>
                        </center>
                        <center>
                            <p>Mengetahui</p>
                            <?= $detail_perjadin['pengesahan']; ?>
                        </center>

                    </p>
                </td>
            </tr>
        </table>

    </div>

</div>
</div>
<!-- /CKEditor default -->
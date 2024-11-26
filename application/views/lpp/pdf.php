<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table.border,
        table.border th,
        table.border td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        /* Tabel tanpa border */
        table.no-border {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-list {
            counter-reset: my-counter;
        }

        .custom-list li {
            list-style: none;
            position: relative;
            padding-left: 25px;
            /* margin-bottom: 10px; */
        }

        .custom-list li:before {
            content: counter(my-counter);
            counter-increment: my-counter;
            position: absolute;
            left: 0;
        }
    </style>
</head>

<body>
    <center>
        <b>
            Laporan Pekerjaan
        </b>
    </center>
    <br><br>

    <b>Jabatan &nbsp;&nbsp;: <?php
                                if ($this->session->userdata('kode_satker') == 1100) {
                                    echo "Kepala Bagian Umum BPS Provinsi Aceh";
                                } else {
                                    echo "Kepala BPS" . $satker['nama_satker'];
                                }
                                ?></b>

    <br>
    <b>Bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $bulanIndonesia . ' ' . $tahun ?></b>
    <br>
    <br>
    <table class="border" width="100%">
        <tbody>
            <tr>
                <td>
                    <center>Minggu Ke
                </td>
                <td>
                    <center>Jenis Pekerjaan yang Dilaksanakan
                </td>
                <td>
                    <center>Hal yang Dicapai
                </td>
            </tr>
            <tr>
                <td>
                    <center>(1)
                </td>
                <td>
                    <center>(2)
                </td>
                <td>
                    <center>(3)
                </td>
            </tr>
            <?php

            foreach ($minggu_lpp as $key => $q) {
            ?>
                <tr>
                    <td>
                        <center>Minggu <?php echo $q['minggu'] ?>
                    </td>
                    <td style="vertical-align: top;">

                        <ol class="custom-list" style="padding-left: 10px;">
                            <?php
                            $no_p = 1;
                            foreach ($isi_lpp as $key => $a) {
                                if ($a['minggu'] == $q['minggu']) {
                            ?>
                                    <left>
                                        <li><?php echo $a['pekerjaan']; ?></li>
                                <?php }
                            } ?>
                        </ol>
                        </left>
                    </td>
                    <td style="vertical-align: top;">
                        <ol class="custom-list" style="padding-left: 10px;">
                            <?php
                            $no_o = 1;
                            foreach ($isi_lpp as $key => $a) {
                                if ($a['minggu'] == $q['minggu']) {
                            ?>
                                    <left>
                                        <li><?php echo $a['output']; ?></li>

                                <?php }
                            } ?>
                        </ol>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <table width=100% class="no-border">
        <tbody>
            <tr>
                <td width=50%>
                    <center>Mengetahui,
                </td>
                <td width=50%>
                    <center><?= $satker['kedudukan'] ?>, <?= $tanggal ?>
                </td>
            </tr>
            <tr>
                <td>
                    <center> Kepala BPS Provinsi Aceh
                </td>
                <td>
                    <center>
                        <?php
                        if ($this->session->userdata('kode_satker') == 1100) {
                            echo "Kepala Bagian Umum <br>BPS Provinsi Aceh";
                        } else {
                            echo "Kepala BPS";
                        }
                        ?>
                </td>
            </tr>
            <tr>
                <td>
                    <center><br><br><br><br><br>
                </td>
                <td>
                    <center>
                </td>
            </tr>
            <tr>
                <td>
                    <center>(Dr. Ahmadriswan Nasution, S.Si, M.T)
                </td>
                <td>
                    <center>(<?= $this->session->userdata('nama_pegawai') ?>)
                </td>
            </tr>
            <tr>
                <td>
                    <center>NIP. 197301251994121001
                </td>
                <td>
                    <center>NIP. <?= $this->session->userdata('nip') ?>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
<div class="container">
    <h2>Data Pegawai</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Kontribusi</th>
                <th>Jumlah Sebagai PJK</th>
                <th>Jumlah Sebagai Anggota</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo $row->nama_pegawai; ?></td>
                    <td><?php echo $row->kontribusi; ?></td>
                    <td><?php echo $row->jumlah_sebagai_pjk; ?></td>
                    <td><?php echo $row->jumlah_sebagai_anggota; ?></td>
                    <td><?php echo $row->total; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
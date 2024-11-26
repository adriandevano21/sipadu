<!DOCTYPE html>
<html>

<head>
    <title>Edit Kegiatan</title>
    <!-- Tambahkan link CSS Bootstrap di sini -->
</head>

<body>

    <div class="container">
        <h2>Edit Kegiatan</h2>
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <form method="post" action="<?php echo base_url('kegiatan/edit/' . $kegiatan['id_kegiatan']); ?>">
            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan:</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?php echo $kegiatan['nama_kegiatan']; ?>">
            </div>
            <div class="form-group">
                <label for="kode_subtim">Kode Subtim:</label>
                <input type="text" class="form-control" id="kode_subtim" name="kode_subtim" value="<?php echo $kegiatan['kode_subtim']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

</body>

</html>
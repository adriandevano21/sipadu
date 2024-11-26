<!DOCTYPE html>
<html>

<head>
    <title>Edit Detail Kegiatan</title>
    <!-- Link CSS Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Edit Detail Kegiatan</h2>
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <form method="post" action="<?php echo base_url('detail_kegiatan/edit/' . $detail_kegiatan['id_detail_kegiatan']); ?>">
            <div class="form-group">
                <label for="id_kegiatan">ID Kegiatan:</label>
                <input type="text" class="form-control" id="id_kegiatan" name="id_kegiatan" value="<?php echo $detail_kegiatan['id_kegiatan']; ?>">
            </div>
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $detail_kegiatan['tanggal_mulai']; ?>">
            </div>
            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai:</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $detail_kegiatan['tanggal_selesai']; ?>">
            </div>
            <div class="form-group">
                <label for="output">Output:</label>
                <input type="text" class="form-control" id="output" name="output" value="<?php echo $detail_kegiatan['output']; ?>">
            </div>
            <div class="form-group">
                <label for="id_indikator_pk">ID Indikator PK:</label>
                <input type="text" class="form-control" id="id_indikator_pk" name="id_indikator_pk" value="<?php echo $detail_kegiatan['id_indikator_pk']; ?>">
            </div>
            <div class="form-group">
                <label for="id_kedeputian">ID Kedeputian:</label>
                <input type="text" class="form-control" id="id_kedeputian" name="id_kedeputian" value="<?php echo $detail_kegiatan['id_kedeputian']; ?>">
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan"><?php echo $detail_kegiatan['keterangan']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

</body>

</html>
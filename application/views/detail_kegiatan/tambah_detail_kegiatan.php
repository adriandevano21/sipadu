<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Tambah Detail Event</h5>
        <div class="header-elements">
            <div class="list-icons">
                <!-- <a class="list-icons-item" data-action="collapse"></a> -->
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <!-- <a class="list-icons-item" data-action="remove"></a> -->
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="<?php echo base_url('detail_kegiatan/tambah'); ?>">
            <div class="form-group">
                <label for="id_kegiatan">Kegiatan:</label>

                <select class="form-control select-minimum" name="id_kegiatan" id="id_kegiatan" required>
                    <option>Pilih Kegiatan</option>
                    <?php
                    foreach ($kegiatan as $key => $value) {
                    ?>
                        <option value="<?= $value['id_kegiatan'] ?>"> <?= $value['nama_kegiatan'] ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_selesai">Tanggal Selesai:</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                </div>
            </div>

            <div class="form-group ">
                <label class="col-form-label">PJK:</label>
                <select class="form-control select-minimum" name="pjk" id="pjk" required>
                    <option>Pilih PJK</option>
                    <?php
                    foreach ($pegawai as $key => $value) {
                    ?>
                        <option value="<?= $value['id_anggota_subtim'] ?>"> <?= $value['nama_pegawai'] ?> [<?= $value['nama_subtim'] ?>]
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="col-form-label">Peserta </label>

                <select multiple="multiple" data-placeholder="Tambahkan anggota" class="form-control form-control-sm select" data-container-css-class="select-sm" data-fouc name="anggota[]">
                    <option></option>
                    <?php
                    foreach ($pegawai
                        as $key => $value) { ?>
                        <option value="<?= $value["id_anggota_subtim"] ?>"><?= $value["nama_pegawai"] ?> [<?= $value['nama_subtim'] ?>]</option>
                    <?php } ?>
                </select>


            </div>
            <div class="row">
                <div class="form-group col-md-6 ">
                    <label class="col-form-label">Tujuan PK:</label>
                    <select class="form-control select-minimum" name="id_tujuan_pk" id="id_tujuan_pk" required>
                        <option>Pilih Tujuan PK</option>
                        <?php
                        foreach ($kedeputian as $key => $value) {
                        ?>
                            <option value="<?= $value['id_tujuan_pk'] ?>"> <?= $value['tujuan_pk'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-form-label">Kedeputian:</label>
                    <select class="form-control select-minimum" name="id_kedeputian" id="id_kedeputian" required>
                        <option>Pilih Kedeputian</option>
                        <?php
                        foreach ($kedeputian as $key => $value) {
                        ?>
                            <option value="<?= $value['id_kedeputian'] ?>"> <?= $value['kedeputian'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="output">Output:</label>
                    <input type="text" class="form-control" id="output" name="output" placeholder="Masukkan Output">
                </div>
                <div class="form-group col-md-6">
                    <label for="keterangan">Keterangan:</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </div>
</div>


<script src="<?= base_url() ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
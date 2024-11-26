<?= $startDate; ?>
<?php if (!empty($available_ruangan)) : ?>
    <div class="form-group row">
        <label class="col-form-label col-lg-3">Tempat Kegiatan </label>
        <div class="col-lg-9">
            <select data-placeholder="tempat kegiatan" class="form-control" data-fouc name="id_ruang_rapat" id="id_ruang_rapat" required>
                <option value="">Pilih Tempat Kegiatan</option>
                <?php foreach ($available_ruangan as $ruangan) : ?>
                    <option value="<?php echo $ruangan['id']; ?>"><?php echo $ruangan['nama_ruangan']; ?></option>
                <?php endforeach; ?>
                <option value="99">Luar Kantor</option>
            </select>
        </div>
    </div>
<?php else : ?>
    <p>Tidak ada ruangan yang tersedia pada tanggal dan pukul yang dipilih.</p>
<?php endif; ?>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Edit Data Projek</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="<?= site_url('projek/edit/') . $projek['id_projek'] ?>">
            <!-- Buat input hidden untuk id projek -->
            <input type="hidden" name="id" value="<?= $projek['id_projek'] ?>">
            <div class="form-group ">
                <label class="col-form-label col-lg-2">Tim
                </label>
                <div class="col-lg-11">
                    <select class="form-control select" name="id_tim" required>
                        <option value="<?= $projek['id_tim'] ?>"> <?= $projek['nama_tim'] ?></option>
                        <option value="12">Umum </option>
                        <option value="13">Statistik Sosial</option>
                        <option value="14">Statistik Ekonomi</option>
                        <option value="15">Sensus</option>
                        <option value="16">Pengolahan dan TI</option>
                        <option value="17">Nerwilis</option>
                        <option value="18">Diseminasi dan Humas</option>
                        <option value="19">Transformasi Organisasi</option>
                        <option value="20">Statistik Sektoral</option>
                        <option value="99">Lainnya</option>
                    </select>
                </div>
            </div>
            <!-- Buat input untuk nama projek -->
            <div class="form-group">
                <label class="col-lg-2" for="nama_projek">Nama Projek</label>
                <div class="col-lg-11">
                    <input type="text" name="nama_projek" id="nama_projek" class="form-control" value="<?= $projek['nama_projek'] ?>">
                </div>
            </div>
            <!-- Buat input untuk tahun -->
            <div class="form-group">
                <label class="col-lg-2" for="tahun">Tahun</label>
                <div class="col-lg-11">
                    <input type="text" name="tahun" id="tahun" class="form-control" value="<?= $projek['tahun_projek'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label col-lg-3">IKU <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <select data-placeholder="IKU" class="form-control select" data-fouc name="id_iku" id="id_iku">
                        <option value="<?= $projek['id_iku'] ?>"><?= $projek['iku'] ?></option>
                        <?php foreach ($iku
                            as $key => $value) { ?>
                            <option value="<?= $value["id"] ?>"> <?= $value["iku"] ?></option>
                        <?php } ?>
                    </select>
                    <span class="form-text text-muted"> Optional <code>default = kosong</code></span>
                </div>
            </div>
            <!-- Buat tombol submit -->
            <button type="submit" class="btn btn-success">Update</button>
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
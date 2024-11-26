<script src="<?= base_url(); ?>/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/editor_ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/uploader_bootstrap.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/gallery.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/media/fancybox.min.js"></script>
<!-- CKEditor default -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Input Laporan Perjalanan Dinas</h5>
        <a href="<?= base_url(); ?>/perjadin/pdf/<?= $detail_perjadin['id_perjadin']; ?>">
            <button type="button" class="btn btn-outline-success"><i class="icon-file-pdf mr-2"></i> Generate PDF</button>
        </a>
        <button type="button" value="Back" onclick="history.back(-1)" class="btn btn-outline-primary"><i class="icon-arrow-left15 mr-2"></i>Back</button>

    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url(); ?>/perjadin/input_laporan_2/<?= $detail_perjadin['id_perjadin']; ?>" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td>1. Nama Pelaksana SPD</td>
                    <td>:</td>
                    <td>
                        <?php if ($jumlah_rombongans > 1 ): ?>
                            <ol>
                                <?php foreach ($rombongans as $item): ?>
                                    <li><?php echo $item['nama_pegawai']; ?></li>
                                <?php endforeach; ?>
                            </ol>
                        <?php else: ?>
                            <?= $detail_perjadin['nama_pegawai']; ?>
                        <?php endif; ?>
                    </td>
                    <td>4. Program yang membiayai</td>
                    <td>:</td>
                    <td> <input type="text" class="form-control" name="program" placeholder="isikan program yang membiayai" value="<?= $detail_perjadin['program']; ?>" required></input>
                    </td>
                </tr>
                <tr>
                    <td width='10%'>2. Tujuan </td>
                    <td width='5%'>: </td>
                    <td><?= $detail_perjadin['judul']; ?></td>
                    <td>5. Kegiatan</td>
                    <td>:</td>
                    <td><input type="text" class="form-control" name="kegiatan" placeholder="isikan kegiatan" value="<?= $detail_perjadin['kegiatan']; ?>" required></td>
                </tr>
                <tr>
                    <td>3. Jadwal</td>
                    <td>:</td>
                    <td><?= $tanggal; ?> </td>
                    
                    <td>6. Komponen</td>
                    <td>:</td>
                    <td><input type="text" class="form-control" name="komponen" placeholder="isikan komponen yang membiayai" value="<?= $detail_perjadin['komponen']; ?>" required></td>
                </tr>
                <tr>
                    <td>Pengesahan</td>
                    <td>:</td>
                    <td><input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="<?= $detail_perjadin['jabatan']; ?> " required></td>
                    
                    <td colspan="3">
                        <select data-placeholder="Nama" class="form-control select-minimum" data-fouc name="username_pejabat" required>
                            <option value="<?= $detail_perjadin["username_pejabat"] ?>"><?= $detail_perjadin["nama_pejabat"] ?></option>
                            <?php foreach ($pegawai
                                as $key => $value) { ?>
                                <option value="<?= $value["username"] ?>"><?= $value["nama_pegawai"] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    
                </tr>
            </table>
            <br>
            
            <div class="form-group">

            </div>
            <div class="form-group row">
                <div class="col-sm-7">
                    <label>
                        <h2>Uraian Kegiatan</h2>
                    </label>
                    <br>
                    <textarea id="editor-full3"  rows="2" cols="2" name="uraian_kegiatan" ><?= $detail_perjadin['uraian_kegiatan']; ?></textarea>
                </div>
                <div class="col-sm-5">
                    <label>
                        <h2>Pejabat dan Tempat yang dikunjungi</h2>
                    </label>
                    <br>
                    <textarea id="editor-full4" class="editor-full" rows="1" cols="2" name="pejabat" required><?= $detail_perjadin['pejabat']; ?></textarea>
                </div>
                <!--<div class="col-sm-4">-->
                <!--    <label>-->
                <!--        <h2>Pengesahan</h2>-->
                <!--    </label>-->
                <!--    <br>-->
                <!--    <textarea id="editor-full5" class="editor-full" rows="2" cols="2" name="pengesahan" required><?= $detail_perjadin['pengesahan']; ?></textarea>-->
                <!--</div>-->
            </div>
            <div class="form-group row">
                
                <div class="col-sm-6">
                    <div class="col-sm-12">
                        <label>
                            <h2>Upload Foto</h2>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="file" class="file-input" data-fouc name="upload_foto1" accept="image/*">
                            <label>
                                Caption Foto 1 (maks 300kb)
                            </label>
                            <input class="form-control" name="caption1" placeholder="caption foto 1" value="<?= $detail_perjadin['caption1']; ?>"></input>
                        </div>
                        <div class="col-sm-6">
                            <input type="file" class="file-input" data-fouc name="upload_foto2" accept="image/*">
                            <label>
                                Caption Foto 2 (maks 300kb)
                            </label>
                            <input class="form-control" name="caption2" placeholder="caption foto 2" value="<?= $detail_perjadin['caption2']; ?>"></input>
                        </div>
                    </div>
                    <br>
                    <h4>Dokumentasi telah Diupload</h4>
                    <div class="row">
                        
                            <div class="col-sm-6 col-lg-3">
                                <div class="card">
                                    <div class="card-img-actions m-1">
                                        <span><?= $detail_perjadin['caption1']; ?></span>
                                        <img class="card-img img-fluid" src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto1']; ?>" alt="">
                                        <div class="card-img-actions-overlay card-img">
                                            <a href="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto1']; ?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                                <i class="icon-plus3"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                                <i class="icon-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card">
                                    <div class="card-img-actions m-1">
                                        <span><?= $detail_perjadin['caption2']; ?></span>
                                        <img class="card-img img-fluid" src="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto2']; ?>" alt="">
                                        <div class="card-img-actions-overlay card-img">
                                            <a href="<?= base_url('upload_file/perjadin/') . $detail_perjadin['foto2']; ?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">
                                                <i class="icon-plus3"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                                <i class="icon-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
                
                <div class="col-sm-6">
                    
                </div>
            </div>
            <div class="form-group">
            </div>
            <!-- <div class="form-group ">
                <div class="col-sm-12">
                    <label>
                        <h2>Upload Foto</h2>
                    </label>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="file" class="file-input" data-fouc name="upload_foto1" accept="image/*">
                        <label>
                            Caption Foto 1 (maks 300kb)
                        </label>
                        <input class="form-control" name="caption1" placeholder="caption foto 1" <?= (empty($dokumentasi_perjadin)) ? 'required' : ''; ?>></input>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="file-input" data-fouc name="upload_foto2" accept="image/*">
                        <label>
                            Caption Foto 2 (maks 300kb)
                        </label>
                        <input class="form-control" name="caption2" placeholder="caption foto 2" <?= (empty($dokumentasi_perjadin)) ? 'required' : ''; ?>></input>
                    </div>
                </div>
            </div> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-success">Submit</button>
            </div>



        </form>
    </div>
</div>
<!-- /CKEditor default -->

<script>
    // CKEDITOR.replace('editor-full1', {
    //     height: 200,
    //     extraPlugins: 'forms'
    // });
    // CKEDITOR.replace('editor-full2', {
    //     height: 200,
    //     extraPlugins: 'forms'
    // });
    // CKEDITOR.replace('editor-full3', {
    //     height: 200,
    //     extraPlugins: 'forms'
    // });
    CKEDITOR.replace('editor-full4', {
        height: 200,
        extraPlugins: 'forms'
    });
    // CKEDITOR.replace('editor-full5', {
    //     height: 200,
    //     extraPlugins: 'forms'
    // });
</script>


<script src="<?= base_url(); ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>

<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_select2.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>


<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/rwfc15biw6hgiluorxlynkqn3yowz2ig8zdu4czdohf2j09v/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    // selector: 'textarea', 
    selector: '#editor-full3',
    plugins: '  anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount ',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });
</script>
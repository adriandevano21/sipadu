<script src="<?= base_url(); ?>/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/editor_ckeditor.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/demo_pages/gallery.js"></script>
<script src="<?= base_url(); ?>/global_assets/js/plugins/media/fancybox.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 1000;
        display: none; /* Mulai dengan tersembunyi */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        font-size: 3rem;
        color: #000; /* Ubah warna jika diperlukan */
    }
</style>


<!-- Overlay -->
    <div id="">
    </div>
<!-- CKEditor default -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Detail Event</h5>
        <a href="<?= base_url(); ?>aktivitas/kirim_peringatan/" id="kirim-wa-ulang-btn">
            <button type="button" class="btn btn-outline-success">
                <i class="icon-paperplane mr-2"></i> Kirim WA Ulang
            </button>
        </a>
        <input type="button" value="Back" onclick="history.back(-1)" class="btn btn-primary" />
    </div>
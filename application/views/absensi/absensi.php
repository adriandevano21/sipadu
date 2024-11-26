<!-- Basic datatable -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">List Absensi</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>



    <table class="table datatable-button-html5-basic">

        <thead>
            <tr>

                <th class="text-center">Nama</th>
                <th class="text-center">Kegiatan</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Jam (WIB)</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data as $key => $value) {
            ?>
                <tr>
                    <td>
                        <?php echo $value['nama_pegawai']; ?>
                    </td>
                    <td>
                        <?php echo $value['kegiatan']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo substr($value['timestamp'], 0, 10);
                        ?>
                    </td>
                    <td class="text-center">
                        <?php echo substr($value['timestamp'], 11, 5);
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>


<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script src="<?= base_url(); ?>global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>

<script>
    $(document).ready(function() {


        // Setting datatable defaults
        // $.extend($.fn.dataTable.defaults, {
        //     autoWidth: false,
        //     dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        //     language: {
        //         search: '<span>Filter:</span> _INPUT_',
        //         searchPlaceholder: 'Type to filter...',
        //         lengthMenu: '<span>Show:</span> _MENU_',
        //         paginate: {
        //             'first': 'First',
        //             'last': 'Last',
        //             'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
        //             'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
        //         }
        //     }
        // });


        // // Basic initialization
        // $('.datatable-button-html5-basic').DataTable({
        //     buttons: {
        //         dom: {
        //             button: {
        //                 className: 'btn btn-light'
        //             }
        //         },
        //         buttons: [
        //             'copyHtml5',
        //             'excelHtml5',
        //             'csvHtml5',
        //             'pdfHtml5'
        //         ]
        //     }
        // });
    });
</script>
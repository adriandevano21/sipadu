<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>
<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>
<script src="<?= base_url() ?>/dashboard/scheduler.min.js"></script>


<style>
    .calendar-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>



<!-- Kalender Kegiatan -->
<div class="card">
    <!--<div class="card-header header-elements-inline">-->
    <!--    <h5 class="card-title">Kalender Event</h5>-->
    <!--    <div class="header-elements">-->
    <!--        <div class="list-icons">-->
    <!--            <a class="list-icons-item" data-action="collapse"></a>-->
    <!--            <a class="list-icons-item" data-action="reload"></a>-->
    <!--            <a class="list-icons-item" data-action="remove"></a>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <div class="card-body">

        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var events = [
            <?php foreach ($rapat as $rapat) : ?> {
                    title: '<?php echo $rapat['topik']; ?>',
                    start: '<?php echo $rapat['tanggal'] . 'T' . $rapat['pukul']; ?>',
                    end: '<?php echo $rapat['tanggal_selesai'] . 'T' . $rapat['selesai']; ?>',
                    ruangan: '<?php echo (isset($rapat['lokasi'])) ? $rapat['lokasi'] : $rapat['nama_ruangan']; ?>',
                    narahubung: '<?php echo $rapat['nama_pegawai']; ?>',
                    id_ruangan: '<?php echo $rapat['id_ruangan']; ?>',
                    resourceId: '<?php echo $rapat['id_ruangan']; ?>',
                    url: '<?php echo base_url('event/lihat/') . $rapat['id_rapat'] ?>'
                },
            <?php endforeach; ?>
        ];
        function setCalendarHeight() {
                var windowHeight = $(window).height();
                $('#calendar').fullCalendar('option', 'height', windowHeight);
            }

        $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: 'agendaDay',
            minTime: '08:00:00',
            maxTime: '17:00:00',
            // contentHeight: '50', // Mengatur tinggi konten menjadi otomatis
            contentHeight: 780,
            slotEventOverlap: false,
            eventRender: function(event, element) {
                switch (event.id_ruangan) {
                    case '4':
                        element.css('background-color', 'Salmon');
                        break;
                    case '5':
                        element.css('background-color', 'LightSeaGreen');
                        break;
                    case '6':
                        element.css('background-color', 'RoyalBlue');
                        break;
                    case '8':
                        element.css('background-color', 'orange');
                        break;
                    case '9':
                        element.css('background-color', 'Plum');
                        break;
                    case '99':
                        element.css('background-color', 'Chocolate');
                        break;
                    default:
                        element.css('background-color', 'sky blue');
                        break;
                };
                element.find('.fc-title').append("<br><b>[" + event.narahubung.split(" ").slice(0, 2).join(" ") + "]</b>");
                element.find('.fc-title').append("<br><b>" + event.ruangan + "</b>");
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            views: {
                month: {
                    titleFormat: 'LL',
                    columnFormat: 'dddd'
                },
                week: {
                    titleFormat: 'MMM Do YY',
                    columnFormat: 'ddd D'
                }
            },
            resources: [
                <?php foreach ($ruang_rapat as $key => $value) {
                    echo "{ title: '" . $value['nama_ruangan'] . "', id: '" . $value['id'] . "', eventColor: 'red' }, ";
                } ?>
            ],
            select: function(start, end, jsEvent, view, resource) {
                console.log('select', start.format(), end.format(), resource ? resource.id : '(no resource)');
            },
            dayClick: function(date, jsEvent, view, resource) {
                console.log('dayClick', date.format(), resource ? resource.id : '(no resource)');
            },
            timeFormat: 'H:mm',
            events: events,
            isRTL: $('html').attr('dir') == 'rtl' ? true : false
        });

    });
    $(window).resize(function() {
        $('#calendar').fullCalendar('render');
    });
</script>


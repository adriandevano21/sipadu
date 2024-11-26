<!--<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>-->
<!--<script src="<?= base_url() ?>/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script>-->
<!--<script src="<?= base_url() ?>/global_assets/js/demo_pages/fullcalendar_formats.js"></script>-->

<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.4.2/main.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timeline@4.4.2/main.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-timeline@4.4.2/main.min.css" rel="stylesheet" type="text/css">

<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.4.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.4.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timeline@4.4.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-common@4.4.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-timeline@4.4.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.14/locales-all.global.min.js"></script>



<style>
    .fc-event {
            border-left: 10px solid #FF5733; /* Mengubah lebar dan warna bar (border-left) */
            padding-left: 10px; /* Sesuaikan padding untuk teks event */
            display: flex;
            align-items: center; /* Vertikal align teks di tengah */
            
            margin-top: auto; /* Posisi bar di tengah vertikal */
            margin-bottom: auto; /* Posisi bar di tengah vertikal */
        }
    
    
    .fc-event .fc-title {
        font-size: 12px; /* Sesuaikan ukuran font sesuai kebutuhan */
        
        white-space: normal !important; /* Membuat teks judul wrap */
    }
</style>
<!-- Kalender Kegiatan -->
<div class="card">
    <div class="card-body">
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
        // $(window).resize(function() {
        //     $('#calendar').fullCalendar('render');
        // });
        document.addEventListener('DOMContentLoaded', function() {
            
          var calendarEl = document.getElementById('calendar');
          
          
        
          var calendar = new FullCalendar.Calendar(calendarEl, {
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            resourceAreaWidth: '15%',
            contentHeight: 'auto',
            slotDuration: '00:30:00',
            minTime: '08:00:00',
            maxTime: '16:30:00',
            slotEventOverlap: false,
            plugins: [ 'interaction', 'resourceTimeline' ],
            timeZone: 'UTC',
            defaultView: 'resourceTimelineDay',
            locale: 'id',
            // aspectRatio: 1.5,
            header: {
              left: 'today',
              center: 'title',
              right: 'prev,next'
              
            },
            //   right: 'resourceTimelineDay'
            //   right: 'resourceTimelineDay,resourceTimelineWeek'
            
            // editable: true,
            resourceLabelText: 'Ruangan',
            slotLabelFormat: [{ hour: '2-digit', minute: '2-digit', omitZeroMinute: false, hour12: false }],
            resources: [
                    <?php foreach ($ruang_rapat as $key => $value) {
                        echo "{ title: '" . $value['nama_ruangan'] . "', id: '" . $value['urutan'] . "', eventColor: '" . $value['warna'] . "' }, ";
                    } ?>
                ],
            events: [
                    <?php foreach ($rapat as $rapat) : ?> {
                        title: '<?php echo $rapat['topik']; ?>',
                        start: '<?php echo $rapat['tanggal'] . 'T' . $rapat['pukul']; ?>',
                        end: '<?php echo $rapat['tanggal_selesai'] . 'T' . $rapat['selesai']; ?>',
                        ruangan: "<?php echo (isset($rapat['lokasi'])) ? $rapat['lokasi'] : $rapat['nama_ruangan']; ?>",
                        narahubung: '<?php echo $rapat['nama_pegawai']; ?>',
                        id_ruangan: '<?php echo $rapat['id_ruangan']; ?>',
                        resourceId: '<?php echo $rapat['urutan']; ?>',
                        url: '<?php echo base_url('event/lihat/') . $rapat['id_rapat'] ?>'
                    },
                <?php endforeach; ?>
                ],
            
          });
        
          calendar.render();
    });

    
    
</script>
<script>
    $(document).ready(function() {
        // Set interval untuk reload halaman setiap 10 menit (600000 milidetik)
        setInterval(function() {
            location.reload();
        }, 600000); // 600000 milidetik = 10 menit
    });
</script>

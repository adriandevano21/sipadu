

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>


<style>
    th {
    font-weight: 800;
    font-size: 20px;
}
.fc-toolbar-title{
    font-weight: 1000;
}
.fc-list-heading-main {
    display: inline-block;
    margin: 0;
}
.fc-list-heading {
    text-align: center;
}
.fc-list-event{
    font-size:15px;
}
</style>
	
	<!-- Kalender Kegiatan -->
	<div class="card border-teal-400">
		<div class="card-header header-elements-inline">
			<!--<h5 class="card-title">Kegiatan <?= $aktivitas['0']['nama_pegawai']; ?></h5>-->
			<h2 class="card-title text-center"><b> Kegiatan Kepala BPS Aceh</b> </h2>
			
		</div>

		<div class="card-body">
		    
			<div id="calendar"></div>
		</div>
	</div>

	<script>

			
			
			document.addEventListener('DOMContentLoaded', function() {
              var calendarEl = document.getElementById('calendar');
            
              var calendar = new FullCalendar.Calendar(calendarEl, {
                  schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                locale: 'id',
                
                initialView: 'listDay',
                contentHeight: 'auto',
            
                // customize the button names,
                // otherwise they'd all just say "list"
                views: {
                  listDay: { buttonText: 'list day' },
                  listWeek: { buttonText: 'list week' },
                  listMonth: { buttonText: 'list month' }
                },
            
                headerToolbar: {
                  left: 'title',
                  center: '',
                  right: 'prev,listDay,listWeek,listMonth,next'
                },
                events: [
                <?php foreach ($aktivitas as $activity) : ?> {
				
				        title: "<?php echo str_replace('"' ,"" , str_replace ("\n","<br />", $activity["aktivitas"]) ) ; ?>", 
						start: '<?php echo $activity['tanggal']." ".$activity['pukul'] ; ?>',
						end: '<?php echo $activity['tanggal_selesai']." ".$activity['selesai'] ; ?>'
					},
				<?php endforeach; ?>],
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
	

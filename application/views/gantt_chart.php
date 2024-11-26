<!-- application/views/gantt_chart_ajax.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Gantt Chart dengan AJAX</title>
    <script src="<?php echo base_url('assets/gantt/codebase/dhtmlxgantt.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/gantt/codebase/dhtmlxgantt.css'); ?>">
</head>

<body>
    <!-- Container untuk Gantt Chart -->
    <div id="gantt_chart" style="width: 100%; height: 400px;"></div>

    <script>
        $(document).ready(function() {
            // Inisialisasi dhtmlxGantt
            gantt.plugins({
                marker: true
            });
            gantt.config.xml_date = "%Y-%m-%d %H:%i";
            var dateToStr = gantt.date.date_to_str(gantt.config.task_date);
            var today = new Date(2023, 3, 5);
            var markerId = gantt.addMarker({
                start_date: new Date(), //a Date object that sets the marker's date
                // start_date: today,
                css: "today", //a CSS class applied to the marker
                text: "Today", //the marker title
                title: dateToStr(new Date()) // the marker's tooltip
            });
            gantt.init("gantt_chart");

            var today = new Date();
            gantt.config.start_date = gantt.date.date_to_str("%Y-%m-%d")(today);

            // Mendapatkan data tasks dari PHP dan memasukkannya ke Gantt Chart
            gantt.parse({
                data: <?php echo json_encode($tasks); ?>
            });

            // Mendengarkan event onTaskCreated dari dhtmlxGantt
            gantt.attachEvent("onAfterTaskAdd", function(taskId, task) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('agenda/addTask'); ?>',
                    data: task,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            // Task berhasil ditambahkan ke database
                            gantt.changeTaskId(taskId, result.task_id);
                        } else {
                            // Gagal menambahkan task
                            alert('Gagal menambahkan task!');
                            gantt.deleteTask(taskId);
                        }
                    }
                });
            });
            // Mendengarkan event onAfterTaskDelete dari dhtmlxGantt
            gantt.attachEvent("onAfterTaskDelete", function(taskId, task) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('agenda/deleteTask'); ?>',
                    data: task,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            // Task berhasil ditambahkan ke database
                            gantt.deleteTask(taskId);
                        } else {
                            // Gagal menambahkan task
                            alert('Gagal menghapus task!');
                            // gantt.deleteTask(taskId);
                        }
                    }
                });
            });
            // Mendengarkan event onAfterTaskDelete dari dhtmlxGantt
            gantt.attachEvent("onAfterTaskUpdate", function(taskId, task) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('agenda/updateTask'); ?>',
                    data: task,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            // Task berhasil ditambahkan ke database
                            gantt.refreshTask(id);
                            gantt.closeLightbox();
                        } else {
                            // Gagal menambahkan task
                            alert('Gagal memperbarui task!');
                            // gantt.deleteTask(taskId);
                        }
                    }
                });
            });


        });
    </script>
</body>

</html>
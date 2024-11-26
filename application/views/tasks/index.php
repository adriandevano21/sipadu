


    
    <!-- Theme JS files -->
	<script src="<?= base_url() ?>/global_assets/js/plugins/loaders/progressbar.min.js"></script>
	<script src="<?= base_url() ?>/global_assets/js/demo_pages/components_progress.js"></script>
	
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">-->
    <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
    <style>
        .task-column {
            min-height: 300px;
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
        }
        .task-card {
            cursor: move;
            margin-bottom: 6px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .column-header {
            font-weight: bold;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .column-title {
            font-size: 18px;
        }
        .task-count {
            background-color: #e9ecef;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 14px;
        }
        .priority-indicator {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            margin-bottom: 8px;
        }
        .priority-Low { background-color: #28a745; }
        .priority-Medium { background-color: #ffc107; }
        .priority-High { background-color: #dc3545; }
        .task-title {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .task-dates {
            font-size: 12px;
            color: #6c757d;
        }
        /*.progress-bar {*/
        /*    height: 4px;*/
        /*    margin-top: 8px;*/
        /*}*/
        .add-task-btn {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            cursor: pointer;
            color: #6c757d;
        }
        
    </style>

<body>
    <div class="container mt-3">
        <h1 class="mb-4"><?php  echo $project->name ?></h1>
        

        <div class="row">
            <div class="col-md-4">
                <div class="task-column" id="planning-tasks" style="background-color : rgb(195 229 243)">
                    <div class="column-header">
                        <span class="column-title">Planning</span>
                        <span class="task-count" id="planning-count">0</span>
                    </div>
                    <!-- Tasks will be loaded here -->
                    <div class="add-task-btn" onclick="openAddTaskModal(1)"><b style="color : blue">+ New</b></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="task-column" id="in-progress-tasks" style="background-color : rgb(255 220 158)">
                    <div class="column-header">
                        <span class="column-title">In Progress</span>
                        <span class="task-count" id="in-progress-count">0</span>
                    </div>
                    <!-- Tasks will be loaded here -->
                    <div class="add-task-btn" onclick="openAddTaskModal(2)"><b style="color : orange">+ New</b></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="task-column" id="done-tasks" style="background-color : rgb(173 245 155 / 70%)">
                    <div class="column-header">
                        <span class="column-title">Done</span>
                        <span class="task-count" id="done-count">0</span>
                    </div>
                    <!-- Tasks will be loaded here -->
                    <div class="add-task-btn" onclick="openAddTaskModal(3)"><b style="color : green">+ New</b></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div class="modal fade" id="taskModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Tambah Tugas</h5>
                    
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <input type="hidden" id="task_id" name="task_id">
                        <input type="hidden" id="project_id" name="project_id">
                        <input type="hidden" id="status_id" name="status_id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Penanggung Jawab</label>
                            <!--<select class="form-select employee-select form-control select2-container" id="employee_id" name="employee_id">-->
                            <select class="form-control employee-select select-minimum" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                <?php foreach ($employees as $employee): ?>
                                    <option value="<?php echo $employee->username; ?>"><?php echo $employee->nama_pegawai; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="mb-3">
                            <label for="progress" class="form-label">Progress (%)</label>
                            <input type="number" class="form-control" id="progress" name="progress" min="0" max="100">
                            
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTaskBtn">Save Task</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<!-- Cool Loading Overlay -->
<div id="coolLoadingOverlay" style="display: none;">
    <div class="cool-spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>

<style>
#coolLoadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.cool-spinner {
    width: 100px;
    height: 100px;
    position: relative;
}

.double-bounce1, .double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #3498db;
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;
    animation: sk-bounce 2.0s infinite ease-in-out;
}

.double-bounce2 {
    animation-delay: -1.0s;
}

@keyframes sk-bounce {
    0%, 100% { 
        transform: scale(0.0);
    } 50% { 
        transform: scale(1.0);
    }
}
</style>

    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
    <script src="<?= base_url() ?>/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="<?= base_url() ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="<?= base_url() ?>/global_assets/js/plugins/forms/styling/switch.min.js"></script>
    
    <script src="<?= base_url() ?>/global_assets/js/demo_pages/form_select2.js"></script>
    <script>
        $(document).ready(function() {
            loadTasks();

            $('#project-select').change(function() {
                loadTasks();
            });

            $('.task-column').sortable({
                connectWith: '.task-column',
                update: function(event, ui) {
                    var taskId = ui.item.data('task-id');
                    var newStatusId = ui.item.parent().attr('id').split('-')[0] === 'planning' ? 1 : 
                                      ui.item.parent().attr('id').split('-')[0] === 'in' ? 2 : 3;
                    updateTaskStatus(taskId, newStatusId);
                }
            });

            $('#saveTaskBtn').click(function() {
                saveTask();
            });

            $('.22222employee-select').select2({
                dropdownParent: $('#taskModal'),
                placeholder: "Search for an employee",
                allowClear: true,
                // theme: "bootstrap"
            });
        });

        function loadTasks() {
            var projectId = $('#project-select').val();
            $.ajax({
               
                url: '<?php echo base_url("tasks/get_tasks/"); ?>' + <?= $project_id ?>,
                method: 'GET',
                success: function(response) {
                    var tasks = JSON.parse(response);
                    $('#planning-tasks, #in-progress-tasks, #done-tasks').children(':not(.column-header, .add-task-btn)').remove();
                    var planningCount = 0, inProgressCount = 0, doneCount = 0;
                    tasks.forEach(function(task) {
                        var taskHtml = createTaskCard(task);
                        if (task.status_id == 1) {
                            $('#planning-tasks .add-task-btn').before(taskHtml);
                            planningCount++;
                        } else if (task.status_id == 2) {
                            $('#in-progress-tasks .add-task-btn').before(taskHtml);
                            inProgressCount++;
                        } else if (task.status_id == 3) {
                            $('#done-tasks .add-task-btn').before(taskHtml);
                            doneCount++;
                        }
                    });
                    $('#planning-count').text(planningCount);
                    $('#in-progress-count').text(inProgressCount);
                    $('#done-count').text(doneCount);
                }
            });
        }

        function createTaskCard(task) {
            var startDate = formatDate(task.start_date);
            var endDate = formatDate(task.end_date);
            
            // Create progress bar HTML only if progress is not 0
            var progressBarHTML = '';
            if (task.progress > 0) {
                progressBarHTML = `
                    <div class="progress rounded-round">
                        <div class="progress-bar ${
                            task.progress < 50 ? 'bg-danger' :
                            task.progress > 80 ? 'bg-success' :
                            'bg-warning'
                        }" style="width: ${task.progress}%">
                            <span>${task.progress}%</span>
                        </div>
                    </div>
                `;
            }
        
            return `
                <div class="card task-card" data-task-id="${task.id}">
                    <div class="card-body">
                        <div class="priority-indicator priority-${task.priority}"></div>
                        <h5 class="task-title">${task.title}</h5>
                        <p class="card-text">${task.description}</p>
                        <p class="task-dates">${startDate} - ${endDate}</p>
                        <p class="card-text"><small><i class="icon-user "></i>: ${task.nama_pegawai || 'Unassigned'}</small></p>
                        ${progressBarHTML}
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="editTask(${task.id})">Edit</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteTask(${task.id})">Delete</button>
                        </div>
                    </div>
                </div>
            `;
        }
        function formatDate(dateString) {
            if (!dateString) return 'Not set';
            var date = new Date(dateString);
            return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
        }

        function openAddTaskModal(statusId) {
            $('#taskModalLabel').text('Add New Task');
            $('#taskForm')[0].reset();
            $('#task_id').val('');
            // $('#project_id').val($('#project-select').val()); 
            $('#project_id').val('<?= $project_id ?>');
            $('#status_id').val(statusId);
            $('.employee-select').val(null).trigger('change');
            $('#taskModal').modal('show');
        }

        // function saveTask() {
        //     var formData = $('#taskForm').serialize();
        //     var url = $('#task_id').val() ? '<?php echo base_url("tasks/edit_task"); ?>' : '<?php echo base_url("tasks/add_task"); ?>';
            
        //     $.ajax({
        //         url: url,
        //         method: 'POST',
        //         data: formData,
        //         success: function(response) {
        //             var result = JSON.parse(response);
        //             if (result.status === 'success') {
        //                 $('#taskModal').modal('hide');
        //                 loadTasks();
        //             } else {
        //                 alert('Error: ' + result.message);
        //             }
        //         }
        //     });
        // }
        
        function saveTask() {
            var formData = $('#taskForm').serialize();
            var url = $('#task_id').val() ? '<?php echo base_url("tasks/edit_task"); ?>' : '<?php echo base_url("tasks/add_task"); ?>';
            
            // Show cool loading overlay
            $('#coolLoadingOverlay').fadeIn(300);
            
            // Disable all buttons and inputs
            $('button, input, select, textarea').prop('disabled', true);
            
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        $('#taskModal').modal('hide');
                        loadTasks();
                    } else {
                        alert('Error: ' + result.message);
                    }
                },
                error: function() {
                    // alert('An error occurred while saving the task.');
                    alert('Error: ' + result.message);
                },
                complete: function() {
                    // Hide cool loading overlay with a fade out effect
                    $('#coolLoadingOverlay').fadeOut(300);
                    
                    // Re-enable all buttons and inputs
                    $('button, input, select, textarea').prop('disabled', false);
                }
            });
        }
        function updateTaskStatus(taskId, newStatusId) {
            $.ajax({
                url: '<?php echo base_url("tasks/update_task_status"); ?>',
                method: 'POST',
                data: { task_id: taskId, new_status_id: newStatusId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status !== 'success') {
                        alert('Error updating task status');
                        loadTasks();
                    }
                }
            });
        }

        function editTask(taskId) {
            $.ajax({
                url: '<?php echo base_url("tasks/get_task/"); ?>' + taskId,
                method: 'GET',
                success: function(response) {
                    var task = JSON.parse(response);
                    $('#taskModalLabel').text('Edit Task');
                    $('#task_id').val(task.id);
                    $('#project_id').val(task.project_id);
                    $('#status_id').val(task.status_id);
                    $('#title').val(task.title);
                    $('#description').val(task.description);
                    $('.employee-select').val(task.employee_id).trigger('change');
                    $('#start_date').val(task.start_date);
                    $('#end_date').val(task.end_date);
                    $('#progress').val(task.progress);
                    $('#priority').val(task.priority);
                    $('#taskModal').modal('show');
                }
            });
        }

        function deleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task?')) {
                $.ajax({
                    url: '<?php echo base_url("tasks/delete_task"); ?>',
                    method: 'POST',
                    data: { task_id: taskId },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            loadTasks();
                        } else {
                            alert('Error deleting task');
                        }
                    }
                });
            }
        }
    </script>
</body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        .task-column {
            min-height: 300px;
        }
        .task-card {
            cursor: move;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Task Management</h1>
        
        <div class="mb-3">
            <label for="project-select" class="form-label">Select Project:</label>
            <select id="project-select" class="form-select">
                <?php foreach ($projects as $project): ?>
                    <option value="<?php echo $project->id; ?>"><?php echo $project->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Planning
                        <button class="btn btn-sm btn-light float-end" onclick="openAddTaskModal(1)">Add Task</button>
                    </div>
                    <div class="card-body task-column" id="planning-tasks">
                        <!-- Tasks will be loaded here -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning">
                        In Progress
                        <button class="btn btn-sm btn-light float-end" onclick="openAddTaskModal(2)">Add Task</button>
                    </div>
                    <div class="card-body task-column" id="in-progress-tasks">
                        <!-- Tasks will be loaded here -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Done
                        <button class="btn btn-sm btn-light float-end" onclick="openAddTaskModal(3)">Add Task</button>
                    </div>
                    <div class="card-body task-column" id="done-tasks">
                        <!-- Tasks will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                            <select class="form-select" id="employee_id" name="employee_id">
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
                            <select class="form-select" id="priority" name="priority">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTaskBtn">Save Task</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
        });

        function loadTasks() {
            var projectId = $('#project-select').val();
            $.ajax({
                url: '<?php echo base_url("tasks/get_tasks/"); ?>' + projectId,
                method: 'GET',
                success: function(response) {
                    var tasks = JSON.parse(response);
                    $('#planning-tasks, #in-progress-tasks, #done-tasks').empty();
                    tasks.forEach(function(task) {
                        var taskHtml = createTaskCard(task);
                        if (task.status_id == 1) {
                            $('#planning-tasks').append(taskHtml);
                        } else if (task.status_id == 2) {
                            $('#in-progress-tasks').append(taskHtml);
                        } else if (task.status_id == 3) {
                            $('#done-tasks').append(taskHtml);
                        }
                    });
                }
            });
        }

        function createTaskCard(task) {
            var priorityClass = task.priority === 'High' ? 'text-danger' : 
                                task.priority === 'Medium' ? 'text-warning' : 'text-success';
            return `
                <div class="card mb-2 task-card" data-task-id="${task.id}">
                    <div class="card-body">
                        <h5 class="card-title">${task.title}</h5>
                        <p class="card-text">${task.description}</p>
                        <p class="card-text"><small class="text-muted">Assigned to: ${task.nama_pegawai || 'Unassigned'}</small></p>
                        <p class="card-text"><small class="text-muted">Start: ${task.start_date || 'Not set'} | End: ${task.end_date || 'Not set'}</small></p>
                        <p class="card-text"><small class="text-muted">Progress: ${task.progress}%</small></p>
                        <p class="card-text"><small class="${priorityClass}">Priority: ${task.priority}</small></p>
                        <button class="btn btn-sm btn-primary" onclick="editTask(${task.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">Delete</button>
                    </div>
                </div>
            `;
        }

        function openAddTaskModal(statusId) {
            $('#taskModalLabel').text('Add New Task');
            $('#taskForm')[0].reset();
            $('#task_id').val('');
            $('#project_id').val($('#project-select').val());
            $('#status_id').val(statusId);
            $('#taskModal').modal('show');
        }

        function saveTask() {
            var formData = $('#taskForm').serialize();
            var url = $('#task_id').val() ? '<?php echo base_url("tasks/edit_task"); ?>' : '<?php echo base_url("tasks/add_task"); ?>';
            
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
                    $('#employee_id').val(task.employee_id);
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
</html>
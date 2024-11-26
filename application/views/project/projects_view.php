

    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <div class="container mt-3">
        <div class="card border-teal-400">
            <div class="card-header  header-elements-inline">
                <h1 class="mb-4">Management Projects</h1>
                <button class="btn btn-primary mb-3" onclick="showAddModal()">Tambah Projek</button>
            </div>
        <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    
                    <th><center>Nama Projek</th>
                    <th><center>Deskripsi</th>
                    <th><center>Jadwal</th>
                    <th><center>Aksi</th>
                </tr>
            </thead>
            <tbody id="projects-table-body">
            </tbody>
        </table>
        </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel">Tambah Projek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="projectForm">
                        <input type="hidden" id="projectId">
                        <div class="form-group">
                            <label for="name">Nama Projek</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveProject()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            loadProjects();
        });

        function loadProjects() {
            $.ajax({
                url: '<?php echo base_url("projects/get_projects"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var tableBody = $('#projects-table-body');
                    tableBody.empty();
                    $.each(response, function(index, project) {
                        var startDate = formatDateID(project.start_date);
                        var endDate = formatDateID(project.end_date);
                        
                        tableBody.append(
                            '<tr>' +
                            
                            '<td>' + project.name + '</td>' +
                            '<td>' + project.description + '</td>' +
                            '<td><center>' + startDate + ' s.d ' + endDate + '</td>' +
                            '<td><center>' +
                            '<a href="<?= base_url() ?>tasks/view/' + project.id + '"> <button class="btn btn-sm btn-success">Lihat</button></a> ' +
                            '<button class="btn btn-sm btn-info" onclick="editProject(' + project.id + ')">Edit</button> ' +
                            '<button class="btn btn-sm btn-danger" onclick="deleteProject(' + project.id + ')">Delete</button>' +
                            '</center></td>' +
                            '</tr>'
                        );
                    });
                }
            });
        }
        
        function formatDateID(dateString) {
            if (!dateString) return '-';
            
            var date = new Date(dateString);
            var day = date.getDate();
            var month = date.getMonth();
            var year = date.getFullYear();
        
            // var monthNames = [
            //     "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            //     "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            // ];
            var monthNames = [
                "01", "02", "03", "04", "05", "06",
                "07", "08", "09", "10", "11", "12"
            ];
        
            return day + '-' + monthNames[month] + '-' + year;
        }

        function showAddModal() {
            $('#projectId').val('');
            $('#name').val('');
            $('#description').val('');
            $('#projectModalLabel').text('Add Project');
            $('#projectModal').modal('show');
        }

        function editProject(id) {
            $.ajax({
                url: '<?php echo base_url("projects/get_projects"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var project = response.find(p => p.id == id);
                    if (project) {
                        $('#projectId').val(project.id);
                        $('#name').val(project.name);
                        $('#description').val(project.description);
                        $('#projectModalLabel').text('Edit Project');
                        $('#projectModal').modal('show');
                    }
                }
            });
        }

        function saveProject() {
            var id = $('#projectId').val();
            var name = $('#name').val();
            var description = $('#description').val();

            var url = id ? '<?php echo base_url("projects/update_project"); ?>' : '<?php echo base_url("projects/add_project"); ?>';
            var data = {
                id: id,
                name: name,
                description: description
            };

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#projectModal').modal('hide');
                        loadProjects();
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }

        function deleteProject(id) {
            if (confirm('Are you sure you want to delete this project?')) {
                $.ajax({
                    url: '<?php echo base_url("projects/delete_project"); ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            loadProjects();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        }
    </script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boards Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <style>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // Ubah posisi toast di sini
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

    </style>
</head>

<body>

<div class="container mt-5">
    <h1>Boards Management</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createBoardModal">Create Board</button>
    <div id="boards-list" class="list-group">
        <!-- Boards will be loaded here with AJAX -->
    </div>
</div>

<!-- Create Board Modal -->
<div class="modal fade" id="createBoardModal" tabindex="-1" role="dialog" aria-labelledby="createBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBoardModalLabel">Create New Board</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createBoardForm">
                    <div class="form-group">
                        <label for="boardName">Board Name</label>
                        <input type="text" class="form-control" id="boardName" name="board_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Board Modal -->
<div class="modal fade" id="editBoardModal" tabindex="-1" role="dialog" aria-labelledby="editBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBoardModalLabel">Edit Board</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBoardForm">
                    <div class="form-group">
                        <label for="editBoardName">Board Name</label>
                        <input type="text" class="form-control" id="editBoardName" name="board_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBoardModal" tabindex="-1" role="dialog" aria-labelledby="deleteBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBoardModalLabel">Delete Board</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this board?</p>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadBoards();

    // Create board
    $('#createBoardForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: "<?= base_url('boards/create') ?>",
            method: "POST",
            data: $(this).serialize(),
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#createBoardModal').modal('hide');
                    $('#createBoardForm')[0].reset();
                    loadBoards();
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    });

    // Load board details into edit modal
    $('#boards-list').on('click', '.edit-board', function() {
        let boardId = $(this).data('id');
        $.ajax({
            url: "<?= base_url('boards/get_board/') ?>" + boardId,
            method: "GET",
            success: function(data) {
                let board = JSON.parse(data);
                $('#editBoardName').val(board.board_name);
                $('#editBoardForm').data('id', board.id);
                $('#editBoardModal').modal('show');
            }
        });
    });

    // Update board
    $('#editBoardForm').on('submit', function(event) {
        event.preventDefault();
        let boardId = $(this).data('id');
        $.ajax({
            url: "<?= base_url('boards/edit/') ?>" + boardId,
            method: "POST",
            data: $(this).serialize(),
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#editBoardModal').modal('hide');
                    loadBoards();
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    });

    // Load board details into delete modal
    $('#boards-list').on('click', '.delete-board', function() {
        let boardId = $(this).data('id');
        $('#confirmDelete').data('id', boardId);
        $('#deleteBoardModal').modal('show');
    });

    // Delete board
    $('#confirmDelete').on('click', function() {
        let boardId = $(this).data('id');
        $.ajax({
            url: "<?= base_url('boards/delete/') ?>" + boardId,
            method: "POST",
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#deleteBoardModal').modal('hide');
                    loadBoards();
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    });

    // Function to load boards
    function loadBoards() {
        $.ajax({
            url: "<?= base_url('boards/get_boards') ?>",
            method: "GET",
            success: function(data) {
                let boards = JSON.parse(data);
                let html = '';
                $.each(boards, function(index, board) {
                    html += `<div class="list-group-item">
                                <h5>${board.board_name}</h5>
                                <button class="btn btn-sm btn-info edit-board" data-id="${board.id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-board" data-id="${board.id}">Delete</button>
                             </div>`;
                });
                $('#boards-list').html(html);
            }
        });
    }
});

</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


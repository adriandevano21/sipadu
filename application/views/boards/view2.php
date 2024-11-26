<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Board</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        .board-column {
            background-color: #f4f5f7;
            padding: 10px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .card-item {
            background-color: #fff;
            border-radius: 3px;
            margin-bottom: 10px;
            padding: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .board-container {
            display: flex;
            overflow-x: auto;
        }
        .board-column-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .board-column-header h5 {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="board-container">
        <!-- Lists will be dynamically loaded here -->
    </div>
    <button class="btn btn-primary mt-4" id="addListButton">Add List</button>
</div>

<!-- Create/Edit List Modal -->
<div class="modal fade" id="listModal" tabindex="-1" aria-labelledby="listModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listModalLabel">Add List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="listForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="listName">List Name</label>
                        <input type="text" class="form-control" id="listName" name="list_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create/Edit Card Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Add Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cardForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cardName">Card Name</label>
                        <input type="text" class="form-control" id="cardName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="cardDescription">Description</label>
                        <textarea class="form-control" id="cardDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cardStartDate">Start Date</label>
                        <input type="date" class="form-control" id="cardStartDate" name="start_date">
                    </div>
                    <div class="form-group">
                        <label for="cardEndDate">End Date</label>
                        <input type="date" class="form-control" id="cardEndDate" name="end_date">
                    </div>
                    <div class="form-group">
                        <label for="cardProgress">Progress</label>
                        <input type="number" class="form-control" id="cardProgress" name="progress" min="0" max="100">
                    </div>
                    <input type="hidden" id="cardIdList" name="id_list">
                    <input type="hidden" id="cardId" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    loadBoard();

    // Initialize the sortable functionality for lists and cards
    function initSortable() {
        $('.board-column').sortable({
            connectWith: '.board-column',
            handle: '.card-item',
            placeholder: 'sortable-placeholder',
            update: function(event, ui) {
                let cardId = ui.item.data('id');
                let newListId = ui.item.closest('.board-column').data('id');
                updateCardList(cardId, newListId);
            }
        }).disableSelection();
    }

    // Load the entire board (lists and cards)
    function loadBoard() {
        $.ajax({
            url: "<?= base_url('boards/get_lists_with_cards') ?>", // Endpoint to get lists with their respective cards
            method: "GET",
            success: function(data) {
                let lists = JSON.parse(data);
                let html = '';
                $.each(lists, function(index, list) {
                    html += `<div class="board-column" data-id="${list.id}">
                                <div class="board-column-header">
                                    <h5>${list.list_name}</h5>
                                    <button class="btn btn-sm btn-secondary edit-list" data-id="${list.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-list" data-id="${list.id}">Delete</button>
                                </div>
                                <div class="card-list">`;
                    $.each(list.cards, function(cardIndex, card) {
                        html += `<div class="card-item" data-id="${card.id}">
                                    <h6>${card.name}</h6>
                                    <p>${card.description}</p>
                                    <button class="btn btn-sm btn-info edit-card" data-id="${card.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-card" data-id="${card.id}">Delete</button>
                                 </div>`;
                    });
                    html += `<button class="btn btn-sm btn-primary add-card" data-id="${list.id}">Add Card</button>
                                </div>
                            </div>`;
                });
                $('.board-container').html(html);
                initSortable(); // Re-initialize sortable functionality
            }
        });
    }

    // Open modal to create/edit a list
    $('#addListButton, .edit-list').on('click', function() {
        $('#listModal').modal('show');
        $('#listForm')[0].reset();
        if ($(this).hasClass('edit-list')) {
            let listId = $(this).data('id');
            $.ajax({
                url: "<?= base_url('boards/get_list/') ?>" + listId,
                method: "GET",
                success: function(data) {
                    let list = JSON.parse(data);
                    $('#listName').val(list.list_name);
                    $('#listForm').data('id', list.id);
                }
            });
        }
    });

    // Save list (create or update)
    $('#listForm').on('submit', function(event) {
        event.preventDefault();
        let listId = $(this).data('id');
        let url = listId ? "<?= base_url('boards/edit_list/') ?>" + listId : "<?= base_url('boards/create_list') ?>";
        $.ajax({
            url: url,
            method: "POST",
            data: $(this).serialize(),
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#listModal').modal('hide');
                    loadBoard();
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    });

    // Open modal to create/edit a card
    $(document).on('click', '.add-card, .edit-card', function() {
        $('#cardModal').modal('show');
        $('#cardForm')[0].reset();
        if ($(this).hasClass('edit-card')) {
            let cardId = $(this).data('id');
            $.ajax({
                url: "<?= base_url('boards/get_card/') ?>" + cardId,
                method: "GET",
                success: function(data) {
                    let card = JSON.parse(data);
                    $('#cardName').val(card.name);
                    $('#cardDescription').val(card.description);
                    $('#cardStartDate').val(card.start_date);
                    $('#cardEndDate').val(card.end_date);
                    $('#cardProgress').val(card.progress);
                    $('#cardId').val(card.id);
                    $('#cardIdList').val(card.id_list);
                }
            });
        } else {
            $('#cardIdList').val($(this).data('id'));
        }
    });

    // Save card (create or update)
    $('#cardForm').on('submit', function(event) {
        event.preventDefault();
        let cardId = $('#cardId').val();
        let url = cardId ? "<?= base_url('boards/edit_card/') ?>" + cardId : "<?= base_url('boards/create_card') ?>";
        $.ajax({
            url: url,
            method: "POST",
            data: $(this).serialize(),
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#cardModal').modal('hide');
                    loadBoard();
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    });

    // Delete list or card
    $(document).on('click', '.delete-list, .delete-card', function() {
        let id = $(this).data('id');
        let type = $(this).hasClass('delete-list') ? 'list' : 'card';
        $('#confirmDelete').data('id', id).data('type', type);
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').on('click', function() {
        let id = $(this).data('id');
        let type = $(this).data('type');
        let url = type === 'list' ? "<?= base_url('boards/delete_list/') ?>" + id : "<?= base_url('boards/delete_card/') ?>" + id;
        $.ajax({
            url: url,
            method: "POST",
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#deleteModal').modal('hide');
                    loadBoard();
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    });

    // Update card's list when moved to another list
    function updateCardList(cardId, newListId) {
        $.ajax({
            url: "<?= base_url('boards/update_card_list/') ?>",
            method: "POST",
            data: { card_id: cardId, new_list_id: newListId },
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    toastr.success(response.message); // Show success toast
                } else {
                    toastr.error(response.message); // Show error toast
                }
            }
        });
    }

    // Initialize toast options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
});
</script>

</body>
</html>

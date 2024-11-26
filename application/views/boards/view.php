<!DOCTYPE html>
<html>
<head>
    <title>Board View</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .card-draggable {
            cursor: move;
        }
        .ui-state-highlight {
            height: 1.5em;
            line-height: 1.2em;
            border: 1px dashed #ccc;
            background-color: #f9f9f9;
        }
        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>


<div class="container mt-4">
    <h1><?= $board->name ?> - Board</h1>
    <div class="row">
        <?php foreach ($lists as $list): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><?= $list->name ?></h4>
                        <button class="btn btn-sm btn-primary" onclick="showAddCardModal(<?= $list->id ?>)">+ Add Card</button>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($list->cards)): ?>
                            <ul class="list-group sortable" id="list-<?= $list->id ?>" data-list-id="<?= $list->id ?>">
                                <?php foreach ($list->cards as $card): ?>
                                    <li class="list-group-item card-item" id="card-<?= $card->id ?>" data-card-id="<?= $card->id ?>">
                                        <strong><?= $card->name ?></strong>
                                        <p><?= $card->description ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $card->progress ?>%;" aria-valuenow="<?= $card->progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>Assigned to: <?= $card->assigned_to ?></small><br>
                                        <small>Start Date: <?= date('d M Y', strtotime($card->start_date)) ?></small><br>
                                        <small>End Date: <?= date('d M Y', strtotime($card->end_date)) ?></small>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button class="btn btn-sm btn-warning" onclick="showEditCardModal(<?= $card->id ?>)">Edit</button>
                                            <button class="btn btn-sm btn-danger ml-2" onclick="deleteCard(<?= $card->id ?>)">Delete</button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="list-group sortable" id="list-<?= $list->id ?>" data-list-id="<?= $list->id ?>">
                                <li class="list-group-item text-center text-muted">No cards in this list.</li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- Tambah List Baru -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Add New List</h4>
                </div>
                <div class="card-body">
                    <form id="addListForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="listName" placeholder="List name">
                        </div>
                        <button type="submit" class="btn btn-success">Add List</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- List Modal -->
<div class="modal fade" id="listModal" tabindex="-1" role="dialog" aria-labelledby="listModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listModalLabel">Add List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="list-form">
                    <div class="form-group">
                        <label for="list-name">List Name</label>
                        <input type="text" class="form-control" id="list-name" required>
                    </div>
                    <input type="hidden" id="board-id" value="<?php echo $board['id']; ?>">
                    <button type="submit" class="btn btn-primary">Add List</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Card -->
<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Add/Edit Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <input type="hidden" id="cardId" name="cardId">
                    <input type="hidden" id="listId" name="listId">
                    <div class="form-group">
                        <label for="cardName">Card Name</label>
                        <input type="text" class="form-control" id="cardName" name="cardName" required>
                    </div>
                    <div class="form-group">
                        <label for="cardDescription">Description</label>
                        <textarea class="form-control" id="cardDescription" name="cardDescription" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cardStartDate">Start Date</label>
                        <input type="date" class="form-control" id="cardStartDate" name="cardStartDate">
                    </div>
                    <div class="form-group">
                        <label for="cardEndDate">End Date</label>
                        <input type="date" class="form-control" id="cardEndDate" name="cardEndDate">
                    </div>
                    <div class="form-group">
                        <label for="cardProgress">Progress</label>
                        <input type="number" class="form-control" id="cardProgress" name="cardProgress" min="0" max="100" step="1">
                    </div>
                    <div class="form-group">
                        <label for="cardAssignedTo">Assigned To</label>
                        <select class="form-control" id="cardAssignedTo" name="cardAssignedTo">
                            <option value="">Select User</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user->username ?>"><?= $user->nama_pegawai ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Card</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    // Add List
    $('#list-form').submit(function(event) {
        event.preventDefault();
        var listName = $('#list-name').val();
        var boardId = $('#board-id').val();

        $.ajax({
            url: '<?php echo base_url(); ?>lists/create',
            type: 'POST',
            data: { list_name: listName, board_id: boardId },
            success: function(response) {
                toastr.success('List added successfully!');
                $('#listModal').modal('hide');
                location.reload(); // Refresh the page to see the changes
            },
            error: function() {
                toastr.error('An error occurred while adding the list.');
            }
        });
    });

    // Add/Edit Card
    $('#card-form').submit(function(event) {
        event.preventDefault();
        var cardId = $('#card-id').val();
        var cardName = $('#card-name').val();
        var cardDescription = $('#card-description').val();
        var listId = $('#card-list-id').val();
        var url = cardId ? 'cards/edit/' + cardId : 'cards/create';

        $.ajax({
            url: '<?php echo base_url(); ?>' + url,
            type: 'POST',
            data: { card_name: cardName, card_description: cardDescription, list_id: listId },
            success: function(response) {
                toastr.success('Card saved successfully!');
                $('#cardModal').modal('hide');
                location.reload(); // Refresh the page to see the changes
            },
            error: function() {
                toastr.error('An error occurred while saving the card.');
            }
        });
    });

    // Edit Card
    $('.edit-card').click(function() {
        var cardId = $(this).data('id');
        var cardName = $(this).closest('.card').find('.card-title').text();
        var cardDescription = $(this).closest('.card').find('.card-text').text();
        var listId = $(this).closest('.card-draggable').data('list-id');

        $('#card-id').val(cardId);
        $('#card-name').val(cardName);
        $('#card-description').val(cardDescription);
        $('#card-list-id').val(listId);
        $('#cardModalLabel').text('Edit Card');
        $('#cardModal').modal('show');
    });

    // Delete Card
    $('.delete-card').click(function() {
        if(confirm('Are you sure you want to delete this card?')) {
            var cardId = $(this).data('id');

            $.ajax({
                url: '<?php echo base_url(); ?>cards/delete/' + cardId,
                type: 'POST',
                success: function(response) {
                    toastr.success('Card deleted successfully!');
                    location.reload(); // Refresh the page to see the changes
                },
                error: function() {
                    toastr.error('An error occurred while deleting the card.');
                }
            });
        }
    });

    // Add Card to List
    $('.add-card').click(function() {
        var listId = $(this).data('list-id');
        $('#card-list-id').val(listId);
        $('#cardModalLabel').text('Add Card');
        $('#card-id').val('');
        $('#card-name').val('');
        $('#card-description').val('');
        $('#cardModal').modal('show');
    });

    // Make Lists and Cards Sortable
    $('.list-container').sortable({
        connectWith: '.list-unstyled',
        placeholder: 'ui-state-highlight',
        start: function(event, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(event, ui) {
            var cardId = ui.item.data('id');
            var newListId = $(this).data('id');

            if (newListId !== ui.item.data('list-id')) {
                $.ajax({
                    url: '<?php echo base_url(); ?>cards/update_card_list',
                    type: 'POST',
                    data: { card_id: cardId, list_id: newListId },
                    success: function(response) {
                        toastr.success('Card moved successfully!');
                    },
                    error: function() {
                        toastr.error('An error occurred while moving the card.');
                    }
                });
            }
        }
    }).disableSelection();

    $('.list-unstyled').sortable({
        connectWith: '.list-unstyled',
        placeholder: 'ui-state-highlight',
        start: function(event, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(event, ui) {
            var cardId = ui.item.data('id');
            var newListId = $(this).closest('.list-container').data('id');

            if (newListId !== ui.item.data('list-id')) {
                $.ajax({
                    url: '<?php echo base_url(); ?>cards/update_card_list',
                    type: 'POST',
                    data: { card_id: cardId, list_id: newListId },
                    success: function(response) {
                        toastr.success('Card moved successfully!');
                    },
                    error: function() {
                        toastr.error('An error occurred while moving the card.');
                    }
                });
            }
        }
    }).disableSelection();
});
</script>

<script>
    // Open Modal for Add Card
function showAddCardModal(listId) {
    $('#cardForm')[0].reset(); // Reset the form
    $('#cardId').val(''); // Clear card ID
    $('#listId').val(listId); // Set the list ID
    $('#cardModalLabel').text('Add Card');
    $('#cardModal').modal('show');
}

// Open Modal for Edit Card
function showEditCardModal(cardId) {
    $.ajax({
        url: "<?= base_url('cards/get_card') ?>/" + cardId,
        type: "GET",
        dataType: "json",
        success: function(card) {
            $('#cardId').val(card.id);
            $('#listId').val(card.id_list);
            $('#cardName').val(card.name);
            $('#cardDescription').val(card.description);
            $('#cardStartDate').val(card.start_date);
            $('#cardEndDate').val(card.end_date);
            $('#cardProgress').val(card.progress);
            $('#cardAssignedTo').val(card.assigned_to); // Set the value of username in the dropdown
            $('#cardModalLabel').text('Edit Card');
            $('#cardModal').modal('show');
        },
        error: function() {
            alert("Failed to retrieve card details");
        }
    });
}


// Handle Form Submission
$('#cardForm').submit(function(e) {
    e.preventDefault();
    var url = $('#cardId').val() ? "<?= base_url('cards/update') ?>" : "<?= base_url('cards/create') ?>";
    $.ajax({
        url: url,
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            $('#cardModal').modal('hide');
            location.reload();
        },
        error: function() {
            alert("Failed to save card");
        }
    });
});

</script>

</body>
</html>

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
<div class="container mt-5">
    <h1 class="mb-4"><?php echo $board['board_name']; ?></h1>
    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#listModal">Add List</button>
    <div class="row">
        <?php foreach($lists as $list): ?>
            <div class="col-md-4 mb-4">
                <div class="list-container" data-id="<?php echo $list->id; ?>">
                    <div class="list-header">
                        <h4><?php echo $list->list_name; ?></h4>
                        <button class="btn btn-secondary btn-sm add-card" data-list-id="<?php echo $list->id; ?>">Add Card</button>
                    </div>
                    <ul id="list-<?php echo $list->id; ?>" class="list-unstyled">
                        <?php foreach($list->cards as $card): ?>
                            <li class="card-draggable mb-3" data-id="<?php echo $card->id; ?>" data-list-id="<?php echo $list->id; ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $card->name; ?></h5>
                                        <p class="card-text"><?php echo $card->description; ?></p>
                                        <button class="btn btn-warning edit-card" data-id="<?php echo $card->id; ?>">Edit</button>
                                        <button class="btn btn-danger delete-card" data-id="<?php echo $card->id; ?>">Delete</button>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
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

<!-- Card Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Add Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="card-form">
                    <input type="hidden" id="card-id">
                    <input type="hidden" id="card-list-id">
                    <div class="form-group">
                        <label for="card-name">Card Name</label>
                        <input type="text" class="form-control" id="card-name" required>
                    </div>
                    <div class="form-group">
                        <label for="card-description">Card Description</label>
                        <textarea class="form-control" id="card-description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
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

</body>
</html>

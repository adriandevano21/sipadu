<!DOCTYPE html>
<html>
<head>
    <title>Cards</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Cards</h1>
    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#cardModal">Add Card</button>
    <div id="cards" class="row">
        <?php foreach($cards as $card): ?>
            <div class="col-md-4 mb-3">
                <div class="card" data-id="<?php echo $card->id; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $card->card_name; ?></h5>
                        <p class="card-text"><?php echo $card->card_description; ?></p>
                        <button class="btn btn-warning edit-card">Edit</button>
                        <button class="btn btn-danger delete-card">Delete</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
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
                    <div class="form-group">
                        <label for="card-name">Card Name</label>
                        <input type="text" class="form-control" id="card-name" required>
                    </div>
                    <div class="form-group">
                        <label for="card-description">Card Description</label>
                        <textarea class="form-control" id="card-description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#card-form').submit(function(event) {
        event.preventDefault();
        var cardId = $('#card-id').val();
        var cardName = $('#card-name').val();
        var cardDescription = $('#card-description').val();
        var url = cardId ? 'cards/edit/' + cardId : 'cards/create';

        $.ajax({
            url: '<?php echo base_url(); ?>' + url,
            type: 'POST',
            data: { card_name: cardName, card_description: cardDescription },
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

    $('.edit-card').click(function() {
        var cardId = $(this).closest('.card').data('id');
        var cardName = $(this).closest('.card').find('.card-title').text();
        var cardDescription = $(this).closest('.card').find('.card-text').text();

        $('#card-id').val(cardId);
        $('#card-name').val(cardName);
        $('#card-description').val(cardDescription);
        $('#cardModalLabel').text('Edit Card');
        $('#cardModal').modal('show');
    });

    $('.delete-card').click(function() {
        if(confirm('Are you sure you want to delete this card?')) {
            var cardId = $(this).closest('.card').data('id');

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
});
</script>
</body>
</html>

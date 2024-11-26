<!DOCTYPE html>
<html>
<head>
    <title>Lists</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Lists</h1>
    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#listModal">Add List</button>
    <div id="lists" class="row">
        <?php foreach($lists as $list): ?>
            <div class="col-md-4 mb-3">
                <div class="card" data-id="<?php echo $list->id; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $list->list_name; ?></h5>
                        <button class="btn btn-warning edit-list">Edit</button>
                        <button class="btn btn-danger delete-list">Delete</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
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
                    <input type="hidden" id="list-id">
                    <div class="form-group">
                        <label for="list-name">List Name</label>
                        <input type="text" class="form-control" id="list-name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#list-form').submit(function(event) {
        event.preventDefault();
        var listId = $('#list-id').val();
        var listName = $('#list-name').val();
        var url = listId ? 'lists/edit/' + listId : 'lists/create';

        $.ajax({
            url: '<?php echo base_url(); ?>' + url,
            type: 'POST',
            data: { list_name: listName },
            success: function(response) {
                toastr.success('List saved successfully!');
                $('#listModal').modal('hide');
                location.reload(); // Refresh the page to see the changes
            },
            error: function() {
                toastr.error('An error occurred while saving the list.');
            }
        });
    });

    $('.edit-list').click(function() {
        var listId = $(this).closest('.card').data('id');
        var listName = $(this).closest('.card').find('.card-title').text();

        $('#list-id').val(listId);
        $('#list-name').val(listName);
        $('#listModalLabel').text('Edit List');
        $('#listModal').modal('show');
    });

    $('.delete-list').click(function() {
        if(confirm('Are you sure you want to delete this list?')) {
            var listId = $(this).closest('.card').data('id');

            $.ajax({
                url: '<?php echo base_url(); ?>lists/delete/' + listId,
                type: 'POST',
                success: function(response) {
                    toastr.success('List deleted successfully!');
                    location.reload(); // Refresh the page to see the changes
                },
                error: function() {
                    toastr.error('An error occurred while deleting the list.');
                }
            });
        }
    });
});
</script>
</body>
</html>

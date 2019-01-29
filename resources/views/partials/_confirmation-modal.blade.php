<!-- Modal -->
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal{{ $id }}">&times;</button>
            <h4 class="modal-title">{{ $title }}</h4>
        </div>
        <div class="modal-body">
            <p>{{ $message }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal{{ $id }}">Cancel</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal{{ $id }}" onclick="{{ $action }}">Delete</button>
        </div>
        </div>
    </div>
</div>
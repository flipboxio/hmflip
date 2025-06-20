<footer class="main-footer f-14">
	<div class="pull-right hidden-xs">
		{{ __(appVersion()) }}
	</div>
		<strong>Copyright &copy; 2016-{{ date('Y') }} <a href="#">{{ siteName() }}</a>.</strong> All rights reserved.
</footer>

<!-- Modal -->
<div class="modal fade z-index-medium" id="delete-warning-modal" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content w-100 h-100 aliceblue">
            <div class="modal-header">
                <h4 class="modal-title f-18">Confirm Delete</h4>
                <a type="button" class="close f-18" data-bs-dismiss="modal">×</a>
            </div>
            <div class="p-3 f-14">
                <p>You are about to delete one track, this procedure is irreversible.</p>
				<p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger f-14" id="delete-modal-yes" href="javascript:void(0)">Yes</a>
                <button type="button" class="btn btn-default f-14" data-bs-dismiss="modal">No</button>
            </div>
        </div>
	</div>
</div>

@push('scripts')
<script src="{{ asset('public/backend/js/admin-footer.min.js') }}"></script>
@endpush

<!-- Modal -->
<div class="modal fade" id="blockProfileModal" tabindex="-1" role="dialog" aria-labelledby="blockProfileModalLabel" data-bs-backdrop="static"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="blockProfileModalLabel">
                    <i class="bi bi-check2-square"></i> @lang('Confirmation')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" value="{{ $user }}">
            <form method="post" action="" class="blockProfileAction" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @php
                        $choice = $user->status == 1 ? 'block' : 'unblock';
                        $message = 'Do you want to '.$choice. ' this user profile?'
                    @endphp
                    @lang($message)
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).on("click", '.blockProfile', function (e) {
            let data = $(this).data();
            let route = data.route;
            document.querySelector('.blockProfileAction').setAttribute('action', route);
        });
    </script>
@endpush



<td colspan="100%" class="text-center">
    <div class="table-not-found">
        <img src="{{asset('assets/admin/img/oc-error-light.svg')}}" alt="no-data" class="no-data-img">
        <span class="mt-3">@lang('No data found')</span>
    </div>
</td>

@push('style')
    <style>
        .no-data-img{
            height: 200px;
            width: 200px;
        }
        .table-not-found {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-bottom: 20px;
        }
    </style>
@endpush

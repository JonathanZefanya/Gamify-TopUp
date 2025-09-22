@extends('admin.layouts.app')
@section('page_title', __('Blog Category'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Blog Category')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Blog Category')</h1>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">@lang('Add Category')</h4>
                <a href="{{ route('admin.blog-category.create') }}" class="btn btn-primary">@lang('Add Category')</a>
            </div>

            <div class="table-responsive">
                <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($blogCategory as $key => $category)
                        <tr>
                            <td>{{ $loop->index + 1  }}</td>
                            <td>
                                @lang($category->name)
                            </td>
                            <td>
                                @if($category->status == 1)
                                    <span class="badge bg-soft-success text-success">
                                        <span class="legend-indicator bg-success"></span>@lang('Active')
                                    </span>
                                @elseif($category->status == 0)
                                    <span class="badge bg-soft-warning text-warning">
                                        <span class="legend-indicator bg-warning"></span>@lang('Inactive')
                                    </span>
                                @else
                                    <span class="badge bg-soft-info text-info">
                                        <span class="legend-indicator bg-info"></span>@lang('Unknown')
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-white btn-sm" href="{{ route('admin.blog-category.edit', $category->id) }}">
                                        <i class="bi-pencil-fill me-1"></i> Edit
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="productsEditDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>

                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="productsEditDropdown1">
                                            <a class="dropdown-item statusBtn text-dark"
                                               href="javascript:void(0)"
                                               data-route="{{ route("admin.blog-category.status", $category->id) }}"
                                               data-bs-toggle="modal" data-bs-target="#statusModal">
                                                <i class="bi-check-circle dropdown-item-icon text-dark"></i> @lang("Status")
                                            </a>
                                            <a class="dropdown-item deleteBtn text-danger"
                                               href="javascript:void(0)"
                                               data-route="{{ route("admin.blog-category.destroy", $category->id) }}"
                                               data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi-trash dropdown-item-icon text-danger"></i> @lang("Delete")
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty"><div class="text-center p-4">
                                    <img class="mb-3 dataTables-image" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                    <img class="mb-3 dataTables-image" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                                    <p class="mb-0">@lang("No data to show")</p>
                                </div></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="statusModalLabel"><i
                            class="bi bi-check2-square"></i> @lang('Confirmation')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="get" class="setStatusRoute">
                    @method('get')
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to change the status of this item? This action cannot be undone and will affect the current status of the item.')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel"><i
                            class="bi bi-check2-square"></i> @lang("Confirmation")</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="setRoute">
                    @csrf
                    @method("delete")
                    <div class="modal-body">
                        <p>@lang("Do you want to delete this category")</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->
@endsection

@push('script')
    <script>
        "use script";
        $(document).ready(function () {
            $('.deleteBtn').on('click', function () {
                let route = $(this).data('route');
                $('.setRoute').attr('action', route);
            })
            $('.statusBtn').on('click', function () {
                let route = $(this).data('route');
                $('.setStatusRoute').attr('action', route);
            })
        })
    </script>
@endpush




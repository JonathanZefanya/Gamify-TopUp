@extends('admin.layouts.app')
@section('page_title',__('Role List'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang("Dashboard")</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang("Role List")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Role List")</h1>
                </div>
            </div>
        </div>


        <div class="card" id="test">
            <div class="card-header card-header-content-between">
                <div class="mb-2 mb-md-0">

                    <div class="input-group input-group-merge navbar-input-group">
                        <div class="input-group-prepend input-group-text">
                            <i class="bi-search"></i>
                        </div>
                        <input type="search" id="datatableSearch"
                               class="search form-control form-control-sm"
                               placeholder="@lang('Search Role... ')"
                               aria-label="@lang('Search Role... ')"
                               autocomplete="off">
                        <a class="input-group-append input-group-text display-none" href="javascript:void(0)">
                            <i id="clearSearchResultsIcon" class="bi-x"></i>
                        </a>
                    </div>

                </div>
                @if(adminAccessRoute(config('role.manage_staff.access.add')))
                    <a class="btn btn-primary addNewBtn" href="javascript:void(0)" data-bs-toggle="modal"
                       data-bs-target="#AddRoleModal"> <i class="fa-duotone fa-solid fa-plus me-1"></i> @lang('Add New')
                    </a>
                @endif
            </div>

            <div class=" table-responsive datatable-custom  ">
                <table id="datatable"
                       class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                       "columnDefs": [{
                          "targets": [0, 3],
                          "orderable": false
                        }],
                       "order": [],
                       "info": {
                         "totalQty": "#datatableWithPaginationInfoTotalQty"
                       },
                       "search": "#datatableSearch",
                       "entries": "#datatableEntries",
                       "pageLength": 15,
                       "isResponsive": false,
                       "isShowPaging": false,
                       "pagination": "datatablePagination"
                     }'>
                    <thead class="thead-light">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">@lang('Showing:')</span>
                            <!-- Select -->
                            <div class="tom-select-custom">
                                <select id="datatableEntries"
                                        class="js-select form-select form-select-borderless w-auto" autocomplete="off"
                                        data-hs-tom-select-options='{
                                            "searchInDropdown": false,
                                            "hideSearch": true
                                          }'>
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">@lang('of')</span>
                            <span id="datatableWithPaginationInfoTotalQty"></span>
                        </div>
                    </div>


                    <div class="col-sm-auto">
                        <div class="d-flex  justify-content-center justify-content-sm-end">
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                </div>
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
                <form action="" method="post" id="setRoute">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>@lang("Do you want to delete this Item")</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="AddRoleModal" tabindex="-1" role="dialog"
         aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h4" id="myExtraLargeModalLabel">@lang('Add Roles')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.role.create')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="">@lang('Name')</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="@lang('Name')" name="name" required/>
                            <span class="text-danger name-error"></span>
                        </div>
                        <div class="col-md-12 my-3">
                            <div class="list-group-item mb-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div class="row align-items-center">
                                            <div class="col-sm mb-2 mb-sm-0">
                                                <label class="form-label"
                                                       for="">@lang('Status')</label>
                                                <p class="fs-5 text-body mb-0">@lang('If you enable this role , then please turn on this button.')</p>
                                            </div>
                                            <div class="col-sm-auto d-flex align-items-center">
                                                <div class="form-check form-switch form-switch-google">
                                                    <input type="hidden" name="status" value="0">
                                                    <input class="form-check-input" name="status"
                                                           type="checkbox" id="addStaffStatus"
                                                           value="1">
                                                    <label class="form-check-label"
                                                           for="addStaffStatus"></label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 px-0">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between text-center">
                                    <h5 class="card-title text-center">{{trans('Accessibility')}}</h5>
                                </div>

                                <div class="card-body select-all-access">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" id="formCheck11" name="accessAll"
                                               class="form-check-input selectAll">
                                        <label class="form-check-label"
                                               for="formCheck11">{{trans('Select All')}}</label>
                                    </div>


                                    <table class=" table table-hover table-striped table-bordered text-center">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-left">@lang('Module')</th>
                                            <th class="text-left">@lang('Permissions')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(config('role') as $key => $value)
                                            <tr>
                                                <td data-label="Permissions"
                                                    class="text-left">{{$value}}</td>

                                                <td><input type="checkbox"
                                                           value="{{title2snake($value)}}"
                                                           name="access[]"/></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade bd-example-modal-xl" id="EditRoleModal" tabindex="-1" role="dialog"
         aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h4" id="myExtraLargeModalLabel">@lang('Add Roles')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.role.update')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="" id="EditableRoleId">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="">@lang('Name')</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="@lang('Name')" id="editAbleRoleName" name="name" required/>
                            <span class="text-danger name-error"></span>
                        </div>
                        <div class="col-md-12 my-3">
                            <div class="list-group-item mb-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div class="row align-items-center">
                                            <div class="col-sm mb-2 mb-sm-0">
                                                <label class="form-label"
                                                       for="">@lang('Status')</label>
                                                <p class="fs-5 text-body mb-0">@lang('If you enable this role , then please turn on this button.')</p>
                                            </div>
                                            <div class="col-sm-auto d-flex align-items-center">
                                                <div class="form-check form-switch form-switch-google">
                                                    <input type="hidden" name="status" value="0">
                                                    <input class="form-check-input" name="status"
                                                           type="checkbox" id="editAbleRoleStatus"
                                                           value="1">
                                                    <label class="form-check-label"
                                                           for="addStaffStatus"></label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 px-0">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between text-center">
                                    <h5 class="card-title text-center">{{trans('Accessibility')}}</h5>
                                </div>

                                <div class="card-body select-all-access">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" id="formCheck11" name="accessAll"
                                               class="form-check-input selectAll">
                                        <label class="form-check-label"
                                               for="formCheck11">{{trans('Select All')}}</label>
                                    </div>


                                    <table class=" table table-hover table-striped table-bordered text-center">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-left">@lang('Module')</th>
                                            <th class="text-left">@lang('Permissions')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="editRoleTableTbody">
                                        @foreach(config('role') as $key => $value)
                                            <tr>
                                                <td data-label="Permissions"
                                                    class="text-left">{{$value}}</td>

                                                <td><input type="checkbox" id="checkbox-{{ $value }}"
                                                           value="{{title2snake($value)}}"
                                                           name="access[]"/></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div
@endsection
@push('js-lib')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
@endpush

@push('script')
    @if(count($errors) > 0 )
        <script>
            @foreach($errors->all() as $key => $error)
            Notiflix.Notify.failure("@lang($error)");
            @endforeach
        </script>
    @endif
@endpush

@push('script')
    <script>
        "use strict";

        $('.select-all-access').on('click', '.selectAll', function () {
            if ($(this).is(':checked')) {
                $(this).parents('.select-all-access').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $(this).parents('.select-all-access').find('input[type="checkbox"]').prop('checked', false);
            }
        });

        $(document).ready(function () {
            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route("admin.get.role.list") }}",
                },

                columns: [
                    {data: 'no', name: 'no'},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ],

                language: {
                    zeroRecords: `<div class="text-center p-4">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`,
                    processing: `<div><div></div><div></div><div></div><div></div></div>`
                },
            });

            $(document).on('click', '.DeleteBtn', function () {
                $('#setRoute').attr('action', $(this).data('route'));
            });

            $(document).on('click','.addNewBtn',function (){
                $('input[type="checkbox"]').prop('checked', false);
            });

            $(document).on('click', '.edit_role_btn', async function () {
                let id = $(this).data('id');
                let url = "{{ route('admin.get.role', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                await axios.get(url)
                    .then(function (res) {
                        renderEditForm(res.data)
                    })
                    .catch(function (error) {

                    });
            })

            function renderEditForm(data) {
                $('input[type="checkbox"]').prop('checked', false);
                $('#editAbleRoleName').val(data.role.name);
                $('#EditableRoleId').val(data.role.id);
                if (data.role.status == 1) {
                    $('#editAbleRoleStatus').prop('checked', true);
                }

                $.each(data.role.permission, function (index, value) {
                    $('input[type="checkbox"][value="' + value + '"]').prop('checked', true)
                });
            }

        })
    </script>
@endpush

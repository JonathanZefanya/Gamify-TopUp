<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-no-gutter">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="{{route('user.dashboard')}}">@lang("Dashboard")</a>
                    </li>
                    @isset($menu)
                        <li class="breadcrumb-item active" aria-current="page">
                            @lang($menu)
                        </li>
                    @endif
                    @isset($submenu)
                        <li class="breadcrumb-item active" aria-current="page">
                            @lang($submenu)
                        </li>
                    @endif
                </ol>
            </nav>
            <h1 class="page-header-title">
                @isset($pagetitle)
                    @lang($pagetitle)
                @else
                    @hasSection('page_title')
                        @yield('page_title')
                    @else
                        @yield('title')
                    @endif
                @endif
            </h1>

            @isset($exportImport)
                <div class="mt-2">
                    <a class="text-body me-3" href="javascript:void(0)" data-bs-toggle="modal"
                       data-bs-target="#exportProductsModal">
                        <i class="bi-download me-1"></i> @lang('Export')
                    </a>
                    <a class="text-body" href="javascript:void(0)" data-bs-toggle="modal"
                       data-bs-target="#importProductsModal">
                        <i class="bi-upload me-1"></i> @lang('Import')
                    </a>
                </div>
            @endif

        </div>

        <div class="col-sm-auto">
            @if($statBtn ?? false)
                <a class="btn btn-primary btn-sm statBtn" href="javascript:;" id="toggleStats">
                    <i class="bi-receipt"></i> @lang('See Stats')
                </a>
                @push('script')
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            let button = document.getElementById('toggleStats');
                            let statsSection = document.getElementById('statsSection');

                            if (localStorage.getItem('statsVisible') === 'true') {
                                statsSection.classList.remove('d-none');
                                button.innerHTML = `<i class="bi-receipt"></i> {{ __('Hide Stats') }}`;
                            }

                            button.addEventListener('click', function () {
                                statsSection.classList.toggle('d-none');
                                let isVisible = !statsSection.classList.contains('d-none');
                                localStorage.setItem('statsVisible', isVisible);
                                button.innerHTML = isVisible
                                    ? `<i class="bi-receipt"></i> {{ __('Hide Stats') }}`
                                    : `<i class="bi-receipt"></i> {{ __('See Stats') }}`;
                            });
                        });

                    </script>
                @endpush
            @endif
        </div>
    </div>
</div>





@extends($extends)
@section('title')
    {{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection
@section('content')
    @php
        $containerClass = (str_ends_with($extends, 'user') && auth()->user()->active_dashboard == 'daybreak')
            ? 'container'
            : (str_ends_with($extends, 'user') ? '' : 'main-content');
    @endphp
    <div class="{{ $containerClass }}">
        @if(str_ends_with($extends, 'user') && auth()->user()->active_dashboard == 'daybreak')
            <div class="pagetitle mt-20">
                <h4 class="mb-1">{{ optional($deposit->gateway)->name }}</h4>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">{{ optional($deposit->gateway)->name }}</li>
                    </ol>
                </nav>
            </div>
        @elseif(str_ends_with($extends, 'user') && auth()->user()->active_dashboard == 'nightfall')
            <div class="pagetitle">
                <h3 class="mb-1">{{ optional($deposit->gateway)->name }}</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">{{ optional($deposit->gateway)->name }}</li>
                    </ol>
                </nav>
            </div>
        @endif
        <div class="card d-flex justify-content-center align-items-center manualBorderCar">
            <div class="col-md-9">
                <div class="card-body">
                        <form action="{{route('addFund.fromSubmit',$deposit->trx_id)}}" method="post"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="section-header">
                                <h3>@lang('Please follow the instruction below')</h3>
                                <div class="description">{{trans('You have requested to')}} <b
                                        class="text--base">{{currencyPosition($deposit->amount_in_base)}}</b>
                                    , {{trans('Please pay')}}
                                    <b class="text--base">{{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</b> {{trans('for successful payment')}}
                                </div>
                                <div class="description"><?php echo optional($deposit->gateway)->note; ?>
                                </div>
                            </div>
                            <div class="row g-2">
                                @if(optional($deposit->gateway)->parameters)
                                    @foreach($deposit->gateway->parameters as $k => $v)
                                        @if($v->type == "text")
                                            <div class="col-12 pt-2">
                                                <label
                                                    class="mb-2">{{trans($v->field_label)}} {{$v->validation == 'required'?'':'(optional)'}}</label>
                                                <input type="{{$v->type}}" name="{{$k}}" class="form-control" id="exampleInputEmail1" {{$v->validation == "required" ? 'required':''}}>
                                                @if ($errors->has($k))
                                                    <span
                                                        class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "textarea")
                                            <div class="col-12">
                                                <label
                                                    class="mb-2">{{trans($v->field_label)}} {{$v->validation == 'required'?'':'(optional)'}}</label>
                                                <textarea class="form-control" name="{{$k}}" {{$v->validation == "required" ? 'required':''}}></textarea>
                                                @if ($errors->has($k))
                                                    <span
                                                        class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "file")
                                            <div class="col-12">
                                                <label>{{trans($v->field_label)}} {{$v->validation == 'required'?'':'(optional)'}}</label>
                                                <div class="profile-details-section">
                                                    <div class="d-flex gap-3 align-items-center manualPayBox">
                                                        <div class="image-area">
                                                            <img id="profile-img" src="{{getFile('dummy','dummy')}}" alt="Profile Image" style="width: 150px; height: 150px; object-fit: cover;">
                                                        </div>
                                                        <div class="btn-area">
                                                            <div class="btn-area-inner d-flex">
                                                                <div class="cmn-file-input">
                                                                    <label for="formFile" class="form-label">@lang('Upload New Photo')</label>
                                                                    <input class="form-control" type="file" name="{{$k}}" id="formFile" onchange="previewImageTwo(event, 'profile-img')">
                                                                </div>
                                                            </div>
                                                            <small>@lang('Allowed JPG,JPEG,PNG. Max size of 1MB')</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error($k)
                                                <span class="text-danger">@lang($message)</span>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100">
                                <span>@lang('Submit Now')</span></button>
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        function previewImageTwo(event, imgId) {
            const fileInput = event.target;
            const previewImg = document.getElementById(imgId);

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
@endpush

@push('style')
    <style>
        .image-area img{
            height: 100px;
            width: 100px;
            border-radius: 10px;
        }
        .form-control{
            height: 39px !important;
        }
        .manualCard{
            margin: 40px;
        }
        .manualBorderCar{
            border-radius: 0 !important;
        }
        .manualBorderCar .card-body{
            background: var(--bg-color2);
            border-radius: 13px;
            padding: 65px !important;        }
    </style>
@endpush


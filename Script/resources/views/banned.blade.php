@extends(template().'layouts.app')
@section('page_title',__('User Banned'))

@section('content')
    <section class="banned-section">
        <div class="container">
            <div class="bannedThumb">
                <img src="{{ asset('assets/global/img/banned.png') }}" />
            </div>
            <div class="messageArea text-center">
                <div class="title">
                    <h3>@lang('!!!BANNED!!!')</h3>
                    <p>@lang('You are banned from this application. Please contact with system Administrator.')</p>
                </div>
                <div class="contactInformation">
                    <h5>@lang('Contact Information')</h5>
                    <ul>
                        <li>
                            <span class="info_Title">@lang('Email: ')</span><span class="info_Value">{{ basicControl()->sender_email }}</span>
                        </li>
                        <li>
                            <span class="info_Title">@lang('phone: ')</span><span class="info_Value">{{ basicControl()->contact_number  }}</span>
                        </li>
                    </ul>
                </div>
                <div class="footerArea">
                    <a class="cmn-btn w-100" href="{{ route('page','/') }}">@lang('Back To Home')</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .banned-section{
            padding: 100px;
        }

        .banned-section{
            min-height: 100vh;
            max-width: 100%;
            background-color: var(--bg-color1);
        }
        .banned-section .container .bannedThumb {
            padding: 0 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .banned-section .container .bannedThumb img{
            height: 200px;
            width: 200px;
        }
        .banned-section .container .messageArea{
            margin: 20px;
        }

        .banned-section .container .messageArea .title{
            padding: 20px;
        }
        .banned-section .container .messageArea .title h3{
            color: red;
            font-weight: 700;
            font-size: 40px;
        }
        .banned-section .container .messageArea .title p{
            font-size: 18px;
            font-weight: 400;
        }

        .banned-section .container .messageArea .contactInformation{
            padding: 0 20px 20px 20px;
        }
        .banned-section .container .messageArea .contactInformation li{
            list-style: none;
        }
        .banned-section .container .messageArea .contactInformation h5{
            font-size: 25px;
            font-weight: 500;
            padding: 5px;
        }
        .banned-section .container .messageArea .contactInformation .info_Title{
            font-size: 18px;
            font-weight: bold;
            padding: 3px;
        }
        .banned-section .container .messageArea .contactInformation .info_Value{
            font-size: 14px;
            padding: 3px;
        }

        .banned-section .container .messageArea .footerArea{
            padding:0 20px 20px 20px;
        }
    </style>
@endpush


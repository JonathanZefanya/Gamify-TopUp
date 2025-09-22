<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/themes/dark/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/jquery-ui.css')}}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .pwa-payment-section {
            height: 100vh;
        }

        .pwa-payment-section .pay-box .btn-custom {
            background: #fff;
            color: #32d6d8;
            border-radius: 50px;
            font-weight: 500;
            padding: 15px;
            border: none;
        }

        .pwa-payment-section .pay-box {
            box-shadow: 5px 2px 30px rgba(0, 0, 0, 0.06);
            background: url(../../assets/card-bg-2.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top right;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 0;
            width: 100%;
        }

        .pwa-payment-section .pay-box .img-box {
            width: 100px;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .pwa-payment-section .pay-box .text-box {
            padding-left: 20px;
        }
        .pwa-payment-section .pay-box p {
            overflow-wrap: break-word;
            font-weight: 500;
        }

        .pwa-payment-section .pay-box .img-box img {
            object-fit: contain;
        }
    </style>
</head>
<body class="">
@yield('content')
@stack('script')

<script src="{{asset(template(true).'js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery/jquery-ui.js')}}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>

@if (session()->has('success'))
    <script>
        Notiflix.Notify.success("@lang(session('success'))");
    </script>
@endif

@if (session()->has('error'))
    <script>
        Notiflix.Notify.failure("@lang(session('error'))");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        Notiflix.Notify.warning("@lang(session('warning'))");
    </script>
@endif

</body>
</html>

<!--Start of Google analytic Script-->
@if(basicControl()->analytic_status)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{basicControl()->measurement_id}}"></script>
    <script>
        "use strict";
        var MEASUREMENT_ID = "{{ basicControl()->measurement_id }}";
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', MEASUREMENT_ID);
    </script>
@endif
<!--End of Google analytic Script-->


<!--Start of Tawk.to Script-->
@if(basicControl()->tawk_status)
    <script type="text/javascript">
        var Tawk_SRC = 'https://embed.tawk.to/' + "{{ trim(basicControl()->tawk_id) }}";
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = Tawk_SRC;
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif


<!--start of Facebook Messenger Script-->
@if(basicControl()->fb_messenger_status)
    <div id="fb-root"></div>
    <script>
        "use strict";
        var fb_app_id = "{{ basicControl()->fb_app_id }}";
        window.fbAsyncInit = function () {
            FB.init({
                appId: fb_app_id,
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v10.0'
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <div class="fb-customerchat" page_id="{{ basicControl()->fb_page_id }}"></div>
@endif
<!--End of Facebook Messenger Script-->

<script>

    var root = document.querySelector(':root');

    @if(getTheme() == 'light')
    root.style.setProperty('--primary-color', hexToRGB('{{basicControl()->light_primary_color}}'));
    @else
    root.style.setProperty('--primary-color', hexToRGB('{{basicControl()->dark_primary_color}}'));
    @endif


    function hexToRGB(hex) {
        let r = 0, g = 0, b = 0;
        if (hex.length === 4) {
            r = parseInt(hex[1] + hex[1], 16);
            g = parseInt(hex[2] + hex[2], 16);
            b = parseInt(hex[3] + hex[3], 16);
        } else if (hex.length === 7) {
            r = parseInt(hex.substring(1, 3), 16);
            g = parseInt(hex.substring(3, 5), 16);
            b = parseInt(hex.substring(5, 7), 16);
        }
        return `${r}, ${g}, ${b}`;
    }

</script>


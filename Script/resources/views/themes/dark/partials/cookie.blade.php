@if(basicControl()->cookie_status == 1)
    <div id="cookieAlert" class="cookie-content" style="display: none;">
        <h4>
            <i class="fad fa-cookie-bite"></i>
            @lang(basicControl()->cookie_heading)
        </h4>
        <p>
            @lang(\Illuminate\Support\Str::limit(basicControl()->cookie_description, 180))
            @lang('By continuing to use our website, you agree to our')
            <a class="cookieSeemoreButton" href="{{ url('/cookie-policy') }}">@lang(basicControl()->cookie_button)</a>
        </p>
        <div class="cookie-btns d-flex justify-content-center align-items-center gap-2">
            <a href="javascript:void(0);" class="cmn-btn justify-content-center text-light" type="button" onclick="acceptCookiePolicy()">@lang('Accept')</a>
            <a href="javascript:void(0);" class="cmn-btn close-btn text-light" type="button" onclick="closeCookieBanner()">@lang('Close')</a>
        </div>
    </div>

    <script>
        function acceptCookiePolicy() {
            localStorage.setItem("cookie_policy_accepted", "true");
            hideCookieBanner();
        }

        function closeCookieBanner() {
            hideCookieBanner();
        }

        function hideCookieBanner() {
            const banner = document.getElementById("cookieAlert");
            if (banner) {
                banner.style.display = "none";
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const hasAccepted = localStorage.getItem("cookie_policy_accepted");
            const banner = document.getElementById("cookieAlert");

            if (!hasAccepted && banner) {
                banner.style.display = "block"
            }
        });
    </script>
@endif

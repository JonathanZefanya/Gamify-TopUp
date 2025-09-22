@php
    $siteTitle = basicControl()->site_title;
    $baseUrl = url('/').'/api/'
@endphp
<main>
    {{--    GETTING STARTED--}}
    @include(template().'partials.docx.sidebar')
    <div class="main-wrapper">
        <div class="row g-4">
            <div class="col-12">
                <h3 class="docs-section-title">
                    @lang('Getting Started')
                </h3>
                <div class="docs-section" id="introduction">
                    <h4 class="docs-title">@lang('#Introduction')</h4>
                    <p>
                        @lang("The $siteTitle API is organized around REST. Our API has predictable resource-oriented URLs, accepts form-encoded request bodies,
                                                    returns JSON-encoded responses, and uses standard HTTP response codes, authentication, and verbs")
                    </p>
                    <h4 class="docs-title">@lang('API Protocols')</h4>
                    <p>@lang("Our APIs follow the general principles of REST")</p>
                    <ol>
                        <li class="mb-1 font-weight-bold">
                            @lang("1. We use standard <code>GET, POST</code> requests to communicate and HTTP response codes to show status and errors.")
                        </li>
                        <li class="mb-1 font-weight-bold">
                            @lang("2. You can expect all responses to be returned as JSON.")
                        </li>
                        <li class="mb-1 font-weight-bold">
                            @lang("3. The API request should have a Content-Type of application/json.")
                        </li>
                        <li class="mb-1 font-weight-bold">
                            @lang("4. All endpoints require authentication with your API Keys.")
                        </li>
                    </ol>
                </div>

                <div class="docs-section" id="authentication">
                    <h4 class="docs-title">@lang('#Authentication')</h4>
                    <h4 class="docs-title">@lang('Retrieving your API Keys')</h4>
                    <p>@lang("Your API keys are very vital to making requests successfully to our servers. To get your keys follow the instruction")</p>
                    <ol>
                        <li class="mb-1 font-weight-bold">
                            @lang("1. Log into your $siteTitle dashboard.")
                        </li>
                        <li class="mb-1 font-weight-bold">
                            @lang("2. Click Api Key from sidebar.")
                        </li>
                        <li class="mb-1 font-weight-bold">
                            @lang("3. Select the API Keys open in the Api Key section of the menu to view and copy your keys.")
                        </li>
                    </ol>
                    <h4 class="docs-title">@lang('Authorizing API calls')</h4>
                    <p>@lang("All API calls on $siteTitle are authenticated. API requests made without authorization will fail with the status : failed.")</p>
                    <P>@lang("To authorize API calls from your server, pass your <code>YOUR_PUBLIC_KEY</code> and <code>YOUR_SECRET_KEY</code> as a header of api request. This means passing an Authorization header with a value of PublicKey: <code>YOUR_PUBLIC_KEY</code> and SecretKey: <code>YOUR_SECRET_KEY</code>")</P>
                </div>
            </div>
        </div>
    </div>

    @include(template().'partials.docx.bearer')

    @include(template().'partials.docx.category')

    @include(template().'partials.docx.top_up')

    @include(template().'partials.docx.card')

    @include(template().'partials.docx.order-list')

    @include(template().'partials.docx.campaign')
</main>

<style>
    body {
        background: var(--bg-color2);
    }
</style>

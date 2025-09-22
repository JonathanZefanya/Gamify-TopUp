<div class="main-wrapper">
    <div class="row g-4">
        <div class="col-12">
            <h3 class="docs-section-title">
                @lang('Campaign')
            </h3>
            <div class="docs-section" id="getCampaign">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Campaign')</h4>
                        <p>
                            @lang("To get campaign list follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}get-campaign</i>
                        </p>
                        <p>
                            <b>@lang("API Key:")</b>
                            <span>@lang("Pass your <code>bearer token </code> to the authorization header") <a
                                    class="docs-link" href="#getBearer">GET Bearer</a></span>
                        </p>
                        <p>
                            <b>@lang("Response format:")</b>
                            <span>@lang("JSON")</span>
                        </p>
                        <hr>
                        <h5 class="mb-3">@lang("Response Body")</h5>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('id:')</b> <span> @lang('campaign id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('name:')</b> <span> @lang('campaign name')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('start_date:')</b>
                                    <span> @lang('when campaign start')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('end_date:')</b> <span> @lang('when campaign end')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('topups:')</b> <span> @lang('the list of top up services for campaign')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('cards:')</b> <span> @lang('the list of card services for campaign')</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="editor-header">
                                    <div class="cmn-tabs2">
                                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="cUrl-tab71"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl71" type="button" role="tab"
                                                        aria-controls="cUrl71"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab71" data-bs-toggle="pill"
                                                        data-bs-target="#PHP71" type="button" role="tab"
                                                        aria-controls="PHP71" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab71" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby71" type="button" role="tab"
                                                        aria-controls="Ruby71"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab71"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js71"
                                                        type="button" role="tab" aria-controls="Node-js71"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab71" data-bs-toggle="pill"
                                                        data-bs-target="#Python71" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js71" role="tabpanel"
                                             aria-labelledby="Node-js-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/get-campaign',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN'
  }
};
request(options, function (error, response) {
  if (error) throw new Error(error);
  console.log(response.body);
});





                                                                </code></pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                                                <span>16</span>
                                                                <span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                                            </span>
                                                </div>

                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="Python71" role="tabpanel"
                                             aria-labelledby="Python-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/get-campaign"

payload = {}
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN'
}

response = requests.request("GET", url, headers=headers, data=payload)

print(response.text)



</code></pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                                                <span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                                            </span>
                                                </div>
                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="PHP71" role="tabpanel"
                                             aria-labelledby="PHP-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/get-campaign', $headers);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();


                                                                </code></pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                                                <span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                                            </span>
                                                </div>
                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show active" id="cUrl71" role="tabpanel"
                                             aria-labelledby="cUrl-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/get-campaign' \
--header 'Authorization: YOUR_BEARER_TOKEN'
                                                                </code></pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                                                <span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                                            </span>
                                                </div>
                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="Ruby71" role="tabpanel"
                                             aria-labelledby="Ruby-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/get-campaign")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"

response = http.request(request)
puts response.read_body


</code></pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                                                <span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                                            </span>
                                                </div>
                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="editor-header">
                                    <div class="cmn-tabs2">
                                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="OK-tab71"
                                                        data-bs-toggle="pill" data-bs-target="#OK71"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab71"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request71"
                                                        type="button" role="tab" aria-controls="Bad-Request71"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK71" role="tabpanel"
                                             aria-labelledby="OK-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "campaign": {
            "id": 1,
            "name": "Flash Deal",
            "start_date": "2025-03-06",
            "end_date": "2025-03-31",
            "status": 1,
            "created_at": "2025-03-06T04:58:14.000000Z",
            "updated_at": "2025-03-06T04:58:14.000000Z",
            "topups": [
                {
                    "id": 1,
                    "top_up_id": 2,
                    "name": "MICO Live 88 Coins",
                    "price": 2.8,
                    "discount": 5,
                    "discount_type": "percentage",
                    "status": 1,
                    "offered_sell": 0,
                    "max_sell": 0,
                    "old_data": null,
                    "campaign_data": {
                        "price": "2.8",
                        "discount": "8",
                        "discount_type": "percentage",
                        "max_sell": "1000"
                    },
                    "created_at": "2025-03-04T09:57:49.000000Z",
                    "updated_at": "2025-03-06T04:58:15.000000Z",
                    "image_path": "http://192.168.0.123/gamers-arena/gamers/assets/upload/top-up-service/EOPdhKAMgfaPhI1VxN30StKN3xytZI.webp"
                },
                ....
            ],
            "cards": [
                {
                    "id": 2,
                    "card_id": 1,
                    "name": "Honor of Kings 80 Tokens",
                    "price": 2.45,
                    "discount": 1,
                    "discount_type": "percentage",
                    "status": 1,
                    "offered_sell": 0,
                    "max_sell": 0,
                    "old_data": null,
                    "campaign_data": {
                        "price": "2.45",
                        "discount": "15",
                        "discount_type": "percentage",
                        "max_sell": "1000"
                    },
                    "created_at": "2025-03-03T09:28:28.000000Z",
                    "updated_at": "2025-03-06T04:58:16.000000Z",
                    "image_path": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card-service/zEhj4vofwEQIWzzbpiMj5FeOkGzcpl.webp"
                },
                ....
            ]
        }
    }
}
                                                        </code></pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                                                <span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                                            </span>
                                                </div>
                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="Bad-Request71" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab71" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
{
    "status": "failed",
    "errors": "Something went wrong"
}
                                                            </code>
                                                            </pre>
                                                    <span class="line-numbers-rows">
                                                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span>
                                                            </span>
                                                </div>
                                                <button onclick="copyTextFunc()" class="copy-code"
                                                        type="button"><i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

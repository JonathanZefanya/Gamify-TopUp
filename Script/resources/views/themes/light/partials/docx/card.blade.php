<div class="main-wrapper">
    <div class="row g-4">
        <div class="col-12">
            <h3 class="docs-section-title">
                @lang('Card')
            </h3>
            <div class="docs-section" id="getCards">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Cards')</h4>
                        <p>
                            @lang("To get all the Card list follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}get-card</i>
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
                                    <b>@lang('id:')</b> <span> @lang('Card id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('category_id:')</b> <span> @lang('Card Category id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('name:')</b>
                                    <span> @lang('Card Name')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('slug:')</b> <span> @lang('Card Slug')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('status:')</b> <span> @lang('Card Status. It Should be 1 For All Active Card')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('product_image:')</b> <span> @lang('The Card Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('preview_image:')</b> <span> @lang('The Card Preview Image Url Path')</span>
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
                                                <button class="nav-link active" id="cUrl-tab9"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl9" type="button" role="tab"
                                                        aria-controls="cUrl9"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab9" data-bs-toggle="pill"
                                                        data-bs-target="#PHP9" type="button" role="tab"
                                                        aria-controls="PHP9" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab9" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby9" type="button" role="tab"
                                                        aria-controls="Ruby9"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab9"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js9"
                                                        type="button" role="tab" aria-controls="Node-js9"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab9" data-bs-toggle="pill"
                                                        data-bs-target="#Python9" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js9" role="tabpanel"
                                             aria-labelledby="Node-js-tab9" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/get-card',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN',
    'Cookie': '...'
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
                                        <div class="tab-pane fade" id="Python9" role="tabpanel"
                                             aria-labelledby="Python-tab9" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/get-card"

payload = {}
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN',
  'Cookie': '...'
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
                                        <div class="tab-pane fade" id="PHP9" role="tabpanel"
                                             aria-labelledby="PHP-tab9" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$request = new Request('GET', 'BASE_URL/get-card', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl9" role="tabpanel"
                                             aria-labelledby="cUrl-tab9" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/get-card' \
--header 'Authorization: YOUR_BEARER_TOKEN' \
--header 'Cookie: ...'
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
                                        <div class="tab-pane fade" id="Ruby9" role="tabpanel"
                                             aria-labelledby="Ruby-tab9" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/get-card")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "...."

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
                                                <button class="nav-link active" id="OK-tab9"
                                                        data-bs-toggle="pill" data-bs-target="#OK9"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab9"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request9"
                                                        type="button" role="tab" aria-controls="Bad-Request9"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK9" role="tabpanel"
                                             aria-labelledby="OK-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "cards": [
            {
                "id": 1,
                "category_id": 1,
                "name": "Honor of Kings (Global)",
                "slug": "honor-of-kings-global",
                "status": 1,
                "product_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card/M8H2HEgm9F5idIYoMoU2j6ZvRrJsA6.webp",
                "preview_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card/mQnj7yQsc0ZrRn2XaGwPuOWXYiTVwz.webp"
            },
            {
                "id": 3,
                "category_id": 1,
                "name": "Mobile Legends Diamonds Pin",
                "slug": "mobile-legends-diamonds-pin",
                "status": 1,
                "product_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card/7OcZfBfKnbcFotrUwDCExlIsNGS0kV.webp",
                "preview_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card/oe0U1xKwbjjN4i1V7hjOjpfC2JSS1z.webp"
            },
            .....
        ]
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
                                        <div class="tab-pane fade" id="Bad-Request9" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab9" tabindex="0">
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

            <div class="docs-section" id="getCardByCat">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Card By Category')</h4>
                        <p>
                            @lang("To get all the Card list by category id follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}get-card?category_id={category_id}</i>
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
                                    <b>id:</b> <span> Card id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>category_id:</b> <span> Card Category id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>name:</b>
                                    <span> Card Name</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>slug:</b> <span> Card Slug</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>status:</b> <span> Card Status. It Should be 1 For All Active Card</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>product_image:</b> <span> The Card Image Url Path</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>preview_image:</b> <span> The Card Preview Image Url Path</span>
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
                                                <button class="nav-link active" id="cUrl-tab20"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl20" type="button" role="tab"
                                                        aria-controls="cUrl20"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab20" data-bs-toggle="pill"
                                                        data-bs-target="#PHP20" type="button" role="tab"
                                                        aria-controls="PHP20" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab20" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby20" type="button" role="tab"
                                                        aria-controls="Ruby20"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab20"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js20"
                                                        type="button" role="tab" aria-controls="Node-js20"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab20" data-bs-toggle="pill"
                                                        data-bs-target="#Python20" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js20" role="tabpanel"
                                             aria-labelledby="Node-js-tab20" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/get-card?category_id=5',
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
                                        <div class="tab-pane fade" id="Python20" role="tabpanel"
                                             aria-labelledby="Python-tab20" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/get-card?category_id=5"

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
                                        <div class="tab-pane fade" id="PHP20" role="tabpanel"
                                             aria-labelledby="PHP-tab20" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/get-card?category_id=5', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl20" role="tabpanel"
                                             aria-labelledby="cUrl-tab20" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/get-card?category_id=5' \
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
                                        <div class="tab-pane fade" id="Ruby20" role="tabpanel"
                                             aria-labelledby="Ruby-tab20" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/get-card?category_id=5")

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
                                                <button class="nav-link active" id="OK-tab20"
                                                        data-bs-toggle="pill" data-bs-target="#OK20"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab20"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request20"
                                                        type="button" role="tab" aria-controls="Bad-Request20"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK20" role="tabpanel"
                                             aria-labelledby="OK-tab20" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "cards": [
            {
                "id": 10,
                "category_id": 5,
                "name": "Netflix Gift Card (MY)",
                "slug": "netflix-gift-card-my",
                "status": 1,
                "product_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card/vNK9c1bqfRqceCLfsR707XNr3IYhMS.webp",
                "preview_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card/Cpg8NhG9JWAoWCW63PB8zuo8rdHrKf.webp"
            },
            ....
        ]
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
                                        <div class="tab-pane fade" id="Bad-Request20" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab20" tabindex="0">
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

            <div class="docs-section" id="cardDetail">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Card Details')</h4>
                        <p>
                            @lang("To get Card all information follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}card/details?card_id={card_id}</i>
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
                                    <b>id:</b> <span> Card up id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>category_id:</b> <span> Card Category id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>name:</b>
                                    <span> Card Name</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>slug:</b> <span> Card Slug</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>region:</b> <span> suppoerted region or country</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>note:</b> <span> any note for the Card</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>status:</b> <span> Card Status. It Should be 1 For All Active Card</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>instant_delivery:</b> <span> 1=> if Top Up send instantly to buyer </span>
                                </p>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>description:</b> <span> Card Description</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>guide:</b> <span> Card Guide</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>total_review:</b> <span> How many review give by the buyer</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>avg_rating:</b> <span> The average review rating by the buyer</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>sell_count:</b> <span> Total Sell time</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>trending:</b> <span> Trending item for 1, 0 is normal</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>preview_image:</b> <span> Card Preview Image</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>product_image:</b> <span> Card Image</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>services:</b> <span>Card Services</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>gateways:</b> <span>Active gateways for payment</span>
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
                                                <button class="nav-link active" id="cUrl-tab30"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl30" type="button" role="tab"
                                                        aria-controls="cUrl30"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab30" data-bs-toggle="pill"
                                                        data-bs-target="#PHP30" type="button" role="tab"
                                                        aria-controls="PHP30" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab30" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby30" type="button" role="tab"
                                                        aria-controls="Ruby30"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab30"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js30"
                                                        type="button" role="tab" aria-controls="Node-js30"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab30" data-bs-toggle="pill"
                                                        data-bs-target="#Python30" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js30" role="tabpanel"
                                             aria-labelledby="Node-js-tab30" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/card/details?card_id=1',
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
                                        <div class="tab-pane fade" id="Python30" role="tabpanel"
                                             aria-labelledby="Python-tab30" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/card/details?card_id=1"

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
                                        <div class="tab-pane fade" id="PHP30" role="tabpanel"
                                             aria-labelledby="PHP-tab30" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/card/details?card_id=1', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl30" role="tabpanel"
                                             aria-labelledby="cUrl-tab30" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/details?card_id=1' \
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
                                        <div class="tab-pane fade" id="Ruby30" role="tabpanel"
                                             aria-labelledby="Ruby-tab30" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/card/details?card_id=1")

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
                                                <button class="nav-link active" id="OK-tab30"
                                                        data-bs-toggle="pill" data-bs-target="#OK30"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab30"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request30"
                                                        type="button" role="tab" aria-controls="Bad-Request30"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK30" role="tabpanel"
                                             aria-labelledby="OK-tab30" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "services": [
            {
                "id": 1,
                "card_id": 1,
                "name": "Gift Card 10 INR IN",
                "price": 0.27,
                "discount": 2,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 0,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
                "old_data": null,
                "campaign_data": null,
                "created_at": "2024-08-17T05:19:12.000000Z",
                "updated_at": "2024-11-11T13:03:09.000000Z",
                "image_path": "#"
            },
            {
                "id": 2,
                "card_id": 1,
                "name": "Gift Card 25 INR IN",
                "price": 0.42,
                "discount": 2,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 0,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 2,
                "old_data": null,
                "campaign_data": null,
                "created_at": "2024-08-17T05:20:36.000000Z",
                "updated_at": "2024-11-11T13:03:09.000000Z",
                "image_path": "#"
            },
            ...
        ]
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
                                        <div class="tab-pane fade" id="Bad-Request30" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab30" tabindex="0">
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

            <div class="docs-section" id="getCardServices">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Card Services')</h4>
                        <p>
                            @lang("To get all the Card Services list follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}card/services</i>
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
                                    <b>id:</b> <span> Service id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>card_id:</b> <span> Card id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>name:</b>
                                    <span> Service Name</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>price:</b> <span> The price of service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>discount:</b> <span> The discount amount of service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>discount_type:</b> <span> The discount amount type. 1.percentage 2.flat</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>is_offered:</b> <span> The service is in campaign or not. 1=> yes, 0=> not</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>offered_sell:</b> <span> The campaign sell of the service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>max_sell:</b> <span> The campaign max sell limit of the service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>old_data:</b> <span> The actual data before campaign</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>campaign_data:</b> <span> The campaign data of the service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>created_at:</b> <span> Service Created date</span>
                                </p>
                            </div>
                        </div><div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>updated_at:</b> <span> Service updated date</span>
                                </p>
                            </div>
                        </div><div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>image_path:</b> <span> Service image path</span>
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
                                                <button class="nav-link active" id="cUrl-tab40"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl40" type="button" role="tab"
                                                        aria-controls="cUrl40"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab40" data-bs-toggle="pill"
                                                        data-bs-target="#PHP40" type="button" role="tab"
                                                        aria-controls="PHP40" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab40" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby40" type="button" role="tab"
                                                        aria-controls="Ruby40"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab40"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js40"
                                                        type="button" role="tab" aria-controls="Node-js40"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab40" data-bs-toggle="pill"
                                                        data-bs-target="#Python40" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js40" role="tabpanel"
                                             aria-labelledby="Node-js-tab40" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/card/services',
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
                                        <div class="tab-pane fade" id="Python40" role="tabpanel"
                                             aria-labelledby="Python-tab40" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/card/services"

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
                                        <div class="tab-pane fade" id="PHP40" role="tabpanel"
                                             aria-labelledby="PHP-tab40" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/card/services', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl40" role="tabpanel"
                                             aria-labelledby="cUrl-tab40" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/services' \
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
                                        <div class="tab-pane fade" id="Ruby40" role="tabpanel"
                                             aria-labelledby="Ruby-tab40" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/card/services")

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
                                                <button class="nav-link active" id="OK-tab40"
                                                        data-bs-toggle="pill" data-bs-target="#OK40"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab40"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request40"
                                                        type="button" role="tab" aria-controls="Bad-Request40"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK40" role="tabpanel"
                                             aria-labelledby="OK-tab40" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "services": [
            {
                "id": 1,
                "card_id": 1,
                "name": "Honor of Kings 16 Tokens",
                "price": 2.9,
                "discount": 1,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 0,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
                "old_data": null,
                "campaign_data": null,
                "created_at": "2025-03-03T09:27:53.000000Z",
                "updated_at": "2025-03-06T04:58:16.000000Z",
                "image_path": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card-service/ksi6iDr9d26D82ZRlr0C3CK9JNpalL.webp"
            },
            {
                "id": 2,
                "card_id": 1,
                "name": "Honor of Kings 80 Tokens",
                "price": 2.45,
                "discount": 1,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 1,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
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
                                        <div class="tab-pane fade" id="Bad-Request40" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab40" tabindex="0">
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

            <div class="docs-section" id="getServicesByCard">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Services By Card')</h4>
                        <p>
                            @lang("To get Services of the Card list follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}card/services?card_id={card_id}</i>
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
                                    <b>id:</b> <span> Service id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>card_id:</b> <span> Card id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>name:</b>
                                    <span> Service Name</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>price:</b> <span> The price of service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>discount:</b> <span> The discount amount of service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>discount_type:</b> <span> The discount amount type. 1.percentage 2.flat</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>is_offered:</b> <span> The service is in campaign or not. 1=> yes, 0=> not</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>offered_sell:</b> <span> The campaign sell of the service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>max_sell:</b> <span> The campaign max sell limit of the service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>old_data:</b> <span> The actual data before campaign</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>campaign_data:</b> <span> The campaign data of the service</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>created_at:</b> <span> Service Created date</span>
                                </p>
                            </div>
                        </div><div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>updated_at:</b> <span> Service updated date</span>
                                </p>
                            </div>
                        </div><div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>image_path:</b> <span> Service image path</span>
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
                                                <button class="nav-link active" id="cUrl-tab400"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl400" type="button" role="tab"
                                                        aria-controls="cUrl4"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab400" data-bs-toggle="pill"
                                                        data-bs-target="#PHP400" type="button" role="tab"
                                                        aria-controls="PHP400" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab400" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby400" type="button" role="tab"
                                                        aria-controls="Ruby400"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab400"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js400"
                                                        type="button" role="tab" aria-controls="Node-js400"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab400" data-bs-toggle="pill"
                                                        data-bs-target="#Python400" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js400" role="tabpanel"
                                             aria-labelledby="Node-js-tab400" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/card/services?card_id=1',
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
                                        <div class="tab-pane fade" id="Python400" role="tabpanel"
                                             aria-labelledby="Python-tab400" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/card/services?card_id=1"

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
                                        <div class="tab-pane fade" id="PHP400" role="tabpanel"
                                             aria-labelledby="PHP-tab400" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/card/services?card_id=1', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl400" role="tabpanel"
                                             aria-labelledby="cUrl-tab400" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/services?card_id=1' \
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
                                        <div class="tab-pane fade" id="Ruby400" role="tabpanel"
                                             aria-labelledby="Ruby-tab400" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/card/services?card_id=1")

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
                                                <button class="nav-link active" id="OK-tab400"
                                                        data-bs-toggle="pill" data-bs-target="#OK400"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab400"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request400"
                                                        type="button" role="tab" aria-controls="Bad-Request400"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK400" role="tabpanel"
                                             aria-labelledby="OK-tab400" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "services": [
            {
                "id": 1,
                "card_id": 1,
                "name": "Honor of Kings 16 Tokens",
                "price": 2.9,
                "discount": 1,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 0,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
                "old_data": null,
                "campaign_data": null,
                "created_at": "2025-03-03T09:27:53.000000Z",
                "updated_at": "2025-03-06T04:58:16.000000Z",
                "image_path": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card-service/ksi6iDr9d26D82ZRlr0C3CK9JNpalL.webp"
            },
            {
                "id": 2,
                "card_id": 1,
                "name": "Honor of Kings 80 Tokens",
                "price": 2.45,
                "discount": 1,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 1,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
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
                                        <div class="tab-pane fade" id="Bad-Request400" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab400" tabindex="0">
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

            <div class="docs-section" id="orderCard">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Order Card')</h4>
                        <p>
                            @lang("To order card follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>POST</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}card/make-order</i>
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
                        <h5 class="mb-3">@lang("Body Params")</h5>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>service_ids<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">array</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            The id of Card Service, Must be in array </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="1,2,3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>quantities<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">array</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            The Quantity of each Service, Must be in array. Each quantity index value represent the same index number of service_ids quantity </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="2,4,3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="editor-header">
                                    <div class="cmn-tabs2">
                                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="cUrl-tab80"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl80" type="button" role="tab"
                                                        aria-controls="cUrl80"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab80" data-bs-toggle="pill"
                                                        data-bs-target="#PHP80" type="button" role="tab"
                                                        aria-controls="PHP80" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab80" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby80" type="button" role="tab"
                                                        aria-controls="Ruby80"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab80"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js80"
                                                        type="button" role="tab" aria-controls="Node-js80"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab80" data-bs-toggle="pill"
                                                        data-bs-target="#Python80" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js80" role="tabpanel"
                                             aria-labelledby="Node-js-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'POST',
  'url': 'BASE_URL/card/make-order',
  'headers': {
    'Content-Type': 'application/json',
    'Authorization': 'YOUR_BEARER_TOKEN'
  },
  body: JSON.stringify({
    "serviceIds": [
      1,
      2
    ],
    "quantity": [
      3,
      4
    ]
  })

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
                                        <div class="tab-pane fade" id="Python80" role="tabpanel"
                                             aria-labelledby="Python-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests
import json

url = "BASE_URL/card/make-order"

payload = json.dumps({
  "serviceIds": [
    1,
    2
  ],
  "quantity": [
    3,
    4
  ]
})
headers = {
  'Content-Type': 'application/json',
  'Authorization': 'YOUR_BEARER_TOKEN'
}

response = requests.request("POST", url, headers=headers, data=payload)

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
                                        <div class="tab-pane fade" id="PHP80" role="tabpanel"
                                             aria-labelledby="PHP-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php
$client = new Client();
$headers = [
  'Content-Type' => 'application/json',
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$body = '{
  "serviceIds": [
    1,
    2
  ],
  "quantity": [
    3,
    4
  ]
}';
$request = new Request('POST', 'BASE_URL/card/make-order', $headers, $body);
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
                                        <div class="tab-pane fade show active" id="cUrl80" role="tabpanel"
                                             aria-labelledby="cUrl-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/make-order' \
--header 'Content-Type: application/json' \
--header 'Authorization: YOUR_BEARER_TOKEN' \
--data '{
    "serviceIds": [1,2],
    "quantity": [3,4]
}'
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
                                        <div class="tab-pane fade" id="Ruby80" role="tabpanel"
                                             aria-labelledby="Ruby-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "json"
require "net/http"

url = URI("BASE_URL/card/make-order")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Post.new(url)
request["Content-Type"] = "application/json"
request["Authorization"] = "YOUR_BEARER_TOKEN"
request.body = JSON.dump({
  "serviceIds": [
    1,
    2
  ],
  "quantity": [
    3,
    4
  ]
})

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
                                                <button class="nav-link active" id="OK-tab80"
                                                        data-bs-toggle="pill" data-bs-target="#OK80"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab80"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request80"
                                                        type="button" role="tab" aria-controls="Bad-Request80"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK80" role="tabpanel"
                                             aria-labelledby="OK-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "utr": "OGRMDQJ71VF6Q"
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
                                        <div class="tab-pane fade" id="Bad-Request80" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab80" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
{
    "status": "failed",
    "errors": [
        "The service ids field is required.",
    ]
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

            <div class="docs-section" id="getCardReview">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Card Reviews')</h4>
                        <p>
                            @lang("To get Reviews of the Card list follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>GET</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}card/review?card_id={card_id}</i>
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
                                    <b>id:</b> <span> Review id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>user_id:</b> <span> Reviewed User ID</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>rating:</b> <span> Card rating. min value 1 max value 5</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>comment:</b>
                                    <span>Product rating comment</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>user:</b> <span> Who give the rating</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>status:</b> <span> Status 1 for published, 0 for holded</span>
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
                                                <button class="nav-link active" id="cUrl-tab50"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl50" type="button" role="tab"
                                                        aria-controls="cUrl50"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab50" data-bs-toggle="pill"
                                                        data-bs-target="#PHP50" type="button" role="tab"
                                                        aria-controls="PHP50" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab50" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby50" type="button" role="tab"
                                                        aria-controls="Ruby50"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab50"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js50"
                                                        type="button" role="tab" aria-controls="Node-js50"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab50" data-bs-toggle="pill"
                                                        data-bs-target="#Python50" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js50" role="tabpanel"
                                             aria-labelledby="Node-js-tab50" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/card/review?card_id=9',
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
                                        <div class="tab-pane fade" id="Python50" role="tabpanel"
                                             aria-labelledby="Python-tab50" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/card/review?card_id=9"

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
                                        <div class="tab-pane fade" id="PHP50" role="tabpanel"
                                             aria-labelledby="PHP-tab50" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/card/review?card_id=9', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl50" role="tabpanel"
                                             aria-labelledby="cUrl-tab50" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/review?card_id=9' \
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
                                        <div class="tab-pane fade" id="Ruby50" role="tabpanel"
                                             aria-labelledby="Ruby-tab50" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/card/review?card_id=9")

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
                                                <button class="nav-link active" id="OK-tab50"
                                                        data-bs-toggle="pill" data-bs-target="#OK50"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab50"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request50"
                                                        type="button" role="tab" aria-controls="Bad-Request50"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK50" role="tabpanel"
                                             aria-labelledby="OK-tab50" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "reviews": [
            {
                "id": 5,
                "user_id": 1,
                "rating": 3,
                "comment": "Amazing product! Everything works flawlessly, and the convenience is unmatched. 70% satisfied!",
                "status": 1,
                "created_at": "2025-03-05T10:37:57.000000Z",
                "updated_at": "2025-03-05T10:37:57.000000Z",
                "user": {
                    "id": 1,
                    "firstname": "Demo",
                    "lastname": "User",
                    "image": "profileImage/fyT3Q7VjKDjvfYcuIXY4CqE2ob7DDP.webp",
                    "image_driver": "local",
                    "imgPath": "http://192.168.0.123/gamers-arena/gamers/assets/upload/profileImage/fyT3Q7VjKDjvfYcuIXY4CqE2ob7DDP.webp",
                    "LastSeenActivity": true,
                    "fullname": "Demo User"
                }
            },
            {
                "id": 10,
                "user_id": 29,
                "rating": 3,
                "comment": "Amazing product! Everything works flawlessly, and the convenience is unmatched. 70% satisfied!",
                "status": 1,
                "created_at": "2025-03-06T05:09:46.000000Z",
                "updated_at": "2025-03-06T05:09:46.000000Z",
                "user": {
                    "id": 29,
                    "firstname": "Angela",
                    "lastname": "Doyle",
                    "image": null,
                    "image_driver": null,
                    "imgPath": "http://192.168.0.123/gamers-arena/gamers/assets/admin/img/default.png",
                    "LastSeenActivity": false,
                    "fullname": "Angela Doyle"
                }
            },
            ....
        ],
        "pagination": {
            "total": 8,
            "per_page": 15,
            "current_page": 1,
            "last_page": 1,
            "next_page_url": null,
            "prev_page_url": null
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
                                        <div class="tab-pane fade" id="Bad-Request50" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab50" tabindex="0">
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

            <div class="docs-section" id="addCardReview">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Add Card Reviews')</h4>
                        <p>
                            @lang("To give a rating of card follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base
                                        Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>POST</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}card/review</i>
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
                        <h5 class="mb-3">@lang("Body Params")</h5>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>card_id<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">integer</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            The id of Card, Must be in integer positive value </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>rating<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">number</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            Must be in positive number between 1 to 5 </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>comment<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">text</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            What was your experience </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="I just love it!">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="editor-header">
                                    <div class="cmn-tabs2">
                                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="cUrl-tab60"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl60" type="button" role="tab"
                                                        aria-controls="cUrl60"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab60" data-bs-toggle="pill"
                                                        data-bs-target="#PHP60" type="button" role="tab"
                                                        aria-controls="PHP60" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab60" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby60" type="button" role="tab"
                                                        aria-controls="Ruby60"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab60"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js60"
                                                        type="button" role="tab" aria-controls="Node-js60"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab60" data-bs-toggle="pill"
                                                        data-bs-target="#Python60" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js60" role="tabpanel"
                                             aria-labelledby="Node-js-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'POST',
  'url': 'BASE_URL/card/review',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN'
  },
  formData: {
    'card_id': '9',
    'rating': '5',
    'comment': 'This is review'
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
                                        <div class="tab-pane fade" id="Python60" role="tabpanel"
                                             aria-labelledby="Python-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/card/review"

payload = {'card_id': '9',
'rating': '5',
'comment': 'This is review'}
files=[

]
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN'
}

response = requests.request("POST", url, headers=headers, data=payload, files=files)

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
                                        <div class="tab-pane fade" id="PHP60" role="tabpanel"
                                             aria-labelledby="PHP-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php
$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$options = [
  'multipart' => [
    [
      'name' => 'card_id',
      'contents' => '9'
    ],
    [
      'name' => 'rating',
      'contents' => '5'
    ],
    [
      'name' => 'comment',
      'contents' => 'This is review'
    ]
]];
$request = new Request('POST', 'BASE_URL/card/review', $headers);
$res = $client->sendAsync($request, $options)->wait();
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
                                        <div class="tab-pane fade show active" id="cUrl60" role="tabpanel"
                                             aria-labelledby="cUrl-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/review' \
--header 'Authorization: YOUR_BEARER_TOKEN' \
--form 'card_id="9"' \
--form 'rating="5"' \
--form 'comment="This is review"'
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
                                        <div class="tab-pane fade" id="Ruby60" role="tabpanel"
                                             aria-labelledby="Ruby-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/card/review")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Post.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
form_data = [['card_id', '9'],['rating', '5'],['comment', 'This is review']]
request.set_form form_data, 'multipart/form-data'
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
                                                <button class="nav-link active" id="OK-tab60"
                                                        data-bs-toggle="pill" data-bs-target="#OK60"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab60"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request60"
                                                        type="button" role="tab" aria-controls="Bad-Request60"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK60" role="tabpanel"
                                             aria-labelledby="OK-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": "Review Added Successfully"
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
                                        <div class="tab-pane fade" id="Bad-Request60" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab60" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
{
    "status": "failed",
    "errors": [
        "The top up id field is required.",
        "The rating field is required.",
        "The comment field is required."
    ]
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

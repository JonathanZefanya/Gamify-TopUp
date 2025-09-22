<div class="main-wrapper">
    <div class="row g-4">
        <div class="col-12">
            <h3 class="docs-section-title">
                @lang('Order List')
            </h3>
            <div class="docs-section" id="topUpOrderList">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Top Up Order List')</h4>
                        <p>
                            @lang("To get all the top up order list follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span class="badge text-bg-success">@lang('Base Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>@lang('GET')</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}get-topup/orders</i>
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
                                    <b>@lang('utr:')</b> <span> @lang('Unique order id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('price:')</b> <span> @lang('Order total amount')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('currency:')</b> <span> @lang('Amount paid currency')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('status:')</b>
                                    <span> @lang('The status of the order. 0=>initiate, 1=>completed,2=>refund,3=>stock_short') </span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('informations:')</b> <span> @lang('Top Up order information')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('review_user_info:')</b> <span> @lang('User review')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('order_details:')</b> <span> @lang('array of object. every service details of order')</span>
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
                                                <button class="nav-link active" id="cUrl-tab70"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl70" type="button" role="tab"
                                                        aria-controls="cUrl70"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab70" data-bs-toggle="pill"
                                                        data-bs-target="#PHP70" type="button" role="tab"
                                                        aria-controls="PHP70" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab70" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby70" type="button" role="tab"
                                                        aria-controls="Ruby70"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab70"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js70"
                                                        type="button" role="tab" aria-controls="Node-js70"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab70" data-bs-toggle="pill"
                                                        data-bs-target="#Python70" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js70" role="tabpanel"
                                             aria-labelledby="Node-js-tab70" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/topUp/order',
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
                                        <div class="tab-pane fade" id="Python70" role="tabpanel"
                                             aria-labelledby="Python-tab70" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/topUp/order"

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
                                        <div class="tab-pane fade" id="PHP70" role="tabpanel"
                                             aria-labelledby="PHP-tab70" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/topUp/order', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl70" role="tabpanel"
                                             aria-labelledby="cUrl-tab70" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/topUp/order' \
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
                                        <div class="tab-pane fade" id="Ruby70" role="tabpanel"
                                             aria-labelledby="Ruby-tab70" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BaseURL/topUp/order")

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
                                                <button class="nav-link active" id="OK-tab70"
                                                        data-bs-toggle="pill" data-bs-target="#OK70"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab70"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request70"
                                                        type="button" role="tab" aria-controls="Bad-Request70"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK70" role="tabpanel"
                                             aria-labelledby="OK-tab70" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "current_page": 1,
        "data": [
            {
                "utr": "O8NYH38WAQW8B",
                "price": 54,
                "currency": "USD",
                "symbol": "$",
                "status": "Wait Sending",
                "dateTime": "2025-03-05T11:59:52.000000Z",
                "order_details": [
                    {
                        "utr": "O8NYH38WAQW8B",
                        "rating": 5,
                        "image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/top-up-service/yRvTZ7P5wwOeDGE2YdCQJMk9SytjiD.webp",
                        "discount": 54,
                        "quantity": 1,
                        "name": "Arena Breakout: Infinite Top Up",
                        "service": "500 +10 Bonds",
                        "base_price": 108,
                        "currency": "USD",
                        "symbol": "$",
                        "slug": "arena-breakout-infinite-top-up"
                    }
                ],
                "review_user_info": [
                    {
                        "review": {
                            "comment": "Amazing product! Everything works flawlessly, and the convenience is unmatched. 100% satisfied!",
                            "rating": 5,
                            "status": "active"
                        }
                    }
                ],
                "informations": {
                    "Server ID": "server-5878",
                    "Server Name": "America"
                }
            },
            ....
        ],
        "first_page_url": "http://192.168.0.123/gamers-arena/gamers/api/topUp/order?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://192.168.0.123/gamers-arena/gamers/api/topUp/order?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://192.168.0.123/gamers-arena/gamers/api/topUp/order?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://192.168.0.123/gamers-arena/gamers/api/topUp/order",
        "per_page": 10,
        "prev_page_url": null,
        "to": 7,
        "total": 7
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
                                        <div class="tab-pane fade" id="Bad-Request70" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab70" tabindex="0">
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

            <div class="docs-section" id="cardOrderList">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Card Order List')</h4>
                        <p>
                            @lang("To get all the card order list follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}get-card/orders</i>
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
                                    <b>@lang('utr:')</b> <span> @lang('Unique order id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('price:')</b> <span> @lang('Order total amount')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('currency:')</b> <span> @lang('Amount paid currency')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('status:')</b>
                                    <span> @lang('The status of the order. 0=>initiate, 1=>completed,2=>refund,3=>stock_short') </span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('informations:')</b> <span> @lang('Top Up order information')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('review_user_info:')</b> <span> @lang('User review')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('order_details:')</b> <span> @lang('array of object. every service details of order')</span>
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
                                                <button class="nav-link active" id="cUrl-tab700"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl700" type="button" role="tab"
                                                        aria-controls="cUrl700"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab700" data-bs-toggle="pill"
                                                        data-bs-target="#PHP700" type="button" role="tab"
                                                        aria-controls="PHP700" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab700" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby700" type="button" role="tab"
                                                        aria-controls="Ruby700"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab700"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js700"
                                                        type="button" role="tab" aria-controls="Node-js700"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab700" data-bs-toggle="pill"
                                                        data-bs-target="#Python700" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js700" role="tabpanel"
                                             aria-labelledby="Node-js-tab700" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/card/order',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN'
  },
  formData: {

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
                                        <div class="tab-pane fade" id="Python700" role="tabpanel"
                                             aria-labelledby="Python-tab700" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/card/order"

payload = {}
files={}
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN'
}

response = requests.request("GET", url, headers=headers, data=payload, files=files)

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
                                        <div class="tab-pane fade" id="PHP700" role="tabpanel"
                                             aria-labelledby="PHP-tab700" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/card/order', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl700" role="tabpanel"
                                             aria-labelledby="cUrl-tab700" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/card/order' \
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
                                        <div class="tab-pane fade" id="Ruby700" role="tabpanel"
                                             aria-labelledby="Ruby-tab700" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/card/order")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
form_data = []
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
                                                <button class="nav-link active" id="OK-tab700"
                                                        data-bs-toggle="pill" data-bs-target="#OK700"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab700"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request700"
                                                        type="button" role="tab" aria-controls="Bad-Request700"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK700" role="tabpanel"
                                             aria-labelledby="OK-tab700" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "current_page": 1,
        "data": [
            {
                "utr": "ONS8GNE4BJ884",
                "price": 34.48,
                "currency": "USD",
                "symbol": "$",
                "status": "Complete",
                "dateTime": "2025-03-05T12:02:42.000000Z",
                "order_details": [
                    {
                        "utr": "ONS8GNE4BJ884",
                        "id": 6,
                        "rating": 0,
                        "image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card-service/6xEzC2ACZMVChJHteBLNUAF6R63vHJ.webp",
                        "card": "Flexepin (CA)",
                        "slug": "flexepin-ca",
                        "service": "Flexepin 20 CAD",
                        "base_price": 12.62,
                        "currency": "USD",
                        "symbol": "$",
                        "discount": 0.38,
                        "quantity": 1,
                        "card_codes": [
                            "FP8796545425"
                        ],
                        "stock_short": "You have 0 more code in wait sending list"
                    },
                    {
                        "utr": "ONS8GNE4BJ884",
                        "id": 10,
                        "rating": 0,
                        "image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/card-service/CYspHPxUYfl9xXkB8YMJRPwyPm9r2t.webp",
                        "card": "Netflix Gift Card (MY)",
                        "slug": "netflix-gift-card-my",
                        "service": "Netflix 521 300 Here",
                        "base_price": 50,
                        "currency": "USD",
                        "symbol": "$",
                        "discount": 40,
                        "quantity": 1,
                        "card_codes": [
                            "NF65315251"
                        ],
                        "stock_short": "You have 0 more code in wait sending list"
                    }
                ],
                "review_user_info": [
                    {
                        "review": {
                            "comment": null,
                            "rating": null,
                            "status": "inactive"
                        }
                    },
                    {
                        "review": {
                            "comment": null,
                            "rating": null,
                            "status": "inactive"
                        }
                    }
                ],
                "informations": []
            },
            ....
        ],
        "first_page_url": "http://192.168.0.123/gamers-arena/gamers/api/card/order?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://192.168.0.123/gamers-arena/gamers/api/card/order?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://192.168.0.123/gamers-arena/gamers/api/card/order?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://192.168.0.123/gamers-arena/gamers/api/card/order",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 10
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
                                        <div class="tab-pane fade" id="Bad-Request700" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab700" tabindex="0">
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

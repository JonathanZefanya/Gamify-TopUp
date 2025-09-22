<div class="main-wrapper">
    <div class="row g-4">
        <div class="col-12">
            <h3 class="docs-section-title">
                @lang('Top Up')
            </h3>
            <div class="docs-section" id="getTopUps">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Top Ups')</h4>
                        <p>
                            @lang("To get all the Top Up list follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}top-up/list</i>
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
                                    <b>@lang('id:')</b> <span> @lang('Top up id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('category_id:')</b> <span> @lang('Top up Category') id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('name:')</b>
                                    <span> @lang('Top up Name')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('slug:')</b> <span> @lang('Top up Slug')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('region:')</b> <span> @lang('Top up Region')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('note:')</b> <span> @lang('Top up note')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('instant_delivery:')</b> <span> @lang('Top Up instant delivery Status. It Should be 1 For All Active instant delivery Top Up')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('order_information:')</b> <span> @lang('Top Up orders information')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('description:')</b> <span> @lang('Top Up description')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('guide:')</b> <span> @lang('Top Up guide')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('total_review:')</b> <span> @lang('Top Up total review')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('avg_rating:')</b> <span> @lang('Top Up average rating')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('sort_by:')</b> <span> @lang('Top Up sorting, 1 for sort by date, 2 for sort by price etc.')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('status:')</b> <span> @lang('Top Up Status. It Should be 1 For All Active Top Up')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('image:')</b> <span> @lang('The Top Up Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('preview_image:')</b> <span> @lang('The Top Up Preview Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('services:')</b> <span> @lang('The TopUp services')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('created_at:')</b> <span> @lang('The TopUp created date')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('updated_at:')</b> <span> @lang('The TopUp updated date')</span>
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
                                                <button class="nav-link active" id="cUrl-tab1"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl1" type="button" role="tab"
                                                        aria-controls="cUrl1"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab1" data-bs-toggle="pill"
                                                        data-bs-target="#PHP1" type="button" role="tab"
                                                        aria-controls="PHP1" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab1" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby1" type="button" role="tab"
                                                        aria-controls="Ruby1"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab1"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js1"
                                                        type="button" role="tab" aria-controls="Node-js1"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab1" data-bs-toggle="pill"
                                                        data-bs-target="#Python1" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js1" role="tabpanel"
                                             aria-labelledby="Node-js-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/top-up/list',
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
                                        <div class="tab-pane fade" id="Python1" role="tabpanel"
                                             aria-labelledby="Python-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/top-up/list"

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
                                        <div class="tab-pane fade" id="PHP1" role="tabpanel"
                                             aria-labelledby="PHP-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN'
];
$request = new Request('GET', 'BASE_URL/top-up/list', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl1" role="tabpanel"
                                             aria-labelledby="cUrl-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/top-up/list' \
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
                                        <div class="tab-pane fade" id="Ruby1" role="tabpanel"
                                             aria-labelledby="Ruby-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/top-up/list")

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
                                                <button class="nav-link active" id="OK-tab1"
                                                        data-bs-toggle="pill" data-bs-target="#OK1"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab1"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request1"
                                                        type="button" role="tab" aria-controls="Bad-Request1"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK1" role="tabpanel"
                                             aria-labelledby="OK-tab1" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "current_page": 1,
        "items": [
            {
                "id": 2,
                "category_id": 8,
                "name": "MICO Live Coins",
                "slug": "mico-live-coins",
                "region": "Global",
                "note": null,
                "status": 1,
                "instant_delivery": 1,
                "image": {
                    "image": "top-up/gYwgPOr73OKgqyRoWiLH3zwQ8oXK55.webp",
                    "image_driver": "local",
                    "preview": "top-up/VPJS0Mr6yqkPR2YRzGZKAqunbuTf0D.webp",
                    "preview_driver": "local"
                },
                "order_information": {
                    "1": {
                        "field_value": "Name",
                        "field_name": "Name",
                        "field_placeholder": "Name",
                        "field_note": "Take is seriously",
                        "field_type": "text"
                    }
                },
                "description": "About MICO Live\r\n<p>MICO Live is one of the most popular worldwide social networking apps for live.</p>",
                "guide": "How to top-up MICO Live Coins?\r\n<p>Refer the simple steps below:</p>\r\n<ol>\r\n<li>Enter your Mico Live ID and select the top up amount.</li></li>\r\n</ol>",
                "total_review": 0,
                "avg_rating": 0,
                "sort_by": 1,
                "deleted_at": null,
                "created_at": "2025-03-04T09:54:06.000000Z",
                "updated_at": "2025-03-04T09:54:06.000000Z",
                "preview_image": "http://192.168.0.123/gamers-arena/project/assets/upload/top-up/VPJS0Mr6yqkPR2YRzGZKAqunbuTf0D.webp",
                "top_up_detail_route": "http://192.168.0.123/gamers-arena/project/direct-topup/details/mico-live-coins",
                "services": [
                    {
                        "id": 1,
                        "top_up_id": 2,
                        "name": "MICO Live 88 Coins",
                        "image": "top-up-service/EOPdhKAMgfaPhI1VxN30StKN3xytZI.webp",
                        "image_driver": "local",
                        "price": 2.8,
                        "discount": 5,
                        "discount_type": "percentage",
                        "status": 1,
                        "is_offered": 0,
                        "offered_sell": 0,
                        "max_sell": 0,
                        "sort_by": 1,
                        "old_data": null,
                        "campaign_data": null,
                        "created_at": "2025-03-04T09:57:49.000000Z",
                        "updated_at": "2025-03-04T09:57:49.000000Z",
                        "image_path": "http://192.168.0.123/gamers-arena/project/assets/upload/top-up-service/EOPdhKAMgfaPhI1VxN30StKN3xytZI.webp"
                    }
                     ......
                ]
            },
            .....
        ],
        "first_page_url": "BASE_URL/top-up/list?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "BASE_URL/top-up/list?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "BASE_URL/top-up/list?page=1",
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
        "path": "BASE_URL/top-up/list",
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
                                        <div class="tab-pane fade" id="Bad-Request1" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab1" tabindex="0">
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

            <div class="docs-section" id="getTopUpsByCat">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Top Up By Category')</h4>
                        <p>
                            @lang("To get all the Top Up list by category id follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}top-up/list?category_id={category_id}</i>
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
                                    <b>@lang('id:')</b> <span> @lang('Top up id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('category_id:')</b> <span> @lang('Top up Category') id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('name:')</b>
                                    <span> @lang('Top up Name')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('slug:')</b> <span> @lang('Top up Slug')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('region:')</b> <span> @lang('Top up Region')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('note:')</b> <span> @lang('Top up note')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('instant_delivery:')</b> <span> @lang('Top Up instant delivery Status. It Should be 1 For All Active instant delivery Top Up')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('order_information:')</b> <span> @lang('Top Up orders information')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('description:')</b> <span> @lang('Top Up description')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('guide:')</b> <span> @lang('Top Up guide')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('total_review:')</b> <span> @lang('Top Up total review')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('avg_rating:')</b> <span> @lang('Top Up average rating')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('sort_by:')</b> <span> @lang('Top Up sorting, 1 for sort by date, 2 for sort by price etc.')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('status:')</b> <span> @lang('Top Up Status. It Should be 1 For All Active Top Up')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('image:')</b> <span> @lang('The Top Up Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('preview_image:')</b> <span> @lang('The Top Up Preview Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('services:')</b> <span> @lang('The TopUp services')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('created_at:')</b> <span> @lang('The TopUp created date')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('updated_at:')</b> <span> @lang('The TopUp updated date')</span>
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
                                                <button class="nav-link active" id="cUrl-tab2"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl2" type="button" role="tab"
                                                        aria-controls="cUrl2"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab2" data-bs-toggle="pill"
                                                        data-bs-target="#PHP2" type="button" role="tab"
                                                        aria-controls="PHP2" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab2" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby2" type="button" role="tab"
                                                        aria-controls="Ruby2"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab2"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js2"
                                                        type="button" role="tab" aria-controls="Node-js2"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab2" data-bs-toggle="pill"
                                                        data-bs-target="#Python2" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js2" role="tabpanel"
                                             aria-labelledby="Node-js-tab2" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/top-up/list?category_id={category_id}',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN',
    'Cookie': '....'
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
                                        <div class="tab-pane fade" id="Python2" role="tabpanel"
                                             aria-labelledby="Python-tab2" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/top-up/list?category_id={category_id}"

payload = {}
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN',
  'Cookie': '....'
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
                                        <div class="tab-pane fade" id="PHP2" role="tabpanel"
                                             aria-labelledby="PHP-tab2" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$request = new Request('GET', 'BASE_URL/top-up/list?category_id={category_id}', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl2" role="tabpanel"
                                             aria-labelledby="cUrl-tab2" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/top-up/list?category_id=8' \
--header 'YOUR_BEARER_TOKEN' \
--header '....'
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
                                        <div class="tab-pane fade" id="Ruby2" role="tabpanel"
                                             aria-labelledby="Ruby-tab2" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/top-up/list?category_id={category_id}")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "..."

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
                                                <button class="nav-link active" id="OK-tab2"
                                                        data-bs-toggle="pill" data-bs-target="#OK2"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab1"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request2"
                                                        type="button" role="tab" aria-controls="Bad-Request2"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK2" role="tabpanel"
                                             aria-labelledby="OK-tab2" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "current_page": 1,
        "items": [
            {
                "id": 2,
                "category_id": 8,
                "name": "MICO Live Coins",
                "slug": "mico-live-coins",
                "region": "Global",
                "note": null,
                "status": 1,
                "instant_delivery": 1,
                "image": {
                    "image": "top-up/gYwgPOr73OKgqyRoWiLH3zwQ8oXK55.webp",
                    "image_driver": "local",
                    "preview": "top-up/VPJS0Mr6yqkPR2YRzGZKAqunbuTf0D.webp",
                    "preview_driver": "local"
                },
                "order_information": {
                    "1": {
                        "field_value": "Name",
                        "field_name": "Name",
                        "field_placeholder": "Name",
                        "field_note": "Take is seriously",
                        "field_type": "text"
                    }
                },
                "description": "About MICO Live\r\n<p>MICO Live is one of the most popular worldwide social networking apps for live streaming.</p>",
                "guide": "How to top-up MICO Live Coins?\r\n<p>Refer the simple steps below:</p>\r\n<ol>\r\n<li>Enter your Mico Live ID and select the top up amount.</li>\r\n<li>Check out and select your payment method.</li>\r\n<li>Once payment made, Mico Live coins will top up automatically into your Mico Live account.</li>\r\n</ol>",
                "total_review": 0,
                "avg_rating": 0,
                "sort_by": 4,
                "deleted_at": null,
                "created_at": "2025-03-04T09:54:06.000000Z",
                "updated_at": "2025-03-05T11:43:51.000000Z",
                "preview_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/top-up/VPJS0Mr6yqkPR2YRzGZKAqunbuTf0D.webp",
                "top_up_detail_route": "http://192.168.0.123/gamers-arena/gamers/direct-topup/details/mico-live-coins",
                "services": [
                    {
                        "id": 1,
                        "top_up_id": 2,
                        "name": "MICO Live 88 Coins",
                        "image": "top-up-service/EOPdhKAMgfaPhI1VxN30StKN3xytZI.webp",
                        "image_driver": "local",
                        "price": 2.8,
                        "discount": 5,
                        "discount_type": "percentage",
                        "status": 1,
                        "is_offered": 1,
                        "offered_sell": 0,
                        "max_sell": 0,
                        "sort_by": 1,
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
                    .....
                ]
            }
            ....
        ],
        "first_page_url": "http://192.168.0.123/gamers-arena/gamers/api/top-up/list?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://192.168.0.123/gamers-arena/gamers/api/top-up/list?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://192.168.0.123/gamers-arena/gamers/api/top-up/list?page=1",
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
        "path": "http://192.168.0.123/gamers-arena/gamers/api/top-up/list",
        "per_page": 10,
        "prev_page_url": null,
        "to": 4,
        "total": 4
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
                                        <div class="tab-pane fade" id="Bad-Request2" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab2" tabindex="0">
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

            <div class="docs-section" id="topUpDetail">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Top Up Details')</h4>
                        <p>
                            @lang("To get Top Up all information follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}top-up/details?slug={slug}</i>
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
                                    <b>@lang('id:')</b> <span> @lang('Top up id')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('category_id:')</b> <span> @lang('Top up Category') id</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('name:')</b>
                                    <span> @lang('Top up Name')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('slug:')</b> <span> @lang('Top up Slug')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('region:')</b> <span> @lang('Top up Region')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('note:')</b> <span> @lang('Top up note')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('instant_delivery:')</b> <span> @lang('Top Up instant delivery Status. It Should be 1 For All Active instant delivery Top Up')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('order_information:')</b> <span> @lang('Top Up orders information')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('description:')</b> <span> @lang('Top Up description')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('guide:')</b> <span> @lang('Top Up guide')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('total_review:')</b> <span> @lang('Top Up total review')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('avg_rating:')</b> <span> @lang('Top Up average rating')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('sort_by:')</b> <span> @lang('Top Up sorting, 1 for sort by date, 2 for sort by price etc.')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('status:')</b> <span> @lang('Top Up Status. It Should be 1 For All Active Top Up')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('image:')</b> <span> @lang('The Top Up Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('preview_image:')</b> <span> @lang('The Top Up Preview Image Url Path')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('active_services:')</b> <span> @lang('The TopUp active services')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('created_at:')</b> <span> @lang('The TopUp created date')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('updated_at:')</b> <span> @lang('The TopUp updated date')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('top_up_detail_route:')</b> <span> @lang('The TopUp detail route')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('reviewStatic:')</b> <span> @lang('The TopUp review and reviewable or not')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('gateways:')</b> <span> @lang('The active gateways for payment')</span>
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
                                                <button class="nav-link active" id="cUrl-tab3"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl3" type="button" role="tab"
                                                        aria-controls="cUrl3"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab3" data-bs-toggle="pill"
                                                        data-bs-target="#PHP3" type="button" role="tab"
                                                        aria-controls="PHP3" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab3" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby3" type="button" role="tab"
                                                        aria-controls="Ruby3"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab3"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js3"
                                                        type="button" role="tab" aria-controls="Node-js3"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab3" data-bs-toggle="pill"
                                                        data-bs-target="#Python3" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js3" role="tabpanel"
                                             aria-labelledby="Node-js-tab3" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/top-up/details?slug={slug}',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN',
    'Cookie': '....'
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
                                        <div class="tab-pane fade" id="Python3" role="tabpanel"
                                             aria-labelledby="Python-tab3" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/top-up/details?slug={slug}"

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
                                        <div class="tab-pane fade" id="PHP3" role="tabpanel"
                                             aria-labelledby="PHP-tab3" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$request = new Request('GET', 'BASE_URL/top-up/details?slug={slug}', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl3" role="tabpanel"
                                             aria-labelledby="cUrl-tab3" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/top-up/details?slug={slug}' \
--header 'Authorization: Bearer 3|zBS0kDnLrDVeejvPo3bICvNtnokQEzeao25NuphN438c7144' \
--header '...'
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
                                        <div class="tab-pane fade" id="Ruby3" role="tabpanel"
                                             aria-labelledby="Ruby-tab3" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/top-up/details?slug={slug}")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "..."

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
                                                <button class="nav-link active" id="OK-tab3"
                                                        data-bs-toggle="pill" data-bs-target="#OK3"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab3"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request3"
                                                        type="button" role="tab" aria-controls="Bad-Request3"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK3" role="tabpanel"
                                             aria-labelledby="OK-tab3" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "topUp": {
            "id": 10,
            "category_id": 12,
            "name": "PUBG Mobile UC (Global)",
            "slug": "pubg-mobile-uc-global",
            "region": "Global",
            "note": "Important Note: Not for Japanese / Korean / Taiwan / Vietnam servers.",
            "status": 1,
            "instant_delivery": 1,
            "image": {
                "image": "top-up/EyIRfPvWAhJ8T1uxY6Ykmh4USLVHr2.webp",
                "image_driver": "local",
                "preview": "top-up/d5aGlVfRWsen1EHYcwhrV4IojFBEMP.webp",
                "preview_driver": "local"
            },
            "order_information": [
                {
                    "field_value": "User ID",
                    "field_name": "User_Id",
                    "field_placeholder": "User ID",
                    "field_note": "Check your user id from setting",
                    "field_type": "text"
                },
                {
                    "field_value": "Server",
                    "field_name": "Server",
                    "field_placeholder": "Server",
                    "field_note": "Check your server from setting",
                    "field_type": "select",
                    "option": {
                        "Asia": "Asia",
                        "Europe": "Europe",
                        "America": "America"
                    }
                }
            ],
            "description": "About PUBG Mobile UC\r\nPlayerUnknown Battleground Mobile&nbsp;or&nbsp;PUBG Mobile&nbsp;is an original battle royale.",
            "guide": "How to top-up PUBG Mobile UC?\r\n\r\nSelect the Unknown Cash UC denomination.\r\nEnter your PUBG Mobile Player ID.",
            "total_review": 1,
            "avg_rating": 5,
            "sort_by": 1,
            "deleted_at": null,
            "created_at": "2025-03-04T10:18:40.000000Z",
            "updated_at": "2025-03-05T11:43:51.000000Z",
            "preview_image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/top-up/d5aGlVfRWsen1EHYcwhrV4IojFBEMP.webp",
            "top_up_detail_route": "http://192.168.0.123/gamers-arena/gamers/direct-topup/details/pubg-mobile-uc-global",
            "active_services": [
                {
                    "id": 29,
                    "top_up_id": 10,
                    "name": "60 UC",
                    "image": "top-up-service/GDemkOKkh1hxhICw3jXl7A9Q10eIrI.webp",
                    "image_driver": "local",
                    "price": 10,
                    "discount": 2,
                    "discount_type": "percentage",
                    "status": 1,
                    "is_offered": 0,
                    "offered_sell": 0,
                    "max_sell": 0,
                    "sort_by": 1,
                    "old_data": null,
                    "campaign_data": null,
                    "created_at": "2025-03-04T10:21:36.000000Z",
                    "updated_at": "2025-03-06T04:58:14.000000Z",
                    "currency": "USD",
                    "currency_symbol": "$",
                    "discountedAmount": 0.2,
                    "discountedPriceWithoutDiscount": 9.8,
                    "image_path": "http://192.168.0.123/gamers-arena/gamers/assets/upload/top-up-service/GDemkOKkh1hxhICw3jXl7A9Q10eIrI.webp"
                },
                ...
            ]
        },
        "reviewStatic": {
            "reviews": [
                {
                    "id": 21,
                    "reviewable_type": "App\\Models\\TopUp",
                    "reviewable_id": 10,
                    "user_id": 24,
                    "rating": 5,
                    "comment": "Absolutely fantastic experience! The service was seamless, and everything worked perfectly. Highly recommended!",
                    "status": 1,
                    "created_at": "2025-03-06T05:10:17.000000Z",
                    "updated_at": "2025-03-06T05:10:17.000000Z",
                    "user": {
                        "id": 24,
                        "firstname": "Tony",
                        "lastname": "Grady",
                        "email": "torphy.yasmin@example.net",
                        "image_driver": null,
                        "image": null,
                        "LastSeenActivity": false,
                        "imgPath": "http://192.168.0.123/gamers-arena/gamers/assets/admin/img/default.png",
                        "fullname": "Tony Grady"
                    }
                },
                ...
            ],
            "hasAlreadyOrdered": true
        },
        "gateways": [
            {
                "id": 2,
                "code": "stripe",
                "name": "Stripe",
                "sort_by": 1,
                "image": "http://192.168.0.123/gamers-arena/gamers/assets/upload/gateway/fkcARCIw6q6Fb3DY1AIS3FvxCc0khe.webp",
                "driver": "local",
                "status": 1,
                "parameters": {
                    "secret_key": "sk_test_XXXXXXXXXXXX",
                    "publishable_key": "pk_test_XXXXXXXXXXXX"
                },
                "currencies": {
                    "0": {
                        "USD": "USD",
                        "AUD": "AUD",
                        "BRL": "BRL",
                        "CAD": "CAD",
                        "CHF": "CHF",
                        "DKK": "DKK",
                        "EUR": "EUR",
                        "GBP": "GBP",
                        "HKD": "HKD",
                        "INR": "INR",
                        "JPY": "JPY",
                        "MXN": "MXN",
                        "MYR": "MYR",
                        "NOK": "NOK",
                        "NZD": "NZD",
                        "PLN": "PLN",
                        "SEK": "SEK",
                        "SGD": "SGD"
                    }
                },
                "extra_parameters": null,
                "supported_currency": [
                    "USD",
                    "EUR",
                    "GBP"
                ],
                "receivable_currencies": [
                    {
                        "name": "USD",
                        "currency_symbol": "USD",
                        "conversion_rate": "1",
                        "min_limit": "0.1",
                        "max_limit": "100000",
                        "percentage_charge": "1",
                        "fixed_charge": "0"
                    },
                    ...
                ],
                "description": "Send form your payment gateway. your bank may charge you a cash advance fee.",
                "currency_type": 1,
                "is_sandbox": 1,
                "environment": "test",
                "is_manual": null,
                "note": null,
                "created_at": "2020-09-10T09:05:02.000000Z",
                "updated_at": "2025-03-05T06:31:09.000000Z"
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
                                        <div class="tab-pane fade" id="Bad-Request3" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab3" tabindex="0">
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

            <div class="docs-section" id="getTopUpServices">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Top Up Services')</h4>
                        <p>
                            @lang("To get all the Top Up Services list follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}topup/services</i>
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
                                    <b> top_up_id: </b> <span> Top up id </span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b> name: </b>
                                    <span> Service Name </span>
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
                                    <b>image_path:</b> <span> Service image path</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('sort_by:')</b> <span> @lang('Top Up sorting, 1 for sort by date, 2 for sort by price etc.')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('created_at:')</b> <span> @lang('The TopUp created date')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('updated_at:')</b> <span> @lang('The TopUp updated date')</span>
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
                                                <button class="nav-link active" id="cUrl-tab4"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl4" type="button" role="tab"
                                                        aria-controls="cUrl4"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab4" data-bs-toggle="pill"
                                                        data-bs-target="#PHP4" type="button" role="tab"
                                                        aria-controls="PHP4" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab4" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby4" type="button" role="tab"
                                                        aria-controls="Ruby4"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab4"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js4"
                                                        type="button" role="tab" aria-controls="Node-js4"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab4" data-bs-toggle="pill"
                                                        data-bs-target="#Python4" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js4" role="tabpanel"
                                             aria-labelledby="Node-js-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/topup/services',
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
                                        <div class="tab-pane fade" id="Python4" role="tabpanel"
                                             aria-labelledby="Python-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/topup/services"

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
                                        <div class="tab-pane fade" id="PHP4" role="tabpanel"
                                             aria-labelledby="PHP-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$request = new Request('GET', 'BASE_URL/topup/services', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl4" role="tabpanel"
                                             aria-labelledby="cUrl-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/topup/services' \
--header 'YOUR_BEARER_TOKEN' \
--header '...'
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
                                        <div class="tab-pane fade" id="Ruby4" role="tabpanel"
                                             aria-labelledby="Ruby-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/api/topup/services")

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
                                                <button class="nav-link active" id="OK-tab4"
                                                        data-bs-toggle="pill" data-bs-target="#OK4"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab4"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request4"
                                                        type="button" role="tab" aria-controls="Bad-Request4"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK4" role="tabpanel"
                                             aria-labelledby="OK-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "services": [
            {
                "id": 1,
                "top_up_id": 2,
                "name": "MICO Live 88 Coins",
                "price": 2.8,
                "discount": 5,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 1,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
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
                                        <div class="tab-pane fade" id="Bad-Request4" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab4" tabindex="0">
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

            <div class="docs-section" id="getServicesByTopUp">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Services By Top Up')</h4>
                        <p>
                            @lang("To get Services of the Top Up list follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}topup/services?top_up_id={top_up_id}</i>
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
                                    <b> top_up_id: </b> <span> Top up id </span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b> name: </b>
                                    <span> Service Name </span>
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
                                    <b>image_path:</b> <span> Service image path</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('sort_by:')</b> <span> @lang('Top Up sorting, 1 for sort by date, 2 for sort by price etc.')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('created_at:')</b> <span> @lang('The TopUp created date')</span>
                                </p>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>@lang('updated_at:')</b> <span> @lang('The TopUp updated date')</span>
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
                                                <button class="nav-link active" id="cUrl-tab41"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl41" type="button" role="tab"
                                                        aria-controls="cUrl41"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab41" data-bs-toggle="pill"
                                                        data-bs-target="#PHP41" type="button" role="tab"
                                                        aria-controls="PHP41" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab41" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby41" type="button" role="tab"
                                                        aria-controls="Ruby41"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab41"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js41"
                                                        type="button" role="tab" aria-controls="Node-js41"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab41" data-bs-toggle="pill"
                                                        data-bs-target="#Python41" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js41" role="tabpanel"
                                             aria-labelledby="Node-js-tab41" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/topup/services?top_up_id={top_up_id}',
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
                                        <div class="tab-pane fade" id="Python41" role="tabpanel"
                                             aria-labelledby="Python-tab41" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/topup/services?top_up_id=2"

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
                                        <div class="tab-pane fade" id="PHP41" role="tabpanel"
                                             aria-labelledby="PHP-tab4" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$request = new Request('GET', 'BASE_URL/topup/services?top_up_id={top_up_id}', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl41" role="tabpanel"
                                             aria-labelledby="cUrl-tab41" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/topup/services?top_up_id={top_up_id}' \
--header 'YOUR_BEARER_TOKEN' \
--header '...'
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
                                        <div class="tab-pane fade" id="Ruby41" role="tabpanel"
                                             aria-labelledby="Ruby-tab41" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/topup/services?top_up_id={top_up_id}")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "..."

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
                                                <button class="nav-link active" id="OK-tab41"
                                                        data-bs-toggle="pill" data-bs-target="#OK41"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab41"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request41"
                                                        type="button" role="tab" aria-controls="Bad-Request41"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK41" role="tabpanel"
                                             aria-labelledby="OK-tab41" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "services": [
            {
                "id": 1,
                "top_up_id": 2,
                "name": "MICO Live 88 Coins",
                "price": 2.8,
                "discount": 5,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 1,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
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
            {
                "id": 2,
                "top_up_id": 2,
                "name": "MICO Live 100 Coins",
                "price": 3.8,
                "discount": 3,
                "discount_type": "percentage",
                "status": 1,
                "is_offered": 0,
                "offered_sell": 0,
                "max_sell": 0,
                "sort_by": 1,
                "old_data": null,
                "campaign_data": null,
                "created_at": "2025-03-04T09:58:09.000000Z",
                "updated_at": "2025-03-06T04:58:14.000000Z",
                "image_path": "http://192.168.0.123/gamers-arena/gamers/assets/upload/top-up-service/1MrpTXWVGuN8jmV6wPfSUKnTs1xItE.webp"
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
                                        <div class="tab-pane fade" id="Bad-Request41" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab41" tabindex="0">
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

            <div class="docs-section" id="orderTopUp">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Order Top Up')</h4>
                        <p>
                            @lang("To order top up follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}top-up/make-order</i>
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
                                    <b>topUpId<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">integer</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            The id of Top-Up, Must be in integer positive value </p>
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
                                    <b>serviceId<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">integer</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            The id of Top-Up Service, Must be in integer positive value </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>User_Id<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">text</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            Order information of the top up. You get from <a href="#topUpDetail" class="docs-link">Top Up Details</a> endpoint.
                                        Pass the all order_information field_name here</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="587412">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>Zone_Name<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">text</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            Order information of the top up. You get from <a href="#topUpDetail" class="docs-link">Top Up Details</a> endpoint.
                                            Pass the all order_information field_name here</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="Z4552287">
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
                                                <button class="nav-link active" id="cUrl-tab8"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl8" type="button" role="tab"
                                                        aria-controls="cUrl8"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab8" data-bs-toggle="pill"
                                                        data-bs-target="#PHP8" type="button" role="tab"
                                                        aria-controls="PHP8" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab8" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby8" type="button" role="tab"
                                                        aria-controls="Ruby8"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab8"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js8"
                                                        type="button" role="tab" aria-controls="Node-js8"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab8" data-bs-toggle="pill"
                                                        data-bs-target="#Python8" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js8" role="tabpanel"
                                             aria-labelledby="Node-js-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'POST',
  'url': 'BASE_URL/top-up/make-order',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN',
    'Cookie': '...'
  },
  formData: {
    'topUpId': '2',
    'serviceId': '1',
    'Player_Id': '300',
    'Zone_Name': 'Asia'
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
                                        <div class="tab-pane fade" id="Python8" role="tabpanel"
                                             aria-labelledby="Python-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/top-up/make-order"

payload = {'topUpId': '2',
'serviceId': '1',
'Player_Id': '300',
'Zone_Name': 'Asia'}
files=[

]
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN',
  'Cookie': 'YOUR_BEARER_TOKEN'
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
                                        <div class="tab-pane fade" id="PHP8" role="tabpanel"
                                             aria-labelledby="PHP-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php
$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$options = [
  'multipart' => [
    [
      'name' => 'topUpId',
      'contents' => '2'
    ],
    [
      'name' => 'serviceId',
      'contents' => '1'
    ],
    [
      'name' => 'Player_Id',
      'contents' => '300'
    ],
    [
      'name' => 'Zone_Name',
      'contents' => 'Asia'
    ]
]];
$request = new Request('POST', 'BASE_URL/top-up/make-order', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl8" role="tabpanel"
                                             aria-labelledby="cUrl-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/top-up/make-order' \
--header 'YOUR_BEARER_TOKEN' \
--header 'Cookie: ....' \
--form 'topUpId="2"' \
--form 'serviceId="1"' \
--form 'Player_Id="300"' \
--form 'Zone_Name="Asia"'
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
                                        <div class="tab-pane fade" id="Ruby8" role="tabpanel"
                                             aria-labelledby="Ruby-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/top-up/make-order")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Post.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "..."
form_data = [['topUpId', '2'],['serviceId', '1'],['Player_Id', '300'],['Zone_Name', 'Asia']]
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
                                                <button class="nav-link active" id="OK-tab8"
                                                        data-bs-toggle="pill" data-bs-target="#OK8"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab8"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request8"
                                                        type="button" role="tab" aria-controls="Bad-Request8"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK8" role="tabpanel"
                                             aria-labelledby="OK-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": "Order has been placed successfully"
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
                                        <div class="tab-pane fade" id="Bad-Request8" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab8" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
{
    "status": "failed",
    "errors": [
        "The top up id field is required.",
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

            <div class="docs-section" id="getTopUpReview">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Top Up Reviews')</h4>
                        <p>
                            @lang("To get Reviews of the Top Up list follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}topup/review?top_up_id={top_up_id}</i>
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
                                    <b>rating:</b> <span> Top up rating. min value 1 max value 5</span>
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
                                                <button class="nav-link active" id="cUrl-tab5"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl5" type="button" role="tab"
                                                        aria-controls="cUrl5"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab5" data-bs-toggle="pill"
                                                        data-bs-target="#PHP5" type="button" role="tab"
                                                        aria-controls="PHP5" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab5" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby5" type="button" role="tab"
                                                        aria-controls="Ruby5"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab5"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js5"
                                                        type="button" role="tab" aria-controls="Node-js5"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab5" data-bs-toggle="pill"
                                                        data-bs-target="#Python5" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js5" role="tabpanel"
                                             aria-labelledby="Node-js-tab5" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'GET',
  'url': 'BASE_URL/topup/review?top_up_id=10',
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
                                        <div class="tab-pane fade" id="Python5" role="tabpanel"
                                             aria-labelledby="Python-tab5" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/topup/review?top_up_id=10"

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
                                        <div class="tab-pane fade" id="PHP5" role="tabpanel"
                                             aria-labelledby="PHP-tab5" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$request = new Request('GET', 'BASE_URL/topup/review?top_up_id=10', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl5" role="tabpanel"
                                             aria-labelledby="cUrl-tab5" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/topup/review?top_up_id=10' \
--header 'YOUR_BEARER_TOKEN' \
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
                                        <div class="tab-pane fade" id="Ruby5" role="tabpanel"
                                             aria-labelledby="Ruby-tab5" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/topup/review?top_up_id=10")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Get.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "..."

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
                                                <button class="nav-link active" id="OK-tab5"
                                                        data-bs-toggle="pill" data-bs-target="#OK5"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab5"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request5"
                                                        type="button" role="tab" aria-controls="Bad-Request5"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK5" role="tabpanel"
                                             aria-labelledby="OK-tab5" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": {
        "reviews": [
            {
                "id": 21,
                "rating": 5,
                "comment": "Absolutely fantastic experience! The service was seamless, and everything worked perfectly. Highly recommended!",
                "status": 1,
                "created_at": "2025-03-06T05:10:17.000000Z",
                "updated_at": "2025-03-06T05:10:17.000000Z",
                "user": {
                    "id": 24,
                    "firstname": "Tony",
                    "lastname": "Grady",
                    "image": null,
                    "image_driver": null,
                    "imgPath": "http://192.168.0.123/gamers-arena/gamers/assets/admin/img/default.png",
                    "LastSeenActivity": false,
                    "fullname": "Tony Grady"
                }
            },
            ...
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
                                        <div class="tab-pane fade" id="Bad-Request5" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab5" tabindex="0">
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

            <div class="docs-section" id="addTopUpReview">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Add Top Up Reviews')</h4>
                        <p>
                            @lang("To give a rating of top up follow the example code and be careful with the parameters.")
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
                                {{$baseUrl}}topup/review</i>
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
                                    <b>topUpId<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">integer</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            The id of Top-Up, Must be in integer positive value </p>
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
                                                <button class="nav-link active" id="cUrl-tab6"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl6" type="button" role="tab"
                                                        aria-controls="cUrl6"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab6" data-bs-toggle="pill"
                                                        data-bs-target="#PHP6" type="button" role="tab"
                                                        aria-controls="PHP6" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab6" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby6" type="button" role="tab"
                                                        aria-controls="Ruby6"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab6"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js6"
                                                        type="button" role="tab" aria-controls="Node-js6"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab6" data-bs-toggle="pill"
                                                        data-bs-target="#Python6" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js6" role="tabpanel"
                                             aria-labelledby="Node-js-tab6" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'POST',
  'url': 'BASE_URL/topup/review',
  'headers': {
    'Authorization': 'YOUR_BEARER_TOKEN',
    'Cookie': '...'
  },
  formData: {
    'topUpId': '2',
    'rating': '5',
    'comment': 'my comment'
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
                                        <div class="tab-pane fade" id="Python6" role="tabpanel"
                                             aria-labelledby="Python-tab6" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/topup/review"

payload = {'topUpId': '2',
'rating': '5',
'comment': 'my comment'}
files=[

]
headers = {
  'Authorization': 'YOUR_BEARER_TOKEN',
  'Cookie': '....'
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
                                        <div class="tab-pane fade" id="PHP6" role="tabpanel"
                                             aria-labelledby="PHP-tab6" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php
$client = new Client();
$headers = [
  'Authorization' => 'YOUR_BEARER_TOKEN',
  'Cookie' => '...'
];
$options = [
  'multipart' => [
    [
      'name' => 'topUpId',
      'contents' => '2'
    ],
    [
      'name' => 'rating',
      'contents' => '5'
    ],
    [
      'name' => 'comment',
      'contents' => 'my comment'
    ]
]];
$request = new Request('POST', 'BASE_URL/topup/review', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl6" role="tabpanel"
                                             aria-labelledby="cUrl-tab6" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location 'BASE_URL/topup/review' \
--header 'Authorization: YOUR_BEARER_TOKEN' \
--header '...' \
--form 'topUpId="2"' \
--form 'rating="5"' \
--form 'comment="my comment"'
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
                                        <div class="tab-pane fade" id="Ruby6" role="tabpanel"
                                             aria-labelledby="Ruby-tab6" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/topup/review")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Post.new(url)
request["Authorization"] = "YOUR_BEARER_TOKEN"
request["Cookie"] = "...."
form_data = [['topUpId', '2'],['rating', '5'],['comment', 'my comment']]
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
                                                <button class="nav-link active" id="OK-tab6"
                                                        data-bs-toggle="pill" data-bs-target="#OK6"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab6"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request6"
                                                        type="button" role="tab" aria-controls="Bad-Request6"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK6" role="tabpanel"
                                             aria-labelledby="OK-tab6" tabindex="0">
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
                                        <div class="tab-pane fade" id="Bad-Request6" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab6" tabindex="0">
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

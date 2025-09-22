<div class="main-wrapper">
    <div class="row g-4">
        <div class="col-12">
            <h3 class="docs-section-title">
                @lang('Generated Bearer Token')
            </h3>
            <div class="docs-section" id="getBearer">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="docs-title">@lang('#Get Token')</h4>
                        <p>
                            @lang("To generate the bearer token follow the example code and be careful with the parameters.")
                        </p>
                        <p class="d-flex align-items-center gap-2"><span
                                class="badge text-bg-success">@lang('Base Url')</span><i>{{$baseUrl}}</i></p>

                        <p>
                            <b>@lang("HTTP Method:")</b>
                            <code><span>POST</span></code>
                        </p>
                        <p>
                            <b>@lang("API URL:")</b>
                            <i class="text-primary">
                                {{$baseUrl}}generate/authorization-token</i>
                        </p>
                        <p>
                            <b>@lang("API Key:")</b>
                            <span>@lang("Get <code>YOUR_PUBLIC_KEY </code> and <code>YOUR_SECRET_KEY </code> from the account page") <a
                                    class="docs-link" href="{{route('user.apiKey')}}">API Key</a></span>
                        </p>
                        <p>
                            <b>@lang("Response format:")</b>
                            <span>@lang("JSON")</span>
                        </p>
                        <hr>
                        <h5 class="mb-3">@lang("Header Params")</h5>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>PublicKey<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">string</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            Find the PublicKey from user dashboard </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="YOUR PUBLIC KEY">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <b>SecretKey<span class="text-danger">*</span></b>
                                    <span class="badge text-bg-info">string</span>
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0">
                                            Find the SecretKey from user dashboard </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" value="YOUR SECRET KEY">
                                    </div>
                                </div>
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
                                                <button class="nav-link active" id="cUrl-tab78"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#cUrl78" type="button" role="tab"
                                                        aria-controls="cUrl78"
                                                        aria-selected="false">@lang("cURL")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="PHP-tab78" data-bs-toggle="pill"
                                                        data-bs-target="#PHP78" type="button" role="tab"
                                                        aria-controls="PHP78" aria-selected="false">@lang("PHP")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Ruby-tab78" data-bs-toggle="pill"
                                                        data-bs-target="#Ruby78" type="button" role="tab"
                                                        aria-controls="Ruby78"
                                                        aria-selected="false">@lang("Ruby")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Node-js-tab78"
                                                        data-bs-toggle="pill" data-bs-target="#Node-js78"
                                                        type="button" role="tab" aria-controls="Node-js78"
                                                        aria-selected="true">@lang("Node.js")
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Python-tab78" data-bs-toggle="pill"
                                                        data-bs-target="#Python78" type="button" role="tab"
                                                        aria-controls="Python"
                                                        aria-selected="false">@lang("Python")
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade" id="Node-js78" role="tabpanel"
                                             aria-labelledby="Node-js-tab78" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre">
                                                                <code class="docs-code">
var request = require('request');
var options = {
  'method': 'POST',
  'url': 'BASE_URL/generate/authorization-token',
  'headers': {
    'PublicKey': 'YOUR_PUBLIC_KEY',
    'SecretKey': 'YOUR_SECRET_KEY'
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
                                        <div class="tab-pane fade" id="Python78" role="tabpanel"
                                             aria-labelledby="Python-tab78" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
import requests

url = "BASE_URL/generate/authorization-token"

payload={}
headers = {
  'PublicKey': 'YOUR_PUBLIC_KEY',
  'SecretKey': 'YOUR_SECRET_KEY'
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
                                        <div class="tab-pane fade" id="PHP78" role="tabpanel"
                                             aria-labelledby="PHP-tab78" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
?php

$client = new Client();
$headers = [
  'PublicKey' => 'YOUR_PUBLIC_KEY',
  'SecretKey' => 'YOUR_SECRET_KEY'
];
$request = new Request('POST', 'BASE_URL/generate/authorization-token', $headers);
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
                                        <div class="tab-pane fade show active" id="cUrl78" role="tabpanel"
                                             aria-labelledby="cUrl-tab78" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
curl --location --request POST 'BASE_URL/generate/authorization-token' \
--header 'PublicKey: YOUR_PUBLIC_KEY' \
--header 'SecretKey: YOUR_SECRET_KEY'</code></pre>
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
                                        <div class="tab-pane fade" id="Ruby78" role="tabpanel"
                                             aria-labelledby="Ruby-tab78" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
require "uri"
require "net/http"

url = URI("BASE_URL/generate/authorization-token")

http = Net::HTTP.new(url.host, url.port);
request = Net::HTTP::Post.new(url)
request["PublicKey"] = "YOUR_PUBLIC_KEY"
request["SecretKey"] = "YOUR_SECRET_KEY"

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
                                                <button class="nav-link active" id="OK-tab78"
                                                        data-bs-toggle="pill" data-bs-target="#OK78"
                                                        type="button"
                                                        role="tab" aria-controls="OK" aria-selected="true">200
                                                    OK
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Bad-Request-tab78"
                                                        data-bs-toggle="pill" data-bs-target="#Bad-Request78"
                                                        type="button" role="tab" aria-controls="Bad-Request78"
                                                        aria-selected="false">400 Bad
                                                    Request
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="editor-content-area">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="OK78" role="tabpanel"
                                             aria-labelledby="OK-tab78" tabindex="0">
                                            <div class="language-bash">
                                                <div class="language-bash-inner">
                                                            <pre class="docs-pre"><code class="docs-code">
{
    "status": "success",
    "message": "Token generated successfully",
    "bearer_token": "2|pz4WUIZZ9ugWvI1xiu6V7cs05mTrtD2ErRzLs8fFfc4d55c8"
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
                                        <div class="tab-pane fade" id="Bad-Request78" role="tabpanel"
                                             aria-labelledby="Bad-Request-tab78" tabindex="0">
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

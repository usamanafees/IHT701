@extends('partials.main')

@section('content')


<style>


.code-editor span.control:before,
.code-editor span.after:after {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -o-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    content: '';
    position: absolute;
    z-index: 1;
    -webkit-transition: all .5s ease-in-out;
    -moz-transition: wall .5s ease-in-out;
    -o-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
}

.code-editor {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -o-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    margin: 30px auto 0 auto;
    width: 950px; 
    text-align: left;
    background-color: #473431;
    border-radius: 0 0 5px 5px;
    overflow: auto;
    -webkit-transition: all .5s ease-in-out;
    -moz-transition: wall .5s ease-in-out;
    -o-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
}

.code-editor:before {
    font-family: 'Consolas';
    color: #222;
    padding-top: 6px; 
    text-align: center;
    top: 25px;
    width: 750px;
    height: 30px;
    background-color: #fafafa;
    border-radius: 5px 5px 0 0;
    -moz-border-radius: 5px 5px 0 0;
    -o-border-radius: 5px 5px 0 0;
    -webkit-border-radius: 5px 5px 0 0;
}

.code-editor span.control:before {
    content: '';
    top: 34px;
    z-index: 2;
    padding: 6px;
    border-radius: 20px;
    -moz-border-radius: 20px;
    -o-border-radius: 20px;
    -webkit-border-radius: 20px;
}

/**
 * prism.js tomorrow night eighties for JavaScript, CoffeeScript, CSS and HTML
 * Based on https://github.com/chriskempson/tomorrow-theme
 * @author Rose Pritchard
 */

code[class*="language-"],
pre[class*="language-"] {
  color: #ccc;
  font-family: Consolas, Monaco, 'Andale Mono', monospace;
  direction: ltr;
  text-align: left;
  white-space: pre;
  word-spacing: normal;

  -moz-tab-size: 4;
  -o-tab-size: 4;
  tab-size: 4;

  -webkit-hyphens: none;
  -moz-hyphens: none;
  -ms-hyphens: none;
  hyphens: none;

}

/* Code blocks */
pre[class*="language-"] {
  padding: 1em;
  margin: 0em 0;
  height: 500px;
  overflow: auto;
}

:not(pre) > code[class*="language-"],
pre[class*="language-"] {
  background: #473431;
}

/* Inline code */
:not(pre) > code[class*="language-"] {
  padding: .1em;
  border-radius: .3em;
  -moz-border-radius: .3em;
  -o-border-radius: .3em;
  -webkit-border-radius: .3em;
}

.token.comment,
.token.block-comment,
.token.prolog,
.token.doctype,
.token.cdata {
  color: #999;
}

.token.punctuation {
  color: #ccc;
}


.token.tag,
.token.attr-name,
.token.namespace {
  color: #e2777a;
}

.token.function-name {
  color: #6196cc;
}


.token.boolean,
.token.number,
.token.function {
  color: #f08d49;
}

.token.property,
.token.class-name,
.token.constant,
.token.symbol {
  color: #f8c555;
}

.token.selector,
.token.important,
.token.atrule,
.token.keyword,
.token.builtin {
  color: #cc99cd;
}

.token.string,
.token.attr-value,
.token.regex,
.token.variable {
  color: #7ec699;
}

.token.operator,
.token.entity,
.token.url
{
  color: #67cdcc;
}


.token.important {
  font-weight: bold;
}

.token.entity {
  cursor: help;
}

pre.line-numbers {
    position: relative;
    padding-left: 3.8em;
    counter-reset: linenumber;
    padding-bottom: 1px;
}

pre.line-numbers > code {
    position: relative;
}

.line-numbers .line-numbers-rows {
    position: absolute;
    pointer-events: none;
    top: 0;

    font-size: 100%;
    left: -13em;
    width: 3em; /* works for line-numbers below 1000 lines */
    letter-spacing: -1px;
    background-color: #322422;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;

}

.line-numbers-rows > span {
    pointer-events: none;
    display: block;
    counter-increment: linenumber;
}

.line-numbers-rows > span:before {
    content: counter(linenumber);
    color: #999;
    display: block;
    padding-right: 0.8em;
    text-align: right;
}
</style>

<script>
    /**
 * Prism: Lightweight, robust, elegant syntax highlighting
 * MIT license https://www.opensource.org/licenses/mit-license.php/
 * @author Lea Verou http://lea.verou.me
 */(function(){var e=/\blang(?:uage)?-(?!\*)(\w+)\b/i,t=self.Prism={util:{type:function(e){return Object.prototype.toString.call(e).match(/\[object (\w+)\]/)[1]},clone:function(e){var n=t.util.type(e);switch(n){case"Object":var r={};for(var i in e)e.hasOwnProperty(i)&&(r[i]=t.util.clone(e[i]));return r;case"Array":return e.slice()}return e}},languages:{extend:function(e,n){var r=t.util.clone(t.languages[e]);for(var i in n)r[i]=n[i];return r},insertBefore:function(e,n,r,i){i=i||t.languages;var s=i[e],o={};for(var u in s)if(s.hasOwnProperty(u)){if(u==n)for(var a in r)r.hasOwnProperty(a)&&(o[a]=r[a]);o[u]=s[u]}return i[e]=o},DFS:function(e,n){for(var r in e){n.call(e,r,e[r]);t.util.type(e)==="Object"&&t.languages.DFS(e[r],n)}}},highlightAll:function(e,n){var r=document.querySelectorAll('code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code');for(var i=0,s;s=r[i++];)t.highlightElement(s,e===!0,n)},highlightElement:function(r,i,s){var o,u,a=r;while(a&&!e.test(a.className))a=a.parentNode;if(a){o=(a.className.match(e)||[,""])[1];u=t.languages[o]}if(!u)return;r.className=r.className.replace(e,"").replace(/\s+/g," ")+" language-"+o;a=r.parentNode;/pre/i.test(a.nodeName)&&(a.className=a.className.replace(e,"").replace(/\s+/g," ")+" language-"+o);var f=r.textContent;if(!f)return;f=f.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/\u00a0/g," ");var l={element:r,language:o,grammar:u,code:f};t.hooks.run("before-highlight",l);if(i&&self.Worker){var c=new Worker(t.filename);c.onmessage=function(e){l.highlightedCode=n.stringify(JSON.parse(e.data),o);t.hooks.run("before-insert",l);l.element.innerHTML=l.highlightedCode;s&&s.call(l.element);t.hooks.run("after-highlight",l)};c.postMessage(JSON.stringify({language:l.language,code:l.code}))}else{l.highlightedCode=t.highlight(l.code,l.grammar,l.language);t.hooks.run("before-insert",l);l.element.innerHTML=l.highlightedCode;s&&s.call(r);t.hooks.run("after-highlight",l)}},highlight:function(e,r,i){return n.stringify(t.tokenize(e,r),i)},tokenize:function(e,n,r){var i=t.Token,s=[e],o=n.rest;if(o){for(var u in o)n[u]=o[u];delete n.rest}e:for(var u in n){if(!n.hasOwnProperty(u)||!n[u])continue;var a=n[u],f=a.inside,l=!!a.lookbehind,c=0;a=a.pattern||a;for(var h=0;h<s.length;h++){var p=s[h];if(s.length>e.length)break e;if(p instanceof i)continue;a.lastIndex=0;var d=a.exec(p);if(d){l&&(c=d[1].length);var v=d.index-1+c,d=d[0].slice(c),m=d.length,g=v+m,y=p.slice(0,v+1),b=p.slice(g+1),w=[h,1];y&&w.push(y);var E=new i(u,f?t.tokenize(d,f):d);w.push(E);b&&w.push(b);Array.prototype.splice.apply(s,w)}}}return s},hooks:{all:{},add:function(e,n){var r=t.hooks.all;r[e]=r[e]||[];r[e].push(n)},run:function(e,n){var r=t.hooks.all[e];if(!r||!r.length)return;for(var i=0,s;s=r[i++];)s(n)}}},n=t.Token=function(e,t){this.type=e;this.content=t};n.stringify=function(e,r,i){if(typeof e=="string")return e;if(Object.prototype.toString.call(e)=="[object Array]")return e.map(function(t){return n.stringify(t,r,e)}).join("");var s={type:e.type,content:n.stringify(e.content,r,i),tag:"span",classes:["token",e.type],attributes:{},language:r,parent:i};s.type=="comment"&&(s.attributes.spellcheck="true");t.hooks.run("wrap",s);var o="";for(var u in s.attributes)o+=u+'="'+(s.attributes[u]||"")+'"';return"<"+s.tag+' class="'+s.classes.join(" ")+'" '+o+">"+s.content+"</"+s.tag+">"};if(!self.document){self.addEventListener("message",function(e){var n=JSON.parse(e.data),r=n.language,i=n.code;self.postMessage(JSON.stringify(t.tokenize(i,t.languages[r])));self.close()},!1);return}var r=document.getElementsByTagName("script");r=r[r.length-1];if(r){t.filename=r.src;document.addEventListener&&!r.hasAttribute("data-manual")&&document.addEventListener("DOMContentLoaded",t.highlightAll)}})();;

Prism.languages.clike={comment:{pattern:/(^|[^\\])(\/\*[\w\W]*?\*\/|(^|[^:])\/\/.*?(\r?\n|$))/g,lookbehind:!0},string:/("|')(\\?.)*?\1/g,"class-name":{pattern:/((?:(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[a-z0-9_\.\\]+/ig,lookbehind:!0,inside:{punctuation:/(\.|\\)/}},keyword:/\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/g,"boolean":/\b(true|false)\b/g,"function":{pattern:/[a-z0-9_]+\(/ig,inside:{punctuation:/\(/}}, number:/\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/g,operator:/[-+]{1,2}|!|&lt;=?|>=?|={1,3}|(&amp;){1,2}|\|?\||\?|\*|\/|\~|\^|\%/g,ignore:/&(lt|gt|amp);/gi,punctuation:/[{}[\];(),.:]/g};
;
Prism.hooks.add("after-highlight",function(e){var t=e.element.parentNode;if(!t||!/pre/i.test(t.nodeName)||t.className.indexOf("line-numbers")===1){return}var n=1+e.code.split("\n").length;var r;lines=new Array(n);lines=lines.join("<span></span>");r=document.createElement("span");r.className="line-numbers-rows";r.innerHTML=lines;if(t.hasAttribute("data-start")){t.style.counterReset="linenumber "+(parseInt(t.getAttribute("data-start"),10)-1)}e.element.appendChild(r)})
;
</script>
      <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="breadcrumb mb-5" style="margin-top: -12px">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="{{route('/')}}">{{trans('menu.home')}}</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a>{{trans('menu.admin')}}</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a>API</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a class="breadcrumb-item active" href="">{{trans('users.dev')}}</a>
                            </li>
                        </div>
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('users.dev')}}
                                </div>
                            </div>
                        </div>
                    </div>   
                          
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>{{trans('users.account_url')}}</th>
                                    <td>{{ url('/') }}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('users.account_id')}}</th>
                                    <td>{{Auth::user()->id}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('users.api_key')}}</th>
                                    <td>{{Auth::user()->api_key}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('users.documentation')}}</th>
                                    <td><a target="_blank" href="{{ url('/') }}/documentation/Intelidus Api Documentation.pdf">Download</a></td>
                                </tr>
                            </table>
                            <div>
                                <h2>{{trans('users.code_examples')}}</h2>
                                <hr>
                                <h2>PHP</h2>
                                <div class="code-editor">
                                    <span class="control"></span>
                                    <span class="control"></span>
                                    <span class="control"></span>
                                    <pre class="line-numbers">
                <code class="language-clike">
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "{{ url('/') }}/api/addSMS?accountid={{Auth::user()->id}}&apikey={{Auth::user()->api_key}}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "admin_comment=Test%20New&massege=this%20is%20a%20test%20please%20ignore&sender_id=6&mobile_num_blk=918826481%2C918826481&template_Add=1&template_name=test%20man%20too&sms_schedule=1&start_date=01/01/2020&hh=16&mm=55&mobile_num=918826481",
  
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Content-Type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;'
                </code></pre></div>
                <hr>
                                <h2>JAVA</h2>
                                <div class="code-editor">
                                    <pre class="line-numbers">
                <code class="language-clike">   
OkHttpClient client = new OkHttpClient().newBuilder()

  .build();

MediaType mediaType = MediaType.parse("application/x-www-form-urlencoded");

RequestBody body = RequestBody.create(mediaType, "admin_comment=Test New&massege=this is a test please ignore&sender_id=6&mobile_num_blk=918826481,918826481&template_Add=1&template_name=test man too&sms_schedule=1&start_date=01/01/2020&hh=16&mm=55&mobile_num=918826481");

Request request = new Request.Builder()
  .url("{{ url('/') }}/api/addSMS?accountid={{Auth::user()->id}}&apikey={{Auth::user()->api_key}}")
  .method("POST", body)
  .addHeader("Accept", "application/json")
  .addHeader("Content-Type", "application/x-www-form-urlencoded")
  .build();

Response response = client.newCall(request).execute();
                                </code></pre></div>
                                <hr>
                                <h2>Ruby</h2>
                                <div class="code-editor">
<pre class="line-numbers">
                <code class="language-clike">
require "uri"

require "net/http"

url = URI("{{ url('/') }}/api/addSMS?accountid={{Auth::user()->id}}&apikey={{Auth::user()->api_key}}")

https = Net::HTTP.new(url.host, url.port);

https.use_ssl = true

request = Net::HTTP::Post.new(url)
request["Accept"] = "application/json"
request["Content-Type"] = "application/x-www-form-urlencoded"
request.body = "admin_comment=Test%20New&massege=this%20is%20a%20test%20please%20ignore&sender_id=6&mobile_num_blk=918826481%2C918826481&template_Add=1&template_name=test%20man%20too&sms_schedule=1&start_date=01/01/2020&hh=16&mm=55&mobile_num=918826481"

response = https.request(request)

puts response.read_body
                                </code></pre></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/login/colorlib.com_etc_regform_colorlib-regform-17_css_style.css" rel="stylesheet">
    <link href="assets/login/colorlib.com_etc_regform_colorlib-regform-17_fonts_material-design-iconic-font_css_material-design-iconic-font.min.css" rel="stylesheet">
    <link rel="icon" href="{{ url('/'.$fevico_image) }}" type="image/x-icon"/>
    <meta name="robots" content="noindex, follow">
    <script nonce="2c6aa72c-d17a-4dde-8722-b8074f188bef">(function(w,d){!function(du,dv,dw,dx){du[dw]=du[dw]||{};du[dw].executed=[];du.zaraz={deferred:[],listeners:[]};du.zaraz.q=[];du.zaraz._f=function(dy){return async function(){var dz=Array.prototype.slice.call(arguments);du.zaraz.q.push({m:dy,a:dz})}};for(const dA of["track","set","debug"])du.zaraz[dA]=du.zaraz._f(dA);du.zaraz.init=()=>{var dB=dv.getElementsByTagName(dx)[0],dC=dv.createElement(dx),dD=dv.getElementsByTagName("title")[0];dD&&(du[dw].t=dv.getElementsByTagName("title")[0].text);du[dw].x=Math.random();du[dw].w=du.screen.width;du[dw].h=du.screen.height;du[dw].j=du.innerHeight;du[dw].e=du.innerWidth;du[dw].l=du.location.href;du[dw].r=dv.referrer;du[dw].k=du.screen.colorDepth;du[dw].n=dv.characterSet;du[dw].o=(new Date).getTimezoneOffset();if(du.dataLayer)for(const dH of Object.entries(Object.entries(dataLayer).reduce(((dI,dJ)=>({...dI[1],...dJ[1]})),{})))zaraz.set(dH[0],dH[1],{scope:"page"});du[dw].q=[];for(;du.zaraz.q.length;){const dK=du.zaraz.q.shift();du[dw].q.push(dK)}dC.defer=!0;for(const dL of[localStorage,sessionStorage])Object.keys(dL||{}).filter((dN=>dN.startsWith("_zaraz_"))).forEach((dM=>{try{du[dw]["z_"+dM.slice(7)]=JSON.parse(dL.getItem(dM))}catch{du[dw]["z_"+dM.slice(7)]=dL.getItem(dM)}}));dC.referrerPolicy="origin";dC.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(du[dw])));dB.parentNode.insertBefore(dC,dB)};["complete","interactive"].includes(dv.readyState)?zaraz.init():du.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script>
<style type="text/css">
    .alert-danger {
        color: red;
    }
</style>
</head>
    <body>

        <div class="wrapper" style="background-image: url('{{ url('/'.$background) }}');">

            <div class="inner">
                <div class="image-holder">
                    <img src="{{ url('/'.$logo) }}" alt="">
                </div>

                {{ Form::open(array('url' => '/login','class' => '',"method"=>"POST", "autocomplete"=>"off")) }}

                <h3>Login Form</h3>

                 @if(Session::has('failure'))
                <div class="alert alert-danger" style="margin-top: 10px;">
                    <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success">
                    <i class="fa fa-ban-circle"></i><strong>success!</strong> {{Session::get('success')}}
                </div>
                @endif


                <div class="form-wrapper">
                    {{Form::email('email','',["class"=>"form-control","autocomplete"=>"off","required"=>"true","placeholder" => "User email"])}}

                </div>

                <div class="form-wrapper">

                    {{Form::password('password',["class"=>"form-control","required"=>"true","placeholder"=>"Password","autocomplete"=>"off"])}}



                </div>


                <div class="">
                    <button type="Submit" class="btn btn-main-primary btn-block">Sign In
                    </button>
                </div>


                {{Form::close()}}

            </div>
        </div>
  </body>
  </html>














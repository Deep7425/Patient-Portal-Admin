 @section('title', 'Lab Order Complete')
<style>
body{ background: #fff url(../img/thank-you-bg.png) no-repeat; background-position: center bottom;}

.login_sucess{width: 65%; margin: 0 auto;font-family: 'Inter', sans-serif !important; text-align: center;}
.login_sucess h1{font-family: 'Inter', sans-serif !important; margin:8% 0 0 0 ; padding:0px; font-size:60px; color:#00538a;}
.login_sucess h1 img{ width:60%;}
.login_sucess p{ font-family: 'Inter', sans-serif !important; margin: 10px 0 0 0; padding: 0px; line-height:24px; font-size: 15px;}

.login_sucess_ico i {border:3px solid #14bef0; border-radius:50%; color:#14bef0; display:inline-block; font-size:96px; height:120px; padding:28px;width:120px;}
.login_sucess_text {font-size: 31px;letter-spacing: 1px;}
.login_sucess_text span {color: #189ad4;}
.login_sucess a {color:#014a7f; font-weight:600; text-decoration:none;}

.login_sucess_ico {margin: 0px 0;}
.backcolor{ background:none;}

.login_sucess_text {font-family: raleway;}
.login_sucess_inner a{font-family: raleway; display: inline-block;}
.login_sucess_inner a:hover{background:#14bef0; color:#fff;}
.login_sucess_inner p{font-family: 'Inter', sans-serif !important; font-size:15px; color:#000; font-family: arial; font-weight:500; width:100%; float:left; margin-bottom:0px; line-height:25px;}
.login_sucess_inner p strong{ font-size:14px; color:#222; margin:30px 0 0 0;}

#my-tab-content .login_sucess_inner h1 {margin: 0px; padding: 0px;font-size: 35px; color:#00538a;}
#my-tab-content .login_sucess_inner .regards{     width: 100%;
    float: left;
	padding:25px 0;
	
    font-weight: 600;
    font-size: 16px;}
#my-tab-content .login_sucess_inner .regards a:hover{ background:#014a7f; color:#fff;}
#my-tab-content .login_sucess_inner .regards a{
    background: #ed560f;
    border: 0;
    color: #fff;
    font-family: 'Inter', sans-serif !important;
    border-radius: 100px;
    height: 45px;
    font-size: 16px;
	margin-top:2%;
	  transition: background-color 0.5s ease;

    font-weight: 600;
    padding: 0 20px;
    line-height: 45px;
}	
#my-tab-content .login_sucess_inner .regards a img{ margin:15px 5px 0 0; float:left;}	
#my-tab-content .login_sucess_inner {
    background: none;
    padding: 0px 0 0px 0;
    float: none;
    margin: 0% auto 0 auto;
    display: inline-block;
}

@media only screen and (max-width: 639px) {
body{background-size: 150%;}
.login_sucess h1{font-size:42px; margin-top:25%;}	
.login_sucess h1 img{ max-width:100%; width:70%;}
body .login_sucess p {
       font-family: 'Inter', sans-serif !important;
    margin: 10px 0 0 0;
    padding: 0px;
    font-size: 18px;
    letter-spacing: 0;
    font-weight: 500;
    line-height: 23px;
}	
 .login_sucess {width: 100%; margin: auto; text-align: center;}
 #my-tab-content .login_sucess_inner{ margin-top:0px;}

.login_sucess_text {
font-size: 20px;
    letter-spacing: 0;
    font-weight: 600;
}
.login_sucess_inner p {
    font-size: 13px;
   
}
}

@media only screen and (min-width: 640px) and (max-width: 767px) {
.login_sucess h1{ margin-top:0px;}	
.login_sucess h1 img{ width:60%;}

.login_sucess {  
	width: 80%;
    margin: auto;
    text-align: center;
    display: table;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.login_sucess_ico img {
    width: 70%;
}
.login_sucess_text {
    font-size: 23px;
    letter-spacing: 1px;
}
.login_sucess_inner p {
    font-size: 14px;}}
@media only screen and (min-width: 768px) and (max-width: 1024px) {
.login_sucess h1{ margin-top:15%;}	
.login_sucess h1 img{ width:70%;}
}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-12">
      <div class="login_sucess">
        <div id="my-tab-content" class="tab-content">
          <div class="tab-pane active">
              <h1><strong><img src="../img/thankyou-text.png"></strong></h1>
				<p>Wasn’t it thrilling to react to all the intriguing questions? Thank you for your time. Ring us up if you face any hiccups<br />
<a href="https://www.healthgennie.com/" target="_blank">Health Gennie</a> is happy to be at your service. 
                </p>              

               <div class="login_sucess_inner text-center">
                    <div class="regards">
                        <a href="https://www.healthgennie.com/download"><img src="../img/arrow-download.png" />Download Health Gennie App</a>
                    </div>
                <!--<a href="{{route('healthAsses')}}">Return to home page</a>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
</script>

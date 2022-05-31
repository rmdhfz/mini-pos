<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> <!DOCTYPE html> <!--[if lt IE 7]> <html class="ie ie6" lang="id-ID"> <![endif]--> <!--[if IE 7]> <html class="ie ie7" lang="id-ID"> <![endif]--> <!--[if IE 8]> <html class="ie ie8" lang="id-ID"> <![endif]--> <!--[if IE 9]> <html class="ie ie9" lang="id-ID"> <![endif]--> <!--[if (gte IE 9)|!(IE)]><!--> <html itemscope itemtype="http://schema.org/Web" lang="id-ID"> <!--<![endif]--> 
<head>
  <base href="<?php echo site_url();?>" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <title><?php echo APP_NAME; ?></title>
  <meta name="HandheldFriendly" content="1" />
  <meta name="MobileOptimized" content="320" />
  <meta name="UI/UX" content="Hafiz Ramadhan" />
  <meta name="Author" content="Hafiz Ramadhan" />
  <meta name="google-site-verification" content="<?php echo GOOGLE_SITE_VERIFICATION; ?>" />
  <link href="https://www.google.com" rel="dns-prefetch" />
  <link href="https://fonts.googleapis.com" rel="dns-prefetch" />
  <link href="https://cdnjs.cloudflare.com" rel="dns-prefetch" />
  <!-- <link rel="shortcut icon" href="<?php echo base_url('favicon.ico');?>" type="image/png" /> -->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <link href="https://oss.maxcdn.com" rel="dns-prefetch" />
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login-style.min.css'); ?>" media="screen"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/assets/css/loading.css') ?>" media="screen"/>
</head>
<body id="body">
  <section class="w3l-workinghny-form">
    <div class="workinghny-form-grid">
      <div class="wrapper">
        <div class="logo">
          <a class="brand-logo" href="<?php echo site_url() ?>">
            <h1><?php echo APP_NAME; ?></h1>
          </a>
        </div>
        <div class="workinghny-block-grid">
          <div class="form-right-inf">
            <div class="login-form-content">
              <form id="login" class="signin-form" method="post" autocomplete="off" style="margin-top: 2rem;">
                <input type="hidden" name="key" value="[hidden]">
                <input type="hidden" name="token" id="token" value="sample">
                <input type="hidden" name="ip_addr" id="ip_addr" value="<?php echo $this->input->ip_address(); ?>">
                <div class="one-frm">
                  <label>Username</label>
                  <input type="text" name="username" id="username" required="1" autocomplete="off" minlength="4" maxlength="35" placeholder="your username" autofocus="on" pattern="[a-zA-Z0-9\s]{4,35}">
                </div>
                <div class="one-frm">
                  <label>Password</label>
                  <input type="password" name="password" id="password" required="1" autocomplete="off" minlength="4" maxlength="35" placeholder="your password">
                </div>
                <button id="masuk" type="submit" class="btn btn-style mt-3"> Login </button>
              </form>
            </div>
          </div>
          <div class="workinghny-left-img">
            <img loading="lazy" src="<?php echo base_url('assets/images/background-login.png') ?>" draggable="false" class="img-responsive" />
          </div>
        </div>
      </div>
    </div>
    <div class="copyright text-center">
      <div class="wrapper">
        <p class="copy-footer-29">© 2022 <a href="<?php echo site_url() ?>"><?php echo APP_NAME; ?></a>. All rights reserved | Design by <a rel="noreferrer nofollow" href="https://linkedin.com/in/hfzrmd" target="_blank">Hafiz Ramadhan</a></p>
      </div>
    </div>
  </section>
</body>
<script type="text/javascript">

  document.addEventListener("DOMContentLoaded", (event) => {
    const disabledAllForms = (forms, disabled) => {
      let all = forms.elements;
      if (all) {
        for (let i = 0, l = all.length; i < l; ++i) {
          all[i].disabled = disabled;
        }
      }
    }

    const autoFocusUsername = () => {
      document.querySelector("#username").setAttribute('autofocus', 'on');
    }

    const form = document.getElementById('login');

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const data = new FormData(form);
      let http;
      if (window.XMLHttpRequest) {
        http = new XMLHttpRequest()
      }else{
        http = new ActiveXObject("Microsoft.XMLHTTP")
      }
      http.responseType = 'json';
      http.open('POST', '<?php echo site_url('verify');?>', true);
      http.send(data);
      disabledAllForms(form, 1);
      document.getElementById('body').classList.add('loading');
      http.onreadystatechange = ()=> {
        disabledAllForms(form, 0);
        document.getElementById('body').classList.remove('loading');
        if(http.readyState == 4 && http.status == 200){
          alert("Success login!");
          setInterval(()=> {
            window.location = "<?php echo site_url('dashboard');?>";
          }, 500);
        }else if (http.readyState == 4 && http.status == 404){
          alert(http.response.msg);
          location.reload(0);
          autoFocusUsername();
        }else if(http.readyState == 4 && http.status == 500){
          alert(http.response.msg);
          location.reload(0);
          autoFocusUsername();
        }else{
          console.log("error");
        }
      }
    });
  });
</script>
</html>
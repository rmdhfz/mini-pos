<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> <!DOCTYPE html> <!--[if lt IE 7]> <html class="ie ie6" lang="id-ID"> <![endif]--> <!--[if IE 7]> <html class="ie ie7" lang="id-ID"> <![endif]--> <!--[if IE 8]> <html class="ie ie8" lang="id-ID"> <![endif]--> <!--[if IE 9]> <html class="ie ie9" lang="id-ID"> <![endif]--> <!--[if (gte IE 9)|!(IE)]><!--> <html itemscope itemtype="http://schema.org/Web" lang="id-ID"> <!--<![endif]--> 
<head>
  <base href="<?php echo site_url();?>" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <title>Registrasi - Inventory Application</title>
  <meta name="HandheldFriendly" content="1" />
  <meta name="MobileOptimized" content="320" />
  <meta name="UI/UX" content="Hafiz Ramadhan" />
  <meta name="Author" content="Hafiz Ramadhan" />
  <meta name="google-site-verification" content="" />
  <link href="https://www.google.com" rel="dns-prefetch" />
  <link href="https://fonts.googleapis.com" rel="dns-prefetch" />
  <link href="https://cdnjs.cloudflare.com" rel="dns-prefetch" />
  <link rel="shortcut icon" href="<?php echo base_url('favicon.ico');?>" type="image/png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/owl.carousel.min.css') ?>" media="screen">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" media="screen">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>" media="screen">
</head>
<body>
  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" draggable="false" loading="lazy" style="background-image: url('assets/images/background-daftar.jpg');"></div>
    <div class="contents order-2 order-md-2">
      <div class="container">
        <div class="row align-items-center justify-content-center" style="margin-top: -3rem;">
          <div class="col-md-7">
            <div class="logo">
              <a class="brand-logo" href="<?php echo site_url() ?>">
                <img loading="lazy" src="<?php echo site_url('assets/images/logo.webp');?>" draggable="false" style="height: 4rem; width: 18rem;" />
              </a>
            </div><br>
            <div class="mb-4">
              <h3>Register</h3>
              <p class="mb-4">
                Silahkan lakukan pendaftaran untuk mendaftar Koas
              </p>
            </div>
            <form action="#" method="post" autocomplete="off">
              <div class="form-group first">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name">
              </div>
              <div class="form-group">
                <label for="nri">NRI</label>
                <input type="text" class="form-control" id="nri">
              </div>
              <div class="form-group last mb-3">
                <label for="angkatan">Angkatan</label>
                <select id="angkatan" name="angkatan" class="form-control"></select>
              </div>
              <div class="form-group last mb-3">
                <label for="paket">Paket</label>
                <select id="paket" name="paket" class="form-control"></select>  
              </div>
              <div class="form-group last mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username">  
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password">  
              </div>
              <input type="submit" value="Register" class="btn btn-block btn-primary">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/main.js') ?>"></script>
</body>
</html>
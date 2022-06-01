<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="ie ie6" lang="id-ID"> <![endif]-->
<!--[if IE 7]><html class="ie ie7" lang="id-ID"> <![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="id-ID"> <![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="id-ID"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="id">

    <!--<![endif]-->
    <head>

        <base href="<?php echo site_url(); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Dashboard &bull; <?php echo APP_NAME; ?></title>

        <meta name="whatsapp">
        <meta name="HandheldFriendly" content="1" />
        <meta name="MobileOptimized" content="320" />
        <meta name="UI/UX" content="Hafiz Ramadhan" />
        <meta name="Author" content="Hafiz Ramadhan" />

        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="#263544" name="theme-color" />
        <meta content="#263544" name="apple-mobile-web-app-status-bar-style" />
        <meta content="1" name="MSSmartTagsPreventParsing" />
        <meta content="#263544" name="msapplication-navbutton-color" />

        <link href="https://www.google.com" rel="dns-prefetch" />
        <link href="https://fonts.googleapis.com" rel="dns-prefetch" />
        <link href="https://cdnjs.cloudflare.com" rel="dns-prefetch" />

        <link rel="icon" href="static/assets/images/logo.png" type="image/x-icon" />
        <link rel="shortcut icon" href="static/assets/images/logo.png" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" media="screen, projection" />
        <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet" media="screen, projection" />

        <link rel="preload" type="text/css" href="static/assets/css/bootstrap.min.css" as="style" onload="this.rel='stylesheet'"/>
        <link rel="stylesheet" type="text/css" href="static/assets/css/waves.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/icon/feather/css/feather.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/font-awesome-n.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/style.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/widget.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/notif.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/loading.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/select2.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/jquery-ui.min.css" media="screen, projection" />

        <!-- datatable -->
        <link rel="stylesheet" type="text/css" href="static/assets/css/dataTables.bootstrap4.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/buttons.dataTables.min.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="static/assets/css/responsive.bootstrap4.min.css" media="screen, projection" />
        <!-- datatable -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <link href="https://oss.maxcdn.com" rel="dns-prefetch" />
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <!-- jquery -->
        <script importance="low" src="static/jquery.min.js"></script>
        <script importance="low" src="static/assets/js/jquery-ui.min.js"></script>
        <!-- jquery -->
        
        <!-- datatable -->
        <script importance="low" src="static/assets/js/jquery.dataTables.min.js"></script>
        <script importance="low" src="static/assets/js/dataTables.bootstrap4.min.js"></script>
        <script importance="low" src="static/assets/js/dataTables.responsive.min.js"></script>
        <script importance="low" src="static/assets/js/responsive.bootstrap4.min.js"></script>
        <!-- datatable -->


        <noscript> "<meta http-equiv="refresh" content="0 URL=<?php echo site_url('noscript'); ?>" />"</noscript>
        <style type="text/css" media="screen, projection">
            .loader {
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #3498db;
                width: 120px;
                height: 120px;
                -webkit-animation: spin 2s linear infinite; /* Safari */
                animation: spin 2s linear infinite;
            } /* Safari */
            @-webkit-keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
            .live {
                animation: blinker 1.5s cubic-bezier(0.5, 0, 1, 1) infinite alternate;
            }
            @keyframes blinker {
                from {
                    opacity: 5;
                }
                to {
                    opacity: 0;
                }
            }
            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type="file"] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
            .transition {
                cursor: zoom-in;
                -webkit-transform: scale(1.5);
                -moz-transform: scale(1.5);
                -o-transform: scale(1.5);
                transform: scale(1.5);
            }
            .noresize {
                resize: none;
            }
            @media only screen and (max-width: 767px) {
                .dt-buttons {
                    visibility: hidden;
                }
            }
            a.hapus:hover {
                color: red !important;
            }
            a.edit:hover {
                color: #33d359 !important;
            }
            a.email:hover {
                color: yellow !important;
            }
            .label-default {
                background-color: #949494 !important;
            }
            @media screen and (max-width: 600px) {
                .mobile-hidden {
                    visibility: hidden;
                    clear: both;
                    float: left;
                    margin: 10px auto 5px 20px;
                    width: 28%;
                    display: none;
                }
            }
            .Blink {
                animation: blinker 1.5s cubic-bezier(0.5, 0, 1, 1) infinite alternate;
            }
            @keyframes blinker {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 0;
                }
            }
            .float{
                position:fixed;
                width:60px;
                height:60px;
                bottom:40px;
                right:40px;
                background-color:#2ed8b6 !important;
                color:#FFF;
                border-radius:50px;
                text-align:center;
                box-shadow: 2px 2px 3px #999;
            }

            .float i:hover{
                color: white;
            }

            .my-float{
                margin-top:22px;
            }
            .card-title {
                font-weight: bold;
            }
        </style>
        <script src="static/assets/js/select2.min.js"></script>
        <script>
            var url, safe, timer, style = "color: #e81d17;" + "font-size: 40px;" + "font-weight: bold;" + "text-shadow: 1px 1px 5px black;" + "filter: dropshadow(color=rgb(249, 162, 34), offx=1, offy=1);", start_time = new Date().getTime(); console.log("%cJangan Menempelkan apapun disini!", style);
            function notif(title = 'Infomation', type = 'success', message){
              sweetAlert({ title: title, type: type, text: message, timer: 1500, showConfirmButton: false });
            }
            function safeURL(url){
                return window.btoa(url);
            }
            function readDATA(url){
                return window.atob(url);
            }
            function check_is_email(email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test( email );
            }
            function ClearFormData(id){
                $(id)[0].reset();
                $("#id").val("");
                $("textarea").text('');
                $("#input-edit").val("");
                $("select").trigger('change');
                $("#preview").removeAttr('src');
                $(".modal-footer").find('button[type=button]').text('submit');
            }
            function ReloadTable(id){
                id.ajax.reload();
            }
            function activaTab(tab){
                $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            }
            function disabled(id){
                $(id).prop('disabled', 1);
            }
            function undisabled(id){
                $(id).prop('disabled', false);
            }
            function readIMG(input) {
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    $('#imgpreview').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
                }
            }
            function loading(){
              $("body").addClass('loading');
            }
            function removeloading(){
              $("body").removeClass('loading');
            }
            function stopajax(){
              $.ajax().abort();
            }
            function GetMonthName(monthNumber) {
              var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
              return months[monthNumber - 1];
            }
            function setupselect(id, name) {
                $(id).empty();
                $(id).append(`<option value='' selected='1' disabled='1'>Pilih ${name}</option>`);
            }
        </script>
    </head>
    <body>
    <div class="loader-bg"><div class="loader-bar"></div></div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a href="<?php echo site_url() ?>" style="font-weight: bold;">
                            <strong><b><?php echo APP_NAME; ?></b></strong>
                        </a>
                        <a class="mobile-menu" id="mobile-collapse" href="javascript:void(0)">
                            <i class="feather icon-menu icon-toggle-right" aria-hidden="true"></i>
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="feather icon-more-horizontal" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left" style="margin-left: 1rem;">
                            <li>
                                <img importance="low" loading="lazy" src="<?php echo site_url('static/assets/images/majoo.png');?>" draggable="false" style="height: 2rem; width: 5rem;" alt="profile-image" />
                            </li>
                            <li><small id="clock"></small></li>
                        </ul>
                        <ul class="nav-right">
                            <li>
                                <small style="font-weight: bold; text-transform: uppercase;">
                                    Hai, <?php echo session('user_name');?> - <?php echo salam(); ?>
                                </small>
                            </li>
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img importance="low" loading="lazy" src="<?php echo base_url('static/assets/images/default.png');?>" draggable="false" class="img-radius" alt="profile-image">
                                        <i class="feather icon-chevron-down" aria-hidden="true"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="<?php echo site_url('logout?confirm=1') ?>"> <i class="feather icon-log-out" aria-hidden="true"></i> Keluar </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="nav-list">
                            <div class="pcoded-inner-navbar main-menu">
                                <div class="pcoded-navigation-label no-print">NAVIGATION</div>
                                <!-- Menu Navigation -->
                                <?php
                                    # cek jika tidak ada session, maka menu tidak akan ditampilkan
                                    # redirect ke login
                                    if (!session('is_login')) {
                                        redirect(site_url());
                                    }
                                    if (session('is_admin')) {
                                        $this->load->view('backend/menu/admin.php');
                                    }
                                ?>
                                <!-- Menu Navigation -->
                            </div>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <?php $file .= ".php"; include $file;?>
                            <center>  
                                <small>
                                    Created by Hafiz Ramadhan.
                                </small> <br>
                              <small><i>elapsed time : {elapsed_time} ms - memory usage : {memory_usage}</i></small>
                              <br> 
                              <small> &copy; 2022 <?php echo APP_NAME; ?> </small> <br>
                              <a href="<?php echo INSTAGRAM; ?>" target="_blank">
                                  <i class="fab fa-instagram" aria-hidden="true"></i>
                              </a>
                              <a href="<?php echo LINKEDIN; ?>" target="_blank">
                                  <i class="fab fa-linkedin" aria-hidden="true"></i>
                              </a>
                              <a href="<?php echo GITHUB; ?>" target="_blank">
                                  <i class="fab fa-github" aria-hidden="true"></i>
                              </a>
                            </center> <br>
                        </div>
                    </div>
                    <div id="styleSelector"></div>
                </div>
            </div>
        </div>
    </div>
    <!--[if lt IE 10]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>
                You are using an outdated version of Internet Explorer, please upgrade <br />
                to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img loading="lazy" src="static/assets/images/browser/chrome.png" alt="Chrome" />
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img loading="lazy" src="static/assets/images/browser/firefox.png" alt="Firefox" />
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img loading="lazy" src="static/assets/images/browser/opera.png" alt="Opera" />
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img loading="lazy" src="static/assets/images/browser/safari.png" alt="Safari" />
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img loading="lazy" src="static/assets/images/browser/ie.png" alt="" />
                            <div>IE (9 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
    <script>
        var H = H || {};
        setInterval(function () {
            var time = H.RealtimeDate();
            $("#clock").html(time);
        }, 1e3),
            (H.RealtimeDate = function () {
                var a = new Date(),
                    b = [];
                (b[0] = "Januari"),
                    (b[1] = "Februari"),
                    (b[2] = "Maret"),
                    (b[3] = "April"),
                    (b[4] = "Mei"),
                    (b[5] = "Juni"),
                    (b[6] = "Juli"),
                    (b[7] = "Agustus"),
                    (b[8] = "September"),
                    (b[9] = "Oktober"),
                    (b[10] = "November"),
                    (b[11] = "Desember");
                var currentMonth = b[a.getMonth()],
                    currentYear = a.getFullYear(),
                    currentDate = a.getDate(),
                    c = [];
                (c[0] = "Minggu"), (c[1] = "Senin"), (c[2] = "Selasa"), (c[3] = "Rabu"), (c[4] = "Kamis"), (c[5] = "Jum'at"), (c[6] = "Sabtu");
                var currentDay = c[a.getDay()],
                    d = a.getHours(),
                    e = a.getMinutes(),
                    f = a.getSeconds();
                return currentDay + ", " + currentDate + " " + currentMonth + " " + currentYear + " &sdot; " + (d = (d < 10 ? "0" : "") + d) + " : " + (e = (e < 10 ? "0" : "") + e) + " : " + (f = (f < 10 ? "0" : "") + f);
            });
    </script>
    <script importance="low" src="static/assets/popper.js/js/popper.min.js"></script>
    <script importance="low" src="static/assets/js/bootstrap.min.js"></script>
    <script importance="low" src="static/assets/js/waves.min.js"></script>
    <script importance="low" src="static/assets/js/jquery.slimscroll.js"></script>
    <script importance="low" src="static/assets/js/pcoded.min.js"></script>
    <script importance="low" src="static/assets/js/vertical/vertical-layout.min.js"></script>
    <script importance="low" src="static/assets/js/script.min.js"></script>
    <script importance="low" src="static/assets/js/notif.min.js"></script>	
  </body>
</html>
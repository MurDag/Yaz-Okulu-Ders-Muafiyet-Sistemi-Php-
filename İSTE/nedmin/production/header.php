<?php
ob_start();
session_start();


if(!isset($_SESSION['kullanici_tc']))
{

header("Location:login?durum=yetkisiz_giris");

}


include '../netting/baglan.php';
error_reporting(0);
 $kullanicisor=$db->prepare("SELECT * from ogrenci where kullanici_tc=:kullanici_tc");
      $kullanicisor->execute(array(
        'kullanici_tc' => $_SESSION['kullanici_tc']
        ));

      $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css">

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>İskenderun Teknik Üniversitesi</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- Ck Editör -->
  <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
 



  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index" class="site_title"><i class="fa fa-users"></i> <span>Kurul Paneli <br>  Sistemi</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_info">
              <center>
          
              <span>Hoşgeldiniz</span>
              <h2><?php echo $kullanicicek['kullanici_ad'].' '.$kullanicicek['kullanici_soyad']; ?></h2>      

              </center>

            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">

                <li><a href="index"><i class="fa fa-home"></i> Anasayfa </a></li>

                <li><a href="kullanici"><i class="fa fa-user"></i> Kullanıcılar </a></li>

                <li><a><i class="fa fa-list"></i>Muafiyet Başvuruları <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="basvuru">Aktif Başvurular</a></li>
                      <li><a href="k-basvuru">Kesinleştirilen Başvurular</a></li>
                      <li><a href="b-listele">Başvuru Listele</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-list"></i>Yaz Okulu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="onayli_dersler">Onaylı Dersler</a>
                      <li><a href="ders_onerileri">Ders Önerileri</a>
                        <li><a href="y_basvurular">Yaz Okulu Başvuruları</a>
                       <li><a href="y_ayarlari">Yaz Okulu Ayarları</a></li>
                       
                    </ul>
                  </li>

                 <li><a href="fakulteler"><i class="fa fa-institution"></i>Fakülteler</a></li>
                 <li><a href="bolumler"><i class="fa fa-graduation-cap"></i>Bölümler</a></li>
                 <li><a href="dersler"><i class="fa fa-book"></i>Dersler</a></li>


                  <li><a><i class="fa fa-gears"></i>Ayarlar <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="duyuru">Sayfa Düzeni</a></li>
                     
                       
                    </ul>
                  </li>


                 
           </ul>
         </div>



       </div>

    </div>
  </div>

  <!-- top navigation -->
  <div class="top_nav">
    <div class="nav_menu">
      <nav>
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <?php echo $kullanicicek['kullanici_adsoyad'] ?>
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
             
              <li><a href="logout"><i class="fa fa-sign-out pull-right"></i> Güvenli Çıkış</a></li>
            </ul>
          </li>

        
        </ul>
      </nav>
    </div>
  </div>
        <!-- /top navigation -->
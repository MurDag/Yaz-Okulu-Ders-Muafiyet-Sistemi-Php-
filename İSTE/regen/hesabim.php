<?php 
error_reporting(0);
 include "../nedmin/netting/baglan.php";
include "header.php";

$kullanici_id=$_SESSION['kullanici_idno'];
$kullanicisor=$db->prepare("SELECT * FROM ogrenci where id=:id");
$kullanicisor->execute(array(
  'id' => $kullanici_id
  ));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);


?>



<!doctype html>
<html lang="en">
  <head>
    <title>İskenderun Teknik Üniversitesi Ders Muafiyet Sistemi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" type="text/css" href="css/main.css">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ders Muafiyet Sistemi</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>
  <body>


  

 <center>

              <table>
              <tr><td> <h1>  Hesabım  </h1></td></tr>
              </table>
              <br>
                  <?php

      if ($_GET['durum']=="updateok") {
        echo "<center> Bilgileriniz başarıyla Güncellendi. </center>";
      }


      ?>

              <br>
              <p >Şifrenizi aşağıdan güncelleyebilirsiniz...</p>
           
          <form action="../nedmin/netting/islem.php" method="POST">
                <span class="label-input100">Ad</span>
         <div class="col-md-3">
            <input type="text" class="form-control m-1" name="kullanici_ad" placeholder="Adınızı Giriniz" value="<?php echo $kullanicicek['kullanici_ad']; ?>"
            name="kullanici_ad">
          </div>
               <span class="label-input100">Soyad</span>
         <div class="col-md-3">
            <input type="text" class="form-control m-1" name="kullanici_soyad" placeholder="Soyadınızı Giriniz" value="<?php echo $kullanicicek['kullanici_soyad']; ?>">
          </div>
            <span class="label-input100">TC Kimlik Numaranız</span>
         <div class="col-md-3">
            <input type="text" class="form-control m-1" name="kullanici_tc" placeholder="TC Kimlik Numaranızı Giriniz" value="<?php echo $kullanicicek['kullanici_tc']; ?>">
          </div>
            <span class="label-input100">Okul Numaranız</span>
         <div class="col-md-3">
            <input type="text" class="form-control m-1" name="kullanici_no" placeholder="Okul Numaranızı Giriniz"  value="<?php echo $kullanicicek['kullanici_no']; ?>">
          </div>
             <span class="label-input100">Telefon Numaranız</span>
         <div class="col-md-3">
            <input type="text" class="form-control m-1" name="kullanici_tel" placeholder="Telefon Numaranızı" value="<?php echo $kullanicicek['kullanici_tel']; ?>">
          </div>
             <span class="label-input100">Mail Adresiniz</span>
         <div class="col-md-3">
            <input type="text" class="form-control m-1" name="kullanici_mail" placeholder="Mail Adresinizi Giriniz" value="<?php echo $kullanicicek['kullanici_mail']; ?>">
          </div>

          <button type="submit" name="hesap_guncelle" class="contact100-form-btn">
            <center>
            <span>
              GÜNCELLE
              <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
            </span>
            </center>
          </button>

          </form>
             
          <br>
  


          <br><br>

    

       <input type="button" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='sifreguncelle';" value="Şifremi Değiştirmek İstiyorum" />




 <?php

include "footer.php";

 ?>
<?php 
session_start();
error_reporting(0);
include "../nedmin/netting/baglan.php";
include "header.php";



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
  </head>
  <body>


    <?php 
$kullanici_tc=$_SESSION['kullanici_tc'];
$kullanicisor=$db->prepare("SELECT * FROM ogrenci where kullanici_tc=:tc");
$kullanicisor->execute(array(
  'tc' => $kullanici_tc
  ));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);



?>

 <center>     <br>
 
              <?php

if ($_GET['durum']=="eksiksifre") {

                echo '<font face="tahoma" size="3" color="red"> Şifrenizin en az 6 rakamdan oluşması gerekmektedir !</font>';
}

if ($_GET['durum']=="sifreleruyusmuyor") {

                echo '<font face="tahoma" size="3" color="red"> Girilen şifreler birbiriyle uyuşmuyor ! </font>';
}


              if ($_GET['durum']=="yanlissifre") {


                echo '<font face="tahoma" size="3" color="red"> Girilen Şifre Yanlıştır Lütfen Tekrar Deneyin ! </font>';
}
if ($_GET['durum']=="sifredegisti") {

                echo '<font face="tahoma" size="3" color="red"> Şifre Başarılı bir Şekilde Değiştirildi.  </font>';
}
              ?>
             
              <br><br>
              <table>
              <tr><td > <h1> Şifre Değiştir  </h1></td></tr>
              </table>
              <br>
              <br>
              <p >Şifrenizi buradan değiştirebilirsiniz...</p>


             
  <form class="contact100-form validate-form" action="../nedmin/netting/islem.php" method="POST">
        <span class="contact100-form-title">
        
          <center>
           <div class="wrap-input100 rs1-wrap-input100 validate-input">
          <span class="label-input100">Şimdiki Şifreniz</span>
          <input class="input100" type="password" name="kullanici_eskipassword" placeholder="Şifrenizi Giriniz" required>
          <span class="focus-input100"></span>
        </div>
        </center>
        </span>

               <div class="wrap-input100 rs1-wrap-input100 validate-input">
          <span class="label-input100">Yeni Şifre</span>
          <input class="input100" type="password" name="kullanici_passwordone" placeholder="Yeni Şifrenizi Giriniz" required>
          <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 rs1-wrap-input100 validate-input">
          <span class="label-input100">Yeni Şifre(Tekrar)</span>
          <input class="input100" type="password" name="kullanici_passwordtwo" placeholder="Yeni Şifrenizi Tekrar Giriniz"  required>
          <span class="focus-input100"></span>
        </div>


   



        <div class="container-contact100-form-btn">
          <button type="submit" name="kullanicisifreguncelle" class="contact100-form-btn">
            <span>
              GÜNCELLE
              <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
            </span>
          </button>
        </div>
      </form>

     
 <?php

include "footer.php";

 ?>
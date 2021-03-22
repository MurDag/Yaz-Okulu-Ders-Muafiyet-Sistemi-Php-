<?php 

include "header.php";
include "../nedmin/netting/baglan.php";
error_reporting(0);

$kullanici_tc=$_SESSION['kullanici_tc'];

      $maddesor=$db->prepare("SELECT * from duyuru order by madde_sira asc");
      $maddesor->execute(array());



 $idsor=$db->prepare("SELECT * from ogrenci where kullanici_tc=:kullanici_tc");
      $idsor->execute(array(
        'kullanici_tc' => $kullanici_tc
        ));

      $idcek=$idsor->fetch(PDO::FETCH_ASSOC);

      $basvuru_yid=$idcek['id'];

 $basvurusor=$db->prepare("SELECT * from basvuru where basvuru_yid=:basvuru_yid");
      $basvurusor->execute(array(
        'basvuru_yid' => $basvuru_yid
        ));
      

      $basvurucek=$basvurusor->fetch(PDO::FETCH_ASSOC);

      $basvurusonuc=$basvurucek['basvuru_sonuc'];

      $say=$basvurusor->rowCount();

       $donemsor=$db->prepare("SELECT * from syfayar");
  $donemsor->execute(array());
 $donemcek=$donemsor->fetch(PDO::FETCH_ASSOC);




$_SESSION['yenile']=0;
$_SESSION['yenile2']=0;
?>


  <body>

<?php


if ($_POST['btamamla']) {

if (condition) {
  # code...
}

    $e=0;
    $g=0;
    if ($_SESSION['r2']==0) {

      
      $dsayisor=$db->prepare("SELECT id from kdersler where basvuru_yid=:basvuru_yid");
      $dsayisor->execute(array(
        'basvuru_yid' => $_SESSION['kullanici_idno']
        ));

      $dsor=$db->prepare("SELECT id from dersler where ders_bolum=:ders_bolum");
      $dsor->execute(array(
        'ders_bolum' => $_SESSION['kullanici_bolum_id']
        ));
      $dizi=array();
      
      while ($dcek=$dsor->fetch(PDO::FETCH_ASSOC)) {
        $dizi[$e]=$dcek['id'];
        $e++; 
      }

      $ee=0;
      while ($dsayicek=$dsayisor->fetch(PDO::FETCH_ASSOC)) {
        
        $kdid=$dsayicek['id'];
        
          $mg=$db->prepare("UPDATE kdersler SET
    muaf_ders=:muaf_ders
    

    WHERE id='$kdid'");

  $update=$mg->execute(array(
    'muaf_ders' => $dizi[$ee]
    
    ));

        
        $ee++;
        $g++;

      }

      


      
    }

}



if ($_GET['basvuru_durum']=="hata") 
    {
      echo '<center>';
       echo '<font size="3" color="red">Zaten kayıtlı bir başvurunuz bulunmaktadır ! Başvurunuzu güncellemeyi deneyebilirsiniz .</font>';
    }



if ($_GET['basvuru_durum']=="ok") {
  
  echo '<div class="alert alert-warning" role="alert">
        Ders Muafiyet Başvurunuz Başarılı Bir Şekilde Gerçekleşmiştir / Başvurunuz Sonuçlandığında Sayfaya Düşecektir
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          
        </button>
      </div>';

}
if ($_GET['kd']=="no") 
    {
      echo '<center>';
       echo '<font size="3" color="red">Başvuru Sırasında Bir Hata oluştu.<br> Lütfen ilgili yöneticiyle iletişime geçiniz !</font>';
    }


if ($_GET['basvuru_durum']=="tbasvuru") {
  
  echo '<div class="alert alert-warning" role="alert">
        Zaten Yapılmış Bir Muafiyet Başvurunuz Var ! / Başvurunuz Sonuçlandığında Sayfaya Düşecektir
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          
        </button>
      </div>';

}

if ($say>0 && $basvurusonuc==0)
{ 
  echo '<br>';
  echo '<center>';
  echo '<a href="b-guncelle?basvuru_durum=guncelle">  <font face="Courier New" size="4" color="blue">  Başvurumu Güncellemek İstiyorum ! </font> </a>';
   echo '</center>';
}








?>


<center>
 <b><tr> <td bgcolor="blue">
 <font  size="6" color="red">  Hoşgeldiniz <?php 
echo $_SESSION['kullanici_ad']; 
echo " ".$_SESSION['kullanici_soyad']; 
?> </font> </td></tr> </b>

<?php 

  $y="yazokulu.php";

 if ($donemcek['ayar_basvuru_donem']==1) {

  ?>

   <form action="dosyayukle.php" method="POST">
     <input type="button" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='dosyayukle';" value="Muafiyet Başvurusu Yapmak İstiyorum" />
  
     </form>  <?php
 }
  if ($donemcek['ayar_basvuru_donem']==2) {
     $kid=$_SESSION['kullanici_idno'];
    date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

     $yazokulu_sonuc_sor=$db->prepare("SELECT * from yazokulu_ilerleme_kontrol where y_kul_id=:y_kul_id and y_basvuru_yil=:y_basvuru_yil");
      $yazokulu_sonuc_sor->execute(array(
        'y_kul_id' => $kid,
        'y_basvuru_yil' => $yil
        ));

       $yazokulu_sonuc_cek=$yazokulu_sonuc_sor->fetch(PDO::FETCH_ASSOC);

if ($yazokulu_sonuc_cek['y_ilerleme_durum']==2) {

?>
<br>
Yaz Okulu başvurunuzun sonucu için<a href="y_basvurular"><font color="red" size="2"><u> Tıklayın...</u></font></a> 
  <?php
}

     $oneri_sonuc_sor=$db->prepare("SELECT * from oneri_ilerleme_kontrol where oneri_kul_id=:oneri_kul_id and oneri_yil=:oneri_yil");
      $oneri_sonuc_sor->execute(array(
        'oneri_kul_id' => $kid,
        'oneri_yil' => $yil
        ));

       $oneri_sonuc_cek=$oneri_sonuc_sor->fetch(PDO::FETCH_ASSOC);

if ($oneri_sonuc_cek['oneri_ilerleme_durum']==2) { ?>

<br>
Öneri başvurunuzun sonucu için ! <a href="oneriler"><font color="red" size="2"><u> Tıklayın...</u></font></a>


<?php }
     $y_basvuru_sor=$db->prepare("SELECT * from yazokulu_basvuru where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
      $y_basvuru_sor->execute(array(
        'basvuru_kul_id' => $kid,
        'basvuru_yil' => $yil
        ));

      $y_basvuru_say=$y_basvuru_sor->rowCount();

      if ($y_basvuru_say>0) {

        ?>
        <br>
  <input type="button" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='y_basvurular';" value="Yazokulu Başvurularım"/>
  <br>

        <?php
             $y_oneri_sor=$db->prepare("SELECT * from onerilen_dersler where onerenkisi_id=:onerenkisi_id and oneri_yil=:oneri_yil");
      $y_oneri_sor->execute(array(
        'onerenkisi_id' => $kid,
        'oneri_yil' => $yil
        ));

      $y_oneri_say=$y_oneri_sor->rowCount();

   if ($y_oneri_say>0) {
        
        ?>
 <input type="button" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='oneriler';" value="Ders Önerilerim"/>


        <?php
      }

      else
      {
        ?>
  <input type="button" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='ders_oner';" value="Ders Öner"/>
        <?php
      }




      }
      else
      {

         ?>
         <br>
 <input type="button" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='yazokulu';" value="Yaz Okulu Başvuru"/>


        <?php

      }

 }

?>


<br>
<?php

 $idsor=$db->prepare("SELECT * FROM ogrenci  where kullanici_tc=:kullanici_tc ");
    $idsor->execute(array( 'kullanici_tc' => $kullanici_tc )); 
    $idcek=$idsor->fetch(PDO::FETCH_ASSOC);
    $id=$idcek['id'];



     $bsor=$db->prepare("SELECT * FROM basvuru  where basvuru_yid=:basvuru_yid ");
    $bsor->execute(array( 'basvuru_yid' => $id )); 
    $bcek=$bsor->fetch(PDO::FETCH_ASSOC);

   



    if ($bcek['basvuru_sonuc']==1 && $donemcek['ayar_basvuru_donem']==1) {

      echo '<th> <font face="Courier New" size="3" color="red"> Muafiyet Başvurunuz Sonuçlanmıştır <br> Lütfen Sonuç için   </font>';
      echo '<a href="sonucgoster"> tıklayınız</a> </th>';

    }




?>


<br>
<div class="konteynir">
<table border="1" width="75%" bgcolor="ff3232">

  <tr>
    <td>
      <center>
        <b><font face="Courier New" size="4" color="white">
      Duyuru    </font></b>
      </center>
    </td>



   </font> 

  </tr>
    <?php  while ($maddecek=$maddesor->fetch(PDO::FETCH_ASSOC)) {
   ?>
  <tr><td> <b><font face="Courier New" size="4" color="white"> <?php echo $maddecek['madde'];  ?>  </font>  </b>  </td></tr>
<?php  }  ?>

</table></div>  


</center>
İste Sınav Yönetmeliğini İndirmek için <a href="https://iste.edu.tr/files/77_files_1482651061.pdf"><font color="red" size="2"><u> Tıklayın...</u></font></a> <br>
İste Akademik Bilgileri için<a href="https://obs.iste.edu.tr/oibs/Bologna/"><font color="red" size="2"><u> Tıklayın...</u></font> </a> <br>

 <?php

include "footer.php";


 ?>
<?php  
error_reporting(0);
session_start();
  include "../nedmin/netting/baglan.php";






  $ogrencisor=$db->prepare("SELECT * from ogrenci where kullanici_tc=:kullanici_tc");
      $ogrencisor->execute(array(
        'kullanici_tc' => $_SESSION['kullanici_tc']
        ));
      $ogrencicek=$ogrencisor->fetch(PDO::FETCH_ASSOC);
      $yid=$ogrencicek['id'];

      


      $kderslersor=$db->prepare("SELECT *  from basvuru where basvuru_yid=:basvuru_yid ");
      $kderslersor->execute(array(
        'basvuru_yid' => $yid
        ));
      $kderslercek=$kderslersor->rowCount();
if($ogrencicek['b_ilerleme']==1)
{
  $_SESSION['ddrm']="ok";
   header("Location:derscek?dvm=1");

}
else if($ogrencicek['b_ilerleme']==2)
{

header("Location:eslestir");

}
else if($ogrencicek['b_ilerleme']==3)
{

header("Location:index?basvuru_durum=tbasvuru");

}

    else  if ($kderslercek==0 || $_GET['basvuru_durum'] == "guncelle" ) {

        if ($_GET['basvuru_durum'] == "guncelle")
        {
            $sil=$db->prepare("DELETE from kdersler where basvuru_yid=:basvuru_yid");
  $kontrol=$sil->execute(array(
    'basvuru_yid' => $yid
    ));

   $basvuru_sil=$db->prepare("DELETE from basvuru where basvuru_yid=:basvuru_yid");
  $k=$basvuru_sil->execute(array(
    'basvuru_yid' => $yid
    ));



        }




?>

<?php include "header.php";
error_reporting(0); 
 ?>

    <?php
      if ($_GET['dosyadurum']=="ok") 
    {
      $_SESSION['dosyadurum']=1;
       header("Location:derscek?dosyadurum=ok");
    }
    if ($_SESSION['dosyadurum']=="ok") 
    {
      echo '<center>';
      echo '<font size="3" color="red">Dosya başarılı bir şekilde yüklendi.</font>';

    }
    if ($_GET['dosyatip']=="no") 
    {
      echo '<center>';
       echo '<font size="3" color="red">Lütfen .PDF formatında bir dosya yükleyiniz.</font>';
    }

    ?>
    <br><br><br><br>
    <center>
<form enctype="multipart/form-data" action="../nedmin/netting/islem.php"  method="POST">
  <font face="tahoma" size="4" color="red"> Ders başvurusu yapılabilmesi için lütfen ilk olarak aşağıdan transkript ve ders içeriğini tek bir dosya içinde .pdf formatında yükleyiniz. </font>
  <br><br><br>
 
<table cellpadding="4" align="center" border="1">
<tr> <td><font face="tahoma" size="4" color="red"> Transkript Yükle </font></td><td><font face="tahoma" size="4" color="red">  Ders İçeriği Yükle </font></td></tr>
    
<tr>

<td><input type="FILE" name="dosya"></td>
<td><input type="FILE" name="dosya2"></td>

</tr>
</table>
<br>
<button type="submit" name="pdf_yukle" class="btn px-4 m-1 btn-danger">Yükle</button>
</form>
</center>
<br><br><br><br><br><br>


<?php include "footer.php"; ?>

<?php

}



?>
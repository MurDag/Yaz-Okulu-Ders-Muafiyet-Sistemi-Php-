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


      $kderslersor=$db->prepare("SELECT * from kdersler where basvuru_yid=:basvuru_yid");
      $kderslersor->execute(array(
        'basvuru_yid' => $yid
        ));
      $kderslersayi=$kderslersor->rowCount();

    



$_SESSION['r2']=0;


?>

<?php include "header.php";
error_reporting(0); 
 ?>

    <?php

    if ($_SESSION['yenile2']<1) {
   echo "<script type='text/javascript'>
 window.location.href=window.location.pathname;
</script>
   ";
   $_SESSION['yenile2']=$_SESSION['yenile2']+1;
}

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
<form enctype="multipart/form-data" action="../nedmin/netting/islem.php?g=h"  method="POST">
  <font face="tahoma" size="4" color="red"> Güncellemek İstediğiniz Dosyayı Yükleyiniz. </font>
  <br><br><br>
 
<table cellpadding="4" align="center" border="1">
<tr> <td><font face="tahoma" size="4" color="red"> Transkript Yükle </font></td><td><font face="tahoma" size="4" color="red">  Ders İçeriği Yükle </font></td></tr>
    
<tr>

<td><input type="FILE" name="dosya"></td>
<td><input type="FILE" name="dosya2"></td>

</tr>
</table>
<br>
<button type="submit" name="pdf_guncelle" class="btn px-4 m-1 btn-danger">Yükle</button>
</form>
</center>
<br>



<?php 
error_reporting(0);
  

 include "../nedmin/netting/baglan.php";


     
      $ogrencisor=$db->prepare("SELECT * from ogrenci where kullanici_tc=:kullanici_tc");
      $ogrencisor->execute(array(
        'kullanici_tc' => $_SESSION['kullanici_tc']
        ));
      $ogrencicek=$ogrencisor->fetch(PDO::FETCH_ASSOC);
      $bolum=$ogrencicek['kullanici_bolum_id'];
      $_SESSION['bolum']=$bolum;
      $yid=$ogrencicek['id'];
      $_SESSION['yid']=$yid;

      $derssor=$db->prepare("SELECT * from dersler where ders_bolum=:ders_bolum");
      $derssor->execute(array(
        'ders_bolum' => $bolum
        ));


        $dsor=$db->prepare("SELECT * from dersler order by id where kullanici_bolum_id=:kullanici_bolum_id");
        $dsor->execute(array(
        'kullanici_bolum_id' => $bolum
        ));

        


        

      
$bderslersor=$db->prepare("SELECT * from kdersler");
      $bderslersor->execute(array(
        'kdersler' => $yid
        ));

      $kdsor=$db->prepare("SELECT * from kdersler where basvuru_yid=:basvuru_yid");
      $kdsor->execute(array(
        'basvuru_yid' => $yid
        ));




 ?>
<!doctype html>
<html lang="tr">
<head>

</head>
<body bgcolor="blue">



 <center>
<?php

  $k=$_POST['satirekle'];
  echo '<center> ';
  echo '<br> ';


  

  $_SESSION['dsayi']=$k;

        
          echo '<br>
<form action="#" method="POST">
<font size="3" color="red">Ders (Satır) Ekle/Çıkar </font>
<input type="number" name="satirekle">
<input type="submit" name="ekle" class="btn px-4 m-1 btn-danger" value="Ekle">
</form>';

if ($_POST['ekle']) {
  

      echo '<center> ';
 
  echo '<br> <br> <br> <form action="../nedmin/netting/islem.php" method="POST"> ';
  echo '<table> <tr>  <td>  </td>  <td align="center"> Ders Adı  </td>  <td align="center"> Kredi  </td> <td align="center">  TUL </td> <td align="center"> AKTS </td>    </tr> ';  
    $l=$_POST['satirekle']+$_SESSION['b'];

    if ($l<0) {

      $l=0;
    }

      for($j=1;$j<=$l;$j++)
  {
    echo '<tr><td> '.$j.'. Dersi Giriniz :   </td> <td> <input type="text" name="ders'.$j.'"> </td> <td>  <input type="number" name="derskredi'.$j.'">    </td> <td>  <input type="text" name="derstul'.$j.'">    </td> <td>  <input type="number" name="dersakts'.$j.'"> </tr>';


  }
  $_SESSION['b']=$j;
  echo '</table> 
  <br> <br>
<input type="submit" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Ders Ekle" name="kders-ekle">
   </form>';
  $_SESSION['b']=$l;
  $_SESSION['dsayi']=$l;
 
}




 ?>



<center>













 <center>
  <br><br>
 <font face="tahoma" size="4" color="red"> Güncellemek İstediğiniz Eşleştirmeyi Aşağıdan Sürükleyip Bırakarak  Yapabilirsiniz.
<br> 
  </font>
 <br><br>


<table><tr>
<td valign="top">
<ul id="sortable">
<?php 
while( $kdcek=$kderslersor->fetch(PDO::FETCH_ASSOC)){
?>
 <li class="ui-state-default"><a href="../nedmin/netting/islem.php?kderssil-id=<?php echo $kdcek['id']; ?>"> <font size="4" color="red">Sil</font></a></li>
<?php
}
?>



</ul></td>


  <td valign="top">
<ul id="sortable">

<?php  

   


$n=$_SESSION['dsayi'];

$a=0;


    $_SESSION['ders_sayisi']=$kderslersayi;
      while( $kderslercekk=$kdsor->fetch(PDO::FETCH_ASSOC))
        { $a++; ?> 
              
   <li class="ui-state-default"><?php echo $kderslercekk['ders_ad']; ?></li>

 <?php  


}

if ($insert) {
  $_SESSION['insertkders']=1;
}

 ?>

</ul>
</td>


<td valign="top">
 
<ul id="sortable">

<?php  

$n=$kderslersayi;
      for($i=1;$i<=$n;$i++)
      { ?>
       <li class="ui-state-default"><img src="../images/arrowright.png" width="100" height="15"/></li>
   <?php   }

  ?>
</ul>

</td>

<td>
  <b>
  <ul id="sortable2">
    
  <?php
  
$h=0;
        


    while ($dcek=$derssor->fetch(PDO::FETCH_ASSOC))
      {
        
          $id = $dcek['id'];
        $dersad = $dcek['ders_ad'];
        
        echo ' <li id="sıra_'.$id.'">'.$id.'-) '.$dersad.'</li>';
   
     $h++;   


}




  ?>

</ul>
</b>

</td>


</tr></table>
<div id="sonuc" ></div>

      <script>
  $( function() {


    function slidekapat() {
         
         setTimeout(function() {
           
          $("#sonuc").slideUp("slow"); 
           
         },500);
         
         
       }

$("#sonuc").hide();



    
     $("#sortable2").sortable({

        opacity: 0.5,
        update: function()
        {

         var deger= $(this).sortable("serialize")+"&update=update";
         $.ajax({

            url: "guncelle-2.php",
            data: deger,
            type: "post",
            success:function(e)
            {
              $("#sonuc").html(e);
              $("#sonuc").slideDown("slow");
              slidekapat();
            }





         });

        }





     });

  } );
  </script>


      <input type="submit" onclick="window.location='index';" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Güncellemeyi Tamamla" name="btamamla">
      


</center>
</body>
</html>







<?php include "footer.php"; ?>


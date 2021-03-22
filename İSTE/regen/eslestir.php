<?php 
error_reporting(0);

 include "header.php";
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

         $mg=$db->prepare("UPDATE ogrenci SET
    b_ilerleme=:b_ilerleme
    

    WHERE id='$yid'");

  $update=$mg->execute(array(
    'b_ilerleme' => 2
    
    ));


      

$_SESSION['r']=0;


 ?>
<!doctype html>
<html lang="en">
<head>

</head>
<body>





 <center>
  <br><br>
   <font face="tahoma" size="4" color="red"> Eşleştirmek İstediğiniz Eşleştirmeyi Aşağıdan Sürükleyip Bırakarak  Yapabilirsiniz.
    
  </font>
<br><br><br>

<table><tr><td valign="top">
<ul id="sortable">

<?php  

if ($_SESSION['yenile']<1) {
   echo "<script type='text/javascript'>
 window.location.href=window.location.pathname;
</script>
   ";
   $_SESSION['yenile']=$_SESSION['yenile']+1;
}

       


$n=$_SESSION['dsayi'];

$a=0;

$kderslersor=$db->prepare("SELECT basvuru_yid from kdersler");
      $kderslersor->execute(array(
        'kdersler' => $yid
        ));
    $kderslercek=$kderslersor->rowCount();
    $_SESSION['ders_sayisi']=$kderslercek;



      $kdersor=$db->prepare("SELECT * from kdersler where basvuru_yid=:basvuru_yid");
      $kdersor->execute(array(
        'basvuru_yid' => $yid
        ));

      ;

      while ($kderscek=$kdersor->fetch(PDO::FETCH_ASSOC)) {
   

  ?>
   <li class="ui-state-default"><?php echo $kderscek['ders_ad']; ?></li> 

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

$n=$_SESSION['dsayi'];
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
        
        echo ' <li id="sıra_'.$id.'">'.$id.' '.$dersad.'</li>';
   
     $h++;   


}




  ?>

</ul>
</b>

</td>


</tr></table>
<div id="sonuc" >          </div>

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

            url: "guncelle.php",
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

<form action="../nedmin/netting/islem.php" method="POST">
      <input type="submit" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Başvuruyu Tamamla" name="btamamla">
      </form> 


</center>


</body>
</html>

<?php  include "footer.php";
 ?>

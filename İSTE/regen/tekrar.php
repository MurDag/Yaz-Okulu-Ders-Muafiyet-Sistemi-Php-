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

      $derssor=$db->prepare("SELECT * from dersler where ders_bolum=:ders_bolum");
      $derssor->execute(array(
        'ders_bolum' => $bolum
        ));


        $dsor=$db->prepare("SELECT * from dersler order by id where kullanici_bolum_id=:kullanici_bolum_id");
        $dsor->execute(array(
        'kullanici_bolum_id' => $bolum
        ));

        

      




 ?>
<!doctype html>
<html lang="en">
<head>

</head>
<body>





 <center>


<table><tr><td valign="top">
<ul id="sortable">

<?php  

$n=$_SESSION['dsayi'];

$a=0;

$kderslersor=$db->prepare("SELECT basvuru_yid from kdersler");
      $kderslersor->execute(array(
        'kdersler' => $yid
        ));
    $kderslercek=$kderslersor->rowCount();
    $_SESSION['ders_sayisi']=$kderslercek;
      for($i=1;$i<=$n;$i++)
        { $a++; ?> 
               <li class="ui-state-default"><?php echo $_POST['ders'.$i]; ?></li> 
 <?php 
               if ($kderslercek==0) {
                  
                   $kderskaydet=$db->prepare("INSERT INTO kdersler SET
                      ders_sira=:ders_sira,
                      ders_ad=:ders_ad,
                      ders_kredi=:ders_kredi,
                      ders_tul=:ders_tul,
                      ders_akts=:ders_akts,
                      basvuru_yid=:basvuru_yid,
                      basvuru_bolum_id=:basvuru_bolum_id

                    ");
                    $insert=$kderskaydet->execute(array(
                      'ders_sira' => $i,
                      'ders_ad' => $_POST['ders'.$i],
                      'ders_kredi' => $_POST['derskredi'.$i],
                      'ders_tul' => $_POST['derstul'.$i],
                      'ders_akts' => $_POST['dersakts'.$i],
                      'basvuru_yid' => $yid,
                      'basvuru_bolum_id' => $bolum
                    ));

                
               }

  ?>

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
       <li class="ui-state-default">===></li>
   <?php   }

  ?>
</ul>

</td>

<td>
  <b>
  <ul id="sortable2">
    
  <?php
  
$h=0;
        
      $basvurusor=$db->prepare("SELECT basvuru_yid from bdersler");
      $basvurusor->execute(array(
        'ders_bolum' => $bolum
        ));
    $bcek=$basvurusor->rowCount();


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
<div id="sonuc" ></div>

      <script>
  $( function() {
    
     $("#sortable2").sortable({

        opacity: 0.5,
        update: function()
        {

         var deger= $(this).sortable("serialize");
         $.ajax({

            url: "guncelle.php",
            data: deger,
            type: "post",
            success:function(e)
            {
              $("#sonuc").html(e);
            }





         });

        }





     });

  } );
  </script>



</center>
</body>
</html>

<?php  include "footer.php"; ?>

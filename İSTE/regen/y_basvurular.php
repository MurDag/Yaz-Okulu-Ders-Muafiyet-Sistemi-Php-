<?php
error_reporting(0);
include "header.php";
include "../nedmin/netting/baglan.php";
$girdi=0;
$max_ders=0;
$max_kredi=0;
$max_uni=0;
 $kid=$_SESSION['kullanici_idno'];
    date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
    $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $kid
    ));

$y_ilerlemecek=$y_ilerlemesor->fetch(PDO::FETCH_ASSOC);


 $y_ayarsor=$db->prepare("SELECT * from y_ayar");
  $y_ayarsor->execute(array());
 $y_ayarcek=$y_ayarsor->fetch(PDO::FETCH_ASSOC);

if ($y_ilerlemecek['y_ilerleme_durum']==1) {

      
    $bsor=$db->prepare("SELECT * FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc!=:basvuru_sonuc");
    $bsor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 2

       ));

}
if ($y_ilerlemecek['y_ilerleme_durum']==2 || $y_ilerlemecek['y_ilerleme_durum']==0) {

      
    $bsor=$db->prepare("SELECT * FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
    $bsor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil

       ));

}






$bsayi=$bsor->rowCount();
if ($y_ilerlemecek['y_ilerleme_durum']==2) {

    $m_unisor=$db->prepare("SELECT distinct k_universite FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc!=:basvuru_sonuc");
    $m_unisor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 2
       ));
  }
  else
  {

        $m_unisor=$db->prepare("SELECT distinct k_universite FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
    $m_unisor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil
       ));

  }

       $max_unisayi=$m_unisor->rowCount();

if ($y_ilerlemecek['y_ilerleme_durum']==2) {
  
    $m_sor=$db->prepare("SELECT * FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc!=:basvuru_sonuc");
    $m_sor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 2
       ));
}
else
{

$m_sor=$db->prepare("SELECT * FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
    $m_sor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil
       ));
}
    



     while ($m_cek=$m_sor->fetch(PDO::FETCH_ASSOC)) {


        $kredisor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $kredisor->execute(array( 'id' => $m_cek['b_ders_ad'] )); 
    $kredicek=$kredisor->fetch(PDO::FETCH_ASSOC);

        $max_ders++;
        $max_kredi=$max_kredi+$kredicek['ders_kredi'];
     
     }
     
  






?>

<!DOCTYPE html>
<html>
<head>
  <title></title>


</head>
<body>
  <center>

    <br>
<br>

    <?php
if ($_GET['y_basvuru_durum']=="successful") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Yaz okulu başvuru kaydınız başarılı bir şekilde alınmıştır ! / Sonuç incelendikten sonra anasayfanıza düşecektir.
        
      </div>';
   }
}

if ($_GET['y_basvuru_guncelle']=="ok") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0 || $y_ilerlemecek['y_ilerleme_durum']==2) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Güncelleme Başarılı  !
        
      </div>';
   }
}

if ($_GET['o-s']=="ok") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0 || $y_ilerlemecek['y_ilerleme_durum']==2) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Silme İşlemi Başarılı  !
        
      </div>';
   }
}


if ($_GET['y_basvuru_durum']=="imzalanmadi") {

  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Yaz okulu başvuru kaydınızın ilk adımı başarılı bir şekilde yapılmıştır. 
       <br>


        Lütfen ders başvurularınızın tamamlanması için almak istediğiniz bütün dersleri ekledikten sonra aşağıdaki butona tıklayın ve dilekçenizi indirdikten sonra imzalayarak tekrar yükleyiniz.
        
      </div>';

      $girdi=1;
       
}


if ($girdi==0) {
  if ($y_ilerlemecek['y_ilerleme_durum']==1) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Yaz okulu başvurunuz başarılı bir şekilde yapılmıştır. 
       <br>
        
      </div>';

     
      }    
}






if ($_GET['y_basvuru_durum']=="error") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Yaz okulu başvurunuz yapılırken bir hata oluştu ! / Lütfen ilgili birime durumu bildiriniz.</strong></font>
              </div>';
            }
}

if ($_GET['y_basvuru_guncelle']=="error") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Güncelleme yapılırken bir hata oluştu ! / Lütfen ilgili birime durumu bildiriniz.</strong></font>
              </div>';
            }
}
if ($_GET['y_basvuru_durum']=="tekrarlibasvuru") {
 
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Bu ders için zaten başvuru yaptınız ! <br> Aynı ders için birden fazla başvuru yapamazsınız.</strong></font>
              </div>';

}

if ($_GET['y_basvuru_durum']=="krediasildi") {
    if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Bu dersi alarak alabileceğiniz maksimum kredi sayısını aşıyorsunuz ! <br> Maksimum kredi alma hakkınız : '.$y_ayarcek['max_kredi'].'</strong></font>
              </div>';
            }
}


?>



  
    <div class="col-md-12" > <h3> <font color="black">Yapılan Yaz Okulu Başvurularınız</font> </h3><hr></div>

    <?php 
    if ($y_ilerlemecek['y_ilerleme_durum']==0) {

          $obmsor=$db->prepare("SELECT *  FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
    $obmsor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil
       ));

    $obmsayi=$obmsor->rowCount();
    }



    if ($y_ilerlemecek['y_ilerleme_durum']==1) {
 ?>
 <font color="black">Eklenen Başvurularınız Sonuçlandığında Anasayfanıza Düşecektir</font>
<?php }

if ($y_ilerlemecek['y_ilerleme_durum']==2) {

    $obmsor=$db->prepare("SELECT *  FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc=:basvuru_sonuc");
    $obmsor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 0
       ));

    $obmsayi=$obmsor->rowCount();

}


  ?>



    <?php

    $obsor=$db->prepare("SELECT *  FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc=:basvuru_sonuc");
    $obsor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 1
       ));

    $obsayi=$obsor->rowCount();

    



     if ($obsayi<=$y_ayarcek['max_ders'] ) {
      if ($y_ilerlemecek['y_ilerleme_durum']==2 && $obmsayi>0) { ?>
        
         <br><center>Lütfen imzalama işlemini başvuracağınız bütün dersleri ekledikten sonra yapınız.</center>
          <input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='y_dilekce_yukle';" value="Başvuruları İmzala" />


     <?php }
     if ($y_ilerlemecek['y_ilerleme_durum']!=1 && $obmsayi>0 && $y_ilerlemecek['y_ilerleme_durum']!=2) {

      ?>


      <br><center>Lütfen imzalama işlemini başvuracağınız bütün dersleri ekledikten sonra yapınız.</center>
          <input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='y_dilekce_yukle';" value="Başvuruları İmzala" />
       
     <?php }

      ?>
      
        <?php }
       if($obsayi==$y_ayarcek['max_ders'] && $y_ilerlemecek['y_ilerleme_durum']!=1)
        { ?>
          <div id="dv1" class="alert alert-info" role="alert"><font color="black"><strong>

       Alabileceğiniz maksimum ders sayısına ulaştınız.</strong></font>
              </div>



       <?php  } ?>

<?php

if ($bsayi>0) { ?>


<?php

 
 if ($y_ilerlemecek['y_ilerleme_durum']==0 && $girdi==0) { ?>

<center><br> <font color="black" size="4">Başvurularınız Henüz İmzalanmadı !</font> <br> Lütfen Yaz Okulu başvurularınızın tamamlanması için başvuracağınız bütün dersleri ekledikten sonra yukarıdaki butona tıklayıp dilekçenizi indirip sonra imzalayarak tekrar yükleyiniz.    <br>          </center>

<?php  }
 if ($y_ilerlemecek['y_ilerleme_durum']==2 && $obmsayi>0) { ?>

<center><br> <font color="black" size="4">Başvurularınız Henüz İmzalanmadı !</font> <br> Yeni başvuru yaptığınız için imzalama işlemini tekrar yapmanız gerekmektedir.    <br>          </center>


<?php 
}
 ?>





<?php


if ($y_ilerlemecek['y_ilerleme_durum']!=1) {
 ?>

<?php if ($max_ders<$y_ayarcek['max_ders'] && $max_unisayi<$y_ayarcek['max_universite'] && $max_kredi<$y_ayarcek['max_kredi']) {  ?>
<br>
 <input type="button" class="btn px-4 m-1 btn-secondary" onclick="location.href='y_basvuruyap';" value="Ders Ekle" />
<?php } ?>
<br>
        Ders :<?php echo " ".$max_ders.'/'.$y_ayarcek['max_ders']; ?> <br>
      Kredi :<?php echo " ".$max_kredi.'/'.$y_ayarcek['max_kredi']; ?> <br>
      Üniversite :<?php echo " ".$max_unisayi.'/'.$y_ayarcek['max_universite']; ?> <br>

<div class="konteynir" >
<table style="margin-top: 50px;">
    <thead>


      <tr>

        <th>
          Üniversite 
        </th>
         <th>
          Fakülte
        </th>
         <th>
          Bölüm
        </th>
        <th> 
        Eşleştirilen Ders
        </th>
        <th colspan="2">Düzenle/Sonuç</th>
        



      </tr>
    </thead>
   
    <tbody >
    <?php 

      while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {  ?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='Başvuru Yeri'>
        	<?php
$kunisor=$db->prepare("SELECT * FROM universite  where universite_id=:universite_id ");
    $kunisor->execute(array( 'universite_id' => $bcek['k_universite'] )); 
    $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);
    echo $kunicek['name'];

        	?>

          
        
        </td>
        <td bgcolor="#DDDDDD" >
           <?php
$kfakultesor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
    $kfakultesor->execute(array( 'fakulte_id' => $bcek['k_fakulte'] )); 
    $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $kfakultecek['name'];

        	?>
        </td>
        <td bgcolor="#DDDDDD">
                    <?php
$kbolumsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
    $kbolumsor->execute(array( 'bolum_id' => $bcek['k_bolum'] )); 
    $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $kbolumcek['name'];

        	?>
        </td>

         <td bgcolor="#DDDDDD" data-title='Eşleştirilen Ders'>
                    <?php
$bderssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $bderssor->execute(array( 'id' => $bcek['b_ders_ad'] )); 
    $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
    echo $bderscek['ders_ad'];

        	?>
        </td>

<?php if ($bcek['basvuru_sonuc']==0) { ?>

        <td bgcolor="#DDDDDD" ><center><a href="y_basvuru_guncelle?basvuruguncelle_id=<?php echo $bcek['id']; ?>">
          <button  <?php if($bcek['basvuru_sonuc']>0 || $y_ilerlemecek['y_ilerleme_durum']==1) { ?> style="color: black; cursor: not-allowed;"   disabled=" disabled "  <?php } ?>
          class="btn px-4 m-1 btn-success">Güncelle</button></a></center></td>



         <td bgcolor="#DDDDDD" ><center><a href="../nedmin/netting/islem.php?y_basvurusil_id=<?php echo $bcek['id']; ?>">
          <button <?php if($bcek['basvuru_sonuc']>0 || $y_ilerlemecek['y_ilerleme_durum']==1) { ?> style="color: black; cursor: not-allowed;"  disabled=" disabled "  <?php } ?> class="btn px-4 m-1 btn-outline-dark">Sil</button></a></center></td>

<?php  }  ?>



<?php  if ($y_ilerlemecek['y_ilerleme_durum']==2 && $bcek['basvuru_sonuc']!=0) {   ?>
          <td bgcolor="#DDDDDD" >   
            <?php 
            if ($bcek['basvuru_sonuc']==0) { ?>
              <font color="black" size="2" style="font-weight: bold;">Sonuçlandırılmadı</font>
           <?php  }  ?>

              <?php 
            if ($bcek['basvuru_sonuc']==1) { ?>
             <font color="#0055FF" size="3" style="font-weight: bold;">Onaylandı  </font>
           <?php  }  ?>

             <?php 
            if ($bcek['basvuru_sonuc']==2) { ?>
             <font color="red" size="3" style="font-weight: bold;" >Red Edildi</font>
           <?php  }  ?>
          </td>

          <td bgcolor="#DDDDDD" align="center">
              <?php
              if ($bcek['basvuru_sonuc']==2) { 

                echo $bcek['red_sebep'];

                } ?>
                 <?php
              if ($bcek['basvuru_sonuc']==1) {  ?>
<center>
                 <font>---</font>
</center>
              <?php } ?>


          </td>
        
<?php } ?>

        
      </tr>
      <?php } ?>



    </tbody>
  </table>




</div>
<?php }
  
  else
  {
    ?>

<div class="konteynir" >
<br>
<font color="darkblue"> Başvuru Henüz Kurul Tarafından <u>Kesinleştirilmedi </u>   </font>

<table style="margin-top: 50px;">

    <thead>


      <tr>

        <th>
          Üniversite 
        </th>
         <th>
          Fakülte
        </th>
         <th>
          Bölüm
        </th>
        <th> 
         Eşleştirilen Ders
        </th>
        <th>Sonuç</th>
       
        




      </tr>
    </thead>
   
    <tbody >
    <?php 

      while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='Önerilen Üniversite'>
          <?php
$kunisor=$db->prepare("SELECT * FROM universite  where universite_id=:universite_id ");
    $kunisor->execute(array( 'universite_id' => $bcek['k_universite'] )); 
    $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);
    echo $kunicek['name'];

          ?>

          
        
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Fakülte'>
           <?php
$kfakultesor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
    $kfakultesor->execute(array( 'fakulte_id' => $bcek['k_fakulte'] )); 
    $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $kfakultecek['name'];

          ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Bölüm'>
                    <?php
$kbolumsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
    $kbolumsor->execute(array( 'bolum_id' => $bcek['k_bolum'] )); 
    $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $kbolumcek['name'];

          ?>
        </td>
       
         <td bgcolor="#DDDDDD" data-title='Eşleştirilen Ders'>
                    <?php
$bderssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $bderssor->execute(array( 'id' => $bcek['b_ders_ad'] )); 
    $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
    echo $bderscek['ders_ad'];

          ?>
        </td>

                <?php
        if ($y_ilerlemecek['y_ilerleme_durum']==2) { ?>

        <td bgcolor="#DDDDDD" data-title='Sonuç' >
          <?php
             if ($bcek['basvuru_sonuc']==0) {
             ?>
           <font color="black">Sonuçlandırılmadı</font> 
           <?php
          }

          if ($bcek['basvuru_sonuc']==1) {
             ?>
           <font color="#00FF00">Onaylandı</font> 
           <?php
          }

          if ($bcek['basvuru_sonuc']==2) {
            ?>
           <font color="red">Red Edildi</font> 
           <?php
          }
          ?>

        </td>



         <td bgcolor="#DDDDDD" data-title='Red Sebebi'>
          <center>
            <?php
             if ($bcek['basvuru_sonuc']==0) {
              ?>
           <font color="black">Sonuçlandırılmadı</font> 
           <?php
          }

           if ($bcek['basvuru_sonuc']==1) {

            ?>
           <font color="black">---</font> 
           <?php

          } 
             if ($bcek['basvuru_sonuc']==2 ) {
             ?>
           <font color="black"><?php echo $bcek['red_sebep']; ?></font> 
           <?php
          } 


          ?>
         </center>
        </td>
        <?php } 
        if ($y_ilerlemecek['y_ilerleme_durum']==1) { ?>

                  <td bgcolor="#DDDDDD" data-title='Sonuç' >
         <?php  if ($bcek['basvuru_sonuc']==0) { ?>
           <font color="black">Sonuçlandırılmadı</font> 
         <?php }
         if ($bcek['basvuru_sonuc']==1) { ?>
           <font color="#0055FF" size="3" style="font-weight: bold;">Onaylandı  </font>
         <?php } ?>
        </td>







        <?php } ?>
        
      </tr>
      <?php } ?>



    </tbody>
  </table>
<br>




</div>

    <?php
  }

 ?>



<?php
}
else
{
?>
<div class="col-md-12" ><h5> <font color="red">Yapılmış Ders Başvurunuz Bulunmamaktadır.</font> </h5><hr></div>
<br> <font color="black">Yaz Okulu Başvurusu yapmak istiyorsanız </font> 
<a href="yazokulu"> <font size="3" color="red" style="font-weight: bold;"><u><b>buraya</b></u> </font> </a> <font color="black"> tıklayınız. </font>
</center>



<?php
}
include "footer.php";


 ?>
</body>
</html>
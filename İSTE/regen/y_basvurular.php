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
       Yaz okulu ba??vuru kayd??n??z ba??ar??l?? bir ??ekilde al??nm????t??r ! / Sonu?? incelendikten sonra anasayfan??za d????ecektir.
        
      </div>';
   }
}

if ($_GET['y_basvuru_guncelle']=="ok") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0 || $y_ilerlemecek['y_ilerleme_durum']==2) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       G??ncelleme Ba??ar??l??  !
        
      </div>';
   }
}

if ($_GET['o-s']=="ok") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0 || $y_ilerlemecek['y_ilerleme_durum']==2) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Silme ????lemi Ba??ar??l??  !
        
      </div>';
   }
}


if ($_GET['y_basvuru_durum']=="imzalanmadi") {

  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Yaz okulu ba??vuru kayd??n??z??n ilk ad??m?? ba??ar??l?? bir ??ekilde yap??lm????t??r. 
       <br>


        L??tfen ders ba??vurular??n??z??n tamamlanmas?? i??in almak istedi??iniz b??t??n dersleri ekledikten sonra a??a????daki butona t??klay??n ve dilek??enizi indirdikten sonra imzalayarak tekrar y??kleyiniz.
        
      </div>';

      $girdi=1;
       
}


if ($girdi==0) {
  if ($y_ilerlemecek['y_ilerleme_durum']==1) {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Yaz okulu ba??vurunuz ba??ar??l?? bir ??ekilde yap??lm????t??r. 
       <br>
        
      </div>';

     
      }    
}






if ($_GET['y_basvuru_durum']=="error") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Yaz okulu ba??vurunuz yap??l??rken bir hata olu??tu ! / L??tfen ilgili birime durumu bildiriniz.</strong></font>
              </div>';
            }
}

if ($_GET['y_basvuru_guncelle']=="error") {
  if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       G??ncelleme yap??l??rken bir hata olu??tu ! / L??tfen ilgili birime durumu bildiriniz.</strong></font>
              </div>';
            }
}
if ($_GET['y_basvuru_durum']=="tekrarlibasvuru") {
 
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Bu ders i??in zaten ba??vuru yapt??n??z ! <br> Ayn?? ders i??in birden fazla ba??vuru yapamazs??n??z.</strong></font>
              </div>';

}

if ($_GET['y_basvuru_durum']=="krediasildi") {
    if ($y_ilerlemecek['y_ilerleme_durum']==0) {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Bu dersi alarak alabilece??iniz maksimum kredi say??s??n?? a????yorsunuz ! <br> Maksimum kredi alma hakk??n??z : '.$y_ayarcek['max_kredi'].'</strong></font>
              </div>';
            }
}


?>



  
    <div class="col-md-12" > <h3> <font color="black">Yap??lan Yaz Okulu Ba??vurular??n??z</font> </h3><hr></div>

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
 <font color="black">Eklenen Ba??vurular??n??z Sonu??land??????nda Anasayfan??za D????ecektir</font>
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
        
         <br><center>L??tfen imzalama i??lemini ba??vuraca????n??z b??t??n dersleri ekledikten sonra yap??n??z.</center>
          <input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='y_dilekce_yukle';" value="Ba??vurular?? ??mzala" />


     <?php }
     if ($y_ilerlemecek['y_ilerleme_durum']!=1 && $obmsayi>0 && $y_ilerlemecek['y_ilerleme_durum']!=2) {

      ?>


      <br><center>L??tfen imzalama i??lemini ba??vuraca????n??z b??t??n dersleri ekledikten sonra yap??n??z.</center>
          <input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='y_dilekce_yukle';" value="Ba??vurular?? ??mzala" />
       
     <?php }

      ?>
      
        <?php }
       if($obsayi==$y_ayarcek['max_ders'] && $y_ilerlemecek['y_ilerleme_durum']!=1)
        { ?>
          <div id="dv1" class="alert alert-info" role="alert"><font color="black"><strong>

       Alabilece??iniz maksimum ders say??s??na ula??t??n??z.</strong></font>
              </div>



       <?php  } ?>

<?php

if ($bsayi>0) { ?>


<?php

 
 if ($y_ilerlemecek['y_ilerleme_durum']==0 && $girdi==0) { ?>

<center><br> <font color="black" size="4">Ba??vurular??n??z Hen??z ??mzalanmad?? !</font> <br> L??tfen Yaz Okulu ba??vurular??n??z??n tamamlanmas?? i??in ba??vuraca????n??z b??t??n dersleri ekledikten sonra yukar??daki butona t??klay??p dilek??enizi indirip sonra imzalayarak tekrar y??kleyiniz.    <br>          </center>

<?php  }
 if ($y_ilerlemecek['y_ilerleme_durum']==2 && $obmsayi>0) { ?>

<center><br> <font color="black" size="4">Ba??vurular??n??z Hen??z ??mzalanmad?? !</font> <br> Yeni ba??vuru yapt??????n??z i??in imzalama i??lemini tekrar yapman??z gerekmektedir.    <br>          </center>


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
      ??niversite :<?php echo " ".$max_unisayi.'/'.$y_ayarcek['max_universite']; ?> <br>

<div class="konteynir" >
<table style="margin-top: 50px;">
    <thead>


      <tr>

        <th>
          ??niversite 
        </th>
         <th>
          Fak??lte
        </th>
         <th>
          B??l??m
        </th>
        <th> 
        E??le??tirilen Ders
        </th>
        <th colspan="2">D??zenle/Sonu??</th>
        



      </tr>
    </thead>
   
    <tbody >
    <?php 

      while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {  ?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='Ba??vuru Yeri'>
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

         <td bgcolor="#DDDDDD" data-title='E??le??tirilen Ders'>
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
          class="btn px-4 m-1 btn-success">G??ncelle</button></a></center></td>



         <td bgcolor="#DDDDDD" ><center><a href="../nedmin/netting/islem.php?y_basvurusil_id=<?php echo $bcek['id']; ?>">
          <button <?php if($bcek['basvuru_sonuc']>0 || $y_ilerlemecek['y_ilerleme_durum']==1) { ?> style="color: black; cursor: not-allowed;"  disabled=" disabled "  <?php } ?> class="btn px-4 m-1 btn-outline-dark">Sil</button></a></center></td>

<?php  }  ?>



<?php  if ($y_ilerlemecek['y_ilerleme_durum']==2 && $bcek['basvuru_sonuc']!=0) {   ?>
          <td bgcolor="#DDDDDD" >   
            <?php 
            if ($bcek['basvuru_sonuc']==0) { ?>
              <font color="black" size="2" style="font-weight: bold;">Sonu??land??r??lmad??</font>
           <?php  }  ?>

              <?php 
            if ($bcek['basvuru_sonuc']==1) { ?>
             <font color="#0055FF" size="3" style="font-weight: bold;">Onayland??  </font>
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
<font color="darkblue"> Ba??vuru Hen??z Kurul Taraf??ndan <u>Kesinle??tirilmedi </u>   </font>

<table style="margin-top: 50px;">

    <thead>


      <tr>

        <th>
          ??niversite 
        </th>
         <th>
          Fak??lte
        </th>
         <th>
          B??l??m
        </th>
        <th> 
         E??le??tirilen Ders
        </th>
        <th>Sonu??</th>
       
        




      </tr>
    </thead>
   
    <tbody >
    <?php 

      while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='??nerilen ??niversite'>
          <?php
$kunisor=$db->prepare("SELECT * FROM universite  where universite_id=:universite_id ");
    $kunisor->execute(array( 'universite_id' => $bcek['k_universite'] )); 
    $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);
    echo $kunicek['name'];

          ?>

          
        
        </td>
        <td bgcolor="#DDDDDD" data-title='??nerilen Fak??lte'>
           <?php
$kfakultesor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
    $kfakultesor->execute(array( 'fakulte_id' => $bcek['k_fakulte'] )); 
    $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $kfakultecek['name'];

          ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='??nerilen B??l??m'>
                    <?php
$kbolumsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
    $kbolumsor->execute(array( 'bolum_id' => $bcek['k_bolum'] )); 
    $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $kbolumcek['name'];

          ?>
        </td>
       
         <td bgcolor="#DDDDDD" data-title='E??le??tirilen Ders'>
                    <?php
$bderssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $bderssor->execute(array( 'id' => $bcek['b_ders_ad'] )); 
    $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
    echo $bderscek['ders_ad'];

          ?>
        </td>

                <?php
        if ($y_ilerlemecek['y_ilerleme_durum']==2) { ?>

        <td bgcolor="#DDDDDD" data-title='Sonu??' >
          <?php
             if ($bcek['basvuru_sonuc']==0) {
             ?>
           <font color="black">Sonu??land??r??lmad??</font> 
           <?php
          }

          if ($bcek['basvuru_sonuc']==1) {
             ?>
           <font color="#00FF00">Onayland??</font> 
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
           <font color="black">Sonu??land??r??lmad??</font> 
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

                  <td bgcolor="#DDDDDD" data-title='Sonu??' >
         <?php  if ($bcek['basvuru_sonuc']==0) { ?>
           <font color="black">Sonu??land??r??lmad??</font> 
         <?php }
         if ($bcek['basvuru_sonuc']==1) { ?>
           <font color="#0055FF" size="3" style="font-weight: bold;">Onayland??  </font>
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
<div class="col-md-12" ><h5> <font color="red">Yap??lm???? Ders Ba??vurunuz Bulunmamaktad??r.</font> </h5><hr></div>
<br> <font color="black">Yaz Okulu Ba??vurusu yapmak istiyorsan??z </font> 
<a href="yazokulu"> <font size="3" color="red" style="font-weight: bold;"><u><b>buraya</b></u> </font> </a> <font color="black"> t??klay??n??z. </font>
</center>



<?php
}
include "footer.php";


 ?>
</body>
</html>
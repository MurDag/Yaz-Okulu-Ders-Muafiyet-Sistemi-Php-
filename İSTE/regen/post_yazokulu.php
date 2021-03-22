<?php 
error_reporting(0);
include "../nedmin/netting/baglan.php";


$ders=$_POST['ders'];
$uni=$_POST['universite'];
$fakulte=$_POST['fakulteler'];



if (isset($_POST['ders'])) {

$unisor=$db->prepare("SELECT * from yazokulu_onayli_dersler where b_ders_ad=:b_ders_ad");
      $unisor->execute(array(
            'b_ders_ad'=>$ders
      ));

      ?>
       <option value="0">Üniversite Seçiniz</option>
      <?php
      while ($unicek=$unisor->fetch(PDO::FETCH_ASSOC)) 
      {

        $uadsor=$db->prepare("SELECT * from universite where universite_id=:universite_id");
      $uadsor->execute(array(
            'universite_id'=>$unicek['k_universite']
      ));

        $uadcek=$uadsor->fetch(PDO::FETCH_ASSOC);

        ?>
         <option value="<?php echo $unicek['k_universite']; ?>"><?php echo $uadcek['name']; ?></option>
         <?php
      } }


if (isset($_POST['universite'])) {

$unisor=$db->prepare("SELECT * from yazokulu_onayli_dersler where k_universite=:k_universite");
      $unisor->execute(array(
            'k_universite'=>$uni
      ));

      ?>
       <option value="0">Fakülte Seçiniz</option>
      <?php
      while ($unicek=$unisor->fetch(PDO::FETCH_ASSOC)) 
      {

        $uadsor=$db->prepare("SELECT * from universite_fakulte where fakulte_id=:fakulte_id");
      $uadsor->execute(array(
            'fakulte_id'=>$unicek['k_fakulte']
      ));

        $uadcek=$uadsor->fetch(PDO::FETCH_ASSOC);

        ?>
         <option value="<?php echo $unicek['k_fakulte']; ?>"><?php echo $uadcek['name']; ?></option>
         <?php
      }

}


if (isset($_POST['fakulteler'])) {

$bolumsor=$db->prepare("SELECT * from yazokulu_onayli_dersler where k_fakulte=:k_fakulte");
      $bolumsor->execute(array(
            'k_fakulte'=>$fakulte
      ));

      ?>
       <option value="0">Bölüm Seçiniz</option>
      <?php
      while ($bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC)) 
      {

        $badsor=$db->prepare("SELECT * from universite_bolum where bolum_id=:bolum_id");
      $badsor->execute(array(
            'bolum_id'=>$bolumcek['k_bolum']
      ));

        $badcek=$badsor->fetch(PDO::FETCH_ASSOC);

        ?>
         <option value="<?php echo $bolumcek['k_bolum']; ?>"><?php echo $badcek['name']; ?></option>
         <?php
      }

}







      ?>
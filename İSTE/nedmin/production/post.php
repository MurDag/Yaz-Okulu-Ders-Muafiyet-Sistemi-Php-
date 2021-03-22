<?php 
include "../netting/baglan.php";

$uni=$_POST['universite'];
$fakulte=$_POST['fakulteler'];
$bbolum=$_POST['bolumid'];
$bfakulteler=$_POST['bfakulteler'];
$bbolumler=$_POST['bbolumler'];

if (isset($_POST['bbolumler'])) {

   $derssor=$db->prepare("SELECT * from dersler where ders_bolum=:ders_bolum");
      $derssor->execute(array(
            'ders_bolum'=>$bbolumler
      ));
      ?>
       <option value="0">Bir Ders Seçiniz</option>
      <?php

      while ($derscek=$derssor->fetch(PDO::FETCH_ASSOC)) 
      {
            ?>
             <option value="<?php echo $derscek['id']; ?>"><?php echo $derscek['ders_ad']; ?></option>
             <?php
      }

}

  
if (isset($_POST['bfakulteler'])) {

$bbolumsor=$db->prepare("SELECT * from bolumler where fakulte_yid=:fakulte_yid");
      $bbolumsor->execute(array(
            'fakulte_yid'=>$bfakulteler
      ));

      ?>
       <option value="0">Bir Bölüm Seçiniz</option>
      <?php
      while ($bbolumcek=$bbolumsor->fetch(PDO::FETCH_ASSOC)) 
      {
        ?>
         <option value="<?php echo $bbolumcek['id']; ?>"><?php echo $bbolumcek['bolum_ad']; ?></option>
         <?php
      }


}   

if (isset($_POST['universite'])) {

$fakultesor=$db->prepare("SELECT * from universite_fakulte where universite_id=:universite_id");
      $fakultesor->execute(array(
            'universite_id'=>$uni
      ));

      ?>
       <option value="0">Fakülte Seçiniz</option>
      <?php
      while ($fakultecek=$fakultesor->fetch(PDO::FETCH_ASSOC)) 
      {
        ?>
         <option value="<?php echo $fakultecek['fakulte_id']; ?>"><?php echo $fakultecek['name']; ?></option>
         <?php
      }
  

}


if (isset($_POST['fakulteler'])) {

   $bolumsor=$db->prepare("SELECT * from universite_bolum where fakulte_id=:fakulte_id");
      $bolumsor->execute(array(
            'fakulte_id'=>$fakulte
      ));
      ?>
       <option value="0">Bölüm Seçiniz</option>
      <?php

      while ($bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC)) 
      {
            ?>
             <option value="<?php echo $bolumcek['bolum_id']; ?>"><?php echo $bolumcek['name']; ?></option>
             <?php
      }

}









      ?>
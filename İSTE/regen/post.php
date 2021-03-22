<?php 
error_reporting(0);
include "../nedmin/netting/baglan.php";

$uni=$_POST['universite'];
$fakulte=$_POST['fakulteler'];
$bfakulte=$_POST['bfakulteid'];
$bbolum=$_POST['bolumid'];

      

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
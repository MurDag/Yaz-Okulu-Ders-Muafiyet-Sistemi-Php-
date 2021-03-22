<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi

$okid=$_GET['oneri_kul_id'];

$onerisor=$db->prepare("SELECT * FROM onerilen_dersler where onerenkisi_id=:onerenkisi_id");
$onerisor->execute(array( 
      'onerenkisi_id' => $okid
     )); 

if(isset($_GET['o_i_d']))
{
  $onerisor=$db->prepare("SELECT * FROM onerilen_dersler where onerenkisi_id=:onerenkisi_id and kayit_degisme_durum=:kayit_degisme_durum");
$onerisor->execute(array( 
      'onerenkisi_id' => $okid,
      'kayit_degisme_durum' => 1
     )); 

}



$sonucsor=$db->prepare("SELECT * FROM oneri_ilerleme_kontrol where oneri_kul_id=:oneri_kul_id");
$sonucsor->execute(array( 
      'oneri_kul_id' => $okid
     )); 

$sonuccek=$sonucsor->fetch(PDO::FETCH_ASSOC);


?>


<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Önerilen Dersler<small>,

              <?php 

              if ($_GET['durum']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif ($_GET['durum']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>


            </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
             
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>

                  <th>Üniversite</th>
                  <th>Fakülte</th>
                  <th>Bölüm</th>
                  <th>Ders Adı</th>
                  <th>Ders İçerik</th>
                  <th>Kredi</th>
                  <th>TUL</th>
                  <th>AKTS</th>
                  <th>Eşleştirilmek İstenen Ders</th>
                  <th>Ders Sonuc</th>
                  <?php if($sonuccek['oneri_ilerleme_durum']!=2){ ?>

                  <th></th>
                  <th></th>
                <?php } ?>
                <th>Red Sebep</th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($onericek=$onerisor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                     <td>
                    <?php  
                    $usor=$db->prepare("SELECT * FROM universite  where universite_id=:universite_id ");
                    $usor->execute(array( 'universite_id' => $onericek['ders_kuniversite'] )); 
                      $ucek=$usor->fetch(PDO::FETCH_ASSOC);

                      echo $ucek['name'];

                    ?>
                    
                      
                    </td>

                    <td>
                    <?php  
                    $fsor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
                    $fsor->execute(array( 'fakulte_id' => $onericek['ders_kfakulte'] )); 
                      $fcek=$fsor->fetch(PDO::FETCH_ASSOC);

                      echo $fcek['name'];

                    ?>
                    
                      
                    </td>
                     <td>
                    <?php  
                    $kbsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
                    $kbsor->execute(array( 'bolum_id' => $onericek['ders_kbolum'] )); 
                      $kbcek=$kbsor->fetch(PDO::FETCH_ASSOC);

                      echo $kbcek['name'];

                    ?>
                    
                      
                    </td>





                  <td>

                    <a href="<?php echo $onericek['ders_klink']; ?>"  target="_blank">
                      <font size="2" color="red"><u>
                    <?php echo $onericek['ders_ad'] ?>

                      </u></font></a>


                    </td>

                  <td>
                    
                     <a href="oneri_incele?ders_id=<?php echo $onericek['ders_bders']; ?>&ders_icerik=<?php echo $onericek['ders_kicerik']; ?>&oneri_kul_id=<?php echo $_GET['oneri_kul_id']; ?>"> <font face="tahoma" color="blue"><u> İçerik</u> </font> </a>

                  </td>

                  <td><?php echo $onericek['ders_kkredi'] ?></td>
                  <td><?php echo $onericek['ders_ktul'] ?></td>
                  <td><?php echo $onericek['ders_kakts'] ?></td>

                  <td>
                    <?php  
                    $dsor=$db->prepare("SELECT * FROM dersler  where id=:id ");
                    $dsor->execute(array( 'id' => $onericek['ders_bders'] )); 
                    $dcek=$dsor->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <a href="oneri_incele?ders_id=<?php echo $onericek['ders_bders']; ?>&oneri_kul_id=<?php echo $_GET['oneri_kul_id']; ?>"> <font face="tahoma" color="blue"><u> <?php echo $dcek['ders_ad'];  ?></u> </font> </a>
                      
                    </td>

                   <td><?php 
                   if ($onericek['oneri_sonuc']==0) 
                   {
                    ?>

<font face="arial" size="2" color=" #FFA000"> Sonuçlanmadı </font>
                    <?php

                   } 
                   if ($onericek['oneri_sonuc']==2) 
                   {

                     ?>

<font face="arial" size="2" color="red"> Reddedildi </font>
                    <?php
                   } 
                   if ($onericek['oneri_sonuc']==1) 
                   {
                     ?>

<font face="arial" size="2" color="blue"> Onaylandı </font>
                    <?php
                   } 
                   ?></td>

                   <?php if($sonuccek['oneri_ilerleme_durum']!=2){ 
                    if($sonuccek['oneri_ilerleme_durum']==3){
                    ?>
                  <td><center><a href="../netting/islem.php?degisme=evet&oneri_onay=<?php echo $onericek['id']; ?>"><button class="btn btn-primary btn-xs">Onayla</button></a></center></td>


                  <td><center><a href="oneri_redsebep?degisme=evet&oneri_red_id=<?php echo $onericek['id']; ?>"><button class="btn btn-danger btn-xs">Reddet</button></a></center></td>
                <?php }else
                 {?>

                   <td><center><a href="../netting/islem.php?oneri_onay=<?php echo $onericek['id']; ?>"><button class="btn btn-primary btn-xs">Onayla</button></a></center></td>


                  <td><center><a href="oneri_redsebep?oneri_red_id=<?php echo $onericek['id']; ?>"><button class="btn btn-danger btn-xs">Reddet</button></a></center></td>

              
                <?php } ?>

                  

                <?php } ?>
                <td><?php echo $onericek['oneri_red_sebep']; ?></td>
                </tr>



                <?php  }

                ?>


              </tbody>
            </table>
            <center>
              <?php if($sonuccek['oneri_ilerleme_durum']==1){ ?>
              <a href="../netting/islem.php?oneri_kesinlestir=<?php echo $_GET['oneri_kul_id']; ?>"><button class="btn btn-primary btn-xs">Kesinleştir</button></a>
              <?php }
               if($sonuccek['oneri_ilerleme_durum']==3){ ?> 
                 <a href="../netting/islem.php?degisme=evet&oneri_kesinlestir=<?php echo $_GET['oneri_kul_id']; ?>"><button class="btn btn-primary btn-xs">Kesinleştir</button></a>

               <?php } ?>
            </center>

            <div class="container">
              <div id="viewpdf"></div>
              
            </div>
            <script src="jquery.min.js"></script>
            <script src="pdfobject.min.js"></script>

          <center>

                        <?php 

            if ($_GET['ders_id']!=null) {
              
                  $bderssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $bderssor->execute(array( 'id' => $_GET['ders_id'] )); 
    $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
            

            ?>

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <td colspan="8">
                    <center>
                   <b> <font face="arial" size="4" color="black"> Eşleştirilmek İstenen Ders Bilgileri </font> </b>  
                    </center>
                  </td>
                </tr>
                <tr>
                  <th>Ders Adı</th>
                  <th>TUL</th>
                  <th>Ders Türü</th>
                  <th>AKTS</th>
                  <th>Kredi</th>
                  <th>Ders Sınıf</th>
                  <th>Ders Dönem</th>
                  <th>Ders Bölüm</th>
                  
                </tr>
              </thead>
              <tbody>
                  <tr>


                    <td><?php echo $bderscek['ders_ad']; ?></td>
                    <td><?php echo $bderscek['ders_tul']; ?></td>
                    <td><?php echo $bderscek['ders_turu']; ?></td>
                    <td><?php echo $bderscek['ders_akts']; ?></td>
                    <td><?php echo $bderscek['ders_kredi']; ?></td>
                    <td><?php echo $bderscek['ders_yil']; ?></td>
                    <td><?php echo $bderscek['ders_donem']; ?></td>
                    <td> <?php  
                    $bsor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
                    $bsor->execute(array( 'id' => $bderscek['ders_bolum'] )); 
                    $bcek=$bsor->fetch(PDO::FETCH_ASSOC);
                    echo $bcek['bolum_ad']; 
                    ?></td>

                  </tr>


              </tbody>

            </table>
            <?php
          }
             ?>

            <!-- Div İçerik Bitişi -->


          </div>
        </div>
      </div>
    </div>
    <center>
      
      <?php 

      if ($_GET['ders_icerik']) { ?>

 <iframe src="../../uploads/onerilendersicerikleri/<?php echo $_GET['ders_icerik']; ?>" width="80%" height="900" style="border: none;" allowfullscreen webkitallowfullscreen></iframe>

    </center>

<?php } ?>


  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>

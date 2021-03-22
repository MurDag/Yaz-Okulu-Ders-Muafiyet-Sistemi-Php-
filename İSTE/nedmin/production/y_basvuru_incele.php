<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi

$okid=$_GET['basvuru_kul_id'];

$onerisor=$db->prepare("SELECT * FROM yazokulu_basvuru where basvuru_kul_id=:basvuru_kul_id");
$onerisor->execute(array( 
      'basvuru_kul_id' => $okid
     )); 
?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Başvurulan Dersler<small>,

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

                  <th>Eşleştirilmek İstenen Ders</th>                  
                  <th>Kredi</th>
                  <th>TUL</th>
                  <th>AKTS</th>
                  <th>Ders Sonuc</th>
                  <th></th>
                  <th></th>
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
                    $usor->execute(array( 'universite_id' => $onericek['k_universite'] )); 
                      $ucek=$usor->fetch(PDO::FETCH_ASSOC);

                      echo $ucek['name'];

                    ?>
                    
                      
                    </td>

                    <td>
                    <?php  
                    $fsor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
                    $fsor->execute(array( 'fakulte_id' => $onericek['k_fakulte'] )); 
                      $fcek=$fsor->fetch(PDO::FETCH_ASSOC);

                      echo $fcek['name'];

                    ?>
                    
                      
                    </td>
                     <td>
                    <?php  
                    $kbsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
                    $kbsor->execute(array( 'bolum_id' => $onericek['k_bolum'] )); 
                      $kbcek=$kbsor->fetch(PDO::FETCH_ASSOC);

                      echo $kbcek['name'];

                    ?>
                    
                      
                    </td>





                  <td><?php 
                   $drssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
                    $drssor->execute(array( 'id' => $onericek['b_ders_ad'] )); 
                      $drscek=$drssor->fetch(PDO::FETCH_ASSOC);


                  echo $drscek['ders_ad'] ?></td>

                  <td><?php echo $drscek['ders_kredi']; ?></td>
                  <td><?php echo $drscek['ders_tul']; ?></td>
                  <td><?php echo $drscek['ders_akts']; ?></td>

                   <td><?php 
                   if ($onericek['basvuru_sonuc']==0) 
                   {
                    ?>

<font face="arial" size="2" color=" #FFA000"> Sonuçlanmadı </font>
                    <?php

                   } 
                   if ($onericek['basvuru_sonuc']==2) 
                   {

                     ?>

<font face="arial" size="2" color="red"> Reddedildi </font>
                    <?php
                   } 
                   if ($onericek['basvuru_sonuc']==1) 
                   {
                     ?>

<font face="arial" size="2" color="blue"> Onaylandı </font>
                    <?php
                   } 
                   ?></td>


                  <td><center><a href="../netting/islem.php?y_basvuru_onay=<?php echo $onericek['id']; ?>"><button class="btn btn-primary btn-xs">Onayla</button></a></center></td>


                  <td><center><a href="y_redsebep?bk_id=<?php echo $okid; ?>&basvuru_red_id=<?php echo $onericek['id']; ?>"><button class="btn btn-danger btn-xs">Reddet</button></a></center></td>
                    
                                      <?php
                   if ($onericek['basvuru_sonuc']==2) 
                   {?>
                 <td><?php echo $onericek['red_sebep']; ?></td>
                    <?php } ?>

                  
                

                </tr>



                <?php  }

                ?>


              </tbody>
            </table>
            <center>
              <a href="../netting/islem.php?y_basvuru_kesinlestir=<?php echo $_GET['basvuru_kul_id']; ?>"><button class="btn btn-primary btn-xs">Kesinleştir</button>
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

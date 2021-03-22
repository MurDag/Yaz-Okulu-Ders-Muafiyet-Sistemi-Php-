<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
    $derssor=$db->prepare("SELECT * FROM kdersler  where basvuru_yid=:basvuru_yid ");
    $derssor->execute(array( 'basvuru_yid' => $_GET['basvuru_id'] )); 
    

    $belgesor=$db->prepare("SELECT basvuru_belge FROM basvuru  where basvuru_yid=:basvuru_yid ");
    $belgesor->execute(array( 'basvuru_yid' => $_GET['basvuru_id'] )); 
    $belgecek=$belgesor->fetch(PDO::FETCH_ASSOC);




?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Muafiyet Başvuruları <small>,

              <?php 

              if ($_GET['durum']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif ($_GET['durum']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>


            </small></h2>
           
            <div class="clearfix"></div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Ders Adı</th>
                  <th>Kredi</th>
                  <th>TUL</th>
                  <th>AKTS</th>
                  <th>Eşleştirilmek İstenen Ders</th>
                  <th>Ders Sonuc</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($derscek=$derssor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td><?php echo $derscek['ders_ad'] ?></td>
                  <td><?php echo $derscek['ders_kredi'] ?></td>
                  <td><?php echo $derscek['ders_tul'] ?></td>
                  <td><?php echo $derscek['ders_akts'] ?></td>

                  <td>
                    <?php  
                    $dsor=$db->prepare("SELECT * FROM dersler  where id=:id ");
                    $dsor->execute(array( 'id' => $derscek['muaf_ders'] )); 
                    $dcek=$dsor->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <a href="basvuru_karar?ders_id=<?php echo $derscek['muaf_ders']; ?>&basvuru_id=<?php echo $_GET['basvuru_id']; ?>"> <font face="tahoma" color="blue"><u> <?php echo $dcek['ders_ad'];  ?></u> </font> </a>
                      
                    </td>

                   <td><?php 
                   if ($derscek['ders_onay']==0) 
                   {
                    ?>

<font face="arial" size="2" color=" #FFA000"> Sonuçlanmadı </font>
                    <?php

                   } 
                   if ($derscek['ders_onay']==1) 
                   {

                     ?>

<font face="arial" size="2" color="red"> Reddedildi </font>
                    <?php
                   } 
                   if ($derscek['ders_onay']==2) 
                   {
                     ?>

<font face="arial" size="2" color="blue"> Onaylandı </font>
                    <?php
                   } 
                   ?></td>


                  <td><center><a href="../netting/islem.php?onayla_id=<?php echo $derscek['id']; ?>"><button class="btn btn-primary btn-xs">Onayla</button></a></center></td>


                  <td><center><a href="sebepekle?reddet_id=<?php echo $derscek['id']; ?>"><button class="btn btn-danger btn-xs">Reddet</button></a></center></td>
                  

                

                </tr>



                <?php  }

                ?>


              </tbody>
            </table>
            <center>
              <a href="../netting/islem.php?kesinlestir_id=<?php echo $_GET['basvuru_id']; ?>"><button class="btn btn-primary btn-xs">Kesinleştir</button>
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
            <br><br>
         


            

          
          





            </center>

          </div>
        </div>
      </div>
    </div>
<center>
  <iframe src="../../uploads/transkript/<?php echo $belgecek['basvuru_belge']; ?>" width="45%" height="900" style="border: none;" allowfullscreen webkitallowfullscreen></iframe>


         

  
  <iframe src="../../uploads/dersicerik/<?php echo $belgecek['basvuru_belge']; ?>" width="45%" height="900" style="border: none;" allowfullscreen webkitallowfullscreen></iframe>
</center>
         
            


  </div>
</div>
<!-- /page content -->




<?php include 'footer.php'; ?>

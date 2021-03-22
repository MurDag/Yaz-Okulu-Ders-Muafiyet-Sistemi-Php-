<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
$basvurusor=$db->prepare("SELECT * FROM basvuru where basvuru_sonuc=1");
$basvurusor->execute();




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

              if ($_GET['kesinlestir']=="ok") {?>

              <b style="color:green;">Kesinleştirme Başarılı...</b>

              <?php } elseif ($_GET['kesinlestir']=="no") {?>

              <b style="color:red;">Kesinleştirme Başarısız...</b>

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
                  <th>Kayıt Tarih</th>
                  <th>Ad</th>
                  <th>Soyad</th>
                  <th>Bölüm</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($basvurucek=$basvurusor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td><?php echo $basvurucek['basvuru_tarih'] ?></td>
                  <td><?php echo $basvurucek['basvuru_ad'] ?></td>
                  <td><?php echo $basvurucek['basvuru_soyad'] ?></td>

                  <td>
                    <?php  
                    $bolumsor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
                    $bolumsor->execute(array( 'id' => $basvurucek['basvuru_bolum_id'] )); 
                    $bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC);
                    echo $bolumcek['bolum_ad']; 
                    ?>
                      
                    </td>
                  <td><center><a href="basvuru_karar?basvuru_id=<?php echo $basvurucek['basvuru_yid']; ?>"><button class="btn btn-primary btn-xs">İncele</button></a></center></td>
                </tr>



                <?php  }

                ?>


              </tbody>
            </table>

            <!-- Div İçerik Bitişi -->


          </div>
        </div>
      </div>
    </div>




  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>

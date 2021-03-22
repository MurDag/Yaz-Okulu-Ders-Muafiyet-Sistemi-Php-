<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
$derssor=$db->prepare("SELECT * FROM dersler");
$derssor->execute();


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ders Listeleme <small>,

              <?php 

              if ($_GET['durum']=="g-ok") {?>

              <b style="color:green;">Güncelleme Başarılı...</b>

              <?php } if ($_GET['durum']=="g-no") {?>

              <b style="color:red;">Güncelleme Başarısız...</b>

              <?php }


              if ($_GET['durum']=="s-ok") {?>

              <b style="color:green;">Silme Başarılı...</b>

              <?php } if ($_GET['durum']=="s-no") {?>

              <b style="color:red;">Silme Başarısız...</b>


          <?php } if ($_GET['durum']=="e-ok") {?>


              <b style="color:green;">Ders Ekleme Başarılı...</b>

              <?php } if ($_GET['durum']=="e-no") {?>

              <b style="color:red;">Ders Ekleme Başarısız...</b>
            <?php } ?>


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


             <center><a href="ders-ekle"><button class="btn btn-success">Ders Ekle</button></a></center>

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Ders Kodu</th>
                  <th>Ders Adı</th>
                  <th>TUL</th>
                  <th>Ders Türü</th>
                  <th>AKTS</th>
                  <th>Kredi</th>
                  <th>Ders Yılı</th>
                  <th>Ders Dönemi</th>
                  <th>Ders Bölümü</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($derscek=$derssor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td><?php echo $derscek['ders_kodu'] ?></td>
                  <td><?php echo $derscek['ders_ad'] ?></td>
                  <td><?php echo $derscek['ders_tul'] ?></td>
                  <td><?php echo $derscek['ders_turu'] ?></td>
                  <td><?php echo $derscek['ders_akts'] ?></td>
                  <td><?php echo $derscek['ders_kredi'] ?></td>
                  <td><?php echo $derscek['ders_yil'] ?></td>
                  <td><?php echo $derscek['ders_donem'] ?></td>
                                    <td><?php  $byid=$derscek['ders_bolum'];  

                      $fadsor=$db->prepare("select bolum_ad from bolumler where id=:id");
                       $fadsor->execute(array(
                        'id' => $byid
                        ));


                      $fadcek=$fadsor->fetch(PDO::FETCH_ASSOC);

                      echo $fadcek['bolum_ad'];   
                                    



                   ?></td>
                  <td><center><a href="ders-duzenle?ders_id=<?php echo $derscek['id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                  <td><center><a href="../netting/islem.php?ders_id=<?php echo $derscek['id']; ?>&drssil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                </tr>



                <?php  }

                ?>


              </tbody>
            </table>

          



                </div>
              </div>


          </div>
        </div>
      </div>
    </div>




  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>

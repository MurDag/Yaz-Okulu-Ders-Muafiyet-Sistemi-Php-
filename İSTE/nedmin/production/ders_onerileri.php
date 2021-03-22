<?php 
error_reporting(0);
include 'header.php'; 
include "../netting/baglan.php";


//Belirli veriyi seçme işlemi
$onerisor=$db->prepare("SELECT *  FROM oneri_ilerleme_kontrol where  oneri_ilerleme_durum=:oneri_ilerleme_durum");
$onerisor->execute(array( 
      'oneri_ilerleme_durum' => 1
     )); 
if (isset($_POST['getir'])) {

  if ($_POST['odersler']==1) {

  $onerisor=$db->prepare("SELECT * FROM oneri_ilerleme_kontrol where oneri_ilerleme_durum=1");
$onerisor->execute();
 
}
elseif ($_POST['odersler']==2) {
    $onerisor=$db->prepare("SELECT * FROM oneri_ilerleme_kontrol where oneri_ilerleme_durum=2");
$onerisor->execute();
}
elseif ($_POST['odersler']==3) {
    $onerisor=$db->prepare("SELECT * FROM oneri_ilerleme_kontrol where oneri_ilerleme_durum=3");
$onerisor->execute();
}

}


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">


    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            

                           
                              
                                    <h2>Ders Öneri Başvuruları <small>,</small></h2>
                                    <br><br><br>
                                    <form action="#" method="POST">
                     <table>              
              <tr>
            <td>
              
               <select name="odersler" class="form-control">
                            <option  <?php if ($_POST['odersler']==1)  {
                              echo 'selected="selected"';
                            } ?> value="1">Aktif Ders Önerileri</option>
                            <option <?php if ($_POST['odersler']==2)  {
                              echo 'selected="selected"';
                            } ?>  value="2">Sonuçlanan Ders Önerileri</option>
                             <option <?php if ($_POST['odersler']==3)  {
                              echo 'selected="selected"';
                            } ?>  value="3">Sonradan Kaydı Silinen Ders Önerileri</option>
                           
                </select>

            </td>
            <td>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Getir" name="getir">
            </td>
          </tr>
        </table>
        </form>

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
                  <th>Kayıt Tarihi</th>
                  <th>Ad</th>
                  <th>Soyad</th>
                  <th>Fakülte</th>
                  <th>Bölüm</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($onericek=$onerisor->fetch(PDO::FETCH_ASSOC)) {
                  
                  ?>


                <tr>
                  <td>

                    <?php  
                    
                    echo $onericek['kayit_tarih']; 
                    ?>
                      
                    </td>

                     <td>
                    <?php  
                    $kisisor=$db->prepare("SELECT * FROM ogrenci  where id=:id ");
                    $kisisor->execute(array( 'id' => $onericek['oneri_kul_id'] )); 
                    $kisicek=$kisisor->fetch(PDO::FETCH_ASSOC);
                    echo $kisicek['kullanici_ad']; 

                    $bsor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
                    $bsor->execute(array( 'id' => $kisicek['kullanici_bolum_id'] )); 
                    $bcek=$bsor->fetch(PDO::FETCH_ASSOC);

                     $fksor=$db->prepare("SELECT * FROM fakulteler  where id=:id ");
                    $fksor->execute(array( 'id' => $bcek['fakulte_yid'] )); 
                    $fkcek=$fksor->fetch(PDO::FETCH_ASSOC);

                    ?>
                      
                    </td>
                    <td>
                      <?php 
                      echo $kisicek['kullanici_soyad']; 

                      ?>
                    </td>
                    <td>
                       <?php  
                   
                    echo $fkcek['fakulte_ad']; 
                    ?>
                   
                      
                    </td>
                    <td>
                      <?php 
                      echo $bcek['bolum_ad']; 

                      ?>
                    </td>
                     

                     <td>
                      <?php if ($_POST['odersler']==3) { ?>

                      <center><a href="oneri_incele?o_i_d=<?php echo $onericek['oneri_ilerleme_durum']; ?>&oneri_kul_id=<?php echo $onericek['oneri_kul_id']; ?>"><button class="btn btn-primary btn-xs">İncele</button></a></center>
                    <?php }else
                      {
                     ?>
                      
                     <center><a href="oneri_incele?oneri_kul_id=<?php echo $onericek['oneri_kul_id']; ?>"><button class="btn btn-primary btn-xs">İncele</button></a></center>
                   <?php } ?>

                    </td>
                </tr>
                <?php  }  ?>


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

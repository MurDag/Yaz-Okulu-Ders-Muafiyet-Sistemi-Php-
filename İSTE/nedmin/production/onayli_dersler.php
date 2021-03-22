<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi

$okid=$_GET['basvuru_kul_id'];

$onayli_ders_sor=$db->prepare("SELECT * FROM yazokulu_onayli_dersler");
$onayli_ders_sor->execute(array()); 
?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Onaylı Dersler<small>,

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

              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            

             <center><a href="yodekle"><button type="submit" name="yodekle" class="btn btn-success">Yeni Ders Ekle</button></a></center>
            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>

                  <th>Kayıt Tarihi</th>
                  <th>Üniversite</th>
                  <th>Fakülte</th>
                  <th>Bölüm</th>
                  <th>Ders Adı</th>                  


                  <th>Eşleştirilen Bölüm</th> 
                  <th>Eşleştirilen Ders</th> 
                  <th></th>
                  <th></th>
                 
                  

                 
                </tr>
              </thead>

              <tbody>

                <?php 

                while($onericek=$onayli_ders_sor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td>
                    <?php echo $onericek['kayit_tarih']; ?>
                  </td>

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

                    <td>
                        <a href="onayli_dersler?kders=<?php echo $onericek['id']; ?>"><font color="red"><u>
                          
                                               <?php  

                      echo $onericek['k_ders_ad'];

                    ?>

                        </u></font> </a>


                    </td>
                    <td>
                      
                    <?php  
                    $bbolum_sor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
                    $bbolum_sor->execute(array( 'id' => $onericek['b_bolum'] )); 
                      $bbolum_cek=$bbolum_sor->fetch(PDO::FETCH_ASSOC);
                    ?>

                    
                          
                    <?php   echo $bbolum_cek['bolum_ad']; ?>

                    </td>
                    <td>
                      
                    <?php  
                    $bders_sor=$db->prepare("SELECT * FROM dersler  where id=:id ");
                    $bders_sor->execute(array( 'id' => $onericek['b_ders_ad'] )); 
                      $bders_cek=$bders_sor->fetch(PDO::FETCH_ASSOC);
                    ?>

                    
                          
                    <?php   echo $bders_cek['ders_ad']; ?>

                    </td>

                  <td><center><a href="yazokulu_odersler_duzenle?yo_ders_düzenle=<?php echo $onericek['id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>


                  <td><center><a href="../netting/islem.php?ders_icerik=<?php echo $onericek['k_ders_icerik']; ?>&kurul_yosil=<?php echo $onericek['id']; ?>"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>

                  
                

                </tr>



                <?php  }

                ?>


              </tbody>
            </table>
<?php if (isset($_GET['kders'])) { 

$kbilgisor=$db->prepare("SELECT * FROM yazokulu_onayli_dersler  where id=:id ");
    $kbilgisor->execute(array( 'id' => $_GET['kders'] )); 
    $kbilgicek=$kbilgisor->fetch(PDO::FETCH_ASSOC);




              $bbilgisor=$db->prepare("SELECT * FROM dersler  where id=:id ");
              $bbilgisor->execute(array( 'id' => $kbilgicek['b_ders_ad'] )); 
              $bbilgicek=$bbilgisor->fetch(PDO::FETCH_ASSOC);
           



 ?>


            <table border="1" align="center">
              <tr>
                <td colspan="2">Kabul Edilen Ders Bilgileri</td>
                <td colspan="2">Eşleştirilen Ders Bilgileri</td>
              </tr>
              <tr>
                <td>Ders Kodu :</td>
                <td>
                  
                  <?php echo $kbilgicek['k_ders_kodu']; ?>

                </td>
                                <td>Ders Kodu :</td>
                <td>
                    
                  <?php echo $bbilgicek['ders_kodu']; ?>
                </td>
              </tr>
              <tr>
                <td>Ders Adı :</td>
                <td>
                  

                  <?php echo $kbilgicek['k_ders_ad']; ?>



                </td>
                                <td>Ders Adı :</td>
                <td>
                  <?php echo $bbilgicek['ders_ad']; ?>
                </td>
              </tr>
             <tr>
                <td>Kredi :</td>
                <td>
                  <?php echo $kbilgicek['k_ders_kredi']; ?>
                </td>
                                <td>Kredi :</td>
                <td>
                  <?php echo $bbilgicek['ders_kredi']; ?>
                </td>
              </tr>
               <tr>
                <td>TUL :</td>
                <td>
                  <?php echo $kbilgicek['k_ders_tul']; ?>
                </td>
                                <td>TUL :</td>
                <td>
                  <?php echo $bbilgicek['ders_tul']; ?>
                </td>
              </tr>
                <tr>
                <td>AKTS :</td>
                <td>
                  <?php echo $kbilgicek['k_ders_akts']; ?>
                </td>
                                <td>AKTS :</td>
                <td>
                  <?php echo $bbilgicek['ders_akts']; ?>
                </td>
              </tr>
           
            <tr>
                <td colspan="2">Ders İçeriği :</td>
                <td colspan="2"><a href="onayli_dersler?ders_icerik=<?php echo $kbilgicek['k_ders_icerik'];?>&kders=<?php echo $kbilgicek['id']; ?>">
                 <font size="3" color="blue"><u> Ders İçerik</u></font> 
                </a></td>
              </tr>
           
            <tr>
                <td colspan="2">Ders Linki :</td>
                <td colspan="2"><a href="<?php echo $kbilgicek['k_ders_link']; ?>" target="_blank">
                 <font size="3" color="blue"><u> Link </u></font> 
                </a></td>
              </tr>
            </table>



<?php } ?>




            <div class="container">
              <div id="viewpdf"></div>
              
            </div>
            <script src="jquery.min.js"></script>
            <script src="pdfobject.min.js"></script>

          <center>

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

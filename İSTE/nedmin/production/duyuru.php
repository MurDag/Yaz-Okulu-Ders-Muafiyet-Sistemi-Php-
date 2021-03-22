<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
$duyurusor=$db->prepare("SELECT * FROM duyuru order by madde_sira asc");
$duyurusor->execute();


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sayfa Ayarları <small>,
              <?php

              if ($_GET['durum']=="d-ok") {
                echo "Güncelleme Başarılı";
              }
              if ($_GET['durum']=="d-no") {
                echo "Güncelleme Başarısız";
              }
              if ($_GET['durum']=="s-ok") {
                echo "Silme İşlemi Başarılı";
              }
              if ($_GET['durum']=="s-no") {
                echo "Silme İşlemi Başarısız";
              }
               if ($_GET['durum']=="e-ok") {
                echo "Ekleme İşlemi Başarılı";
              }
               if ($_GET['durum']=="e-no") {
                echo "Ekleme İşlemi Başarısız";
              }


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
            <div class="clearfix">
              


            </div>
          </div>
          <div class="x_content">


             <center><a href="duyuru-ekle"><button class="btn btn-success">Duyuru Ekle</button></a></center>

            <table id="datatable-responsive" class="" cellspacing="0" width="100%" border="1">
              <thead>
                <tr>
                  <th>Madde</th>
                  <th>Sıra</th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($duyurucek=$duyurusor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>

                  <td width="1300"> <?php echo $duyurucek['madde'] ?>  </td>
                   <td> <center><?php echo $duyurucek['madde_sira'] ?>  </center> </td>
                  <td><center><a href="duyuru-duzenle?duyuru_id=<?php echo $duyurucek['id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                  <td><center><a href="../netting/islem.php?duyuru_id=<?php echo $duyurucek['id']; ?>&duyurusil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                </tr>


                <?php  
                }
                ?>
              </tbody>
            </table>

            <br> <br>

                </div>
              </div>
              <form action="../netting/islem.php" method="POST">
                            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Basvuru Dönem :<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="basvuru_donem" required>



                  <option value="1">Ders Muafiyet Başvuru</option>



                  <option value="2">Yaz Okulu Başvuru</option>



                 </select>
                 <br><br>

              <center>  <input type="submit" class="btn btn-success" value="Kaydet" name="donem-sec"> </button></center>  

               </div>
             </div>
             </form>
               
                
              
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>

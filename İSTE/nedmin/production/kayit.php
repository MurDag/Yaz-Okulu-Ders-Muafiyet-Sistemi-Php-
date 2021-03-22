<?php
include '../netting/baglan.php';
error_reporting(0);

$bolumsor=$db->prepare("select * from bolumler");
	$bolumsor->execute();


	
	$bolumsayi=$bolumsor->rowCount();

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ders Muafiyet Sistemi</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body  class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
         

          <form action="../netting/islem.php" method="POST">


            <h1>Kullanıcı Kayıt Paneli </h1>
            
             <div> 
              <input type="text" name="kullanici_ad" class="form-control" placeholder="Adınız" required="" />
            </div>
               <div> 
              <input type="text" name="kullanici_soyad" class="form-control" placeholder="Soyadınız" required="" />
            </div>
            <div> 
              <input type="text" name="kullanici_tc" class="form-control" placeholder="TC Kimlik No " pattern="\d{11}" title="Bu alana sadece 11 karakterli sayısal değer girilebilir" required="" />
            </div>
            <div>
              <input type="email"  name="kullanici_mail" class="form-control" placeholder="Mail Adresiniz" required>
            </div>
              <div>
              <input type="text" name="kullanici_no" class="form-control" placeholder="Öğrenci Numarası" pattern="\d{9}" title="Bu alana sadece 9 karakterli sayısal değer girilebilir" required="" />
            </div>
             <div> 
              <input type="text" name="kullanici_tel" class="form-control" placeholder="Telefon Numaranız " pattern="\d{11}" title="Bu alana sadece 11 karakterli sayısal değer girilebilir" required="" />
            </div>
            <div>
              <input type="password" name="kullanici_passwordone" class="form-control" pattern="\d{6}" title="Lütfen şifrenizi en az 6 karakter olacak şekilde belirleyiniz" placeholder="Şifre (En az 6 karakter)" required="" />
            </div>
            <div>
              <input type="password" name="kullanici_passwordtwo" class="form-control" pattern="\d{6}" title="Lütfen şifrenizi en az 6 karakter olacak şekilde belirleyiniz" placeholder="Şifreyi Tekrar Giriniz" placeholder="Şifrenizi Tekrar Giriniz" required="" />
            </div>
      
<br>
            <div>
              Lütfen Bölümünüzü Seçiniz
            <br><br>
            </div>
      <select name="bolumler">

             			<?php	while ($bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC))
             				{
						?>	

						<option value="<?php echo $bolumcek['id']; ?>" style="width: 100%; background-color: #73879C; color:white;">   <?php echo $bolumcek['bolum_ad']; ?> </option>';
				
             			<?php	}	?> 
             		

             			</select>
            <div>
             			
             				


           </div>
           <div><br><br></div>
            <div>
            <button style="width: 100%; background-color: #73879C; color:white;" type="submit" name="kullanicikaydet" class="btn btn-default"> Kaydol</button>
            </div>


            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">
               <div class="title-bg">
          <div class="title"><a href="login" > Zaten Bir Üyeyim !</div> </a>
        </div> 
             

               
              </p>

              <div class="clearfix"></div>
              <br />

              <div>

              	   <?php
              if ($_GET['durum']=="basarisiz") 
              {
              	echo "Kayit Basarisiz Lütfen İlgili Yöneticiye Durumu Bildirin";
                echo $_SESSION['isim'];
              }
                elseif ($_GET['durum']=="benzerkayit")
                { 
                echo "Girilen Bilgilerle Uyuşan Kullanıcılar Mevcut !";
                echo '<br><br><br>';
                }
                elseif ($_GET['durum']=="farklisifre")
              {
              	echo "Girilen Şifreler Birbiriyle Uyuşmuyor !";
              	echo '<br><br><br>';
              }

                 elseif ($_GET['durum']=="eksiksifre") 
              {
              	echo "Şifre en az 6 karakter olmalıdır !";
              	echo '<br><br><br>';
              }



              ?>

                <h1><i class="fa fa-paw"></i>Ders Muafiyet Sistemi</h1>
              </div>
            </div>
          </form>

         



        </section>
      </div>

    </div>
  </div>
</body>
</html>
<?php 
error_reporting();
session_start();

if(!isset($_SESSION['kullanici_tc']))
{

header("Location:../nedmin/production/login?durum=yetkisiz_giris");

}


 ?>





 <!DOCTYPE html>
<html>
<html lang="en">
  <head>



    <title>İskenderun Teknik Üniversitesi Ders Muafiyet-Yaz Okulu Sistemi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="input-file-css.css">
   
    <link rel="stylesheet" href="css/style.css">

      <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Sortable - Drop placeholder</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { cursor: move ; margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
  html>body #sortable li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  </script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
    <style type="text/css">
  #sortable2 {  list-style-type: none; margin: 0; padding: 0; width: 100%;}
  #sortable2 li {cursor: move; margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em;  }
  html>body #sortable2 li { height: 1.5em; line-height: 1.2em;}
  .ui-state-highlight {height: 1.5em; line-height: 1.2em; }
   #sonuc {
     
     border:1px solid #ddd;
     margin:5px;
     padding:10px;
     background: lightgreen;
     width:400px;
     
   }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
  $( function() {
    $( "#sortable2" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( "#sortable2" ).disableSelection();
  } );
  </script>


  <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js"> </script>
  <script type="text/javascript">

    function PrintElem(elem) {
      Popup($(elem).html());
    }

    function Popup(data) {
      var printekrani = window.open('', 'Print', 'height=650,width=600');
      printekrani.document.write('<html><head><title></title>');
      /*optional stylesheet*/ //printekrani.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
      printekrani.document.write('</head><body >');
      printekrani.document.write(data);
      printekrani.document.write('</body></html>');

      printekrani.document.close(); // necessary for IE >= 10
      printekrani.focus(); // necessary for IE >= 10

      printekrani.print();
      printekrani.close();

      return true;
    }

  </script>

  </head>
<body>
 
        

        <nav class=" px-4 navbar navbar-expand-lg navbar-dark bg-danger mb-4">
          <a class="navbar-brand" href="index">İskenderun Teknik Üniversitesi</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown1" aria-controls="navbarNavDropdown1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown3">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link"  href="index"><span class="icon-home2 mr-1 wrap-icon"></span><span>Anasayfa</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="hesabim"><span class="icon-home2 mr-1 wrap-icon"></span><span>Hesabım</span></a>
              </li>
             <li class="nav-item">
                <a class="nav-link" href="cikis"><span class="icon-home2 mr-1 wrap-icon"></span><span>ÇIKIŞ</span></a>
             </li>

            </ul>
          </div>
        </nav>




</body>
</html>

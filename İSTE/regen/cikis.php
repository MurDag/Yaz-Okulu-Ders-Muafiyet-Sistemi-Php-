<?php 
session_start();

session_destroy();
header("Location:../nedmin/production/login?durum=exit");

 ?>
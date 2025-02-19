<?php
include_once 'includes/constants.php';
include_once 'includes/functions.php';
sec_session_start();
if(login_check($mysqli) !== true){
  header('location:index.php?act=login&error=1');
  exit();
 }
?>
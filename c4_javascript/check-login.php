<?php
  session_start();
  if(!isset($_SESSION['user_id'])){
    die('Not logged in');
  }
?>
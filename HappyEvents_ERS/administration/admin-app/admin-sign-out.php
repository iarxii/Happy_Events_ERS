<?php
  session_start();
  //destroy the users session.
  $_SESSION = array();
  setcookie(session_name(), '', time() - 2592000, '/');
  session_destroy();

  header("Location: ../admin-index.php")
?>
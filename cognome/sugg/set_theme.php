<?php
  /* 
    Set style theme for site display
  */
  // server should keep session data for at least 1 day
  ini_set('session.gc_maxlifetime', 86400);
  // each client should remember their session id for exactly 1 day
  session_set_cookie_params(86400);
  session_start(); 
  if (isset($_POST['site_theme'])) {
    $_SESSION['site_theme'] = $_POST['site_theme'];
  }
  if (isset($_SESSION['site_theme'])) {
    $theme = $_SESSION['site_theme'];
    if ($theme=='light_white_bg') {
      echo "<link rel='stylesheet' type='text/css' href='../light_white_bg_colors.css'>";
    }
    else if ($theme=='light') {
      echo "<link rel='stylesheet' type='text/css' href='../standard_colors.css'>";
    }
    else if ($theme=='dark') {
      echo "<link rel='stylesheet' type='text/css' href='../dark_colors.css'>";
    }
    else if ($theme=='medium_dark') {
      echo "<link rel='stylesheet' type='text/css' href='../medium_dark_colors.css'>";
    }      
  }
  else {
    echo "<link rel='stylesheet' type='text/css' href='../light_white_bg_colors.css'>";
  }
?>
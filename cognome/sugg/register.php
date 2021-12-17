<!DOCTYPE html>
<html>
<head>
  <!--
    References: https://www.rexegg.com/regex-php.html
    https://www.washington.edu/accesscomputing/webd2/student/unit5/module2/lesson5.html
  -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Hippocampus Region Models and Theories</title>
  <link rel="stylesheet" type="text/css" href="../main.css">
  <?php include('set_theme.php'); ?>
  <?php include('../function/hc_header.php'); ?>
  <script type="text/javascript">
    function toggle_vis(elem_name) {
       var elem = document.getElementById(elem_name);
       if (elem.style.display === "none") {
        elem.style.display = "block";
      } else {
        elem.style.display = "none";
      }
    }
    function submit_reg() {
      document.getElementById("user_submitted").value = 'true';
      document.forms["register"].submit();
    }
  </script>
</head>
<body>
  <?php include("../function/hc_body.php"); ?>
  <div style="width:90%;position:relative;left:5%;"> 
    <br><br>
  <!-- start of header -->
  <?php echo file_get_contents('header.html'); ?>
  <script type='text/javascript'>
    document.getElementById('header_title').innerHTML="<a href='register.php' style='text-decoration: none;color:black !important'><span class='title_section'>New User Registration</span></a>";
  </script>
  <!-- end of header -->
  
  <?php
  include('mysql_connect.php');  

  function reg_unsuc() {
    echo "<span style='color:darkred'>Registration unsuccessful.</span><br><br>";
  }

  function entry_check($entry_name, $message) {
    if (!isset($_POST[$entry_name]) || $_POST[$entry_name] == '') {
      reg_unsuc();
      echo $message."<br><br><a href='register.php'>Back to registration</a><br><br>";
      exit();
    }    
  }

  function reg_try_again($message) {
    reg_unsuc();
    echo $message;
    echo "<br><br><a href='register.php'>Back to registration</a><br><br>";
    exit();    
  }

  function reg_user($cog_conn) {
    include('secret_key.php');
    $sql = "INSERT INTO `natemsut_cog_sug`.`accounts` (`username`, `password`, `real_name`, `email`, `affiliation`, `notes`) VALUES ('".$_POST['username']."', AES_ENCRYPT('".$_POST['password']."', '".$pass_enc_secret_key."'), '".$_POST['realname']."', '".$_POST['email']."', '".$_POST['affiliation']."', '".$_POST['notes']."');";
    $result = $cog_conn->query($sql);
  }

  if (isset($_POST['user_submitted'])) {
    echo "<div class='article_details' style='padding: .4rem;font-size:1em;'><br><center>";    
    /*
      Check for required entries
    */
    entry_check("username","Username entry missing.");   
    entry_check("password","Password entry missing.");
    entry_check("password_reenter","Password reentry missing.");
    entry_check("realname","Real name entry missing.");
    entry_check("email","E-mail entry missing.");
    entry_check("affiliation","Affiliation entry missing.");
    /*
      Check username duplicate
    */
    $sql = "SELECT username FROM natemsut_cog_sug.accounts WHERE username='".$_POST['username']."';";
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) { 
      reg_try_again("Duplicate username '".$_POST['username']."' detected. Please select another.");
    }
    /*
      Check email duplicate
    */
    $sql = "SELECT email FROM natemsut_cog_sug.accounts WHERE email='".$_POST['email']."';";
    $result = $cog_conn->query($sql);
    if ($result->num_rows > 0) { 
      reg_try_again("Duplicate email '".$_POST['email']."' detected. Please select another.");
    }    
    /*
      Check for password re-entry match
    */
    if ($_POST['password'] != $_POST['password_reenter']) {
      reg_try_again("Password reentry did not match the original. Please try again.");      
    }
    /*
      Check password requirements
    */
    $min_pwd_length = 8;
    if (strlen($_POST['password']) < $min_pwd_length) {
      reg_try_again("Password did not meet the length requirement of eight charactors. Please try again."); 
    }

    reg_user($cog_conn);

    echo "Registration of user: ".$_POST['username']." was successful.<br><br><a href='mod_art.php'>Return to suggest articles page.</a></center><br></div><br>";
    $_SESSION['user_login'] = $_POST['username'];    
    exit();
  }

  echo "<div class='article_details' style='padding: .4rem;font-size:.7em;'>";
  echo "<form name='register' id='register' action='register.php' method='POST'><center><table style='padding:30px;'>
  <tr><td style='min-width:150px;'>Username *</td><td><input type='text' name='username'></input></td></tr>
  <tr><td><br></td></tr>
  <tr><td>Password *</td><td><input type='password' name='password'></input></td></tr>
  <tr><td><br></td></tr>
  <tr><td>Reenter<br>Password *</td><td><input type='password' name='password_reenter'></input></td></tr>  
  <tr><td><br></td></tr>
  <tr><td>Real Name *</td><td><input type='test' name='realname'></input></td></tr>
  <tr><td><br></td></tr>
  <tr><td>E-Mail *</td><td><input type='text' name='email'></input></td></tr>  
  <tr><td><br></td></tr>
  <tr><td>Affiliation<br>(University<br>or Other) *</td><td><textarea name='affiliation' cols='22' rows='4' wrap='soft'></textarea></td></tr>
  <tr><td><br></td></tr>
  <tr><td>General Notes</td><td><textarea name='notes' cols='22' rows='4' wrap='soft'></textarea></td></tr>
  </table><center>Note: sections marked with '*' are required.<br><br><!-- Note: when one presses submit an email will be sent to the email that was provided in registration. A link in the email must be clicked before registration is complete.--><input type='hidden' name='user_submitted' id='user_submitted'></input><input type='button' value='Submit' onclick='javascript:submit_reg()' style='font-size:.9em;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;'></center><br>
  </center></form>";

  echo "</div><br><br><br>";   

  $cog_conn->close();

  ?>
</div>
</body>
</html>  
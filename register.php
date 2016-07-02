<?php require_once('Connections/localhost.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="register.php";
  $loginUsername = $_POST['username'];
  $LoginRS__query = sprintf("SELECT username FROM `user` WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_localhost, $localhost);
  $LoginRS=mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registerForm")) {
  $insertSQL = sprintf("INSERT INTO `user` (surname, firstname, email, username, password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['surname'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_localhost, $localhost);
$query_Register = "SELECT * FROM `user`";
$Register = mysql_query($query_Register, $localhost) or die(mysql_error());
$row_Register = mysql_fetch_assoc($Register);
$totalRows_Register = mysql_num_rows($Register);
?>
<?php require_once('Connections/localhost.php'); ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width"/>
	<title>Register - Lemon Consults Group</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <link href="../RegistrationComplete/assets/img/Globasoft.ico" rel="shortcut icon" type="image/x-icon" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>
<body>
<div id="content-wrapper">
    	<div id="header">
        	Welcome!
        </div>
        <div id="nav-bar">
        	<nav>
            	<ul>
                	<li id="login"><a href="login.php">Login</a></li>
                    <li id="register"><a href="register.php">Register</a></li>
                    <li id="forgot-password"><a href="forgot_password.php">Forgot password</a></li>
                </ul>
            </nav>
        </div>
        <div id="page-heading">
            <h1>Sign Up!</h1>
        </div>
        <div id="content">
        	<div id="content-left">
        	  <h2>Lemon Consults Group</h2>
        	  <h6>Contact me</h6>
        	</div>
            <div id="content-right">
              <form action="<?php echo $editFormAction; ?>" method="POST" name="registerForm" class="form" id="registerForm">
                <table width="400" align="center">
                  <tr>
                    <td><table width="174">
                      <tr>
                        <td><span id="sprytextfield1"> First name<br>
                          <input name="firstname" type="text" class="input-text" id="firstname">
                        <span class="textfieldRequiredMsg">Firstname is required.</span></span></td>
                        <td><span id="sprytextfield2"> Surname<br>
                        <input name="surname" type="text" class="input-text" id="surname">
                        <span class="textfieldRequiredMsg">Surname is required.</span></span></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><span id="sprytextfield3"> Email<br>
                    <input name="email" type="email" class="input-text" id="email" value="">
                    <span class="textfieldRequiredMsg">Email is required.</span></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><span id="sprytextfield4">Username<br>
<input name="username" type="text" class="input-text" id="username">
                    <span class="textfieldRequiredMsg">Username is required.</span></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><table>
                      <tr>
                        <td><span id="sprytextfield6"> Password<br>
                        <input name="password" type="password" class="input-text" id="password">
                        <span class="textfieldRequiredMsg">Password is required.</span></span></td>
                        <td><span id="sprytextfield7"> Confirm password<br>
                        <input name="passwordConfirm" type="password" class="input-text" id="passwordConfirm">
                        <span class="textfieldRequiredMsg">Password confirmation required.</span></span></td>
                      </tr>
                    </table>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="register" type="submit" class="submit-button" id="register2" value="Submit"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="registerForm">
              </form>
            	
            </div>
        </div>
        <div id="footer">
          <h6>@Lemon Consults Group   </h6>
    </div>
    </div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
</script>
</body>
</html>
<?php
mysql_free_result($Register);
?>

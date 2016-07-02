<?php @session_start(); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "updateUserForm")) {
  $updateSQL = sprintf("UPDATE ``user`` SET email=%s, password=%s WHERE UserID=%s",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['userIdHiddenField'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "account.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_User = "-1";
if (isset($_GET['MM_Username'])) {
  $colname_User = $_GET['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_User = sprintf("SELECT * FROM `user` WHERE username = %s", GetSQLValueString($colname_User, "text"));
$User = mysql_query($query_User, $localhost) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width"/>
	<title>Template</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
    <link href="../RegistrationComplete/assets/img/Globasoft.ico" rel="shortcut icon" type="image/x-icon" />
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
            <h1>Page header is here</h1>
        </div>
        <div id="content">
        	<div id="content-left">
        	  <h2>Aside here</h2>
        	  <h6>Contact me</h6>
        	</div>
            <div id="content-right">
              <form action="<?php echo $editFormAction; ?>" method="POST" name="updateUserForm" class="form" id="updateUserForm">
                <p>Account name: <?php echo $row_User['surname']; ?><?php echo $row_User['firstname']; ?>		 |	User name: <?php echo $row_User['username']; ?></p>
                <table width="400" align="center">
                  <tr>
                    <td><p>
                      <label for="email"></label>
                      Email</p>
                      <p>
                        <input name="email" type="text" class="input-text" id="email" value="<?php echo $row_User['email']; ?>">
                    </p></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><p>
                      <label for="password"></label>
                      Password
 </p>
                      <p>
  <input name="password" type="password" class="input-text" id="password" value="<?php echo $row_User['password']; ?>">
                    </p></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="updateSubmit" type="submit" class="submit-button" id="updateSubmit" value="Update Account">
                    <input name="userIdHiddenField" type="hidden" id="userIdHiddenField" value="<?php echo $row_User['UserID']; ?>"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <input type="hidden" name="MM_update" value="updateUserForm">
              </form>
            </div>
        </div>
        <div id="footer">
          <h6>@Lemon Consults Group   </h6>
    </div>
    </div>
</body>
</html>
<?php
mysql_free_result($User);
?>

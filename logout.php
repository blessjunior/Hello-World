<?php require_once('Connections/localhost.php'); ?>
<?php
// *** Logout the current user.
$logoutGoTo = "login.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
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

$colname_LogOut = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_LogOut = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_LogOut = sprintf("SELECT * FROM `user` WHERE username = %s", GetSQLValueString($colname_LogOut, "text"));
$LogOut = mysql_query($query_LogOut, $localhost) or die(mysql_error());
$row_LogOut = mysql_fetch_assoc($LogOut);
$totalRows_LogOut = mysql_num_rows($LogOut);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width"/>
	<title>Logout - Lemon Consults Group</title>
	<link rel="stylesheet" type="text/css" href="css/layout.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
</head>
<body>
<div id="content-wrapper">
    	<div id="header">
        	Welcome!
        </div>
        <div id="nav-bar">
        	<nav>
            	<ul>
                	<li id="login"><a href="#">Login</a></li>
                    <li id="register"><a href="#">Register</a></li>
                    <li id="forgot-password"><a href="#">Forgot password</a></li>
                </ul>
            </nav>
        </div>
        <div id="page-heading">
            <h1>You have successfully logged out!</h1>
        </div>
        <div id="content">
        	<div id="content-left">
        	  <h2>Aside  here</h2>
        	  <h6>Contact me</h6>
        	</div>
            <div id="content-right">
            	
            </div>
        </div>
        <div id="footer">
          <h6>@Lemon Consults Group   </h6>
    </div>
    </div>
</body>
</html>
<?php
mysql_free_result($LogOut);
?>

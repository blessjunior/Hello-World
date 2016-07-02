<?php 
	@session_start(); 
	$_SESSION['EMPW'] = $_POST['email'];
?>
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

$colname_EmailPassword = "-1";
if (isset($_SESSION['EMPW'])) {
  $colname_EmailPassword = $_SESSION['EMPW'];
}
mysql_select_db($database_localhost, $localhost);
$query_EmailPassword = sprintf("SELECT * FROM `user` WHERE email = %s", GetSQLValueString($colname_EmailPassword, "text"));
$EmailPassword = mysql_query($query_EmailPassword, $localhost) or die(mysql_error());
$row_EmailPassword = mysql_fetch_assoc($EmailPassword);
$totalRows_EmailPassword = mysql_num_rows($EmailPassword);
 




mysql_free_result($EmailPassword);
?>

<?php
#get delivery report on sent mail
if($totalRows_EmailPassword > 0){
	
	#Set mail attributes
	$from = "noreply@lemoncg.com";
	$email = $_SESSION['EMPW'];
	$subject = "Lemon Consults Group | Password Recovery";
	$body = "Your current password is: ".$row_EmailPassword['password'];
	
	#create mail object and send
	mail($email, $subject, $body, "From:".$from);

	echo 'Your current password has been sent successfully. Please check your mail';
}
	#delivery message for mail sending failure
else {
	echo 'Please try again in a few moments. Failed to send';
}
?>
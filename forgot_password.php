<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width"/>
	<title>Password Recovery</title>
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
            <h1>Email Password</h1>
        </div>
        <div id="content">
        	<div id="content-left">
        	  <h2>Password recovery center</h2>
        	  <a href="register.php"><h6>Register new account</h6></a>
        	</div>
            <div id="content-right">
              <form action="email_password_model.php" method="post" name="emailPasswordForm" id="emailPasswordForm">
                <p>
                  <label for="email"></label>
                  <input name="email" type="email" class="input-text" id="email">
                </p>
                <p>
                  <input name="emailPasswordSubmit" type="submit" class="submit-button" id="emailPasswordSubmit" value="Send Email">
                </p>
              </form>
            	
            </div>
        </div>
        <div id="footer">
          <h6>@Lemon Consults Group   </h6>
    </div>
    </div>
</body>
</html>
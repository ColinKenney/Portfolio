<?php
    include_once('config.php');
    include_once('dbutils.php');
    
?>

<html>
    <head>

<title>Enter Users</title>

<!-- This is the code from bootstrap -->        
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
    </head>
    
    <body>

<!-- Visible title -->
        <div class="row">
            <div class="col-xs-12">
				<center>
                <h1>Enter Users</h1>
				</center>
            </div>
        </div>
		<style type="text/css">
        body {
            border-top: 5px solid #ffcc00;
            background-image: -ms-linear-gradient(top, #ffeeaa 0%, #EEEEEE 100%);
            background-image: -moz-linear-gradient(top, #ffeeaa 0%, #EEEEEE 100%);
            background-image: -o-linear-gradient(top, #ffeeaa 0%, #EEEEEE 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ffeeaa), color-stop(1, #EEEEEE));
            background-image: -webkit-linear-gradient(top, #ffeeaa 0%, #EEEEEE 100%);
            background-image: linear-gradient(to bottom, #ffeeaa 0%, #EEEEEE 100%);
        }
		</style>
        
<!-- Processing form input -->        
        <div class="row">
            <div class="col-xs-12">
<?php
//
// Code to handle input from form
//

if (isset($_POST['submit'])) {
    // only run if the form was submitted
    
    // get data from form
    $email = $_POST['email'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
    
   // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);    
    
    // check for required fields
    $isComplete = true;
    $errorMessage = "";
    
    if (!$email) {
        $errorMessage .= " Please enter an email.";
        $isComplete = false;
    } else {
        $email = makeStringSafe($db, $email);
    }

    if (!$password) {
        $errorMessage .= " Please enter a password.";
        $isComplete = false;
    }
	
	if (!$password2) {
        $errorMessage .= " Please enter a password again.";
        $isComplete = false;
    }
	
	if ($password != $password2) {
		$errorMessage .= " Your two passwords are not the same.";
		$isComplete = false;
	}
	    
	
    if ($isComplete) {
    
		// check if there's a user with the same email
		$query = "SELECT * FROM users WHERE email='" . $email . "';";
		$result = queryDB($query, $db);
		if (nTuples($result) == 0) {
			// if we're here it means there's already a user with the same email
			
			// generate the hashed version of the password
			$hashedpass = crypt($password, getSalt());
			
			// put together sql code to insert tuple or record
			$insert = "INSERT INTO users(email, hashedpass) VALUES ('" . $email . "', '" . $hashedpass . "');";
		
			// run the insert statement
			$result = queryDB($insert, $db);
			
			// we have successfully inserted the record
			echo ("Successfully entered " . $email . " into the database.");
		} else {
			$isComplete = false;
			$errorMessage = "Sorry. Another account has been created under email " . $email;
		}
	}
}
?>
            </div>
        </div>
		
		
<!-- Showing errors, if any -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && !$isComplete) {
        echo '<div class="alert alert-danger" role="alert">';
        echo ($errorMessage);
        echo '</div>';
    }
?>            
    </div>
</div>

<!-- form for inputting data -->
        <div class="row">
            <div class="col-xs-4" style="left: 35%">
                
<form action="input_store.php" method="post">
<!-- email -->
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" name="email"/>
    </div>
	
<!-- Store Name -->
	<div class="form-group">
		<label for="storeName">Store Name</label>
		<input type="text" class="form-control" name="name"/>
	</div>

<!-- password1 -->
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password"/>
    </div>

<!-- password2 -->
    <div class="form-group">
        <label for="password2">Re-enter Password</label>
        <input type="password" class="form-control" name="password2"/>
    </div>
    
    <button type="submit" class="btn btn-default" name="submit">Add</button>
	<a class="btn btn-default" href="grocerLogin.php" role="button">Cancel</a>
</form>
                
            </div>
        </div>
      

        
    </body>
    
</html>
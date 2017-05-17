<html>
	<head>
<!-- Bootstrap link -->		
		
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
		<title>Grocery Hawk</title>
	</head>
	<body>

<!-- Menu bar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="customerSide.php"><span class="glyphicon glyphicon-grain"></span> Continue Shopping</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
		<li class="active"><a href="checkout.php"><span class="glyphicon glyphicon-check"></span> Checkout</a></li>
		<li>
		<?php 
		session_start();
		if(isset($_SESSION['email'])){

			echo "<a href='customerLogout.php'><span class='glyphicon glyphicon-log-out'></span> Log Out</a>";
		}else{
			if (!isset($_SESSION['email'])) {
			session_destroy();
		} 
			echo "<br/><li><a href='customerLogin.php'>Login/Create Account</a></li>";
		}
		
		?>
		</li>
	 </ul>
  </div>
</nav>

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

<?php
session_start();
include_once("config.php");
include_once('dbutils.php');
if (isset($_POST['submit'])) {
	//if we are here, form was sumbitted and needs to process form data
	
	//get data from form
	$id = $_POST['id'];
	$customerName = $_POST['customerName'];
	$homeAddress = $_POST['homeAddress'];
	$billingAddress = $_POST['billingAddress'];
	$creditCard = $_POST['creditCard'];
	$cardExp = $_POST['cardExp'];
	$cardCode = $_POST['cardCode'];
	
	// variables to keep track if the form is complete (false if issues)
	$isComplete = true;
	
	// error message if issues with data
	$errorMessage = "";
	
	if (!$customerName) {
		$errorMessage .= "Please enter your Name. \n";
		$isComplete = false;
	}
	
	if (!$homeAddress) {
		$errorMessage .= "Please enter your Home Address. \n";
		$isComplete = false;
	}
	
	if (!$billingAddress) {
		$errorMessage .= "Please enter your Billing Address. \n";
		$isComplete = false;
	}
	
	if (!$creditCard) {
		$errorMessage .= "Please enter your Credit Card Number. \n";
		$isComplete = false;
	}
	
	if (!$cardExp) {
		$errorMessage .= "Please enter your Credit Card Number Expiration Date. \n";
		$isComplete = false;
	}
	
	if (!$cardCode) {
		$errorMessage .= "Please enter your Credit Card Number Security Code. \n";
		$isComplete = false;
	}
	
	if ($creditCard<12) {
		$errorMessage .= "Please enter your Credit Card Number. \n";
		$isComplete = false;
	}
	
	if (!$cardCode<3) {
		$errorMessage .= "Please enter your Credit Card Number Security Code. \n";
		$isComplete = false;
	}
	}
	// stop execution and show error if the form is not complete
	if ($isComplete){

	
		// put together SQL statement to insert new record
		$query = "INSERT INTO customers(customerName, homeAddress, billingAddress) VALUES ('$customerName','$homeAddress', '$billingAddress');";
		
		// connect to db
		$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
		
		// run the insert statement
		$result = queryDB($query, $db);
		
		if (session_start()) {
				$_SESSION['query'] = $query;
				header('Location: customerSide.php');
				exit;
		}
	}

?>

<!-- Form to enter items -->
<div class="row">
	<div class="col-xs-12" style="margin-left: 10px;">
		
<form action="checkout.php" method="post">


<!-- Name -->
<div class="form-group">
	<label for="customerName">Name: </label>
	<input type="text" class="form-control" name="customerName" value="<?php if($customerName) { echo $customerName;} ?>" />
</div>

<!-- Home Address -->
<div class="form-group">
	<label for="homeAddress">Home Address: </label>
	<input type="text" class="form-control" name="homeAddress" value="<?php if($homeAddress) { echo $homeAddress;} ?>" />
</div>

<!-- Billing Address -->
<div class="form-group">
	<label for="billingAddress">Billing Address: </label>
	<input type="text" class="form-control" name="billingAddress" value="<?php if($billingAddress) { echo $billingAddress;} ?>" />
</div>

<!-- Credit Card Number -->
<div class="form-group">
	<label for="creditCard">Credit Card Number: </label>
	<input type="number" min="12" class="form-control" name="creditCard" value="<?php if($creditCard) { echo $creditCard;} ?>" />
</div>

<!-- Card Expiration -->
<div class="form-group">
	<label for="cardExp">Card Expiration Date: </label>
	<input type="text" class="form-control" name="unit" value="<?php if($cardExp) { echo $cardExp;} ?>" />
</div>

<!-- Card Security Code -->
<div class="form-group">
	<label for="cardCode">Card Security Code: </label>
	<input type="number" min="3" class="form-control" name="cardCode" value="<?php if($cardCode) { echo $cardCode;} ?>" />
</div>
	
<button type="submit" class="btn btn-default" name="submit"><span class="glyphicon glyphicon-usd"></span> Finish Purchase</button>
	

</form>
		
	</div>
</div>

</form>
</div>


</body>
</html>
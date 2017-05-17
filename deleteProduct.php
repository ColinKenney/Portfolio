<?php
/*
 * php file that asks the user if they want to delete a certain product
 * It obtains the id for the product to delete from an id variable passed
 *
 */

	include_once('config.php');
	include_once('dbutils.php');
	
	
	/*
	 * If the user made a decision on a deletion by using the form below, we process that below
	 * 
	 */
	
	if(isset($_POST['submit'])) {
		// process the deletion (if selected) if the form below was sunmitted
		
		
		// get data from form
		$id = $_POST['id'];
		$delete = $_POST['delete'];
		
		
		if ($delete == 'yes') {
			// if the user said yes to delete, we need to delete the product
			
			
			// connect to db
			$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
		
			//
			$query = "DELETE FROM inventory WHERE id = $id;";
			
			queryDB($query, $db);

		}
		// send user back to grocer_input.php
		header('Location: grocer_input.php');
		exit;
	}
 
	/*
	 * Check if a GET variable was passed with the id for the product
	 *
	 */
 
 
	if(!isset($_GET['id'])){
		// if the id was not passed through the url
		
		//sends user back to grocer_input.php and stops executing code in this page
		header('Location: grocer_input.php');
		exit;		
	}

	/*
	 * Now we will check to make sure the id passed through the GET variable matches the id of the product in the db
	 */
	
	// connect to the db
	$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
	
	
	// set up a query
	$id = $_GET['id'];
	$query = "SELECT * FROM inventory WHERE id = $id;";
	
	// run the query
	$result = queryDB($query, $db);
	
	// if the id is not in the inventory table, send user back to the grocer_input.php
	if(nTuples($result) == 0) {
		//sends user back to grocer_input.php and stops executing code in this page
		header('Location: grocer_input.php');
		exit;
	}
	
	/*
	 * Now we know we got a valid product id through the GET variable
	 */
	
	// get some data from the inventory table to ask a better question when confirming deletion
	$row = nextTuple($result);
	
	$product = $row['product'];
	
	
	
?>


<html>
	<head>
<!-- Bootstrap link -->		
		
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
		<title>Delete <?php echo $product; ?> item?</title>
	</head>
	
	<body>
		
<!-- Visable title -->
<div class="row">
	<div class="col-xs-12">
		<h1>Do you want to delete the <?php echo $product; ?> item?</h1>
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

<!-- form to ask users to confirm deletion -->
<div class="row">
	<div class="col-xs-12">
		<form action="deleteProduct.php" method="post">
			<div class="radio">
				<label>
					<input type="radio" name="delete" value="yes" checked>
					Yes
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="delete" value="no">
					No
				</label>
			</div>
			
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			
			<button type="submit" class="btn btn-default" name="submit">Submit</button>
		</form>
	</div>
</div>
		
	</body>
</html>
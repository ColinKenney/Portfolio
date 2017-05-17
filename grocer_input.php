
<?php
// kicks users if they haven't logged in yet
	session_start();
	if (!isset($_SESSION['email'])){
		header('Location: grocerLogin.php');
		exit;
	}



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
		
		<title>Grocer</title>
	</head>
	<body>


<?php
// check if the form data needs to be  processed
// include config and utils files
include_once('config.php');
include_once('dbutils.php');
	

if (isset($_POST['submit'])) {
	//if we are here, form was sumbitted and needs to process form data
	
	//get data from form
	$image = $_POST['image'];
	$category = $_POST['category'];
	$product = $_POST['product'];
	$unit = $_POST['unit'];
	$price = $_POST['price'];
	$stock = $_POST['stock'];
	
	// variables to keep track if the form is complete (false if issues)
	$isComplete = true;
	
	// error message if issues with data
	$errorMessage = "";
	
	if (!$image) {
		$errorMessage .= "Please enter a category for the new item. \n";
		$isComplete = false;
	}
	if (!$category) {
		$errorMessage .= "Please enter a category for the new item. \n";
		$isComplete = false;
	}
	if (!$product) {
		$errorMessage .= "Please enter a product name for the new item. \n";
		$isComplete = false;
	}
	if (!$unit) {
		$errorMessage .= "Please enter a unit for the new item. \n";
		$isComplete = false;
	}
	if (!$price) {
		$errorMessage .= "Please enter a price for the new item. \n";
		$isComplete = false;
	}
	if (!$stock) {
		$errorMessage .= "Please enter a stock for the new item. \n";
		$isComplete = false;
	}
	
	// stop execution and show error if the form is not complete
	if ($isComplete){

	
		// put together SQL statement to insert new record
		$query = "INSERT INTO inventory(image, category, product, unit, price, stock) VALUES ('$image', '$category', '$product', '$unit', $price, $stock);";
		
		// connect to db
		$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
		
		// run the insert statement
		$result = queryDB($query, $db);
		
		// we have successfully entered the data
		echo ("Successfully entered new item " . $product);
	}
}


?>

<!-- Menu bar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li class="active"><a href="grocer_input.php"><span class="glyphicon glyphicon-grain"></span> Inventory</a></li>
        <li><a href="grocerOrders.php"><span class="glyphicon glyphicon-hourglass"></span> Waiting Orders</a></li>
		<li><a href="grocerOrders2.php"><span class="glyphicon glyphicon-send"></span> Delivered Orders</a></li>
		<li><a href="grocerOrders3.php"><span class="glyphicon glyphicon-remove"></span> Returned Orders</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="grocerLogout.php"><span class="glyphicon glyphicon-log-out"></span> log out</a></li>
     </ul>
  </div>
</nav>

<!-- Title -->	
<div class="row">
	<div class="col-xs-12" style="margin-left: 10px;">
		   <h1>Inventory</h1>
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

<!-- welcome user -->
<div class="row">
    <div class="col-xs-12" style="margin-left: 10px;">
        <p>Welcome <?php echo $_SESSION['email']; ?></p>
    </div>
</div>


<div class="row">
	<div class="col-xs-12">
		
		<!-- Show errors if there are any -->
<?php
	if (isset($isComplete) && !$isComplete) {
		echo '<div class="alert alert-danger" role="alert">';
		echo ($errorMessage);
		echo '</div>';
	}
?>
	
	</div>
</div>


<!-- Form to enter items -->
<div class="row">
	<div class="col-xs-12" style="margin-left: 10px;">
		
<form action="grocer_input.php" method="post">

<!-- image -->
<div class="form-group">
	<label for="image">Image: </label>
	<input type="text" class="form-control" name="image" value="<?php if($image) { echo $image;} ?>" />
</div>

<!-- Category -->
<div class="form-group">
	<label for="category">Category: </label>
	<input type="text" class="form-control" name="category" value="<?php if($category) { echo $category;} ?>" />
</div>

<!-- Product -->
<div class="form-group">
	<label for="product">Product: </label>
	<input type="text" class="form-control" name="product" value="<?php if($product) { echo $product;} ?>" />
</div>

<!-- Unit -->
<div class="form-group">
	<label for="unit">Unit: </label>
	<input type="text" class="form-control" name="unit" value="<?php if($unit) { echo $unit;} ?>" />
</div>

<!-- Price -->
<div class="form-group">
	<label for="price">Price: </label>
	<input type="number" min="0" step=".01" class="form-control" name="price" value="<?php if($price) { echo $price;} ?>" />
</div>

<!-- Stock -->
<div class="form-group">
	<label for="stock">Stock: </label>
	<input type="number" class="form-control" name="stock" value="<?php if($stock) { echo $stock;} ?>" />
</div>

	
<button type="submit" class="btn btn-default" name="submit"><span class="glyphicon glyphicon-save"></span> Save</button>
	

</form>
		
		
		
	</div>
</div>




<!-- show contents of items table -->
<div class="row">
	<div class="col-xs-12" style="margin-left: 10px;">
		
<!-- Set up html table to show contents -->
<table class="table table-hover">
	<!-- headers for table -->
	<thead>
		<!-- <th>Image</th> -->
		<th>Category</th>
		<th>Product</th>
		<th>Unit</th>
		<th>Price</th>
		<th>Stock</th>
		<th> </th>
		<th> </th>
	</thead>
	
<?php
	/*
	 *List all products in the database
	 *
	 */
	
	
	//conect to the database
	$db = connectDB($DBHost,$DBUser, $DBPasswd, $DBName);
	
	// set up a query to get info on the item form the db
	$query = "SELECT inventory.image, inventory.category, inventory.product, inventory.unit, inventory.price, inventory.stock, inventory.id FROM inventory;";
	
	//run the query
	$result = queryDB($query, $db);
	
	
	
	
	while($row = nextTuple($result)) {
		
		echo "\n <tr>";
		/*echo "<td>" . $row['image'] . "</td>";*/
		echo "<td>" . $row['category'] . "</td>";
		echo "<td>" . $row['product'] . "</td>";
		echo "<td>" . $row['unit'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td>" . $row['stock'] . "</td>";
		// link to update record (item)
        echo "<td><a href='updateInventory.php?id=" . $row['id']  .  "'>edit</a></td>";
		// link to delete record (item)
		echo "<td><a href='deleteProduct.php?id=" . $row['id'] .  "'>	delete</a></td>";
		echo "</tr> \n";
		
	}


?>

</table>
		
	</div>
</div>

	</body>
</html>
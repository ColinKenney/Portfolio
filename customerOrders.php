<html>
	<head>
<!-- Bootstrap link -->		
		
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<title>Grocery Hawk</title>
	</head>
	<body>
		
		
<?php
// check if the form data needs to be  processed
// include config and utils files
include_once('config.php');
include_once('dbutils.php');
?>

<div class="row">
	<div class="col-xs-12">
		<h1>Welcome to Grocery Hawk</h1>
	</div>
</div>

<!-- Menu bar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="customerSide.php"><span class="glyphicon glyphicon-grain"></span> Inventory</a></li>
        <li class="active"><a href="customerOrders.php"><span class="glyphicon glyphicon-tags"></span> Orders</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
		<li>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php
			session_start();
			if(isset($_SESSION['email'])){
				echo $_SESSION['email'];
			}else{
				if (!isset($_SESSION['email'])) {
					session_destroy();
				}
				echo "Guest ";
			}
			?><span class="caret"></span></a>
			<ul class="dropdown-menu">
			<?php if(isset($_SESSION['email'])){ echo"
            <li><a href='orderHistory.php'>Order History</a></li>
            <li><a href='orderStatus.php'>Order Status</a></li>
            <!--li role='separator' class='divider'></li-->";}
             else{
				echo "<li><a href='customerLogin.php'>Please Login</a></li>";
			}?>
			</ul>
			</li>		
		<li><a href="viewCart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>
		<li><?php 
		session_start();
		if(isset($_SESSION['email'])){

			echo "<a href='customerLogout.php'><span class='glyphicon glyphicon-log-out'></span> Log Out</a>";
		}else{
			if (!isset($_SESSION['email'])) {
			session_destroy();
		} 
			echo "<br/><li><a href='customerLogin.php'>Login/Create Account</a></li>";
		}
		?></li>
        <!--<li><a href="customerLogin.php">Login/Create Account</a></li>-->
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


<div class="row">
	<div class="col-xs-12">
<h1 align="center">Orders</h1>		
<!-- Set up html table to show contents -->
<table class="table table-hover">
	<!-- headers for table -->
	<thead>
		<th>Items Ordered</th>
		<th>Total Price</th>
		<th>Order Status</th>
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
	
	// set up a query to get info on the order form the db
	$query = "SELECT orders.id, orders.customerName, orders.itemsOrdered, orders.totalPrice, orders.orderStatus FROM orders order by orderStatus;";
	
	//run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		
		echo "\n <tr>";
		echo "<td>" . $row['itemsOrdered'] . "</td>";
		echo "<td>" . $row['totalPrice'] . "</td>";
		echo "<td>" . $row['orderStatus'] . "</td>";
		echo "</tr> \n";
		
	}
?>
		</table>
		<a href='customerSide.php' class='btn btn-default glyphicon glyphicon-menu-left'>Back</a>
		</div>
	<div class="col-xs-1"></div>
	</div>
</div>




	</body>
</html>
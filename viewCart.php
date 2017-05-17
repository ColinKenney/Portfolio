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

<?php
// View Cart page. Acts as an Adding to Cart & Viewing Cart page.
// Include config and dbutils 
include_once('config.php');
include_once('dbutils.php');
?>

<!-- Menu Bar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="customerSide.php"><span class="glyphicon glyphicon-grain"></span> Inventory</a></li>
        <li><a href="customerOrders.php"><span class="glyphicon glyphicon-tags"></span>  Orders</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
		<li class="active"><a href="viewCart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>
		<li><a href="checkout.php"><span class="glyphicon glyphicon-check"></span> Checkout</a></li>
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



<?php
session_start();
$db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
$query="SELECT * FROM inventory;";
$result = queryDB($query,$db);
while($row = nextTuple($result)){
	$productID=$row['id'];
	$currentQuantity=$row['id'];
        if ($_SESSION['currentOrder']){
			$query="SELECT * FROM orderedProducts;";
            $result=queryDB($query,$db);
            if (nTuples($result) == 0) {
                $queryA="INSERT INTO orderedProducts(id,quantity)Values($productID,$currentQuantity);";
                $resultA=queryDB($queryA,$db);
            }
		while($row=nextTuple($queryResult)){
            $checkQuantity=$row['quantity'];
            $intCheck=intval($checkQuantity);
            $intQuant=intval($quantity);
            $newQuantity=($intCheck)+($quantity);
            $queryB="UPDATE orderedProducts SET quantity=$newQuantity;";
            $resultB=queryDB($queryB,$db);
			}
		}
		else{
			$_SESSION['currentOrder']=$newOrder;
			while($row = nextTuple($result)){
			$query="INSERT INTO orderedProducts(id,quantity)Values($productID,$currentQuantity);";
			$result=queryDB($query,$db);
			}
		}
	}
    ?>


<div class="row">
	<div class="col-xs-12">
<h1 align="center">Products</h1>		
<!-- Set up html table to show contents -->
<table class="table table-hover">
	<!-- headers for table -->
	<thead>
		<th>Images</th>
		<th>Category</th>
		<th>Product</th>
		<th>Unit</th>
		<th>Price</th>
		<th>Stock</th>
		<th>Quantity </th>
		<th>Add to Cart</th>
		<th> </th>
	</thead>

<!-- Products List Start -->


<?php
    //get categories for drop down and start a session with a stream_wrapper_restore
    // for every page for this store it will have a consistent Store ID 
    //for now we hard code
    $order=$_SESSION['startedOrder'];
    if($order==""){
        echo "Your cart is empty.";
        exit;
    }
	
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    //get Date
    $query="SELECT orderedProducts.id, orderedProducts.quantity FROM orderedProducts WHERE inventroy.price=$price;";
    $result = queryDB($query, $db);
    while($row = nextTuple($result)) {
        $productID=$row['id'];
		echo "\n <tr>";
		echo "<td>";
		echo "<td>" . $row['product'] . "</td>";
		echo "<td>" . $row['quantity'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "</tr> \n";
        echo "<td><form action='updateCart.php?id=$productID' method='post'>";
        echo "<td><a href='removeProduct.php?id=$productID'><h4><span class='label label-danger'><span class='glyphicon glyphicon-remove'>Remove</span></span></h4></a></td>";
        echo "<td>";
    } 
    ?>
	</table>
	</div>
</div>
</body>
</html>
		</table>
	</div>
</div>
</body>
</html>
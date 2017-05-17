<?php
/*
 * This php file enables users to edit a particular order
 * It obtains the id for the order to update from an id variable passed using the GET method (in the url)
 *
 */
    include_once('config.php');
    include_once('dbutils.php');
    
    /*
     * If the user submitted the form with updates, we process the form with this block of code
     *
     */
    if (isset($_POST['submit'])) {
        // process the update if the form was submitted
        
        // get data from form
        $id = $_POST['id'];
        if (!isset($id)) {
            // if for some reason the id didn't post, kick them back to grocerOrders.php
            header('Location: grocerOrders.php');
            exit;
        }

        // get data from form
        $id = $_POST['id'];
        
        $orderStatus = $_POST['orderStatus'];
        
        
        // variable to keep track if the form is complete (set to false if there are any issues with data)
        $isComplete = true;
        
        // error message we'll give user in case there are issues with data
        $errorMessage = "";
        
        
        // check each of the required variables in the table        
		
		if (!isset($orderStatus)){
			$errorMessage .= "Please enter the status for the order. \n";
			$isComplete = false;
		}
        
        
        // If there's an error, they'll go back to the form so they can fix it
        
        if($isComplete) {
            // if there's no error, then we need to update
            
            //
            // first update order record
            //
            // put together SQL statement to update item
            $query = "UPDATE orders SET orderStatus='$orderStatus' WHERE id=$id;";
            
            // connect to the database
            $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
            
            // run the update
            $result = queryDB($query, $db);            
                    
            
            // now that we are done, send user back to grocerOrders and exit 
            header("Location: grocerOrders.php?successmessage=Successfully updated order $id");
            exit;
        }        
    } else {
        //
        // if the form was not submitted (first time in)
        //
    
        /*
         * Check if a GET variable was passed with the id for the item
         *
         */
        if(!isset($_GET['id'])) {
            // if the id was not passed through the url
            
            // send them out to grocer_input.php and stop executing code in this page
            header('Location: grocerOrders.php');
            exit;
        }
        
        /*
         * Now we'll check to make sure the id passed through the GET variable matches the orderNumber of a order in the database
         */
        
        // connect to the database
        $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
        
        // set up a query
        $id = $_GET['id'];
        $query = "SELECT * FROM orders WHERE id=$id;";
        
        // run the query
        $result = queryDB($query, $db);
        
        // if the id is not in the inventory table, then we need to send the user back to grocerOrders.php
        if (nTuples($result) == 0) {
            // send them out to grocerOrders and stop executing code in this page
            header('Location: grocerOrders.php');
            exit;
        }
        
        /*
         * Now we know we got a valid item id through the GET variable
         */
        
        // get data on item to fill out form with existing values
        $row = nextTuple($result);
        
        $orderStatus = $row['orderStatus'];
        
        
    }
?>


<html>
    <head>
<!-- Bootstrap links -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        
        
        <title>Update order <?php echo $id; ?></title>
    </head>
    
    <body>
       
<!-- Title -->
<div class="row">
    <div class="col-xs-12">
        <h1>Update order: <?php echo $id ?></h1>        
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


<!-- Showing errors, if any -->
<div class="row">
    <div class="col-xs-12">
<?php
    if (isset($isComplete) && !$isComplete) {
        // executes only if form was previously submitted (and therefore $isComplete is set) and isComplete was set to false
        // you'll never be here if the form wasn't submitted (the first time you get in)
        
        echo '<div class="alert alert-danger" role="alert">';
        echo ($errorMessage);
        echo '</div>';
    }
?>            
    </div>
</div>



<!-- form to update order -->
<div class="row">
    <div class="col-xs-12">
        
<form action="updateOrder.php" method="post">


<!-- orderStatus -->
<div class="form-group">
	<label for="orderStatus">Order Status: </label>
	<form action="updateOrder.php">
	<select name="orderStatus">
		<option value="Waiting to be Delivered" selected>Waiting to be Delivered</option>
		<option value="Delivered">Delivered</option>
		<option value="Returned to Store">Returned to Store</option>
	</select>
	<br><br>
</div>


<!-- hidden id (not visible to user, but need to be part of form submission so we know which order we are updating -->
<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<button type="submit" class="btn btn-default" name="submit">Save</button>

</form>
        
        
    </div>
</div>

       
       
        
    </body>
</html>
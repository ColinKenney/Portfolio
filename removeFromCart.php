<?php
    include_once('config.php');
    include_once('dbutils.php');
    session_start();
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $order=$_SESSION['startedOrder'];
    $query="DELETE orderedProducts.id, orderedProducts.productName orderedProducts.quantity FROM orderedProducts WHERE inventroy.price=$price AND orders.id=$order;";
    $result=queryDB($query,$db);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
<?php
    include_once('config.php');
    include_once('dbutils.php');
    $newQuantity=$_POST['quantity'];
    session_start();
    $db = connectDB($DBHost, $DBUser, $DBPasswd, $DBName);
    $item=$_GET['id'];
    $newQuantity=$_POST['quantity'];
    $order=$_SESSION['currentOrder'];
    $query="UPDATE orderedProducts SET quantity=$newQuantity WHERE orders.id=$order;";
    $result=queryDB($query,$db);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
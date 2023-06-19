<?php
include("connect.php");

$start_price = $_GET['start_price'];
$end_price = $_GET['end_price'];

try {   
    $sql = "SELECT name, price FROM items WHERE price BETWEEN :start_price AND :end_price;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':start_price', $start_price, PDO::PARAM_STR);
    $stmt->bindParam(':end_price', $end_price, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($res); 

} catch(PDOException $ex) {
    echo $ex->getMessage();
}

$dbh = null;
?>

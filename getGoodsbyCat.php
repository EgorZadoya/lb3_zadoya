<?php
include("connect.php");
$category = $_GET["category"];

try {
    $sqlSelect = "SELECT category.ID_Category, category.c_name, items.ID_Items, items.name 
    FROM category JOIN items ON category.ID_Category = items.FID_Category
    WHERE Category.c_name = :category";
    $sth = $dbh->prepare($sqlSelect);
    $sth->bindValue(":category", $category);
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_NUM);

    header('Content-Type: text/xml');

    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<response>';

    foreach ($res as $row) {
        echo '<item>';
        echo '<c_name>' . $row[1] . '</c_name>';
        echo '<name>' . $row[3] . '</name>';
        echo '</item>';
    }

    echo '</response>';
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

$dbh = null;
?>

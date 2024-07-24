<?php
    session_start();
    var_dump($_POST);
    //If we got here, an order should be succesfully completed
    require_once("Database.php");
    $pdo = getDB();
    $sql="Insert into Orders (U_id, Total, items) value ( :uid, :total, :items)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":uid", $_POST["u_id"]);
    $stmt->bindParam(":total", $_POST["price"]);
    $stmt->bindParam(":items", $_POST["cartItems"]);
    if($stmt->execute())
    {
        header("location: orderhistory.php");
        exit;
    }
    else{
        $error = "Sorry there was an error with your order";
    }
    //take everything in the post and write it as an order to the orders table
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1><?=$error?></h1>
</body>
</html>

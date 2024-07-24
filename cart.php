<?php
session_start();
require_once "Database.php";
$pdo = getDB();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once("Database.php");
$itemIds = $_SESSION["cart"];//[1,4,32,16]
$cart=array();
foreach($itemIds as $id)
{
    $pdo = getDB();
    $sql="Select * from Games where G_id = :g_id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":g_id",$id);
    $stmt->execute();
    $game = $stmt->fetch();
    $cart[]=$game;
    unset($pdo);
    unset($stmt);
    unset($game);
    unset($sql);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">-->
    <link rel="stylesheet" href="cart.css">

</head>
<body>

<!--<header class="navhead">-->
<nav class="navbar">
    <div class="navdiv">
        <?php
        if($_SESSION["isAdmin"]==1)
        {
            ?>
            <div class="admin-logo">
                <a href="home.php">Administrator</a>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="logo">
                <a href="home.php">GameHunt </a>
            </div>
            <?php
        }
        ?>

        <ul class="list1">
            <li><a href="catalog.php">Browse </a></li>
            <li><a href="profile.php"> Profile </a></li>
            <?php
            if($_SESSION["isAdmin"]==1)
            {
                ?>
                <li><a href="admin.php">All Orders</a></li>
                <?php
            }
            else
            {
                ?>
                <li><a href="orderhistory.php">Order History </a></li>
                <?php
            }
            ?>

        </ul>

        <ul class="list2">
            <li><a href="about.php">About</a></li>
        </ul>
        <div class="button-spacing">
            <button class="navbtn"><a href="logout.php">Logout</a></button>
            <button class="navbtn"><a href="cart.php">Cart</a></button>
        </div>
    </div>

</nav>
<!--</header>-->
<div class="boxContainer">
    <table class="elementsContainer">
        <tr>
            <td>
                <input type="text" placeholder="Search" class="search">
            </td>
            <td>
                <a href="#"><i class="material-icons">search</i></a>
            </td>
        </tr>
    </table>

</div>

<div class="slide-container">
    <div class="slide-content">
        <div class="purchase">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                $subtotal=0;
                    foreach($cart as $purchasedItem)
                    {
                     ?>
                        <tr>
                            <th scope="col"><?= $count?></th>
                            <td><?= $purchasedItem["Game_name"]?></td>
                            <td><?= $purchasedItem["Price"]?></td>
                        </tr>
                <?php
                        $subtotal+=intval($purchasedItem["Price"]);
                        $count++;
                    }
                    $subtotal = number_format($subtotal, 2, ".", ",");
                    $withTax = $subtotal*1.08625;
                    $withTax = number_format($withTax, 2, ".", ",");
                    $cartString = implode(",",$itemIds);
                ?>
                </tbody>
            </table>
            <p>Subtotal: <?=$subtotal?></p>
            <p>Total Price with NY Sales Tax: <?=$withTax?></p>
        </div>
        <form action="purchase.php" method="post">
            <input type="hidden" name="u_id" value="<?= $_SESSION["id"]?>">
            <input type="hidden" name="price" value="<?= $withTax?>">
            <input type="hidden" name="cartItems" value="<?= $cartString?>">
            <button type="submit">Purchase!</button>
        </form>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4>Learn More</h4>
                <ul class="footer-order">
                    <li><a href="about.php">about </a></li>
                    <li><a href="about.php">our service  </a></li>
                    <li><a href="about.php">privacy policy </a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Get Help</h4>
                <ul class="footer-order">
                    <li><a href="about.php">order status </a></li>
                    <li><a href="about.php">shipping </a></li>
                    <li><a href="about.php">payment options </a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul class="footer-order">
                    <li><a href="https://www.nyit.edu">The New York Institute of Technology</a></li>
                    <li><a href="https://www.nyit.edu/admissions/contact#:~:text=If%20you%20would%20like%20to,7520.">516-686-1000</a></li>
                    <li><a href="https://www.nyit.edu/long_island/directions">Northern Boulevard at Valentines Lane Old Westbury, NY 11568</a></li>
                    <li><a href="https://www.nyit.edu/long_island/directions">Building Hours: Monday-Saturday: 8 a.m.-11:15 p.m.
                            Sunday:Closed</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

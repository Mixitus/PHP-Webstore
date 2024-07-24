<?php
session_start();
require_once "Database.php";
$pdo = getDB();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "Database.php";
$pdo = getDB();
$sql = "SELECT * FROM Games;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows=$stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalog Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="catalog.css">

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
        <?php
            foreach($rows as $row)
            {
               ?>
                <div class="card-wrapper">
                    <div class="card">
                        <div class="image-content">
                            <span class="overlay"></span>

                            <div class="card-image">
                                <img src="images/<?=$row["Image"]?>" alt="" class="card-img">
                            </div>
                        </div>
                        <div class="card-content">
                            <h2 class="name"><?=$row["Game_name"]?></h2>
                            <p class="description"> <?=$row["Description"]?></p>

                            <button class="card-button"><a href="gameinfo.php?game=<?= $row["G_id"]?>">View Game</a></button>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
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
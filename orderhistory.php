<?php

// Initialize the session
session_start();
require_once "Database.php";

 //Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: Login.php");
    exit;
}

$pdo = getDB();
$sql = "SELECT u.Username, o.O_id, o.U_id, o.Total, o.items
FROM Orders o
Join Users u on u.U_id = o.U_id
where u.U_id = :userId";

$stmt = $pdo->prepare($sql);
$stmt->bindParam("userId", $_SESSION["id"]);
$stmt->execute();
$rows = $stmt->fetchAll();
$rownum = 1;


?>

<!doctype html>
<html lang="en">
<head>
    <title>Order History Page</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
          href = "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity = "sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin = "anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel = "stylesheet" href="orderhistory.css">

</head>

<nav role="navigation">
    <div id="menuToggle">
        <input type="checkbox"/>

        <span></span>
        <span></span>
        <span></span>

        <ul id="menu">
            <header class="nav-logo">
                <img class="navimage" src ="images/code-injection.png">

            </header>
            <li> <a href="home.php"><i class="fas fa-home"></i><b> Home</b></li></a>
            <li> <a href="profile.php"><i class="far fa-id-card"></i><b> Profile</b></li></a>
            <li> <a href="orderhistory.php"><i class="fas fa-chart-bar"></i><b> Order History</b></li></a>
            <li> <a href="logout.php"><i class="fas fa-sign-out-alt"></i><b> Logout</b></li></a>
            <li> <a href="about.php"><i class="fas fa-book"></i><b> About</b></li></a>
            <footer>
                <div id="borderbottom">
                    <img class="navNYIT" src ="images/BlackNYITlogo.png">
                </div>
            </footer>
        </ul>
    </div>
</nav>
</header>
</div>
<body>
<div class="RundataHeader">
    <p>Order Information</p>
</div>

<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Usernames...">
<div class="outer-wrapper">
    <div class="table-wrapper">

        <table id="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">O_ID</th>
                <th scope="col">Items</th>
                <th scope="col">Total</th>

                <?php
                $rownum = 1;
                foreach($rows as $row)
                {

                ?>
            <tr>
                <th scope="row"><?=$rownum?></th>
                <td><?=$row["Username"]?></td>
                <td><?=$row["O_id"]?></td>
                <td><?=$row["items"]?></td>
                <td>$<?=$row["Total"]?></td>
            </tr>
            <?php
            $rownum++;
            }
            ?>
            <script>
                function myFunction() {
                    // Declare variables
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table");
                    tr = table.getElementsByTagName("tr");

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
            </tbody>
        </table>
    </div>
</div>
<!-- Footer --><br>
<footer class="w3-container-w3-theme-dark-w3-padding-16">

    <p>Supported by <a href="https://www.nyit.edu/" target="_blank">New York Institute of Technology</a></p>
    <div style="position:relative;bottom:55px;" class="w3-tooltip w3-right">
        <span class="w3-text w3-theme-light w3-paddding">Go To Top</span>
        <a class="w3-text-white" href="#myHeader"><span class="w3-xlarge">
    <i class="fa fa-chevron-circle-up"></i></span></a>
    </div>
    <p>Contact us at 516.686.7520</p>
</footer>
</body>
</html>
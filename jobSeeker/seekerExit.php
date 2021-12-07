<!-- 
    Logout or permananentlly remove account from database
-->

<html>

<?php

include("../db_conn.php");
session_start();

// get user name 

$uName =  $_SESSION["username"];
?>
<title>EXIT</title>

<!-- Side navigation bar -->
<div class="sidenav">
    <a href="main.php">For you</a>
    <a href="jobQuery.php">Job search</a>
    <a href="history.php">History</a>
    <a href="profile.php">My profile</a>
    <a href="seekerExit.php">Exit</a>
</div>

<!-- Main content goes here -->
<div class="main">
    <form action="seekerExit.php" , method="post">
        <h1> Logout </h1>
        <p><input type='submit' , value='Logout' , name='logout'>
        <h1> Delete account </h1>
        <p>Type "confirm" and press delete. REMEMBER: There is no turning back!</p>
        <p><input type='text' , name='confirmToDelete'>
        <p> <input type='submit' , value='Delete account' , name='deleteAccount'>
    </form>
</div>

<?php
if (isset($_POST["logout"])) {
    $_POST["logout"] = NULL;
    header("Location: ../signIn/index.php");
    session_destroy();
}
if (isset($_POST["deleteAccount"])) {
    if ($_POST["confirmToDelete"] == "confirm") {
        $q_delteUser = "delete from job_portal.user where user_id = '$uName'";
        mysqli_query($connection, $q_delteUser);
    } else {
        echo "<div class='main'>Type confirm to permanently remove '$uName'!";
    }
}

?>

<style>
    /* The sidebar menu */
    .sidenav {
        height: 100%;
        /* Full-height: remove this if you want "auto" height */
        width: 180px;
        /* Set the width of the sidebar */
        position: fixed;
        /* Fixed Sidebar (stay in place on scroll) */
        z-index: 1;
        /* Stay on top */
        top: 0;
        /* Stay at the top */
        left: 0;
        background-color: #111;
        /* Black */
        overflow-x: hidden;
        /* Disable horizontal scroll */
        padding-top: 20px;
    }

    /* The navigation menu links */
    .sidenav a {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #f1f1f1;
    }

    /* Style page content */
    .main {
        margin-left: 180px;
        /* Same as the width of the sidebar */
        padding: 0px 10px;
    }

    /* Style applicable job*/
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    /* Add some padding inside the card container */
    .container {
        padding: 2px 16px;
    }


    input {
        border: 2px solid #ccc;
        padding: 10px;
    }


    /* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }
</style>

</html>
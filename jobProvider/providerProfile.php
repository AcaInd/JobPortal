<!--  
    Manages job provider's profile.
-->

<html>

<?php
include("../db_conn.php");
session_start();

// Setting session variables


$uName = $_SESSION["username"];


// get user id of job provider

$q_uid = "select `id` from `job_provider` where `user_id` = '$uName'";
$res_uid = mysqli_query($connection, $q_uid);

// user id of job provider

if (mysqli_num_rows($res_uid) > 0) {
    $row_id = mysqli_fetch_assoc($res_uid);
    $_SESSION["user_id"] = $row_id["id"];
    $uId = $_SESSION["user_id"];  // job provider's id
    echo $uId;
} else {
    echo "User does not exist";
}

// Fetch job provider details the table job_provider

$q_jpDetails = "select * from job_provider where id = $uId;";
$res_jpDetails = mysqli_query($connection, $q_jpDetails);

if (mysqli_num_rows($res_jpDetails) > 0) {
    $row_jpDetails = mysqli_fetch_assoc($res_jpDetails);
    $jpName = $row_jpDetails["name"];
    $jpDesc = $row_jpDetails["description"];
    $jpPhone = $row_jpDetails["phone"];
    $jpEmail = $row_jpDetails["email"];
    $jpAddress = $row_jpDetails["address"];
    $jpRegno = $row_jpDetails["register_number"];
} else {
    echo "Could not load job provider details!";
}


?>

<!-- Side navigation menu -->

<div class="sidenav">
    <a href="providerProfile.php">Profile</a>
    <a href="jobs.php">Jobs</a>
    <a href="applications.php">Applications</a>
    <a href="providerExit.php">Exit</a>
</div>

<!-- Main class -->

<div class="main">


    <h1> <?php echo "Welcome " . $jpName ?></h1>
    <p>
    <h3>Manage your profile</h3>
    <hr>

    <form action="providerProfile.php" , method="post">
        <p>
            Name: <input type="text" , name="name" , <?php echo "value='" . $jpName . "'" ?>>
        <p>
            Description: <input type="text" , name="desc" , <?php echo "value= '" . $jpDesc . "'" ?>>
        <p>
            Address: <input type="text" , name="address" , <?php echo "value= '" . $jpAddress . "'" ?>>
        <p>
            Phone: <input type="text" , name="phone" , value=<?php echo $jpPhone ?>>
            Email: <input type="text" , name="email" , value=<?php echo $jpEmail ?>>
        <p>
            Register No. : <input type="text" , name="regNo" , <?php echo "value= '" . $jpRegno . "'" ?>>
        <p>
            <input type="submit" , name="submitPrimaryDetails" , value="Save/Update">



    </form>


    <?php
    $jpName = $_POST["name"];
    $jpPhone = $_POST["phone"];
    $jpEmail = $_POST["email"];
    $jpDesc = $_POST["desc"];
    $jpAddress = $_POST["address"];
    $jpRegno = $_POST["regNo"];

    // Save/Update Primary details of job seeker in job_seeker table

    if (isset($_POST["submitPrimaryDetails"])) {
        $q_upadatePrimaryDetails = "update job_provider set name='$jpName', description = '$jpDesc', address ='$jpAddress', phone='$jpPhone', email='$jpEmail', register_number ='$jpRegno' where id='$uId';";
        if (mysqli_query($connection, $q_upadatePrimaryDetails)) {
            header("Refresh:0"); // refresh page after operation
        } else {
            echo "<div class='main'> Error updating details";
        }
    }

    ?>

</div>

<!-- Styles used in this web page -->

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

    /* Style for qualification table*/

    td {
        border: 1px solid black;
        padding: 5px;
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
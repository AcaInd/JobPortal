<!-- 
    List all jobs added by job provider
-->

<html>
<?php
include("../db_conn.php");
session_start();
$uId = $_SESSION["user_id"];
$jobs = "";  // all existing jobs
$q_jobs = "select * from job where provider_id = $uId;";
$r_jobs = mysqli_query($connection, $q_jobs);
if (mysqli_num_rows($r_jobs) > 0) {
    $jobs = "<table><tr><th>Job Title</th><th>Vacancy</th><th>Last date</th></tr>";
    while ($row_jobs = mysqli_fetch_assoc($r_jobs)) {
        $jobs = $jobs . "<tr><td>" . $row_jobs["title"] . "</td><td>" . $row_jobs["vacancy"] . "</td><td>" . $row_jobs["last_date"] . "</td><td>" . "<input type='radio' name='check' value='" . $row_jobs["id"] . "'></td></tr>";
    }
    $jobs = $jobs . "</table>";
} else {
    $jobs = $jobs . "No Jobs found. Create one";
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
    <form action='jobs.php' , method='post'>
        <h1> Manage Jobs </h1>

        <p>
            <input type="submit" , name="createJob" , value="Create new job">
        </p>

        <p>

        <h3>Jobs </h3>
        <p>
            <?php
            echo $jobs;
            ?>

        </p>

        <p>
            <input type='submit' , value='View/Edit selected' , name='submitEdit'>
            <input type='submit' , value='Delete selected' , name='submitDelete'>
        </p>
    </form>
</div>


<?php
if (isset($_POST["createJob"])) {
    $_SESSION["mode"] = "Create new"; // new for new job profile

    header("Location:editJobs.php");
    $_POST["createJob"] = NULL;
}

if (isset($_POST["submitEdit"])) {
    $_POST["submitEdit"] = NULL;
    $_SESSION["jobId"] = $_POST["check"];
    $_SESSION["mode"] = "Update";

    if ($_POST["check"] != NULL) {
        header("Location:editJobs.php");
    } else {
        echo "<div class='main'><p>Select a job profile to view/edit</p>";
    }
}

if (isset($_POST["submitDelete"])) {
    $_POST["submitDelete"] = NULL; // reset 
    $jbId = $_POST["check"];
    $q_deleteJob = "delete from job where id=$jbId";
    echo "<div class='main'><p> Select a job to delete: $q_deleteJob</p></div>";
    if (mysqli_query($connection, $q_deleteJob) == false) {
        echo "<div class='main'><p> Select a job to delete: $q_deleteJob</p></div>";
    } else {
        header("refresh:0");
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
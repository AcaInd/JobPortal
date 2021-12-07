<!-- 
    This page shows job recommendations to the job seeker based on their
    Educational qualifications. 
-->

<html>

<?php

session_start();
include("../db_conn.php");
$uName =  $_SESSION["username"];

try {
    $q_uid = "select `id` from `job_seeker` where `user_id` = '$uName'";
    $res_uid = mysqli_query($connection, $q_uid);

    // user id of job seeker

    if (mysqli_num_rows($res_uid) > 0) {
        $row_id = mysqli_fetch_assoc($res_uid);
        $_SESSION["user_id"] = $row_id["id"];
        $uId = $_SESSION["user_id"];
    } else {
        echo "User does not exist";
    }

    // age of job seeker

    $q_ageOfJobSeeker = "select floor(datediff('2021-01-01',(select dob from job_seeker where id = '$uId'))/ 365.25) as age;";
    $res_ageOfJobSeeker = mysqli_query($connection, $q_ageOfJobSeeker);

    if (mysqli_num_rows($res_ageOfJobSeeker) > 0) {
        $row_ageOfJobSeeker = mysqli_fetch_assoc($res_ageOfJobSeeker);
        $_SESSION["age"] = $row_ageOfJobSeeker["age"];
    } else {
        echo "Error";
    }
} catch (Exception $e) {
    echo "Could not load user details";
}
?>

<!-- Side navigation -->

<div class="sidenav">
    <a href="main.php">For you</a>
    <a href="jobQuery.php">Job search</a>
    <a href="history.php">History</a>
    <a href="profile.php">My profile</a>
    <a href="seekerExit.php">Exit</a>
</div>

<!-- Page content -->

<div class="main">

    <div class="title">
        <h1>
            Jobs For You
        </h1>
        <?php

        // query to select jobs that match job_seeker's educational qualifications

        $q_jobs = "select j.id as jid,j.title, j.description, j.min_sal, j.max_sal, j.min_age, j.max_sal, j.min_gpa, j.last_date, j.vacancy, j.link, j.level, j.course, j.spec, jp.id, jp.name from job j join job_provider jp on j.provider_id = jp.id where j.level in (select level from qualification where job_seeker_id = '$uId') and j.course in (select course from qualification where job_seeker_id = '$uId') and j.spec in (select spec from qualification where job_seeker_id = '$uId') order by j.max_sal desc;";
        $res_jobs = mysqli_query($connection, $q_jobs);

        if (mysqli_num_rows($res_jobs) > 0) {
            while ($row = mysqli_fetch_assoc($res_jobs)) { ?>
                <div class="card">

                    <div class="container">
                        <h3> <?php echo $row["title"] . ' at ' . $row["name"] ?></h3>
                        Salary: <?php echo $row["min_sal"] . ' - ' . $row["max_sal"]   ?>
                        <p> Last date to apply: <?php echo $row["last_date"] ?> </p>
                        Vacancy: <?php echo $row["vacancy"] ?> </br>

                        <?php
                        $link = "'" . $row["link"] . "'";
                        $jobId = $row["jid"];

                        // Go to job details page
                        echo "<p><a class='detail', href = 'jobDetails.php?val=$jobId'> View details <p></a>"
                        ?>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "No jobs found. Please update your profile!";
        }
        ?>

    </div>
</div>

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

    .detail {
        float: right;
        background: #555;
        padding: 10px 15px;
        color: #fff;
        border-radius: 5px;
        margin-right: 10px;
        border: none;
        text-decoration: none;
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
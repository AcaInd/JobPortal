<html>

<?php
include("../db_conn.php");
session_start();
$jpId = $_SESSION["user_id"];
echo "<div class='main'>";

$q_providerName = "select `name` from `job_provider` where `id` = $jpId";
$res_providerName = mysqli_query($connection, $q_providerName);
if (mysqli_num_rows($res_providerName) > 0) {
    $row = mysqli_fetch_assoc($res_providerName);
    $name = $row['name'];
    echo $name;
}

$q_applications = "SELECT a.job_seeker_id, a.job_id, a.job_title, a.provider_name, a.dateAndTime,  a.status, js.name as jsname FROM applied a JOIN job_seeker js ON a.job_seeker_id = js.id WHERE a.provider_name = '$name'";
$res_application = mysqli_query($connection, $q_applications);

if (mysqli_num_rows($res_application) > 0) {

    $applications = "<table><tr><th>No.</th><th>Title</th><th>Candidate</th><th>Last modified</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($res_application)) {
        $count++;
        $str = $row['job_seeker_id'] . "-" . $row['job_id'];

        $applications = $applications . "<tr><td>" . $count . "</td><td>" . $row['job_title'] . "</td><td>" . $row['jsname'] . "</td><td>" . $row['dateAndTime'] . "</td><td>" . $row['status'] . "</td><td><input type='radio' name='check' value=$str>" . "</td></tr>";
    }
    $applications = $applications . "</table>";
} else {
    $applications = "Nobody applied yet";
}


if (isset($_POST['view'])) {
    $_POST['view'] = NULL;
    $selected = $_POST['check'];
    echo $selected;
    $_SESSION['temp'] = $selected;
    header("Location: viewApplication.php?val=$selected");
} else {
    $msg = "Select an application and click 'View application'";
}


echo "</div>";

?>

<div class='main'>
    <form action='applications.php' , method='post'>
        <?php echo $applications ?>
        <p>
            <?php echo $msg ?>
        </p>

        <p>
            <input type='submit' value='View application' name='view'>
        </p>



    </form>
</div>


<div class="sidenav">
    <a href="providerProfile.php">Profile</a>
    <a href="jobs.php">Jobs</a>
    <a href="applications.php">Applications</a>
    <a href="providerExit.php">Exit</a>
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
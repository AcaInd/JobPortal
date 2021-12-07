<html>

<?php
include("../db_conn.php");
session_start();

$jobId = (int) $_GET["val"];
$uid = $_SESSION["user_id"];
$age = (int) $_SESSION["age"];

$_SESSION['job_Id'] = $jobId;
$count = 2; // 2 requirements already checked


$q_jobDetails = "select j.id, j.title, j.description as jdes, j.min_sal, j.max_sal, j.min_age, j.max_age, j.min_gpa, j.last_date, j.vacancy, j.link, j.level, j.course, j.spec, j.provider_id, jp.name, jp.description as jpdes, jp.address, jp.phone, jp.email, jp.register_number from job j join job_provider jp on j.provider_id = jp.id where j.id ='$jobId';";
$q_JobSeekerQualifications = "select q.level, q.course, q.spec, q.univ, q.gpa, q.year, q.job_seeker_id from qualification q join job j where q.job_seeker_id = $uid and j.id = $jobId and j.level = q.level and j.course = q.course and j.spec = q.spec;";

$res_jobDetails = mysqli_query($connection, $q_jobDetails);
$res_jobSeekerQualifications = mysqli_query($connection, $q_JobSeekerQualifications);

if (mysqli_num_rows($res_jobSeekerQualifications) > 0) {
    $row_jobSeekerQualifications = mysqli_fetch_assoc($res_jobSeekerQualifications);
    $gpa = $row_jobSeekerQualifications["gpa"];
}

if (mysqli_num_rows($res_jobDetails) > 0) { ?>
    <div class="main">
        <?php
        $row_jobDetails = mysqli_fetch_assoc($res_jobDetails);

        $_SESSION['jobTitle'] = $row_jobDetails["title"];
        $_SESSION['jpName'] = $row_jobDetails["name"];

        echo "<h1>" . $row_jobDetails["title"] . "</h1>";
        echo "<h3> Overview</h3>";
        echo "<hr>";

        if ($age > $row_jobDetails["min_age"] && $age < $row_jobDetails["max_age"]) {
            echo "<li>Age limit: " . $row_jobDetails["min_age"] . ' - ' . $row_jobDetails["max_age"] . "<font color='green'> ✓  </font>";
            $count++;
        } else {
            echo "<li>Age limit: " . $row_jobDetails["min_age"] . ' - ' . $row_jobDetails["max_age"] . "<font color='red'> ⚠</font>";
        };

        if ($gpa >= $row_jobDetails["min_gpa"]) {
            echo "<li>Minimum gpa: " . $row_jobDetails["min_gpa"] . "<font color='green'> ✓  </font>";
            $count++;
        } else {
            echo "<li>Minimum gpa: " . $row_jobDetails["min_gpa"] . "<font color='red'> ⚠</font>";
        }
        echo "<li>Education: <b>" . $row_jobDetails["course"] . "</b> in <b>" . $row_jobDetails["spec"] . "</b> <font color='green'> ✓  </font>";

        echo "<li>Salary: Rs." . $row_jobDetails["min_sal"] . ' - ' . $row_jobDetails["max_sal"];
        echo "<li>Last date: " . $row_jobDetails["last_date"] . "<font color='green'> ✓  </font>";
        echo "<h3> Description</h3>";
        echo "<hr>";
        echo "<p>" . $row_jobDetails["jdes"];
        echo "<h4> About " . $row_jobDetails["name"];
        echo "</h4><p>" . $row_jobDetails["jpdes"];
        echo "<p>📧 " . $row_jobDetails["email"];
        echo "<p>📞 " . $row_jobDetails["phone"];
        echo "<h3>Apply </h3><hr>";
        $link = $row_jobDetails["link"];
        // echo "<a href = '$link'>Go to portal</a>";
        if ($count == 4) {
            echo "<a href = 'sample.php?val=$jobId'>Go to portal</a>";
        } else {
            $i = 4 - $count;
            echo "<font color='red'>$i requirement(s) are not satisfied :( <br>Please update your profile and try again</font>";
        }

        ?>
    </div>

<?php } else {
    echo "Something happenend.. ";
}


?>


<style>
    .main {
        margin-left: 180px;
        margin-right: 90px;
        padding: 10px 10px;
    }
</style>



</html>
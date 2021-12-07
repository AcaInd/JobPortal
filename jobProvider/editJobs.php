<!-- 
    Update existing job profile or create new profile.
-->

<html>

<?php
include("../db_conn.php");
session_start();
$uId = $_SESSION["user_id"]; // fetch job_seeker's id
$mode = $_SESSION["mode"]; // create new or update existing job profile
$jobId = $_SESSION["jobId"];

// Initiate variables based on the mode of access

if ($mode == "Update") {
    $q_jobDetails = "select * from job where id= $jobId";
    $res_jobDetails = mysqli_query($connection, $q_jobDetails);
    if (mysqli_num_rows($res_jobDetails) > 0) {
        $row_jobDetails = mysqli_fetch_assoc($res_jobDetails);
        $input_date = $row_jobDetails["last_date"];
        $jobTitle = $row_jobDetails["title"];
        $jobDesc = $row_jobDetails["description"];
        $vacancy = $row_jobDetails["vacancy"];
        $level = $row_jobDetails["level"];
        $course = $row_jobDetails["course"];
        $spec = $row_jobDetails["spec"];
        $gpa = (float) $row_jobDetails["min_gpa"];
        $minSal = $row_jobDetails["min_sal"];
        $maxSal = $row_jobDetails["max_sal"];
        $minAge = $row_jobDetails["min_age"];
        $maxAge = $row_jobDetails["max_age"];
        $link = $row_jobDetails["link"];
        $_POST["selectCourse"] = $course;
        $_POST["selectLevel"] = $level;
        $_POST["selectSpec"] = $spec;
    } else {
        echo "<div class='main'> Couldn't load job details</div>";
        // header("Location: jobs.php"); // return to jobs.php
    }
} else {
    $input_date = date("Y-m-d"); // today's date
    $jobTitle = NULL;
    $jobDesc = "";
    $vacancy = 0;
    $level = NULL;
    $course = NULL;
    $spec = NULL;
    $gpa = 0.0;
    $minSal = 1000;
    $maxSal = NULL;
    $minAge = 18;
    $maxAge = NULL;
    $link = "";
}
?>

<!-- Main class -->

<div class="main">
    <form action='editJobs.php' , method='post'>
        <input type='submit' , value='< Go back' , name='goToJobs'>
        <h1> <?php echo $mode . " job profile" ?> </h1>
        <hr>
        Job title: <input type='text' , <?php echo "value= '" . $jobTitle . "'" ?> , name="jobTitle">
        <p>
            Description: <input type="text" , <?php echo "value= '" . $jobDesc . "'" ?> , name='jobDesc'>
        </p>
        <p>
            Last date: <input type='date' , <?php echo "value= '" . $input_date . "'" ?>, name="lastDate">
        </p>
        <p>
            Vacancy: <input type='number' , <?php echo "value= '" . $vacancy . "'" ?> , name="vacancy">
        </p>
        <p>
            Minimum salary: <input type='number' , <?php echo "value= '" . $minSal . "'" ?>, name="minSal">

            Maximum salary: <input type='number' , <?php echo "value= '" . $maxSal . "'" ?> , name="maxSal">
        </p>
        <p>
            Minimum age: <input type='number' , <?php echo "value= '" . $minAge . "'" ?> , name="minAge">

            Maximum age: <input type='number' , <?php echo "value= '" . $maxAge . "'" ?> , name="maxAge">
        </p>
        <p>
            GPA(Out of 10): <input type="number" , name="gpa" , value=<?php echo $gpa ?> step="0.1" , max="10.0">
        </p>
        <p>
            Apply link: <input type="text" , <?php echo "value= '" . $link . "'" ?> , name='link'>
        </p>
        <h4> Job requirements</h4>
        Level: <select name="selectLevel">
            <option value="none">Select</option>
            <option value="ug">ug</option>
            <option value="pg">pg</option>
            <option value="pg+">pg above</option>
        </select>
        Course: <select name="selectCourse">
            <option value="none">Select</option>
            <option value="BTech">BTech</option>
            <option value="BSc">BSc</option>
            <option value="MA">MA</option>
            <option value="BA">BA</option>
            <option value="MTech">MTech</option>
            <option value="BBA">MTech</option>
            <option value="MBA">MTech</option>
        </select>
        Specialization: <select name="selectSpec">
            <option value="none">Select</option>
            <option value="Information Technology">Information Technology</option>
            <option value="Electrical Engineering">Electrical Engineering</option>
            <option value="Applied Physics">Applied Physics</option>
            <option value="Electronics">Electronics</option>
            <option value="Mechatronics">Mechatronics</option>
            <option value="Mechanics">Mechatronics</option>
        </select>
        <p>
            <input type="submit" , name="submitJob" , <?php echo " value= '" . $mode . "'" ?>>
        </p>
    </form>
</div>

<?php

// Go back to previous page

if (isset($_POST["goToJobs"])) {
    $_POST["goToJobs"] = NULL; // reset
    header("Location: jobs.php"); // go back to jobs page
}

// Create a new or update job profile

if (isset($_POST["submitJob"])) {

    // collect all form values 

    $input_date = $_POST['lastDate'];
    $lastDate = date("Y-m-d", strtotime($input_date));
    $jobTitle = $_POST["jobTitle"];
    $jobDesc = $_POST["jobDesc"];
    $vacancy = $_POST["vacancy"];
    $level = $_POST["selectLevel"];
    $course = $_POST["selectCourse"];
    $spec = $_POST["selectSpec"];
    $gpa = (float) $_POST["gpa"];
    $minSal = $_POST["minSal"];
    $maxSal = $_POST["maxSal"];
    $minAge = $_POST["minAge"];
    $maxAge = $_POST["maxAge"];
    $link = $_POST["link"];

    // create query based on mode of access

    if ($mode == "Create new") {  // new job profile
        $q_editJob = "insert into job(title, description, min_sal, max_sal, min_age, max_age, min_gpa, last_date, vacancy, link, level, course, spec, provider_id) values('$jobTitle', '$jobDesc', $minSal, $maxSal, $minAge, $maxAge, $gpa, '$lastDate', $vacancy, '$link', '$level', '$course', '$spec', $uId);";
    } else { // update existing job profile
        $q_editJob = "update job set title = '$jobTitle', description='$jobDesc', min_sal=$minSal, max_sal=$maxSal, min_age=$minAge, max_age=$maxAge, min_gpa = $gpa, last_date = '$lastDate', vacancy=$vacancy, link='$link', level='$level', course='$course', spec='$spec', provider_id=$uId";
    }

    // uncomment to see the query
    // echo "<div class='main'> Query: $q_editJob </div>";


    // check if query executed successfully

    $isEdited = mysqli_query($connection, $q_editJob);

    if ($isEdited == false) {
        echo "<div class='main'><font color='red'> Invalid details!</font> </div>";
    } else {
        echo "<div class='main'> <font color='green'>Details successfully updated</font> </div>";
    }
    //header("refresh:0");
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
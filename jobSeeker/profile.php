<!--  
    Manages jobseeker's profile. Job seekers can update their primary details
    and educational details. Multiple educational qualifications can be 
    added.
-->

<html>

<?php
include("../db_conn.php");
session_start();

// Setting session variables

$uId = $_SESSION["user_id"];
$uName = $_SESSION["username"];

// Fetch job seeker details from the table job_seeker

$q_jsDetails = "select * from job_seeker where id = $uId;";
$res_jsDetails = mysqli_query($connection, $q_jsDetails);

if (mysqli_num_rows($res_jsDetails) > 0) {
    $row_jsDetails = mysqli_fetch_assoc($res_jsDetails);
    $jsId = $row_jsDetails["id"];
    $jsName = $row_jsDetails["name"];
    $jsDob = $row_jsDetails["dob"];
    $jsGender = $row_jsDetails["gender"];
    $jsPhone = $row_jsDetails["phone"];
    $jsEmail = $row_jsDetails["email"];
    $jsAddress = $row_jsDetails["address"];
} else {
    echo "Could not load job seeker details!";
}

// Fetch jobseeker's educational details from the table, qualification

$q_jsQualifications = "select * from qualification where job_seeker_id =$uId;";
$res_jsQualifications = mysqli_query($connection, $q_jsQualifications);
if (mysqli_num_rows($res_jsQualifications) > 0) {
    $qualifications = "<table><tr><th>Level</th><th>Course</th><th>Specification</th><th>GPA</th><th>Year</th><th>University</th></tr>";
    while ($row_jsQ = mysqli_fetch_assoc($res_jsQualifications)) {
        $rmvId = $row_jsQ["id"];
        $qualifications = $qualifications . "<tr><td>" . $row_jsQ["level"] . "</td><td>" . $row_jsQ["course"] . "</td><td>" . $row_jsQ["spec"] . "</td><td>" . $row_jsQ["gpa"] . "</td><td>" . $row_jsQ["year"] . "</td><td>" . $row_jsQ["univ"] . "</td><td><input type='radio' name='check' value='" . $rmvId . "'></td></tr>";
    }
    $qualifications = $qualifications . "</table>";
}
?>


<!-- Side navigation menu -->

<div class="sidenav">
    <a href="main.php">For you</a>
    <a href="jobQuery.php">Job search</a>
    <a href="history.php">History</a>
    <a href="profile.php">My profile</a>
    <a href="seekerExit.php">Exit</a>
</div>

<!-- Main class -->

<div class="main">


    <h1> My Profile</h1>
    <p>
    <h3>Primary Details</h3>
    <hr>

    <form action="profile.php" , method="post">
        <p>
            Name: <input type="text" , name="name" , <?php echo "value='" . $jsName . "'" ?>>
        <p>
            Dob: <input type="date" , name="dob" , value=<?php echo $jsDob ?>>
        <p>
            Gender(m/f/o): <input type="text" , name="gender" , value=<?php echo $jsGender ?>>
        <p>
            Phone: <input type="text" , name="phone" , value=<?php echo $jsPhone ?>>
            Email: <input type="text" , name="email" , value=<?php echo $jsEmail ?>>
        <p>
            Address: <input type="text" , name="address" , <?php echo "value= '" . $jsAddress . "'" ?>>
        <p>
            <input type="submit" , name="submitPrimaryDetails" , value="Save/Update">


        <h3>Educational Deails</h3>
        <hr>
        <h4> New qualification</h4>

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
        GPA(Out of 10): <input type="number" , name="gpa" , step="0.1" , max="10.0">
        <p>
            Year: <input type="number" , name="year" , max="2200">
            University/Board: <input type="text" , name="university">
        <p>
            <input type="submit" , name="submitQualif" , value="Add new qualification">
        <p>

        <h4> My qualifications </h4>
        <?php echo $qualifications; ?>
        <p>
            <input type='submit' , value='Delete selected' , name='submitDelete'>
        </p>
    </form>


    <?php
    $jsName = $_POST["name"];
    $jsPhone = $_POST["phone"];
    $jsEmail = $_POST["email"];
    $jsGender = $_POST["gender"];
    $jsAddress = $_POST["address"];
    $tempLevel = $_POST["select"];

    // Save/Update Primary details of job seeker in job_seeker table

    if (isset($_POST["submitPrimaryDetails"])) {
        $input_date = $_POST['dob'];
        $jsDob = date("Y-m-d", strtotime($input_date));
        $q_upadatePrimaryDetails = "update job_seeker set name='$jsName', dob = '$jsDob', gender='$jsGender', phone='$jsPhone', email='$jsEmail', address='$jsAddress' where id='$jsId';";
        if (mysqli_query($connection, $q_upadatePrimaryDetails)) {
            header("Refresh:0"); // refresh page after operation
        } else {
            echo "Error";
        }
    }

    // Add new qualification for job seeker in qualification table

    if (isset($_POST["submitQualif"])) {
        $level = $_POST["selectLevel"];
        $crs = $_POST["selectCourse"];
        $spec = $_POST["selectSpec"];
        $univ = $_POST["university"];
        $yr = $_POST["year"];
        $gpa = $_POST["gpa"];
        $q_newQualif = "insert into qualification (level, course, spec, univ, gpa, year, job_seeker_id) values ('$level', '$crs', '$spec', '$univ',$gpa,'$yr',$jsId);";
        $res_newQualif = mysqli_query($connection, $q_newQualif);
        header("Refresh:0"); // refresh page after operation
    }

    // Delete a qualification from qualification table

    if (isset($_POST["submitDelete"])) {
        $qualificationId = $_POST['check'];
        $q_deleteQualif = "delete from qualification where id = $qualificationId";
        mysqli_query($connection, $q_deleteQualif);
        header("Refresh:0");
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
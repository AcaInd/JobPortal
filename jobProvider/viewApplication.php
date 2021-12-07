<html>


<?php
include("../db_conn.php");
session_start();
echo "<div class='main'>";


$str = $_SESSION['temp'];

$new_str_arr = explode('-', $str);
$jsId = $new_str_arr[0];
$jId = $new_str_arr[1];



$uId = $jsId;



// fetch job seeker's profile

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

// fetch job seeker's educational details

$q_jsQualifications = "select * from qualification where job_seeker_id =$uId;";
$res_jsQualifications = mysqli_query($connection, $q_jsQualifications);
if (mysqli_num_rows($res_jsQualifications) > 0) {
    $qualifications = "<table><tr><th>Level</th><th>Course</th><th>Specification</th><th>GPA</th><th>Year</th><th>University</th></tr>";
    while ($row_jsQ = mysqli_fetch_assoc($res_jsQualifications)) {
        $rmvId = $row_jsQ["id"];
        $qualifications = $qualifications . "<tr><td>" . $row_jsQ["level"] . "</td><td>" . $row_jsQ["course"] . "</td><td>" . $row_jsQ["spec"] . "</td><td>" . $row_jsQ["gpa"] . "</td><td>" . $row_jsQ["year"] . "</td><td>" . $row_jsQ["univ"] . "</td></tr>";
    }
    $qualifications = $qualifications . "</table>";
}

// fetch applied status

$q_applied = "select * from applied where job_seeker_id=$jsId and job_id=$jId";

$res_applied = mysqli_query($connection, $q_applied);
$status = "";
if (mysqli_num_rows($res_applied) > 0) {
    $row_applied = mysqli_fetch_assoc($res_applied);
    $status = $row_applied['status'];
    $modified = $row_applied['dateAndTime'];
    $jobTitle = $row_applied['job_title'];
}


?>

<form action='viewApplication.php' , method='post'>
    <input type='submit' value='< Go Back' name='goToApps'>
    <h1> Application for <?php echo $jobTitle ?></h1>
    <h3> About Candidate</h3>
    <hr>

    <p>
        Name: <input type="text" , name="name" , <?php echo "value='" . $jsName . "'" ?> readonly>
    <p>
        Dob: <input type="date" , name="dob" , value=<?php echo $jsDob ?> readonly>
    <p>
        Gender(m/f/o): <input type="text" , name="gender" , value=<?php echo $jsGender ?> readonly>
    <p>
        Phone: <input type="text" , name="phone" , value=<?php echo $jsPhone ?> readonly>
        Phone: <input type="text" , name="phone" , value=<?php echo $jsPhone ?> readonly>
        Email: <input type="text" , name="email" , value=<?php echo $jsEmail ?> readonly>
    <p>
        Address: <input type="text" , name="address" , <?php echo "value= '" . $jsAddress . "'" ?> readonly>
    <p>

    <h3> Educational details</h3>
    <hr>
    <?php echo $qualifications ?>
    <h3> Application status</h3>
    <hr>
    <?php echo "<br>Current status: " . $status ?><br>
    <?php echo "Last modified:  " . $modified ?>

    <p>
        <input type='submit' name='accept' value='Accept'>
        <input type='submit' name='reject' value='Reject'>
    </p>




</form>
<?php
if (isset($_POST['accept'])) {
    $_POST['accept'] = NULL;
    $q_editApplied = "update applied set status='ACCEPTED', dateAndTime=now() where job_seeker_id=$uId and job_id=$jId";
    echo $q_editApplied;
    mysqli_query($connection, $q_editApplied);
    header("refresh:0");
}

if (isset($_POST['reject'])) {
    $_POST['reject'] = NULL;
    $q_editApplied = "update applied set status='REJECTED', dateAndTime=now() where job_seeker_id=$uId and job_id=$jId";
    echo $q_editApplied;
    mysqli_query($connection, $q_editApplied);
    header("refresh:0");
}

if (isset($_POST['goToApps'])) {
    $_POST['goToApps'] = NULL;
    header("Location: applications.php");
}

?>

<style>
    .main {
        margin-left: 180px;
        /* Same as the width of the sidebar */
        padding: 0px 10px;
    }

    td {
        border: 1px solid black;
        padding: 5px;
    }
</style>

</html>
<!-- job seeker's official website model -->

<html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("../db_conn.php");
$uid = $_SESSION['user_id'];
$jobId = $_SESSION['job_Id'];
$jTitle = $_SESSION['jobTitle'];
$jpName = $_SESSION['jpName'];


$q_checkApplied = "select * from applied where job_seeker_id=$uid and job_id=$jobId;";

$res_checkApplied = mysqli_query($connection, $q_checkApplied);

?>
<div class='main'>

    <form action='sample.php' , method='post'>
        <input type='submit' method='post' , name='goToMain' , value='< Go Back'>
        <p>
        <h1><?php echo $jpName . "'s Official website" ?></h1>
        <p>
            Please complete your application procedure from job provider's official website.
        </p>
        <p>
            Once you are done press "Finish"
        </p>

    </form>
    <?php
    if ($res_checkApplied) {

        $i = (int) mysqli_num_rows($res_checkApplied);

        if ($i == 0) { ?>
            <form action='sample.php' , method="post">
                <input type='submit' name='confirm' value='Finish'>
            </form>
    <?php } else {
            echo "<font color='green'>Applied Successfully</font>";
            $rowStatus = mysqli_fetch_assoc($res_checkApplied);
            echo "<p> Current status: " . $rowStatus['status'];
            echo "<br> Last Modified: " . $rowStatus['dateAndTime'];
        }
    } else {
        echo "Error happened";
    }

    if (isset($_POST['confirm'])) {

        $_POST['confirm'] = NULL; // reset


        $q_insertApplied = "insert into applied values ($uid, $jobId,'$jTitle', '$jpName', now(), 'APPLIED');";
        mysqli_query($connection, $q_insertApplied);

        header("Refresh:0");

        // uncomment to see insert query
        // echo $q_insertApplied;

    }

    if (isset($_POST['goToMain'])) {
        $_POST['goToMain'] = NULL;
        header("Location: main.php");
    }

    ?>

</div>







<style>
    .main {
        margin-left: 180px;
        padding: 0px 10px;
    }
</style>

</html>
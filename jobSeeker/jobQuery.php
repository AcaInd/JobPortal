<html>

<?php
include("../db_conn.php");
session_start();
$jsId = $_SESSION["user_id"];

?>

<div class="sidenav">
    <a href="main.php">For you</a>
    <a href="jobQuery.php">Job search</a>
    <a href="history.php">History</a>
    <a href="profile.php">My profile</a>
    <a href="seekerExit.php">Exit</a>
</div>

<div class="main">
    <h1>Job Search</h1>
    <form action="jobQuery.php" , method="post">
        <p>
            Company Name: <input type='text' , name='companyName' , value='%'>
        </p>
        <p>
            Vacancy:
            <select name="selectSymbolVacancy">
                <option value=">" selected>></option>
                <option value="<">
                    < </option>
                <option value="=">=</option>
                <option value=">=">>=</option>
                <option value="<=">
                    <= </option>
                <option value="!=">!=</option>
            </select>
            <input type='number' , name='vacancy' , value='0'>
        </p>
        <p>
            Salary: between <input type='number' , name='minSal' , value='1000'>
            and <input type='number' , name='maxSal' , value='1000000'>
        </p>
        <p>
            Sort by:
            <select name="selectSortCondition">
                <option value="min_sal">Minimum Salary</option>
                <option value="max_sal" selected>Maximum Salary</option>
                <option value="vacancy">Vacancy</option>
                <option value="last_date">Last date</option>
            </select>
            <select name="selectOrder">
                <option value='asc'>Ascending</option>
                <option value='desc' selected>Descending</option>
            </select>
        <p>
            <input type='submit' , value='Search' , name='submitQuery'>
        </p>

    </form>


</div>

<?php
if (isset($_POST["submitQuery"])) {
    $minSal = $_POST["minSal"];
    $maxSal = $_POST["maxSal"];
    $companyName = $_POST["companyName"];
    $vacancy = $_POST["vacancy"];
    $symbolVacancy = $_POST["selectSymbolVacancy"];
    $sortParam = $_POST["selectSortCondition"];
    $sortOrder = $_POST["selectOrder"];
    $q_jobSearch = "select j.id as jid,j.title, j.description, j.min_sal, j.max_sal, j.min_age, j.max_sal, j.min_gpa, j.last_date, j.vacancy, j.link, j.level, j.course, j.spec, jp.id, jp.name from job j join job_provider jp on j.provider_id = jp.id where j.level in (select level from qualification where job_seeker_id = '$jsId') and j.course in (select course from qualification where job_seeker_id = '$jsId') and j.spec in (select spec from qualification where job_seeker_id = '$jsId') and j.min_sal >= $minSal and max_sal <= $maxSal and j.vacancy $symbolVacancy $vacancy and jp.name like '$companyName' order by j.$sortParam $sortOrder";


    // uncomment to show the query being executed
    // echo "<div class= 'main'>$q_jobSearch";


    $res_jobs = mysqli_query($connection, $q_jobSearch);
    if (mysqli_num_rows($res_jobs) > 0) {
        echo "<div class = 'main'><p>";
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

                    echo "<p><a href = 'jobDetails.php?val=$jobId'> View details </a>"
                    ?>
                </div>
            </div>
<?php
        }
    } else {
        echo "<p><font color = 'red'>No jobs found.</font></p>";
    }
} else {
    echo "Query Error";
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
<!DOCTYPE html>
<html>

<?php
session_start();

$userType = $_GET['userType'];
$_SESSION['userType'] = $_GET['userType'];

?>

<head>
     <title>SIGN UP</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
     <div class='container'>
          <form action="Signup_check.php" method="post">
               <h2><?php echo "Job " . $userType ?> <br>SIGN UP</h2>

               <!-- print error message -->

               <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
               <?php } ?>

               <!-- print success message -->

               <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
               <?php } ?>



               <label>Create User Id</label>
               <?php if (isset($_GET['uname'])) { ?>
                    <input type="text" name="uname" placeholder="User id must be unique" value="<?php echo $_GET['uname']; ?>"><br>
               <?php } else { ?>
                    <input type="text" name="uname" placeholder="User Id must be unique"><br>
               <?php } ?>


               <label>Password</label>
               <input type="password" name="password" placeholder="Password"><br>

               <label>Re Password</label>
               <input type="password" name="re_password" placeholder="Re_Password"><br>

               <button type="submit">Sign Up</button>

               <a href=<?php echo "signInPage.php?userType=$userType" ?> class="ca">Already have an account?</a>
          </form>
     </div>
</body>

</html>
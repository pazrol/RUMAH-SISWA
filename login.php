<?php
session_start(); // Start the session

//Call file to connect server Rumah Siswa
include("header.php");

if (isset($_POST['submit'])) 
{
    $user = mysqli_real_escape_string($connect, $_POST['user']);
    $pass = mysqli_real_escape_string($connect, ($_POST['password']));

    $select = mysqli_query($connect, "SELECT * FROM `user_form` WHERE user = '$user' AND password = '$pass'") or die('query failed');


    if (mysqli_num_rows($select) > 0) 
    {
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user'] = $user;
      $_SESSION['user_id'] = $row['user_id'];

      // Store user type in session
      $_SESSION['user_type'] = $row['user_type'];
      echo 
      '<script>
        location.href = "homepage.php?id='.$row['user_id'].'";
       </script>';// Redirect to the home page
      exit(); // Exit to prevent further execution
    } 
    else
    {
      $message[] ='Invalid username or password. Please click button register if youre new user.';

    }

   
}


?>

<html>
  <head>
    <title>RUMAH SISWA</title>
  </head>
  <body>
    <!--CSS Link-->
  <style>
      <?php
   include('login.css');
   ?>
   </style>
    <div class="form-container">
      <form action="login.php" method = "POST">
        <h3>Login</h3>

        <?php
      if(isset($message))
      {
         foreach($message as $message)
         {
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>

        <input type="user" name="user" placeholder="Enter username" class="box" required>
        <input type="password" name="password" placeholder="Enter password" class="box" required>
        <input type="submit" name="submit" value="Login" class="btn">
        <p>Don't have an account? <a href="register.php">Sign Up Now!</a></p>
      <p>
       <a class="linktoRegister" href="https://drive.google.com/drive/folders/1gXUf9u-SMSTh3s_CpvW0iRbAsxHYsBEe?usp=drive_link" target="_blank">Click Here For User Manual</a>
      </p>
      </form>
    </div>
  </body>
</html>

<?php
session_start(); // Start the session

// Call file to connect server Rumah Siswa
include("header.php");

// Logout functionality
if (isset($_GET['logout'])) 
{
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("location: login.php");
    exit();
}

$message = array();

if (isset($_POST['submit'])) 
{
    $title = mysqli_real_escape_string($connect, ($_POST['title']));
    $desc = mysqli_real_escape_string($connect, ($_POST['description']));
    $ph = mysqli_real_escape_string($connect, ($_POST['phone_num']));
    $add = mysqli_real_escape_string($connect, ($_POST['address']));
    $add2 = mysqli_real_escape_string($connect, ($_POST['address2']));
    $state = mysqli_real_escape_string($connect, ($_POST['state']));
    $ht = mysqli_real_escape_string($connect, ($_POST['house_type']));
    $furnishing = mysqli_real_escape_string($connect, ($_POST['furnishing']));
    $p = mysqli_real_escape_string($connect, ($_POST['price']));
            
    // Assuming you have a column named 'status' in your database table to store the application status
    $status = 'pending'; 

     // File upload handling
     if(isset($_FILES['house_img']) && $_FILES['house_img']['error'] === UPLOAD_ERR_OK) 
     {
      $tmp_name = $_FILES['house_img']['tmp_name'];
      $img_name = $_FILES['house_img']['name'];
      $img_path = 'images/' . $img_name;
      if(move_uploaded_file($tmp_name, $img_path)) 
      {
          // Insert data into database
          $query = "INSERT INTO `house`(`title`, `description`, `phone_num`, `address`, `address2`, `state`, `house_type`, `furnishing`, `price`, `house_img`, `status`) 
          VALUES ('$title', '$desc', '$ph', '$add', '$add2', '$state', '$ht', '$furnishing', '$p', '$img_name', '$status')";
          
          if(mysqli_query($connect, $query)) 
          {
              $message[] = 'Application Submitted';
          } 
          else 
          {
              $message[] = 'Application Failed!';
          }
      }
      else 
      {
        $message[] = 'Failed to move uploaded file.';
      }
  }
  else 
  {
      $message[] = 'No file uploaded or upload error occurred.';
  }
          
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Rumah Siswa</title>
  </head>
  <body>
    <?php include("navlist.php");?>
    

    <style>
      <?php include("advertise.css");?>
    </style>

    <section class="container">
      <h4>Aplication Form</h4>
      <form action="" method="POST" class="form" enctype="multipart/form-data">

      <?php
          if(isset($message)) 
          {
              foreach($message as $msg) 
            {
               echo '<div class="message">'.$msg.'</div>';
            }
          }
      ?>

        <div class="input-box">
          <label>Title</label>
          <input type="text" name="title" placeholder="Enter Title" required />
        </div>

        <div class="input-box">
          <label>Description</label>
          <input type="text" name="description" placeholder="Enter Description" required />
        </div>

        <div class="input-box">
          <div class="input-box">
            <label>Phone Number</label>
            <input type="text" name="phone_num" placeholder="Enter phone number" required />
          </div>
        </div>

        <div class="input-box address">
          <label>Address</label>
          <input type="text" name="address" placeholder="Enter street address" required />
          <input type="text" name="address2" placeholder="Enter street address line 2"/>

          <div class="column">
            <div class="select-box">
              <select name="state">
                <option value="Kuala Lumpur">Kuala Lumpur</option>
                <option value="Selangor">Selangor</option>
                <option value="Melaka">Melaka</option>
                <option value="Negeri Sembilan">Negeri Sembilan</option>
                <option value="Johor">Johor</option>
                <option value="Perak">Perak</option>
                <option value="Perlis">Perlis</option>
                <option value="Pahang">Pahang</option>
                <option value="Terengganu">Terengganu</option>
                <option value="Kelantan">Kelantan</option>
                <option value="Pulau Pinang">Pulau Pinang</option>
              </select>
            </div>
          </div>
          <div class="input-box address">
            <label>Price</label>
            <input type="text" name="price" placeholder="Enter Price RM" required />
          </div>
        </div>

        <div class="option-box" required>
          <h3>Type</h3>
          <div class="type-option">
            <div class="type">
              <input type="radio" name="house_type" value="Landed"/>
              <label name="house_type">Landed</label>
            </div>
            <div class="type">
              <input type="radio" name="house_type" value="Condominium/Apartment"/>
              <label name="house_type">Condominium/Apartment</label>
            </div>
            <div class="type">
              <input type="radio" name="house_type" value="Room"/>
              <label name="house_type">Room</label>
            </div>
          </div>
        </div>

        <div class="option-box">
          <h3>Furnishing</h3>
          <div class="furnishing-option">
            <div class="furnishing">
              <input type="radio" name="furnishing" value="Unfurnished"/>
              <label name="furnishing">Unfurnished</label>
            </div>
            <div class="furnishing">
              <input type="radio" name="furnishing" value="Partially Furnished"/>
              <label name="furnishing">Partially Furnished</label>
            </div>
            <div class="furnishing">
              <input type="radio" name="furnishing" value="Fully Furnished"/>
              <label name="furnishing">Fully Furnished</label>
            </div>
          </div>
        </div>

        <div class="input-box">
          <label>Upload Picture</label>
          <input type="file" name="house_img" accept="image/*" required />
        </div>

        <button type="submit" name="submit">Submit</button>
      </form>
    </section>
  </body>
</html>

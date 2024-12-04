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

// Check if house_id is provided in the URL
if(isset($_GET['house_id'])) 
{
    $house_id = $_GET['house_id'];

    // Fetch house details from the database based on house_id
    $query = "SELECT * FROM `house` WHERE house_id='$house_id'";
    $result = mysqli_query($connect, $query);

    // Check if house details found
    if(mysqli_num_rows($result) > 0) 
    {
        // Fetch house details
        $house_details = mysqli_fetch_assoc($result);
    } 
    else 
    {
        // No house details found
        echo "House details not found.";
        exit();
    }
} 
else 
{
    // house_id not provided in the URL
    echo "House ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>House Detail</title>
    
</head>

<body>

<style>
  <?php include("houseDetail.css"); ?>
</style>

<?php include("navlist.php"); ?>

<div class="card-container">
    <div class="card">
        <div class="imgbox">
            <img src="images/<?php echo $house_details['house_img']; ?>" alt="<?php echo $house_details['title']; ?>"/>
        </div>
        <div class="detail">
            <h2><?php echo $house_details['title']; ?></h2>
            <h3>PRICE : RM<?php echo $house_details['price']; ?></h3>
            <p>DESCRIPTION : <?php echo $house_details['description']; ?></p>
            <p>PHONE NUMBER : +6<?php echo $house_details['phone_num']; ?></p>
            <p>ADDRESS : <?php echo $house_details['address']; ?></p>
            <p>ADDRESS 2 : <?php echo $house_details['address2']; ?></p>
            <p>STATE : <?php echo $house_details['state']; ?></p>
            <p>HOUSE TYPE : <?php echo $house_details['house_type']; ?></p>
            <p>FURNISHING : <?php echo $house_details['furnishing']; ?></p>
        </div>
    </div>
</div>

</body>
</html>


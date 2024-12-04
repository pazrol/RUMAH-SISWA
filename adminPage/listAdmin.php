<?php
session_start(); // Start the session
// Call file to connect server Rumah Siswa
include("../header.php");

// Logout functionality
if (isset($_GET['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Rumah Siswa</title>
</head>

<body>
<?php include("../navlist.php")?>

<div class="container">
  <?php
  if (isset($_GET["msg"])) 
  {
    $msg = $_GET["msg"];
    echo '<div class="alert alert-warning">' . $msg . '</div>';
  }
  ?>
  <a href="addUser.php" class="btn btn-dark mb-3">Add New</a>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Position</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM `user_form`";
      $result = mysqli_query($connect, $sql);
      while ($row = mysqli_fetch_assoc($result)) 
      {
      ?>
        <tr>
          <td><?php echo $row["user_id"] ?></td>
          <td><?php echo $row["name"] ?></td>
          <td><?php echo $row["user"] ?></td>
          <td><?php echo $row["password"] ?></td>
          <td><?php echo $row["position"] ?></td>
          <td>
            <a href="editUser.php?id=<?php echo $row["user_id"] ?>" class="btn btn-primary">Edit</a>
            <a href="deleteUser.php?id=<?php echo $row["user_id"] ?>" class="btn btn-danger">Delete</a>
          </td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>

</body>

</html>


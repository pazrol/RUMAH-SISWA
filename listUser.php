<?php
session_start(); // Start the session
// Call file to connect server Rumah Siswa
include("header.php");

// Logout functionality
if (isset($_GET['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("location: login.php");
    exit();
}

//Look for a valid user id, either through GET or POST
if ((isset($_GET['id'])) && (is_numeric($_GET['id'])))
{
    $id = $_GET['id'];
}
else if ((isset($_POST['id'])) && (is_numeric($_POST['id'])))
{
    $id = $_POST['id'];
}
else
{
    echo '<p class = "error">This page has been accessed in error.</p>';
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
  <style>
    <?php include('listUser.css'); ?>
  </style>


</head>

<body>
  <?php include("navlist.php"); ?>

  <div class="container">
    <a href="addUser.php?id=<?php echo $id ?>" class="btn btn-dark mb-3">Add New</a>
    <h2>User List</h2>
    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Password</th>
          <th scope="col">Position</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `user_form` WHERE user_type = 'user'";
        $result = mysqli_query($connect, $sql);
        while ($row2 = mysqli_fetch_assoc($result)) 
        {
        ?>
          <tr>
            <td align="center"><?php echo $row2["user_id"] ?></td>
            <td align="center"><?php echo $row2["name"] ?></td>
            <td align="center"><?php echo $row2["user"] ?></td>
            <td align="center"><?php echo $row2["password"] ?></td>
            <td align="center"><?php echo $row2["position"] ?></td>
            <td align="center">
              <a href="editUser.php?editid=<?php echo $row2["user_id"] ?>&id=<?php echo $id ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row2['user_id']; ?>);" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="container">
    <h2>Admin List</h2>
    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Password</th>
          <th scope="col">Position</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `user_form` WHERE user_type = 'admin'";
        $result = mysqli_query($connect, $sql);
        while ($row2 = mysqli_fetch_assoc($result)) 
        {
        ?>
          <tr>
            <td align="center"><?php echo $row2["user_id"] ?></td>
            <td align="center"><?php echo $row2["name"] ?></td>
            <td align="center"><?php echo $row2["user"] ?></td>
            <td align="center"><?php echo $row2["password"] ?></td>
            <td align="center"><?php echo $row2["position"] ?></td>
            <td align="center">
              <a href="editUser.php?editid=<?php echo $row2["user_id"] ?>&id=<?php echo $id ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row2['user_id']; ?>);" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Popup HTML -->
  <div id="popup" class="popup">
    <div class="popup-content">
      <p>Are you sure you want to delete this user?</p>
      <input type="hidden" id="deleteUserId">
      <div class="popup-buttons">
        <button class="primary" onclick="confirmDeleteUser()">Yes</button>
        <button class="secondary" onclick="cancelDelete()">No</button>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(userId) {
      document.getElementById('popup').style.display = 'block';
      document.getElementById('deleteUserId').value = userId;
    }

    function cancelDelete() {
      document.getElementById('popup').style.display = 'none';
    }

    function confirmDeleteUser() {
      var userId = document.getElementById('deleteUserId').value;
      window.location.href = "deleteUser.php?deleteid=" + userId + "&id=<?php echo $id ?>";
    }
  </script>-

</body>
</html>

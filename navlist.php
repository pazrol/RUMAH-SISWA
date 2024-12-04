<!-- CSS Link -->
<style>
        <?php include('navlist.css'); ?>
    </style>

<?php
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

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link rel="stylesheet" href="style.css" />
    <title>Navlist</title>
  </head>

<header>
    <div class="content flex_space">
        <div class="logo">
            <img src="RUMAH SISWA LOGO.png" alt="" />
        </div>

        <?php
        $q = "SELECT * FROM user_form WHERE user_id = $id";

        $result = @mysqli_query ($connect, $q); //Run the query

        if($result)
        {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            //check user is admin
            if ($row['user_type'] == 'admin')
            {
                echo '<div class="navlinks">
                <ul id="menulist">
                    <li><a href="homepage.php?id='.$row['user_id'].'">home</a></li>
                    <li><a href="aboutUs.php?id='.$row['user_id'].'">About Us</a></li>
                    <li><a href="house.php?id='.$row['user_id'].'">houses</a></li>                                  
                    <li><a href="profile.php?id='.$row['user_id'].'">profile</a></li>

                    <!-- Dropdown for admin -->
                    <li class="dropdown">
                        <a class="dropbtn" onclick="myFunction()"><button>ADMIN</button></a>
                        <ul id="adminDropdown" class="dropdown-content">
                            <li><a href="postlist.php?id='.$row['user_id'].'">post</a></li>
                            <li><a href="listUser.php?id='.$row['user_id'].'">user</a></li>
                        </ul>
                    </li>

                    <!-- If user clicks the logout button -->
                    <li><a href="?logout=true">log out</a></li>
                </ul>
                
            </div>';
            }
            else 
            {
                echo '<div class="navlinks">
                <ul id="menulist">
                    <li><a href="homepage.php?id='.$row['user_id'].'">home</a></li>
                    <li><a href="aboutUs.php?id='.$row['user_id'].'">About Us</a></li>
                    <li><a href="house.php?id='.$row['user_id'].'">houses</a></li>                                  
                    <li><a href="profile.php?id='.$row['user_id'].'">profile</a></li>
                    <!-- If user clicks the logout button -->
                    <li><a href="?logout=true">log out</a></li>
                    <li><a href="advertise.php?id='.$row['user_id'].'"><button class="primary-btn">ADVERTISE NOW !</button></a></li>
                </ul>
                <span class="fa fa-bars" onclick="menutoggle()"></span>
            </div>';
            }

        }
        ?>

        

    </div>
</header>


<script>
    // Function to toggle the dropdown
    function myFunction() {
  document.getElementById("adminDropdown").classList.toggle("show");
}

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) 
    {
        if (!event.target.matches('.dropbtn')) 
        {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) 
            {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) 
                {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>


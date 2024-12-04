<?php
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet"/>
    <title>Rumah Siswa</title>
</head>
<body>
<?php include("navlist.php"); ?>
<style>
<?php include("house.css")?>
</style>

<section class="section__container popular__container">
    <h2 class="section__header">Find Your House Now!</h2>
    <div class="popular__grid">
        <?php
        // Construct the query based on user search preferences
        $query = "SELECT * FROM `house` WHERE status='approved'";

        // Check if any preferences are provided
        if (isset($_GET['state']) && $_GET['state'] != '' ||
            isset($_GET['house_type']) && $_GET['house_type'] != '' ||
            isset($_GET['furnishing']) && $_GET['furnishing'] != '') 
            {

            $query .= " AND ";

            $conditions = [];
            if (isset($_GET['state']) && $_GET['state'] != '') 
            {
                $conditions[] = "state = '" . $_GET['state'] . "'";
            }
            if (isset($_GET['house_type']) && $_GET['house_type'] != '') 
            {
                $conditions[] = "house_type = '" . $_GET['house_type'] . "'";
            }
            if (isset($_GET['furnishing']) && $_GET['furnishing'] != '') 
            {
                $conditions[] = "furnishing = '" . $_GET['furnishing'] . "'";
            }

            $query .= implode(" AND ", $conditions);
        }

        $result = mysqli_query($connect, $query);

        // Check if there are any houses found
        if (mysqli_num_rows($result) > 0) 
        {
            // Loop through each row in the result set
            while ($row = mysqli_fetch_assoc($result)) 
            {
                ?>
                <!-- House Card -->
                <div class="house_card">
                    <img src="images/<?php echo $row['house_img']; ?>"
                         alt="<?php echo $row['title']; ?>"/>
                    <div class="popular__content">
                        <div class="popular__card__header">
                            <h3><?php echo $row['title']; ?></h3>
                            <h4> State : <?php echo $row['state']; ?></h4>
                            <h4> House Type : <?php echo $row['house_type']; ?></h4>
                            <h4> Furnishing : <?php echo $row['furnishing']; ?></h4>
                        </div>
                        <p>RM <?php echo $row['price']; ?></p>
                        <a href="housedetail.php?house_id=<?php echo $row['house_id']; ?>&id=<?php echo $id; ?>"
                           class="more_btn">More Information</a>
                    </div>
                </div>
                <!-- End of House Card -->
                <?php
            }
        } 
        else 
        {
            echo "No houses found.";
        }
        ?>
    </div>
</section>
</body>
</html>

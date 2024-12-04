<?php
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

// Look for a valid user id, either through GET or POST
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
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Retrieve user preferences 
$state = isset($_GET['state']) ? $_GET['state'] : '';
$house_type = isset($_GET['house_type']) ? $_GET['house_type'] : '';
$furnishing = isset($_GET['furnishing']) ? $_GET['furnishing'] : '';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rumah Siswa</title>
    <!-- For slide adv-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- CSS Link -->
    <style>
        <?php include('homepage.css'); ?>
    </style>

    <?php include("navlist.php"); ?>
    
    <section id="home">
    <section class="home">
        <div class="content">
            <div class="owl-carousel owl-theme">
                <?php
                // Fetch data from the database with a limit of 3
                $query = "SELECT `house_id`, `title`, `description`, `house_img` FROM `house` LIMIT 3";
                $result = mysqli_query($connect, $query);

                if (mysqli_num_rows($result) > 0) 
                {
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        ?>
                        <div class="item">
                            <img src="images/<?php echo $row['house_img']; ?>" alt=""/>
                            <div class="text">
                                <h1><?php echo $row['title']; ?></h1>
                                <p><?php echo $row['description']; ?></p>
                                <div class="flex">
                                    <a href="housedetail.php?house_id=<?php echo $row['house_id']; ?>&id=<?php echo $id;?>" class="primary-btn">More Information</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } 
                else
                {
                    echo "No houses found.";
                }
                ?>
            </div>
        </div>
    </section>
</section>

<!-- Search form -->
<section class="book">
    <form action="house.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="text">
            <h1><span>Find Your</span> House Now!</h1>
        </div>

        <label>State</label>
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

        <label>House Type</label>
        <select name="house_type">
            <option value="Landed">Landed</option>
            <option value="Condominium/Apartment">Condominium/Apartment</option>
            <option value="Room">Room</option>
        </select>

        <label>House Type</label>
        <select name="furnishing">
            <option value="Unfurnished">Unfurnished</option>
            <option value="Partially Furnished">Partially Furnished</option>
            <option value="Fully Furnished">Fully Furnished</option>
        </select>
        <button type="submit">Find Now</button>
    </form>
</section>

<!--House Adv Slide Show-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
            navText: [
                "<i class='fa fa-chevron-left'></i>",
                "<i class='fa fa-chevron-right'></i>",
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 1,
                },
                1000: {
                    items: 1,
                },
            },
        });
    });
</script>
<!-- End of House Adv Slide Show-->
</body>

</html>

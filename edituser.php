<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

// Include the database connection
require_once "database.php";

// Fetch the officials from the database
$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $users_id = $row["users_id"];
    $fullName = $row["firstName"] . ' ' . $row["lastName"];
    $age = $row["age"];
    $sex = $row["sex"];
    $contact = $row["contact"];
    $address = $row["address"];
    $users_profile = $row["users_profile"];
    $username = $row["username"];
}

$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBarangay</title>

    <!--stylesheet-->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="edit-user.css">
    <link rel="stylesheet" href="profile.css">

    <style>
        .main-page .edit-form #editProfile {
        background-color: #c8c6c6;
    }
    </style>

    <!--script-->
    <script src="scriptt.js" defer></script>
</head>

<body>
<div class="bg-photo">
        <img src="images/background.jpg" alt="">
    </div>
    <div class="homepage">
        <div class="menu" id="menu">
            <div class="menu-header">
                <img src="images/logo.png" alt="" onclick="logo1()">
                <address>Brgy. Libas, <br> Lavezares, N. Samar</address>
            </div>
            <div class="menu-selection">
                <h3>DASHBOARD</h3>
                <form action="home.php" method="post">
                    <button type="submit">Dashboard</button>
                </form>
                <h3>MENU</h3>
                <form action="officials&staff.php" method="post">
                    <button type="submit">Barangay Officials & Staffs</button><br>
                </form>
                <form action="residents-records.php" method="post">
                    <button type="submit">Residents Records</button><br>
                </form>
                <form action="certificate&clearance.php" method="post">
                    <button type="submit">Certificate and Clearance</button><br>
                </form>
                <form action="announcement.php" method="post">
                    <button type="submit">Announcements</button><br>
                </form>
                <form action="about.php" method="post">
                    <button type="submit">About</button><br>
                </form>
            </div>
        </div>
        <div class="main-page" id="main-page">
        <div class="header">
                <i class="bi bi-filter-left" onclick="menu()"></i>
                <svg xmlns="http://www.w3.org/2000/svg" width="80" onclick="menu()" height="40" fill="#fff"
                    class="bi bi-filter-left" viewBox="0 0 16 16">
                    <path
                        d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                </svg>
                <h1>eBARANGAY</h1>
                <div class="space"></div>
                <div class="user-profile-header"
                    style="width: 8.1vh; height: 8.1vh; background-color: white; border-radius: 50px; margin-right: 2rem; overflow: hidden; border-radius: 50%;"
                    onclick="userProfile()">
                    <img src="<?php echo $users_profile ?>" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div id="loading-screen">
                <div class="loading-line"></div>
            </div>
            <div class="user" id="user">
                <div class="user-area">
                    <div class="user-info">
                        <div class="user-info1">
                            <h2>ACCOUNT</h2>
                            <hr>
                            <p>Name: <?php echo $fullName ?></p>
                            <p>Age: <?php echo $age ?></p>
                            <p>Gender: <?php echo $sex ?></p>
                            <p>Contact: <?php echo $contact ?></p>
                            <form action="edituser.php">
                                <button class="edit" type="submit">Edit</button>
                            </form>
                        </div>
                        <div class="space"></div>
                        <form action="logout.php">
                            <button type="submit">LOGOUT</button>
                        </form>
                    </div>
                    <div class="user-profile">
                        <div class="user-profile1">
                            <img src="<?php echo $users_profile ?>" alt="">
                        </div>
                        <div class="username"><?php echo $username ?></div>
                        <div class="space"></div>
                    </div>
                </div>
            </div>
            <div class="edit-form-sec">
                <div class="edit-form">
                    <div class="account-selection-area">
                        <div class="account-selection">
                            <nav>
                                <button id="editProfile"
                                    onclick="editProfile()">Edit Profile</button>
                                <button id="changeUser" onclick="changeUsername()">Change
                                    Username</button>
                                <button id="changePass" onclick="changePass()">Change
                                    Password</button>
                            </nav>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="profileform-area">
                    <div class="profile-form" id="editprofile">
                        <div class="section">
                            <h1>EDIT PROFILE</h1>
                            <form action="update-user-info.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="users_id" id="users_id" value="<?php echo $users_id ?>">
                                <div class="user-image">
                                    <div class="avatar" id="avatar">
                                        <img src="images/avatar.jpg" alt="">
                                    </div>
                                    <div class="space"></div>
                                    <label for="photo" class="upload-btn">Upload photo</label><br>
                                    <input type="file" id="photo" name="photo" accept="image/*"><br>

                                    <script>
                                        document.getElementById('photo').addEventListener('change', function (event) {
                                            const preview = document.getElementById('avatar');
                                            const file = event.target.files[0];
                                            const reader = new FileReader();

                                            reader.addEventListener('load', function () {
                                                const image = new Image();
                                                image.src = reader.result;
                                                preview.innerHTML = '';
                                                preview.appendChild(image);
                                            }, false);

                                            if (file) {
                                                reader.readAsDataURL(file);
                                            } else {
                                                preview.innerHTML = 'No image selected';
                                            }
                                        });
                                    </script>
                                </div>
                                <div class="space"></div>
                                <div class="user-infoo">
                                    <label for="fname">First name</label>
                                    <input id="fname" name="fname" required>
                                    <label for="lname">Last name</label>
                                    <input id="lname" name="lname" required>
                                    <label for="age">Age</label>
                                    <input id="age" name="age" required>
                                    <label for="sex">Sex</label>
                                    <select name="sex" id="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="contact">Contact No.</label><br>
                                    <input id="contact" name="contact" required>
                                    <label for="address">Current Address</label>
                                    <input id="address" name="address" required>
                                    <div class="button">
                                        <button style=" margin-top: -1.3rem; " type="submit" name="submit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <footer>eBARANGAY &copy 2024 </footer>
        </div>
</body>

</html>

<script>
        // Add this to your existing script.js
document.addEventListener("DOMContentLoaded", function() {
    const loadingScreen = document.getElementById('loading-screen');
    const content = document.getElementById('content');
    
    // Adding a delay to ensure the loading screen stays visible for a brief moment
    setTimeout(() => {
        loadingScreen.style.display = 'none';
        content.style.display = 'block';
    }, 400); // Adjust the delay as necessary (1500 milliseconds in this example)
});
</script>
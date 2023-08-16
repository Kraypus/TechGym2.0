<?php
require 'database.php';
require 'login.php';
include 'submitpfp.php';
shell_exec("submitpfp.php");

$mysqli = require __DIR__ . "/database.php";

// Check if the user ID is present in the URL
if (isset($_GET["user_id"])) {
    $userId = $_GET["user_id"];

    // Fetch displayed user details
    $displayedUserQuery = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
    $displayedUserQuery->bind_param("i", $userId);
    $displayedUserQuery->execute();
    $displayedUserResult = $displayedUserQuery->get_result();
    $displayedUser = $displayedUserResult->fetch_assoc();
    $displayedUserQuery->close();

    // Check if the displayed user exists
    if ($displayedUser) {
        // Assign displayed user details to new variables
        $displayedUserId = $displayedUser['id'];
        $displayedUserImage = "img/" . $displayedUser['image'];
        $displayedUsername = $displayedUser['username'];
        $displayedUserRole = $displayedUser['role'];
        $displayedUserEmail = $displayedUser['email'];

        // Assign displayed user skills
        $displayedUserSkills = [
            ['name' => 'GYM', 'percentage' => 90],
            ['name' => 'PHP', 'percentage' => 80],
            ['name' => 'CSS', 'percentage' => 75],
            ['name' => 'JavaScript', 'percentage' => 50]
        ];

        // Assign displayed user languages
        $displayedUserLanguages = [
            ['name' => 'Serbian', 'percentage' => 100],
            ['name' => 'English', 'percentage' => 40]
        ];
    } else {
        // Display an error message or handle accordingly
    }
}

// Fetch the currently logged-in user's details if available
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $userQuery = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
    $userQuery->bind_param("i", $userId);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    $user = $userResult->fetch_assoc();
    $userQuery->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/custom.css?<?=time()?>" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="http://localhost/TechGym/js/validation.js" defer></script>
    <script src="http://localhost/TechGym/js/autosize-dist/autosize.js"></script>
    
    <style>
        body, h1, h2, h3, h4, h5 {font-family: "Raleway", sans-serif}

        /* Forms */
        #title, #content {
            border: none;
            display: inline;
            font-family: inherit;
            font-size: inherit;
            padding: none;
            width: auto;
            resize: none;
            background: transparent;
            color: white;
            border-radius: 12px;
        }

        #content {
            width:100%;
        }

        textarea {
            resize: none;
            width:100%;
        }

        .input.right:active {
            color:red
        }

        div.top{
            display: block;
        }

        p {
             color: white;
        }

        h2 {
             color: black;
        }

    </style>
</head>

<body>

    <!-- Adjust behaviour of "#" links -->
    <script>
    // Adjust scroll position when a navigation link is clicked
    document.addEventListener("DOMContentLoaded", function() {
        var navLinks = document.querySelectorAll(".navbar a");

        // Iterate over each navigation link and attach a click event listener
        navLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            // Get the target element ID from the link's href attribute
            var targetId = link.getAttribute("href");

            // Check if the target element ID starts with "#"
            if (targetId && targetId.startsWith("#")) {
            event.preventDefault(); // Prevent the default link behavior

            // Get the target page from the data-page attribute
            var targetPage = link.getAttribute("data-page");

            // Check if the target page is null or empty
            if (targetPage === null || targetPage.trim() === "") {
                // Scroll to the target element without redirecting or delay
                scrollToElement(targetId);
            } else if (targetPage === window.location.pathname) {
                // Check if the target page is index.php
                if (targetPage === "index.php") {
                // Scroll to the target element with a small delay
                setTimeout(function() {
                    scrollToElement(targetId);
                }, 500); // Adjust the delay time as needed
                } else {
                // Scroll to the target element without redirecting or delay
                scrollToElement(targetId);
                }
            } else {
                // Redirect to the target page and store the target element ID
                scrollToTargetElement(targetId, targetPage);
            }
            }
        });
        });
    });

    // Function to scroll to the target element
    function scrollToElement(targetId) {
        var targetElement = document.querySelector(targetId);
        if (targetElement) {
        // Set the custom scroll position adjustment (in pixels)
        var customScrollAdjustment = 78; // Modify this value as needed

        // Calculate the adjusted scroll position with the custom adjustment
        var scrollPosition = targetElement.offsetTop - customScrollAdjustment;

        // Scroll to the target element with the adjusted scroll position
        window.scrollTo({
            top: scrollPosition,
            behavior: "smooth" // Optionally, use smooth scrolling behavior
        });
        }
    }

    // Function to scroll to the target element after redirecting
    function scrollToTargetElement(targetId, targetPage) {
        // Store the target element ID in session storage
        sessionStorage.setItem("scrollTarget", targetId);

        // Redirect the user to the target page
        window.location.href = targetPage;
    }

    // After the page loads, check if there is a stored target element ID in session storage
    window.addEventListener("load", function() {
        var scrollTarget = sessionStorage.getItem("scrollTarget");
        if (scrollTarget) {
        // Clear the stored target element ID from session storage
        sessionStorage.removeItem("scrollTarget");

        // Scroll to the target element with a small delay
        setTimeout(function() {
            scrollToElement(scrollTarget);
        }, 500); // Adjust the delay time as needed
        }
    });
    </script>

    <!-- Dynamically adjusting contents below the Navbar -->
    <script>
        let resizeTimer;

        // Adjusts .content padding-top based on Navbar height
        function adjustContentPadding() {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            document.querySelector('.content').style.paddingTop = navbarHeight + 'px';
        }

        // On load
        window.addEventListener('load', adjustContentPadding);

        // When window resizes
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            adjustContentPadding();
            
            // Continue function after resizing stopped
            resizeTimer = setTimeout(() => {
                adjustContentPadding();
                resizeTimer = null;
            }, 300); // ~for how long
        });
    </script>

    <!-- Dropdown fade -->
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          var dropdowns = document.querySelectorAll(".dropdown");

          dropdowns.forEach(function(dropdown) {
              var dropdownContent = dropdown.querySelector(".dropdown-content");
              var timeoutId;

              dropdown.addEventListener("mouseenter", function() {
                  clearTimeout(timeoutId);
                  dropdownContent.style.opacity = "1";
                  dropdownContent.style.visibility = "visible";
              });

              dropdown.addEventListener("mouseleave", function() {
                  timeoutId = setTimeout(function() {
                      dropdownContent.style.opacity = "0";
                      dropdownContent.style.visibility = "hidden";
                  }, 200);
              });
          });
      });
    </script>

        <!-- Log in modal -->
        <div id="login-modal" class="modal">
          <div class="modal-content section w3-card-4">
      
            <br>
              <form action="login.php" method="post" id="log-in" novalidate>

                <div class="inputdiv">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="inputdiv">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>

                <button type="submit" name="log-in" value="Log in" class="fa-solid fa-right-to-bracket profilesave fa-2xl savemodal"></button>
                
            </form>
            <span id="login-modal-close-button" class="modal-close-button">&times;</span>
            <br><br>

            <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                        <h2 class="sectiontitle"> Log in </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register modal -->
        <div id="register-modal" class="modal">
          <div class="modal-content section w3-card-4">
            <br>
            <form action="process-signup.php" method="post" id="signup" novalidate>

            <div class="inputdiv">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
            </div>

            <div class="inputdiv">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname">
            </div>

            <div class="inputdiv">
                <label for="username">Username: *</label>
                <input type="text" id="username" name="username">
            </div>

            <div class="inputdiv">
                <label for="email">Email: *</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="inputdiv">
                <label for="password">Password: *</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="inputdiv">
                <label for="confirm_password">Confirm Password: *</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>

            <button type="submit" name="register" value="Register" class="fa-solid fa-user-plus profilesave fa-2xl savemodal"></button>
          </form>
          <span id="register-modal-close-button" class="modal-close-button">&times;</span>
          <br><br>
            <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                        <h2 class="sectiontitle"> Register </h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Edit modal -->
        <div id="edit-modal" class="modal">
        <div class="modal-content section w3-card-4">
          <form class="form" id = "form" action="" enctype="multipart/form-data" method="post"><br><br>
          <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
          <div class="upload">
              <img src="img/<?php echo $user['image']; ?>" id = "image">

              <div class="rightRound" id = "upload">
              <input type="file" name="fileImg" id = "fileImg" accept=".jpg, .jpeg, .png">
              <i class = "fa fa-camera"></i>
              </div>

              <div class="leftRound" id = "cancel" style = "display: none;">
              <i class = "fa fa-times"></i>
              </div>

              <div class="rightRound" id = "confirm" style = "display: none;">
              <input type="submit">
              <i class = "fa fa-check"></i>
              </div>
          </div>
          </form>
          <br>
          <form action="process-update-account.php" method="post" id="update-profile" novalidate="novalidate">
              <div class="inputdiv">
                  <label for="name">Name:</label>
                  <input type="text" name="name" id="name" placeholder="<?php echo $user['name']; ?>">
              </div>


              <div class="inputdiv">
                  <label for="surname">Surname:</label>
                  <input type="text" name="surname" id="surname" placeholder="<?php echo $user['surname']; ?>">
              </div>


              <div class="inputdiv">
                  <label for="username">Username:</label>
                  <input type="text" name="username" id="username" placeholder="<?php echo $user['username']; ?>">
              </div>

              <button type="submit" name="updateProfile" value="Save" class="fa-solid fa-floppy-disk profilesave fa-2xl savemodal"></button>
          </form>
          <br><hr><br>
          
          <form action="process-update-email.php" method="post" id="update-email" novalidate="novalidate">
              <div class="inputdiv">
                  <label for="email">Email:</label>
                  <input type="email" name="email" id="email" placeholder="<?php echo $user['email']; ?>">
              </div>

              <div class="inputdiv">
                  <label for="confirm_email">Confirm email:</label>
                  <input type="email" name="confirm_email" id="confirm_email" placeholder="">
              </div>

              <button type="submit" name="updateEmail" value="Save" class="fa-solid fa-floppy-disk profilesave fa-2xl savemodal"></button>
          </form>
          <br><hr><br>

          <form action="process-update-password.php" method="post" id="update-password" novalidate="novalidate">
              <div class="inputdiv">
                  <label for="password">Password:</label>
                  <input type="password" name="password" id="password" placeholder="">
              </div>

              <div class="inputdiv">
                  <label for="confirm_password">Confirm password:</label>
                  <input type="password" name="confirm_password" id="confirm_password" placeholder="">
              </div>

              <button type="submit" name="updatePassword" value="Save" class="fa-solid fa-floppy-disk profilesave fa-2xl savemodal"></button>
          </form>
          <br><br><hr>
            <button class="edituser">ADVANCED</button><br>
            <br>
            <button class="edituser">INTERMEDIATE</button><br>
            <br>
            <button class="edituser">BEGINNER</button><br>
            <br><br>
            <span id="edit-modal-close-button" class="modal-close-button">&times;</span>
            <br><br>
          <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                        <h2 class="sectiontitle"> Settings </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar -->
        <ul class="navbar">
            <li class="dropdown">
                <a href="#index" data-page="index.php" class="dropbtn active"><i class="fa fa-fw fa-home"></i> Home</a>
                <div class="dropdown-content" data-dropdown="home">
                    <div>
                        <a href="#equipment" data-page="index.php"><i class="fa-solid fa-dumbbell"></i> Equipment</a>
                    </div>
                    <div>
                        <a href="#trainers" data-page="index.php"><i class="fa-solid fa-users"></i> Trainers</a>
                    </div>
                    <div>
                        <a href="#location" data-page="index.php"><i class="fa-solid fa-location-dot"></i> Location</a>
                    </div>
                    <div>
                        <a href="#plans" data-page="index.php"><i class="fa-solid fa-coins"></i> Plans</a>
                    </div>
                    <div>
                        <a href="#aboutus" data-page="index.php"><i class="fa-solid fa-circle-info"></i> About us</a>
                    </div>
                </div>
            </li>

            <li class="dropdown">
                <a href="#profiles" data-page="profiles.php" class="dropbtn"><i class="fa fa-fw fa-users"></i> Profiles</a>
                <div class="dropdown-content">
                    <div>
                        <a href="#admins" data-page="profiles.php"><i class="fa-solid fa-dumbbell"></i> Admins</a>
                    </div>
                    <div>
                        <a href="#trainers" data-page="profiles.php"><i class="fa-solid fa-users"></i> Trainers</a>
                    </div>
                    <div>
                        <a href="#users" data-page="profiles.php"><i class="fa-solid fa-location-dot"></i> Users</a>
                    </div>
                </div>
            </li>

            <li>
                <a href="#routines" data-page="routines.php"><i class="fa-solid fa-table"></i> Routines</a>
            </li>

            <?php if (isset($user)): ?><li class="dropdown"><a href="#" class="dropbtn">
                    <?php if ($user['role'] == "user"): ?>
                        <i class="fa-solid fa-user"></i>
                    <?php elseif ($user['role'] == "trainer"): ?>
                        <i class="fa-solid fa-user-ninja"></i>
                    <?php elseif ($user['role'] == "admin"): ?>
                        <i class="fa-solid fa-user-secret"></i>
                    <?php else: ?>
                        <i class="fa-solid fa-user"></i>
                    <?php endif; ?>
                        <?php echo $user['username']; ?></a>

                <div class="dropdown-content">
                    <div>
                        <a href="profile.php"><i class="fa-solid fa-user-pen"></i> Profile</a>
                    </div>
                    <div>
                        <a href="#" id="edit-btn"><i class="fa-solid fa-user-gear"></i> Settings</a>
                    </div>
                </div>
            </li>

            <li>
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
            </li>
            <?php else: ?>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-dropdown-button="nouser"><i class="fa-solid fa-user"></i></a>
                <div class="dropdown-content" data-dropdown="nouser">
                    <div>
                        <a href="#" id="login-btn"><i class="fa-solid fa-right-to-bracket"></i> Log in</a>
                    </div>
                    <div>
                        <a href="#" id="register-btn"><i class="fa-solid fa-user-plus"></i> Register</a>
                    </div>
                </div>
            </li>
            <?php endif; ?>
        </ul>

    <!-- Page container -->
    <div class="w3-content w3-margin-top content" style="max-width:1400px;">
        <!-- Grid -->
        <div class="w3-row-padding">
            <!-- Left column -->
            <div class="w3-third">
                <div class="box w3-text-grey w3-card-4">
                    <div class="w3-display-container">
                        <img src="<?php echo $displayedUserImage; ?>" style="width:100%" class="pfp section">
                        <div class="w3-display-bottomleft w3-container w3-text-black">
                            <h2 class="pfpname"><?php echo $displayedUsername; ?></h2>
                        </div>
                    </div>
                    <div class="profileuser">
                        <p style="text-transform: capitalize;"><i class="fa fa-briefcase fa-fw w3-margin-right w3-large red"></i><?php echo $displayedUserRole; ?></p>
                        <p><i class="fa fa-home fa-fw w3-margin-right w3-large red"></i>Location</p>
                        <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large red"></i><?php echo $displayedUserEmail; ?></p>
                        <p><i class="fa fa-phone fa-fw w3-margin-right w3-large red"></i>Phone number</p>
                        <hr>

                        <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right red"></i>Skills</b></p>
                        <?php foreach ($displayedUserSkills as $skill): ?>
                            <p><?php echo $skill['name']; ?></p>
                            <div class="w3-light-grey w3-round-xlarge w3-small">
                                <div class="w3-container w3-center w3-round-xlarge backred" style="width:<?php echo $skill['percentage']; ?>%"><?php echo $skill['percentage']; ?>%</div>
                            </div>
                        <?php endforeach; ?>

                        <br>

                        <p class="w3-large w3-text-theme"><b><i class="fa fa-globe fa-fw w3-margin-right red"></i>Languages</b></p>
                        <?php foreach ($displayedUserLanguages as $language): ?>
                            <p><?php echo $language['name']; ?></p>
                            <div class="w3-light-grey w3-round-xlarge">
                                <div class="w3-container w3-center w3-round-xlarge backred" style="height:24px;width:<?php echo $language['percentage']; ?>%"></div>
                            </div>
                        <?php endforeach; ?>

                        <br>
                    </div>
                </div><br>
            </div><!-- End left column -->
            <!-- Right column -->
            <div class="w3-twothird">
                <?php
                // Fetch the first content and title
                $displayedUserContentQuery1 = $mysqli->prepare("SELECT * FROM user_profile WHERE user_id = ? AND form_id = ?");
                $formId1 = 1;
                $displayedUserContentQuery1->bind_param("ii", $displayedUserId, $formId1);
                $displayedUserContentQuery1->execute();
                $displayedUserContentResult1 = $displayedUserContentQuery1->get_result();
                $displayedUserContent1 = "";
                $displayedUserTitle1 = "";

                if ($displayedUserContentResult1->num_rows > 0) {
                    $displayedUserContentData1 = $displayedUserContentResult1->fetch_assoc();
                    $displayedUserContent1 = $displayedUserContentData1['content'];
                    $displayedUserTitle1 = $displayedUserContentData1['title'];
                }

                $displayedUserContentQuery1->close();

                // Fetch the second content and title
                $displayedUserContentQuery2 = $mysqli->prepare("SELECT * FROM user_profile WHERE user_id = ? AND form_id = ?");
                $formId2 = 2;
                $displayedUserContentQuery2->bind_param("ii", $displayedUserId, $formId2);
                $displayedUserContentQuery2->execute();
                $displayedUserContentResult2 = $displayedUserContentQuery2->get_result();
                $displayedUserContent2 = "";
                $displayedUserTitle2 = "";

                if ($displayedUserContentResult2->num_rows > 0) {
                    $displayedUserContentData2 = $displayedUserContentResult2->fetch_assoc();
                    $displayedUserContent2 = $displayedUserContentData2['content'];
                    $displayedUserTitle2 = $displayedUserContentData2['title'];
                }

                $displayedUserContentQuery2->close();

                // Fetch the third content and title
                $displayedUserContentQuery3 = $mysqli->prepare("SELECT * FROM user_profile WHERE user_id = ? AND form_id = ?");
                $formId3 = 3;
                $displayedUserContentQuery3->bind_param("ii", $displayedUserId, $formId3);
                $displayedUserContentQuery3->execute();
                $displayedUserContentResult3 = $displayedUserContentQuery3->get_result();
                $displayedUserContent3 = "";
                $displayedUserTitle3 = "";

                if ($displayedUserContentResult3->num_rows > 0) {
                    $displayedUserContentData3 = $displayedUserContentResult3->fetch_assoc();
                    $displayedUserContent3 = $displayedUserContentData3['content'];
                    $displayedUserTitle3 = $displayedUserContentData3['title'];
                }

                $displayedUserContentQuery3->close();

                ?>

                <div class="w3-container w3-card box w3-margin-bottom section" id="hide1"><br>
                    <div class="w3-container aboutuslist">
                        <li><p><?php echo $displayedUserContent1; ?></p></li>
                        <div class="w3-display-container" style="margin-top: 60px;"><br>
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                                <h2 class="sectiontitle"><?php echo $displayedUserTitle1; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w3-container w3-card box w3-margin-bottom section" id="hide2"><br>
                    <div class="w3-container aboutuslist">
                        <li><p><?php echo $displayedUserContent2; ?></p></li>
                        <div class="w3-display-container" style="margin-top: 60px;"><br>
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                                <h2 class="sectiontitle"><?php echo $displayedUserTitle2; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    $mysqli = require __DIR__ . "/database.php";

                    // Retrieve the user_id from the URL
                    $user_id = $_GET['user_id'];

                    // Prepare the user_id for safe use in the queries
                    $safe_user_id = $mysqli->real_escape_string($user_id);

                    // Get the user's role
                    $sql = "SELECT role FROM user WHERE id = '{$safe_user_id}'";
                    $result = $mysqli->query($sql);
                    $user = $result->fetch_assoc();

                    if ($user['role'] === 'admin' || $user['role'] === 'trainer') {
                        // Show the content only for admin and trainer
                        ?>
                        <div class="w3-container w3-card box w3-margin-bottom section"><br>
                            <div class="w3-container">
                                <?php
                                // Fetch the user's data
                                $sql = "SELECT * FROM user WHERE id = '{$safe_user_id}'";
                                $result = $mysqli->query($sql);
                                $userProfile = $result->fetch_all(MYSQLI_ASSOC);

                                // Fetch the existing data for the header, if available
                                $sql = "SELECT * FROM trainer_table WHERE form_id = 3 AND user_id = '{$safe_user_id}' AND row_id = -1";
                                $result = $mysqli->query($sql);
                                $headerRow = $result->fetch_assoc();
                                ?>
                                <form action="trainer-table.php" method="POST">
                                    <input type="hidden" name="form_id" value="3">
                                    <table class="styled-table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h5><p type="text" name="header_content1" placeholder="TITLE" class="input-icon form-title"><?php echo isset($headerRow['content1']) ? $headerRow['content1'] : ''; ?></p></h5>
                                                </th>
                                                <th>
                                                    <h5><p type="text" name="header_content2" placeholder="TITLE" class="input-icon form-title"><?php echo isset($headerRow['content2']) ? $headerRow['content2'] : ''; ?></p></h5>
                                                </th>
                                                <th>
                                                    <h5><p type="text" name="header_content3" placeholder="TITLE" class="input-icon form-title"><?php echo isset($headerRow['content3']) ? $headerRow['content3'] : ''; ?></p></h5>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Loop through the rows
                                            for ($i = 0; $i < 5; $i++) {
                                                // Fetch the existing data for the row, if available
                                                $sql = "SELECT * FROM trainer_table WHERE form_id = 3 AND user_id = '{$safe_user_id}' AND row_id = $i";
                                                $result = $mysqli->query($sql);
                                                $row = $result->fetch_assoc();
                                                ?>
                                                <tr>
                                                    <td class="aboutuslist">
                                                        <li><p name="content1[]" placeholder="INFO" class="input-icon input"><?php echo isset($row['content1']) ? $row['content1'] : ''; ?></p></li>
                                                    </td>
                                                    <td class="aboutuslist">
                                                        <li><p name="content2[]" placeholder="INFO" class="input-icon input"><?php echo isset($row['content2']) ? $row['content2'] : ''; ?></p></li>
                                                    </td>
                                                    <td class="aboutuslist">
                                                        <li><p name="content3[]" placeholder="INFO" class="input-icon input"><?php echo isset($row['content3']) ? $row['content3'] : ''; ?></p></li>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <div class="w3-container aboutuslist">
                                        <li><p><?php echo $displayedUserContent3; ?></p></li>
                                        </div>
                                        <div class="w3-display-container" style="margin-top: 60px;"><br>
                                            <div class="w3-display-bottomleft w3-container w3-text-black">
                                                <h2 class="sectiontitle"><?php echo $displayedUserTitle3; ?></h2>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

            </div>
        </div><!-- End right column -->
    </div><!-- End grid -->
</div><!-- End page container -->

    <footer class="w3-container backdarkred w3-center w3-margin-top">
        <p>Copyright &copy; FIMEK 2023; Projekt Tech Gym &trade;</p>
    </footer>

        <script type="text/javascript">
            document.getElementById("fileImg").onchange = function(){
            document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); //Preview

            document.getElementById("cancel").style.display = "block";
            document.getElementById("confirm").style.display = "block";

            document.getElementById("upload").style.display = "none";
        }

        var userImage = document.getElementById('image').src;
        document.getElementById("cancel").onclick = function(){
        document.getElementById("image").src = userImage; //Cancel

        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";

        document.getElementById("upload").style.display = "block";
        }
        </script>

        <script>
            // Close buttons
            document.querySelectorAll(".modal-close-button").forEach(function(button) {
                button.addEventListener("click", function() {
                    // Hide the parent modal
                    this.closest(".modal").style.display = "none";
                });
            });

            // Close the modal if the user clicks outside of it
            window.addEventListener("click", function(event) {
                if (event.target.classList.contains("modal")) {
                    // Hide the clicked modal
                    event.target.style.display = "none";
                }
            });

            document.addEventListener("DOMContentLoaded", function() {
                var navbar = document.querySelector(".navbar");

                navbar.addEventListener("click", function(event) {
                    if (event.target.id === "edit-btn") {
                        var editModal = document.getElementById("edit-modal");
                        openModal(editModal);
                    }
                });

                // Get the buttons for each modal
                var registerBtn = document.getElementById("register-btn");
                var loginBtn = document.getElementById("login-btn");
                var editBtn = document.getElementById("edit-btn");

                // Get the modal elements
                var registerModal = document.getElementById("register-modal");
                var loginModal = document.getElementById("login-modal");
                var editModal = document.getElementById("edit-modal");

                // Get the close buttons inside each modal
                var registerCloseButton = document.getElementById("register-modal-close-button");
                var loginCloseButton = document.getElementById("login-modal-close-button");
                var editCloseButton = document.getElementById("edit-modal-close-button");

                // Function to display the corresponding modal
                function openModal(modal) {
                    modal.style.display = "block";
                }

                // Function to hide the corresponding modal
                function closeModal(modal) {
                    modal.style.display = "none";
                }

                // Add click event listeners to the buttons
                registerBtn.addEventListener("click", function() {
                    closeModal(loginModal);
                    closeModal(editModal);
                    openModal(registerModal);
                });

                loginBtn.addEventListener("click", function() {
                    closeModal(registerModal);
                    closeModal(editModal);
                    openModal(loginModal);
                });

                editBtn.addEventListener("click", function() {
                    closeModal(registerModal);
                    closeModal(loginModal);
                    openModal(editModal);
                });

                // Add click event listeners to the close buttons
                registerCloseButton.addEventListener("click", function() {
                    closeModal(registerModal);
                });

                loginCloseButton.addEventListener("click", function() {
                    closeModal(loginModal);
                });

                editCloseButton.addEventListener("click", function() {
                    closeModal(editModal);
                });

                // Close the modal if the user clicks outside of it
                window.addEventListener("click", function(event) {
                    if (event.target === registerModal) {
                        closeModal(registerModal);
                    }
                    if (event.target === loginModal) {
                        closeModal(loginModal);
                    }
                    if (event.target === editModal) {
                        closeModal(editModal);
                    }
                });
            });
        </script>

    </body>
</html>
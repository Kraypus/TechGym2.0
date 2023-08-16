<?php
require 'database.php';
require 'login.php';
include 'submitpfp.php';

// Include the database connection file
$mysqli = require __DIR__ . "/database.php";

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $userQuery = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
    $userQuery->bind_param("i", $userId);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    $user = $userResult->fetch_assoc();
    $userQuery->close();
}

if (isset($_POST["updateUserProfile"])) {
    $userIdToUpdate = $_POST["updateUserProfile"];

    // Initialize an array to hold the column and value pairs for the UPDATE query
    $updateValues = array();
    $paramTypes = '';

    // Prepare the UPDATE query
    $updateQuery = "UPDATE user SET";

    // Check each field and add it to the UPDATE query if it's not empty or unchanged
    if (!empty($_POST["name"])) {
        $name = $_POST["name"];
        $updateQuery .= " name = ?,";
        $updateValues[] = $name;
        $paramTypes .= 's';
    }
    if (!empty($_POST["surname"])) {
        $surname = $_POST["surname"];
        $updateQuery .= " surname = ?,";
        $updateValues[] = $surname;
        $paramTypes .= 's';
    }
    if (!empty($_POST["username"])) {
        $username = $_POST["username"];
        $updateQuery .= " username = ?,";
        $updateValues[] = $username;
        $paramTypes .= 's';
    }
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        $updateQuery .= " email = ?,";
        $updateValues[] = $email;
        $paramTypes .= 's';
    }
    if (!empty($_POST["password"])) {
        $password = $_POST["password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery .= " password_hash = ?,";
        $updateValues[] = $hashedPassword;
        $paramTypes .= 's';
    }

    // Remove the trailing comma from the UPDATE query
    $updateQuery = rtrim($updateQuery, ",");

    // Add the WHERE condition to the UPDATE query
    $updateQuery .= " WHERE id = ?";

    // Add the user ID to the array of values
    $updateValues[] = $userIdToUpdate;
    $paramTypes .= 'i';

    // Prepare and execute the UPDATE query
    $updateStmt = $mysqli->prepare($updateQuery);
    $updateStmt->bind_param($paramTypes, ...$updateValues);
    $updateStmt->execute();
    $updateStmt->close();
}

// Function to display user profiles
function displayUserProfiles($role)
{
    global $mysqli, $user;

    $query = "SELECT * FROM user WHERE role = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $image = "img/" . $row['image'];
        $username = $row['username'];
        $userId = $row['id'];
        ?>
        <div class="w3-third w3-container w3-margin-bottom userProfile" id="userprofile" style="height: 267px; width: 267px;">
            <div class="w3-display-container">
                <?php if (isset($user) && $user['role'] == "admin") { ?>
                    <button class="fa fa-pencil-square-o profilesedit saveright fa-2xl edit-user-btn" data-user-id="<?php echo $userId; ?>"></button>
                <?php } ?>
                <a href="profile-displayed.php?user_id=<?php echo $userId; ?>"><img style="height: 257px;" src="<?php echo $image; ?>" class="section pfp2 profile-container"></a>
                <div class="w3-display-bottomleft w3-container w3-text-black">
                    <h2 class="pfpname"><?php echo $username; ?></h2>
                </div>
            </div>
        </div>

            <!-- Edit user modal -->
            <div id="edit-user-modal-<?php echo $userId; ?>" class="modal edit-user-modal" style="display: none;">
                <div class="modal-content section w3-card-4">
                    <!-- User image form -->
                    <form class="form" action="" enctype="multipart/form-data" method="post">
                        <br><br>
                        <input type="hidden" name="id" value="<?php echo $userId; ?>">
                        <div class="upload">
                            <img src="<?php echo $image; ?>" id="image-<?php echo $userId; ?>">
                            <div class="rightRound" id="upload-<?php echo $userId; ?>">
                                <input type="file" name="fileImg" id="fileImg-<?php echo $userId; ?>" accept=".jpg, .jpeg, .png">
                                <i class="fa fa-camera"></i>
                            </div>
                            <div class="leftRound" id="cancel-<?php echo $userId; ?>" style="display: none;">
                                <i class="fa fa-times"></i>
                            </div>
                            <div class="rightRound" id="confirm-<?php echo $userId; ?>" style="display: none;">
                                <input type="submit">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </form>
                    <br>
                    
                    <form action="" method="post" novalidate="novalidate">
                        <div class="inputdiv">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="<?php echo $row['name']; ?>">
                        </div>
                        <div class="inputdiv">
                            <label for="surname">Surname:</label>
                            <input type="text" name="surname" id="surname" placeholder="<?php echo $row['surname']; ?>">
                        </div>
                        <div class="inputdiv">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" placeholder="<?php echo $row['username']; ?>">
                        </div>
                        <div class="inputdiv">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" placeholder="<?php echo $row['email']; ?>">
                        </div>
                        <div class="inputdiv">
                            <label for="password">Password:</label>
                            <input type="text" name="password" id="password" placeholder="">
                        </div>
                        <button type="submit" name="updateUserProfile" value="<?php echo $userId; ?>" class="fa-solid fa-floppy-disk profilesave fa-2xl savemodal"></button>
                        <br><br><hr>
                    </form>

                    <form action="process-update-roles.php" method="post">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <button type="submit" name="role" value="admin" class="edituser">ADMIN</button><br>
                        <br>
                        <button type="submit" name="role" value="trainer" class="edituser">TRAINER</button><br>
                        <br>
                        <button type="submit" name="role" value="user" class="edituser">USER</button>
                    </form>
                    
                    <br><hr>
                    <form action="delete-user.php" method="post">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <button type="submit" class="edituser">DELETE USER</button><br>
                    </form>

                    <span class="modal-close-button">&times;</span>
                    <br><br>
                    <div class="w3-display-container" style="margin-top: 60px;">
                        <div class="w3-display-bottomleft w3-container w3-text-black">
                            <h2 class="sectiontitle"><?php echo $username; ?>'s settings</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User image javascript-->
            <script type="text/javascript">
            var userId = <?php echo $userId; ?>;

            document.getElementById("fileImg-<?php echo $userId; ?>").onchange = function() {
                var imagePreview = document.getElementById("image-<?php echo $userId; ?>");
                var cancelButton = document.getElementById("cancel-<?php echo $userId; ?>");
                var confirmButton = document.getElementById("confirm-<?php echo $userId; ?>");
                var uploadButton = document.getElementById("upload-<?php echo $userId; ?>");

                imagePreview.src = URL.createObjectURL(this.files[0]);
                cancelButton.style.display = "block";
                confirmButton.style.display = "block";
                uploadButton.style.display = "none";
            };

            var userImage = document.getElementById("image-<?php echo $userId; ?>").src;
            document.getElementById("cancel-<?php echo $userId; ?>").onclick = function() {
                var imagePreview = document.getElementById("image-<?php echo $userId; ?>");
                var cancelButton = document.getElementById("cancel-<?php echo $userId; ?>");
                var confirmButton = document.getElementById("confirm-<?php echo $userId; ?>");
                var uploadButton = document.getElementById("upload-<?php echo $userId; ?>");

                imagePreview.src = userImage;
                cancelButton.style.display = "none";
                confirmButton.style.display = "none";
                uploadButton.style.display = "block";
            };

            document.getElementById("edit-user-modal-close-button-<?php echo $userId; ?>").onclick = function() {
                document.getElementById("edit-user-modal-<?php echo $userId; ?>").style.display = "none";
            };

            document.getElementById("edit-user-form-<?php echo $userId; ?>").onsubmit = function(e) {
                e.preventDefault();
                var form = this;
                var xhr = new XMLHttpRequest();
                xhr.open(form.method, form.action, true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Success: Reload the page or perform any necessary action
                        location.reload();
                    }
                };
                xhr.send(new FormData(form));
            };
            </script>
            
        <?php
    }
    $stmt->close();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
                <a href="#profiles" data-page="" class="dropbtn"><i class="fa fa-fw fa-users"></i> Profiles</a>
                <div class="dropdown-content">
                    <div>
                        <a href="#admins" data-page=""><i class="fa-solid fa-user-secret"></i> Admins</a>
                    </div>
                    <div>
                        <a href="#trainers" data-page=""><i class="fa-solid fa-user-ninja"></i> Trainers</a>
                    </div>
                    <div>
                        <a href="#users" data-page=""><i class="fa-solid fa-user"></i> Users</a>
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
    <div class="w3-content w3-margin-top content" style="max-width:1400px;" id="profiles">
        <!-- Grid -->
        <div class="w3-row-padding">

            <div class="w3-card-4 w3-margin box section" id="admins">
                <br>
                <div class="w3-row-padding" id="adminscontainer">
                    <!-- Fetch and display admins -->
                    <?php
                    displayUserProfiles('admin');
                    ?>
                </div>

                <div class="w3-display-container" style="margin-top: 60px;">
                    <div class="w3-display-bottomleft w3-container w3-text-black">
                        <h1 class="sectiontitle">Admins</h1>
                    </div>
                </div>

            </div>

            <div class="w3-card-4 w3-margin box section" id="trainers">
                <br>
                <div class="w3-row-padding" id="trainerscontainer">
                    <!-- Fetch and display trainers -->
                    <?php
                    displayUserProfiles('trainer');
                    ?>
                </div>

                <div class="w3-display-container" style="margin-top: 60px;">
                    <div class="w3-display-bottomleft w3-container w3-text-black">
                        <h1 class="sectiontitle">Trainers</h1>
                    </div>
                </div>

            </div>

            <div class="w3-card-4 w3-margin box section" id="users">
                <br>
                <div class="w3-row-padding" id="userscontainer">
                    <!-- Fetch and display users -->
                    <?php
                    displayUserProfiles('user');
                    ?>
                </div>

                <div class="w3-display-container" style="margin-top: 60px;">
                    <div class="w3-display-bottomleft w3-container w3-text-black">
                        <h1 class="sectiontitle">Users</h1>
                    </div>
                </div>

            </div>

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

        <!-- Edit User modals -->
        <script>
            // Function to open the modal
            function openModal(userId) {
            // Show the modal
            $("#edit-user-modal-" + userId).show();
            }

            // Function to close the modal
            function closeModal(userId) {
            // Hide the modal
            $("#edit-user-modal-" + userId).hide();
            }

            // Event listener for the Edit User buttons
            $(".edit-user-btn").click(function() {
            // Get the user ID from the data attribute
            var userId = $(this).data("user-id");

            // Open the modal
            openModal(userId);
            });

            // Event listener for the modal close buttons
            $(".modal-close-button").click(function() {
            // Get the user ID from the modal ID
            var userId = $(this).closest(".modal").attr("id").split("-").pop();

            // Close the modal
            closeModal(userId);
            });

            // Event listener for clicking outside the modal content to close it
            $(".modal").click(function(event) {
            // Check if the clicked element is the modal content
            if ($(event.target).hasClass("modal-content")) {
                // Get the user ID from the modal ID
                var userId = $(this).attr("id").split("-").pop();

                // Close the modal
                closeModal(userId);
            }
            });
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
<?php
require 'database.php';
require 'login.php';
include 'submitpfp.php';
shell_exec("submitpfp.php");

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>TechGym</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="css/custom.css?<?=time()?>" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="http://localhost/TechGym/js/validation.js" defer></script>
        <style>
            body, h1, h2, h3, h4, h5 {
                font-family: "Raleway", sans-serif;
            }

            /* Logo */
            .logocontainer {
                display: flex;
                justify-content: center;
            }

            .logo {
                border-bottom: 1px solid #bbb;
                padding-bottom: 10px;
                width: 50%;
            }
        </style>
    </head>

    <body class="darkgrey">
        <!-- Adjust behaviour of "#" links -->
        <script>
            // Adjust scroll position when a navigation link is clicked
            document.addEventListener("DOMContentLoaded", function () {
                var navLinks = document.querySelectorAll(".navbar a");

                // Iterate over each navigation link and attach a click event listener
                navLinks.forEach(function (link) {
                    link.addEventListener("click", function (event) {
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
                                    setTimeout(function () {
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
                        behavior: "smooth", // Optionally, use smooth scrolling behavior
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
            window.addEventListener("load", function () {
                var scrollTarget = sessionStorage.getItem("scrollTarget");
                if (scrollTarget) {
                    // Clear the stored target element ID from session storage
                    sessionStorage.removeItem("scrollTarget");

                    // Scroll to the target element with a small delay
                    setTimeout(function () {
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
                const navbarHeight = document.querySelector(".navbar").offsetHeight;
                document.querySelector(".content").style.paddingTop = navbarHeight + "px";
            }

            // On load
            window.addEventListener("load", adjustContentPadding);

            // When window resizes
            window.addEventListener("resize", () => {
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
            document.addEventListener("DOMContentLoaded", function () {
                var dropdowns = document.querySelectorAll(".dropdown");

                dropdowns.forEach(function (dropdown) {
                    var dropdownContent = dropdown.querySelector(".dropdown-content");
                    var timeoutId;

                    dropdown.addEventListener("mouseenter", function () {
                        clearTimeout(timeoutId);
                        dropdownContent.style.opacity = "1";
                        dropdownContent.style.visibility = "visible";
                    });

                    dropdown.addEventListener("mouseleave", function () {
                        timeoutId = setTimeout(function () {
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
                <a href="#index" data-page="" class="dropbtn active"><i class="fa fa-fw fa-home"></i> Home</a>
                <div class="dropdown-content" data-dropdown="home">
                    <div>
                        <a href="#equipment" data-page=""><i class="fa-solid fa-dumbbell"></i> Equipment</a>
                    </div>
                    <div>
                        <a href="#trainers" data-page=""><i class="fa-solid fa-users"></i> Trainers</a>
                    </div>
                    <div>
                        <a href="#location" data-page=""><i class="fa-solid fa-location-dot"></i> Location</a>
                    </div>
                    <div>
                        <a href="#plans" data-page=""><i class="fa-solid fa-coins"></i> Plans</a>
                    </div>
                    <div>
                        <a href="#aboutus" data-page=""><i class="fa-solid fa-circle-info"></i> About us</a>
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

        <!-- Page Container -->
        <div class="w3-content darkgrey content" style="max-width: 1400px;" id="index">

            <div class="logocontainer">
                <img src="images/TechGym-1.png" class="logo" />
            </div>
            <br />

            <!-- Grid -->
            <div class="w3-row">
                <!-- Sections -->
                <div class="l8 s12 centrecontent">

                    <!-- Equipment -->
                    <div class="w3-card-4 w3-margin box section" id="equipment">
                        <br />

                        <!-- Slideshow container -->
                        <div class="slideshow-container">
                            <div class="slideimage fade">
                                <div class="numbertext">1 / 3</div>
                                <img src="images/Equipment-1.jpg" style="width: 100%;" class="slideshowimg" />
                                <div class="text">Don't decrease the goal. Increase the effort.</div>
                            </div>

                            <div class="slideimage fade">
                                <div class="numbertext">2 / 3</div>
                                <img src="images/Equipment-2.jpg" style="width: 100%;" class="slideshowimg" />
                                <div class="text">Bench and Pull. Untill it's done.</div>
                            </div>

                            <div class="slideimage fade">
                                <div class="numbertext">3 / 3</div>
                                <img src="images/Equipment-3.jpg" style="width: 100%;" class="slideshowimg" />
                                <div class="text">The only bad workout is one that didn't happen.</div>
                            </div>

                            <!-- Next and previous buttons -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>

                            <!-- Dots/circles -->
                            <div style="text-align: center;" class="rectangle">
                                <span class="dot" onclick="currentSlide(1)"></span>
                                <span class="dot" onclick="currentSlide(2)"></span>
                                <span class="dot" onclick="currentSlide(3)"></span>
                            </div>
                        </div>
                        <br />
                        <br />
                        <br />

                        <!-- Image slideshow -->
                        <script>
                            let slideIndex = parseInt(localStorage.getItem("slideIndex"));
                            if (!slideIndex || isNaN(slideIndex)) {
                                slideIndex = 1;
                            }
                            showSlides(slideIndex);

                            // Next/previous controls
                            function plusSlides(n) {
                                showSlides((slideIndex += n));
                            }

                            // Thumbnail image controls
                            function currentSlide(n) {
                                showSlides((slideIndex = n));
                            }

                            function showSlides(n) {
                                let i;
                                let slides = document.getElementsByClassName("slideimage");
                                let dots = document.getElementsByClassName("dot");
                                if (n > slides.length) {
                                    slideIndex = 1;
                                }
                                if (n < 1) {
                                    slideIndex = slides.length;
                                }
                                for (i = 0; i < slides.length; i++) {
                                    slides[i].style.display = "none";
                                }
                                for (i = 0; i < dots.length; i++) {
                                    dots[i].className = dots[i].className.replace(" active", "");
                                }
                                slides[slideIndex - 1].style.display = "block";
                                dots[slideIndex - 1].className += " active";
                                localStorage.setItem("slideIndex", slideIndex.toString());
                            }
                        </script>

                          <div class="w3-container" style="color: white;">
                            <ul class="aboutuslist">
                                <li><p>Naša teretana nudi najsavremeniju opremu dizajniranu da vam pomogne da postignete svoje fitnes ciljeve. Naš širok izbor mašina uključuje kardiovaskularnu opremu kao što su trake za trčanje, eliptični i stacionarni bicikli. Takođe nudimo opremu za trening snage kao što su slobodne tegove, mašine za tegove i oprema za otpor. Naša oprema se pažljivo održava i redovno dezinfikuje kako bi se obezbedilo čisto i bezbedno okruženje za vežbanje. Naše stručno osoblje je uvek na raspolaganju da vam pomogne u vezi sa svim pitanjima ili nedoumicama koje imate u vezi sa opremom.</p></li>
                            </ul>
                        </div>

                        <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                              <h1 class="sectiontitle">Equipment</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Trainers -->
                    <div class="w3-card-4 w3-margin box section" id="trainers"><br>
                    <div class="w3-row-padding">
                      <div class="w3-third w3-container w3-margin-bottom">
                        <div class="w3-display-container">
                        <img src="images/Chad-1.jpg" style="width:100%;" class="w3-hover-opacity pfp section">
                        <div class="w3-display-bottomleft w3-container w3-text-black"><h2 class="pfpname">John Doe</h2></div>
                          </div>
                        <div class="w3-container indexlb usercontainer" style="min-height: 100%;">
                            <ul class="aboutuslist">
                                <li><p>“You're going to have to let it hurt. Let it suck. The harder you work, the better you will look. Your appearance isn’t parallel to how heavy you lift, it’s parallel to how hard you work.”</p></li>
                            </ul>
                        </div>
                      </div>
                      <div class="w3-third w3-container w3-margin-bottom">
                      <div class="w3-display-container">
                        <img src="images/Chad-2.jpg" style="width:100%" class="w3-hover-opacity pfp section">
                        <div class="w3-display-bottomleft w3-container w3-text-black"><h2 class="pfpname">Juan Perez</h2></div>
                          </div>
                        <div class="w3-container indexlb usercontainer" style="min-height: 100%;">
                            <ul class="aboutuslist">
                                <li><p>"No Hablo Inglés"</p></li>
                            </ul>
                        </div>
                      </div>
                      <div class="w3-third w3-container">
                      <div class="w3-display-container">
                        <img src="images/Chad-3.jpg" style="width:100%" class="w3-hover-opacity pfp section">
                        <div class="w3-display-bottomleft w3-container w3-text-black"><h2 class="pfpname">Jan Novak</h2></div>
                          </div>
                        <div class="w3-container indexlb usercontainer" style="min-height: 100%;">
                            <ul class="aboutuslist">
                                <li><p>“The resistance that you fight physically in the gym and the resistance that you fight in life can only build a strong character.”</p></li>
                            </ul>
                        </div>
                      </div>
                    </div>

                        <div class="w3-container" style="color: white;">
                            <ul class="aboutuslist">
                                <li><p>Naš tim profesionalnih trenera donosi veliko iskustvo u raznim fitnes disciplinama, pružajući izuzetne smernice i podršku za svaki nivo fitnesa. Sa strašću da pomognu klijentima da ostvare svoje ciljeve, naši treneri nude personalizovanu pažnju i specijalizovano programiranje kako bi vam pomogli da se osećate najbolje što možete.</p></li>
                            </ul>
                        </div>

                        <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                              <h1 class="sectiontitle">Trainers</h1>
                            </div>
                        </div>

                    </div>

                    <!-- Location -->
                    <div class="w3-card-4 w3-margin box section" id="location">
                        <p align="center"><iframe style="width: 97.5%; border-radius: 12px; margin-top: 20px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1986.3664065277908!2d19.81660032112249!3d45.24483403805347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475b10305763fc3f%3A0x4290e23a6c0e9642!2sFakultet%20za%20ekonomiju%20i%20in%C5%BEenjerski%20menad%C5%BEment%20-%20FIMEK!5e0!3m2!1ssr!2srs!4v1685528283518!5m2!1ssr!2srs" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        
                          <div class="w3-container" style="color: white;">
                            <p class="listtitle">&nbsp &nbsp Možete nas naći na sledećoj adresi: </p> 
                            <ul class="aboutuslist">
                                <li><p>Cvećarska 2, Novi Sad </p></li>
                            </ul>
                            <p class="listtitle">&nbsp &nbsp Kontaktirati na broj:</p> 
                            <ul class="aboutuslist">
                                <li><p>(021) 3-6-2-4-3-6 </p></li>
                            </ul>
                        </div>

                        <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                              <h1 class="sectiontitle">Location</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Plans -->
                    <div class="w3-card-4 w3-margin box section" id="plans"><br>
                        <div class="w3-row-padding">
                            <div class="w3-third w3-container w3-margin-bottom">
                                <div class="w3-display-container">
                                    <img src="images/Plan-1.png" style="width:100%;" class="w3-hover-opacity pfp section">
                                    <div class="w3-display-bottomleft w3-container w3-text-black"><h2 class="pfpname">Free</h2></div>
                                </div>
                                <div class="w3-container indexlb usercontainer">
                                    <ul class="aboutuslist">
                                        <h4>Chads:</h4>
                                        <li><p>2 Content sections</p></li>
                                        <li><p>1 Subscribed routine</p></li>
                                        <hr>
                                        <h4>Trainers:</h4>
                                        <li><p>1 Routine section</p></li>
                                        <hr>
                                    </ul>
                                    <button class="plans-button" type="button">€5</button>
                                </div>
                            </div>

                            <div class="w3-third w3-container w3-margin-bottom">
                                <div class="w3-display-container">
                                    <img src="images/Plan-2.png" style="width:100%" class="w3-hover-opacity pfp section">
                                    <div class="w3-display-bottomleft w3-container w3-text-black"><h2 class="pfpname">Iron</h2></div>
                                </div>
                                <div class="w3-container indexlb usercontainer">
                                    <ul class="aboutuslist">
                                        <h4>Chads:</h4>
                                        <li><p>4 Content sections</p></li>
                                        <li><p>2 Subscribed routines</p></li>
                                        <hr>
                                        <h4>Trainers:</h4>
                                        <li><p>2 Routine sections</p></li>
                                        <hr>
                                    </ul>
                                    <button class="plans-button" type="button">€10</button>
                                </div>
                            </div>

                            <div class="w3-third w3-container">
                                <div class="w3-display-container">
                                    <img src="images/Plan-3.png" style="width:100%" class="w3-hover-opacity pfp section">
                                    <div class="w3-display-bottomleft w3-container w3-text-black"><h2 class="pfpname">Olympic</h2></div>
                                </div>
                                <div class="w3-container indexlb usercontainer">
                                    <ul class="aboutuslist">
                                        <h4>Chads:</h4>
                                        <li><p>8 Content sections</p></li>
                                        <li><p>4 Subscribed routines</p></li>
                                        <hr>
                                        <h4>Trainers:</h4>
                                        <li><p>4 Routine sections</p></li>
                                        <li><p>A chance to be featured on the home page!</p></li>
                                        <hr>
                                    </ul>
                                    <button class="plans-button" type="button">€15</button>
                                </div>
                            </div>
                        </div>

                        <div class="w3-container" style="color: white;">
                            <ul class="aboutuslist">
                                <li><p>Naš tim profesionalnih trenera donosi veliko iskustvo u raznim fitnes disciplinama, pružajući izuzetne smernice i podršku za svaki nivo fitnesa. Sa strašću da pomognu klijentima da ostvare svoje ciljeve, naši treneri nude personalizovanu pažnju i specijalizovano programiranje kako bi vam pomogli da se osećate najbolje što možete.</p></li>
                            </ul>
                        </div>

                        <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                            <h1 class="sectiontitle">Plans</h1>
                            </div>
                        </div>
                    </div>

                    <!-- About us -->
                    <div class="w3-card-4 w3-margin box section" id="aboutus">
                          <div class="w3-container" style="color: white;">
                          <p class="listtitle"><h5>&nbsp &nbsp GymTech, nudi sledeće usluge I pogodnosti:</h5></p>
                          <ul class="aboutuslist">
                            <li><p>Širok spektar opreme za trening snage I kondiciju, uključujući kardio mašine, tegove, sprave za vežbanje I druge fitness dodatke.</p></li>
                            <li><p>Raznovrsne programe treninga za sve nivoe vežbača, uključujući individualni I grupni trening, funkcionalni trening, vežbe snage I kondicije, kao I program treninga za mršavljenje.</p></li>
                            <li><p>Stručne trenera sa iskustvom I znanjem za pružanje podrške I saveta o ishrani, programima treninga I zdravom načinu života.</p></li>
                            <li><p>Modernu I funkcionalnu teretanu sa savremenim dizajnom I opremom, koja stvara motivišuću I prijatnu atmosferu za vežbače.</p></li>
                            <li><p>Mogućnost online prijave za članstvo I kupovinu karata, kao I pregleda rasporeda treninga I radnog vremena teretane.</p></li>
                            <li><p>Dodatne usluge poput ishrane I masaže, koje mogu pomoći vežbačima da postignu svoje ciljeve brže I efikasnije.</p></li>
                            <li><p>Mogućnost online komunikacije sa trenerima I drugim vežbačima, putem društvenih mreža I drugih online platformi.</p></li>
                            <li><p>Uz sve ove usluge I pogodnosti, vaša teretana GymTech stvara sveobuhvatan pristup zdravlju I fitnesu, koji pomaže vežbačima da ostvare svoje ciljeve I poboljšaju svoje zdravlje I dobrobit.</p></li>
                          </ul>
                        </div>

                        <div class="w3-display-container" style="margin-top: 60px;">
                            <div class="w3-display-bottomleft w3-container w3-text-black">
                              <h1 class="sectiontitle">About us</h1>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End large sections -->
            </div>
            <br />
            <!-- End grid -->
        </div>
        <!-- End page container -->

        <footer class="w3-container backdarkred w3-center">
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
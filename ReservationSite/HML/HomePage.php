<?php
    require_once 'BACK/config_session.php';
    require_once 'BACK/signup_view.php';
    require_once 'BACK/login_view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUEEN AND KNIGHT EVENT SERVICES</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../STYLES/styles.css">
    <link rel="stylesheet" href="../STYLES/responive.css">
    <link rel="stylesheet" href="../STYLES/logIn.css">
    <link rel="icon" type="image/png" href="../Pictures/logo2.png">
    <script src="../login.js" defer></script>
    <script src="../sidebar.js"></script>
    <script src="../goback.js"></script>

</head>


<body>
    <nav>

        <div class="logo">
            <img src="../Pictures/logo.png" alt="logo">
            <a href="#">QUEEN AND KNIGHT <br>
            EVENT SERVICES</a>
        </div> 
        
        <div class="sidebar">
            <div><a href=""><img src="../Pictures/close.png" alt="" onclick="closeSidebar()"></a></div>
            <ul class="sidebar-content">
                <li><a href="#">HOME</a></li>
                <li><a href="Calendar.html" onclick="saveCurrentPage()">CALENDAR</a></li>
                <li><a onclick="showSignup()">FEEDBACK</a></li>
                <li><a href="support.html" onclick="saveCurrentPage()">SUPPORT</a></li>
                <div class="auth-buttons loginbutton">
                    <button class="login sidebarlog" onclick="showlogin()"><a >LOGIN</a></button>
                    <button class="signUp sidebarlog" onclick="showSignup2()"><a>SIGN UP</a></button>
                </div>
            </ul>
        </div>

        <ul class="nav-links">
            <li><a href="#">HOME</a></li>
            <li><a href="Calendar.html" onclick="saveCurrentPage()">CALENDAR</a></li>
            <li><a onclick="showSignup2()">FEEDBACK</a></li>
            <li><a href="support.html">SUPPORT</a></li>
        </ul>

        <div class="auth-buttons loginbutton">
            <button class="login" onclick="showlogin()"><a >LOGIN</a></button>
            <button class="signUp" onclick="showSignup2()"><a>SIGN UP</a></button>
        </div>
        <div class="menubar" >
            <a href="#" onclick="showSidebar()"><img src="../Pictures/menu.png" alt=""></a>
        </div>

    </nav>
    <!-- LOG IN -->
    <div id="loginPopup" class="popUp hidden">
        <div class="popUp-content">
            <div class="customer-login">
                <p id="tag">CUSTOMER LOGIN</p>
            </div>
            <div class="back-Button" onclick="closelogin()">
                <button><a><img src="../Pictures/backButton.png" alt=""></a></button>
            </div>
            <form action="BACK/login.php" id="loginForm" method="post">
                <input type="text" class="username" id="username" name="username" required placeholder="Email">
                <input type="password" class="pass" id="pass" name="pass" required placeholder="Password">
                
                <div class="login-box">
                    <button type="submit"><a>LOGIN</a></button>
                </div>
            </form>

            <?php
            check_login_errors();
            ?>

            <div class="forgot-pass">
                <a>Forgot Password?</a>
            </div>
            <div class="line">
            </div>
            <div  class="createAcc" id="createAcc" onclick="showSignup()">
                <button><a >Creat new account</a></button>
            </div>
            <div class="admin-acc" onclick="showADlogin()">
                <a>Login as admin</a>
            </div>
        </div>
    </div>
    <!-- ADMIN LOGIN -->
    <div id="ADloginPopup" class="ADpopUp ADhidden">
        <div class="ADpopUp-content">
            <div class="Admin-login" >
                <p id="tag">ADMIN LOGIN</p>
            </div>
            <div id="ADcloseBtn" class="ADback-Button" onclick="closeADlogin()">
                <button><a><img src="../Pictures/backButton.png" alt=""></a></button>
            </div>
            <form action="BACK/loginAdmin.php" id="loginForm" method="post">
                <input type="text" class="username" id="ADusername" name="username" required placeholder="Email">
                <input type="password" class="pass" id="ADpass" name="pass" required placeholder="Password">

                <div class="login-box">
                <button type="submit"><a>LOGIN</a></button>
            </div>

            </form>
            
            <div class="forgot-pass">
                <a>Forgot Password?</a>
            </div> 
        </div>
    </div>
    <!-- SIGN UP -->
    <div id="SPloginPopup" class="SPpopUp SPhidden">
        <div class="SPpopUp-content">
            <div class="SignUp">
                <p id="tag">Sign Up</p>
            </div>
            <div id="SPcloseBtn" class="SPback-Button" onclick="closeSignup()">
                <button><a><img src="../Pictures/backButton.png" alt=""></a></button>
            </div>
            <form action="BACK/signup.php" id="loginForm" method="post">
                <input type="email" class="username" id="username" name="username"  placeholder="Email">
                <input type="password" class="pass"  name="pass"  placeholder="Password">
                <input type="password" class="confirm" id="confirm" name="confirm"  placeholder="Confirm password">
                <div class="SignUP-box">
                    <button type="submit" ><a>Sign Up</a></button>
                </div>
            </form>
            
            <?php
            check_signup_errors();
            ?>
            
            <div id="cancel" class="cancel" onclick="cancelSignup()">
            <a href="#">cancel sign up</a>
            </div> 
        </div>
    </div>
    <!-- SIGN UP2 -->
    <div id="SPloginPopup2" class="SPpopUp SPhidden">
        <div class="SPpopUp-content">
            <div class="SignUp">
                <p id="tag">Sign Up</p>
            </div>
            <div class="SPback-Button2" onclick="closeSignup2()">
                <button><a><img src="../Pictures/backButton.png" alt=""></a></button>
            </div>
            <form action="BACK/signup.php" id="loginForm" method="post">
                <input type="email" class="username" id="username" name="username"  placeholder="Email">
                <input type="password" class="pass"  name="pass"  placeholder="Password">
                <input type="password" class="confirm" id="confirm" name="confirm"  placeholder="Confirm password">
                <div class="SignUP-box">
                    <button type="submit" ><a>Sign Up</a></button>
                </div>
            </form>

            <?php
            check_signup_errors();
            ?>

            <div onclick="closeSignup2()" class="cancel2">
                <a href="#">cancel sign up</a>
            </div> 
        </div>
    </div>


    <!-- IMAGE SLIDERIZZ -->
    <div class="slider">
        <div class="reservation">
            <button class="reservation-button" onclick="showSignup2()"><a href="#">MAKE A RESERVATION</a></button>
        </div>
        <div class="message">
            <button><a href="#"><img src="../Pictures/message.png" alt=""></a></button>
        </div>
        <figure>
            <div class="slide">
                <img src="../Pictures/LP1.jpg" alt="">
            </div>
    
            <div class="slide">
                <img src="../Pictures/LP2.jpg" alt="">
            </div>
    
            <div class="slide">
                <img src="../Pictures/LP3.jpg" alt="">
            </div>
    
            <div id="cancel" class="slide">
                <img src="../Pictures/LP4.jpg" alt="">
            </div>
        </figure>.
        
        
        <div class="centered-text">
            <h1>Transform Your <span style="color: #6aef55;">Vision</span> into <span style="color: rgba(106, 239, 85, 1);">Reality</span></h1>
            <p>Book Your <span style="color: rgba(106, 239, 85, 1);">Special</span> Day with Us.</p>
            
        </div>
        
        
    </div>
    
    
    
    
    <!--    EVENTS SECTION  -->
    <div class="events-section">

        <h2>EVENTS</h2>

        
        <div class="events-categories">
            <a href="#" class="category-link">BIRTHDAYS</a>
            <a href="#" class="category-link">DEBUTS</a>
            <a href="#" class="category-link">WEDDINGS</a>
        </div>
        <div class="events-gallery">
            <div class="scroll"><img src="../Pictures/down.png" alt=""></div>
            <div class="event-item">
                <img src="../Pictures/Event1.jpg" alt="ERROR 1 EVENTS">
            </div>
            <div class="event-item">
                <img src="../Pictures/Event2.jpg" alt="ERROR 2 EVENTS">
            </div>
            <div class="event-item">
                <img src="../Pictures/Event3.jpg" alt="ERROR 3 EVENTS">
            </div>
            <div class="event-item">
                <img src="../Pictures/Event4.jpg" alt="ERROR 4 EVENTS">
            </div>
        </div>
    </div>

    <!--    WHAT WE OFFER SECTION TO BUD    -->
    <div class="offer-section">
        <h2>WHAT WE OFFER</h2>
        <div class="food-catering">
            <div class="catering-content">
                <div class="catering-item1">
                    <img src="../Pictures/Food1.jpg" alt="Catering Image 1">
                </div>
                <div class="catering-description">
                    <h3>FOOD CATERING</h3>
                    <p>At Queen and Knight Event Services, we provide affordable and delicious food catering services tailored to your needs. 
                        Our diverse menu features fresh, high-quality ingredients prepared by skilled chefs.
                        At all budget-friendly prices, whether it's a corporate event, wedding, or private party, 
                        we ensure a memorable culinary experience with excellent service.</p>
                    <div class="catering-item2">
                        <img src="../Pictures/Food2.jpg" alt="Catering Image 2">
                    </div>
                </div>
                <div class="catering-item3">
                    <img src="../Pictures/Food3.jpg" alt="Catering Image 3">
                    <p>We offer customizable menus to suit your preferences and dietary requirements,
                        ensuring every guest is satisfied. Let us handle your catering needs with professionalism and care,
                        so you can enjoy your event without breaking the bank. Choose [your company name] 
                        for exceptional and affordable catering services.</p>
                </div>
                <div class="catering-item4">
                    <img src="../Pictures/Food4.jpg" alt="Catering Image 4">
                </div>
                
            </div>
        </div>
    </div>
    <!--    ABOUT    -->
    <div class="about-section">
        <h1>ABOUT US</h1>
        <div class="about-pics">
            <div class="card">
                <div class="about-desc">
                    <h2>ABOUT US</h2>
                    <p>Welcome to Queen and Knights Event 
                        services , your premier partner for 
                        planning and reserving exceptional 
                        events. Our mission is to make the 
                        process of organizing events seamless, 
                        efficient, and enjoyable. We specialize 
                        in providing a comprehensive reservation 
                        platform that caters to a wide range of 
                        events, from weddings and corporate 
                        gatherings to private parties and 
                        community celebrations.
                    </p>
                </div>
            </div>
            <img src="../Pictures/About1.jpg" alt="About1">
            <img src="../Pictures/About2.jpg" alt="About1">
            <img src="../Pictures/About3.jpg" alt="About1">
            <img src="../Pictures/About4.jpg" alt="About1">
        </div>

    </div>

    <!-- FOOTER -->
     <div class="Footer1">
        <div class="social">
            <a href="messenger.com"><img src="../Pictures/messenger.png" alt="messenger" class="messenger"></a>
            <a href="facebook.com"><img src="../Pictures/facebook.png" alt="facebook" class="facebook"></a>
        </div>
        <div class="footer">
            <p class="page">Page: Queen and Knight
               <br> Event Services
            </p>
            <p class="telephone">Tel no. : 0000000</p>
        </div>
        
     </div>
     <div class="Footer2">
        <div class="logo2">
            <a href="#"><img src="../Pictures/logo.png" alt=""></a>
        </div>
        <div class="footer-img">
        </div>
        <div class="title">
            <h1>queen and knights event services</h1>
        </div>
     </div>


</body>
</html>

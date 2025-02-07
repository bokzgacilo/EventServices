<?php
require_once 'api/config_session.php';
require_once 'api/signup_view.php';
require_once 'api/login_view.php';
include_once("api/connection.php");


// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QUEEN AND KNIGHT EVENT SERVICES</title>

  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../styles/responive.css"> -->
  <link rel="icon" type="image/png" href="../images/logo2.png">
  <?php
    include("reusables/asset_loader.php");
  ?>
  <link rel="stylesheet" href="../styles/styles.css">

</head>


<body>
  <div class="container-fluid p-0 m-0">
    <nav>
      <div class="logo">
        <img src="../images/logo3.png">
        <a href="index.php">QUEEN AND KNIGHT EVENT SERVICES</a>
      </div>

      <div class="nav-links">
        <a href="">Home</a>
        <a href="#packages">Packages</a>
        <a href="#services">Services</a>
        <a href="#about">About</a>
        <a href="dashboard.php">Dashboard</a>
      </div>

      <div class="user-buttons">
        <a class="login-btn">LOGIN</a>
        <a class="signup-btn">SIGN UP</a>
      </div>
    </nav>

    <div class="slider">
      <div class="message">
        <button><a href="#"><img src="../images/message.png" alt=""></a></button>
      </div>
      <figure>
        <div class="slide">
          <img src="../images/LP2.jpg" alt="">
        </div>

        <div class="slide">
          <img src="../images/LP3.jpg" alt="">
        </div>

        <div id="cancel" class="slide">
          <img src="../images/LP4.jpg" alt="">
        </div>
      </figure>.


      <div class="centered-text">
        <h1>Transform Your <span style="color: #6aef55;">Vision</span> into <span style="color: rgba(106, 239, 85, 1);">Reality</span></h1>
        <p>Book Your <span style="color: rgba(106, 239, 85, 1);">Special</span> Day with Us.</p>
      </div>
    </div>

    <div class="package-section" id="packages">
      <h1 class="event-title">PACKAGES OFFERED</h1>
      <div class="package-list">
        <!-- API -->
      </div>
      <div class="pagination">
        <!-- API -->
      </div>
    </div>
    
    <!--    WHAT WE OFFER SECTION TO BUD    -->
    <div class="offer-section" id="services">
      <h1 class="event-title">SERVICES OFFERED</h1>
      <div class="offers">
        <img src="../images/Food1.jpg" class="offer-big-image">
        <div class="offer-long">
          <h2>FOOD CATERING</h2>
          <p>At Queen and Knight Event Services, we provide affordable and delicious food catering services tailored to your needs.
            Our diverse menu features fresh, high-quality ingredients prepared by skilled chefs.
            At all budget-friendly prices, whether it's a corporate event, wedding, or private party,
            we ensure a memorable culinary experience with excellent service.</p>
          <img src="../images/Food2.jpg">
        </div>
        <div class="offer-long">
          <img src="../images/Food3.jpg">
          <p>We offer customizable menus to suit your preferences and dietary requirements,
            ensuring every guest is satisfied. Let us handle your catering needs with professionalism and care,
            so you can enjoy your event without breaking the bank. Choose [your company name]
            for exceptional and affordable catering services.</p>
        </div>
        <img src="../images/Food4.jpg" class="offer-big-image">
      </div>
    </div>
    <!--    ABOUT    -->
    <div class="about-section" id="about">
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
        <img src="../images/About1.jpg" alt="About1">
        <img src="../images/About2.jpg" alt="About1">
        <img src="../images/About3.jpg" alt="About1">
        <img src="../images/About4.jpg" alt="About1">
      </div>

    </div>

    <!-- FOOTER -->
    <div class="Footer1">
      <div class="social">
        <a href="messenger.com"><img src="../images/messenger.png" alt="messenger" class="messenger"></a>
        <a href="facebook.com"><img src="../images/facebook.png" alt="facebook" class="facebook"></a>
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
        <a href="#"><img src="../images/logo.png" alt=""></a>
      </div>
      <div class="footer-img">
      </div>
      <div class="title">
        <h1>queen and knights event services</h1>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      var storedPage = localStorage.getItem('page');

      if (!storedPage) {
        storedPage = 1;
        localStorage.setItem('page', storedPage); // Optionally, set it in localStorage
      }

      function get_package(page){
        $.ajax({
          type: 'get',
          url: 'api/pagination/get_all_packages.php',
          data: {
            page: page
          },
          success: response => {
            $(".package-list").html(response)
          }
        })
      }

      function get_pagination(page){
        $.ajax({
          type: 'get',
          url: 'api/pagination/get_all_pagination.php',
          data: {
            page: page
          },
          success: response => {
            $(".pagination").html(response)
          }
        })
      }

      $(document).on('click', '.page-num' ,function(e) {
        get_package($(this).attr('data-target'))
        get_pagination($(this).attr('data-target'))
      });

      $(document).on('click', '#previous-button' ,function() {
        var currentPage = parseInt(localStorage.getItem('page')) || 1;  // Default to page 1 if not set

        if (currentPage > 1) {
          var previousPage = currentPage - 1;
          localStorage.setItem('page', previousPage);  // Store the new page in localStorage
          get_package(previousPage)
          get_pagination(previousPage)
        }
      });

      $(document).on('click', '#next-button', function() {
        var currentPage = parseInt(localStorage.getItem('page')) || 1;
        var nextPage = currentPage + 1;
        localStorage.setItem('page', nextPage);
        get_package(nextPage)
        get_pagination(nextPage)
      });

      get_package(storedPage)
      get_pagination(storedPage)
    })
  </script>
</body>

</html>
<?php
  include_once("api/connection.php");
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>QUEEN AND KNIGHT EVENT SERVICES</title>
  <?php
    include("reusables/asset_loader.php");
  ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <style>
    .slick-next {
      right: 0;
    }
  </style>
</head>

<body>

  <div class="container-fluid p-0 m-0">
    <?php include_once("reusables/headbar.php"); ?>

    <div class="slick-carousel">
      <img src="../images/LP1.jpg" style="height: 900px; object-fit: cover;">
      <img src="../images/LP2.jpg" style="height: 900px; object-fit: cover;">
      <img src="../images/LP3.jpg" style="height: 900px; object-fit: cover;">
      <img src="../images/LP4.jpg" style="height: 900px; object-fit: cover;">
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

    <div class="about-section" id="about">
      <h1 class="event-title">ABOUT</h1>
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
        community celebrations.</p>
    </div>

    <?php
      include_once("reusables/footbar.php");
    ?>

    <script>
      $(document).ready(function(){
        $('.slick-carousel').slick({
          autoplay: true,
          infinite: true,
          autoplaySpeed: 2000,
        });
      });
        
      $(document).ready(function() {
        var storedPage = localStorage.getItem('page');

        if (!storedPage) {
          storedPage = 1;
          localStorage.setItem('page', storedPage); // Optionally, set it in localStorage
        }

        function get_package(page) {
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

        function get_pagination(page) {
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

        $(document).on('click', '.page-num', function(e) {
          get_package($(this).attr('data-target'))
          get_pagination($(this).attr('data-target'))
        });

        $(document).on('click', '#previous-button', function() {
          var currentPage = parseInt(localStorage.getItem('page')) || 1; // Default to page 1 if not set

          if (currentPage > 1) {
            var previousPage = currentPage - 1;
            localStorage.setItem('page', previousPage); // Store the new page in localStorage
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
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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <style>
    .slick-next {
      right: 0;
    }
  </style>
</head>

<body>
  <div class="modal fade" id="quotationModal" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="quotationModalLabel">Create Your Own Package</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
          <form id="quotationForm" class="d-flex flex-column gap-2">
            <p class="fw-semibold">Please fill out the form to request a quotation.</p>
            <div class="form-group">
              <p class="form-label fw-semibold">Event Date</p>
              <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group">
              <p class="form-label fw-semibold">Venue</p>
              <input type="text" class="form-control" name="venue" placeholder="Address of venue" required>
            </div>
            <div class="form-group">
              <p class="form-label fw-semibold">Number of Pax</p>
              <input type="number" class="form-control" name="pax" placeholder="Enter number of guests" required>
            </div>
            <div class="form-group">
              <label for="chairs" class="form-label fw-semibold">Number of Chairs</label>
              <input type="number" class="form-control" name="chairs" placeholder="Enter number of chairs" required>
            </div>
            <div class="form-group">
              <label for="tables" class="form-label fw-semibold">Number of Tables</label>
              <input type="number" class="form-control" name="tables" placeholder="Enter number of tables" required>
            </div>
            <div class="form-group">
              <label class="form-label fw-semibold">Catering Service Inclusions</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" id="foodService"
                  value="Food Service">
                <label class="form-check-label" for="foodService">Food Service</label>
              </div>
              <div id="foodDetails" class="mt-2 mb-2" style="display: none;">
                <label for="allergy" class="form-label fw-semibold">Allergy Details</label>
                <input type="text" class="form-control" name="allergy" placeholder="Enter allergy details">

                <label for="menu" class="form-label mt-2 fw-semibold">Preferred Menu</label>
                <input type="text" class="form-control" name="menu" placeholder="Enter preferred menu">
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" value="Waiter and Server">
                <label class="form-check-label" for="serviceCrew">Service Crew</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" value="Photo Booth">
                <label class="form-check-label" for="photoBooth">Photo Booth</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" value="Photo Coverage">
                <label class="form-check-label" for="clown">Photo Coverage</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" value="Video Coverage">
                <label class="form-check-label" for="clown">Video Coverage</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" value="Event Host">
                <label class="form-check-label" for="clown">Event Host/Hostess</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclusion[]" value="Lights and Sound System">
                <label class="form-check-label" for="clown">Lights and Sound System</label>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label fw-semibold">Contact Number</label>
              <input type="text" class="form-control" name="contact_number" placeholder="0976222095X" required>
              <span>Please ensure that it is active, capable of receiving calls, and able to respond.</span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Request</button>
        </div>
        </form>

      </div>
    </div>
  </div>

  <div class="container-fluid p-0 m-0">
    <?php include_once("reusables/headbar.php"); ?>

    <div class="slick-carousel">
      <img src="../images/LP1.jpg" style="height: 900px; object-fit: cover;">
      <img src="../images/LP2.jpg" style="height: 900px; object-fit: cover;">
      <img src="../images/LP3.jpg" style="height: 900px; object-fit: cover;">
      <img src="../images/LP4.jpg" style="height: 900px; object-fit: cover;">
    </div>



    <div class="package-section" id="packages">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
        <h1 class="event-title">PACKAGES OFFERED</h1>
        <button class="btn btn-primary btn-lg" id="custom-package-btn" 
    <?php 
        if (empty($_SESSION['userfullname'])) {
            echo 'onclick="showLoginAlert()"';
        } else {
            echo 'data-bs-toggle="modal" data-bs-target="#quotationModal"';
        }
    ?>>Custom Package</button>
      </div>
      <div class="col-lg-2 col-12">
        <select class="form-select" id="select-category">
          <option>Birthday</option>
          <option>Wedding</option>
          <option>Funeral</option>
          <option>Party</option>
          <option>Other</option>
        </select>
      </div>
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
          <p>At Queen and Knight Event Services, we provide affordable and delicious food catering services tailored to
            your needs.
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
      function showLoginAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Please Login',
            text: 'You must log in to request a custom package.',
            showCancelButton: true,
            confirmButtonText: 'Login',
        }).then((result) => {
            if (result.isConfirmed) {
                // Trigger the login modal opening
                document.querySelector('a.login-btn').click();  // Make sure a.login-btn exists in your HTML
            }
        });
    }


      $(document).ready(function () {
        $('.slick-carousel').slick({
          autoplay: true,
          infinite: true,
          autoplaySpeed: 2000,
        });
      });

      $("#quotationForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: "api/createCustomPackage.php",
          data: $(this).serialize(),
          success: function (response) {
            if (response == 1) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Quotation request sent successfully!',
              });
              $("#quotationModal").modal("hide");
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Failure',
                text: 'Failed to send quotation request. Please try again.',
              });

            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred. Please try again.',
            });

          }
        });
      })

      $(document).ready(function () {
        $('#foodService').change(function () {
          if ($(this).is(':checked')) {
            $('#foodDetails').slideDown();
          } else {
            $('#foodDetails').slideUp();
          }
        });
      });

      $(document).ready(function () {
        var storedPage = localStorage.getItem('page');

        $("#select-category").on("change", function () {
          const selectedValue = $(this).val();

          get_category(storedPage, selectedValue)
          get_category_pagination(storedPage, selectedValue)
        });

        if (!storedPage) {
          storedPage = 1;
          localStorage.setItem('page', storedPage); // Optionally, set it in localStorage
        }

        function get_category(page, category){
            $.ajax({
              type: "get",
              url: "api/pagination/get_all_category_items.php",
              data: {
                category: category,
                page: page
              },
              success: response => {
                $(".package-list").html(response)
                localStorage.setItem('category', category);
              }
            })
        }

        function get_category_pagination(page, category) {
          $.ajax({
            type: 'get',
            url: 'api/pagination/get_all_category_pagination.php',
            data: {
              category: category,
              page: page
            },
            success: response => {
              $(".pagination").html(response)
            }
          })
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

        $(document).on('click', '.page-num', function (e) {
          get_package($(this).attr('data-target'))
          get_pagination($(this).attr('data-target'))
        });

        $(document).on('click', '#previous-button', function () {
          var currentPage = parseInt(localStorage.getItem('page')) || 1; // Default to page 1 if not set

          if (currentPage > 1) {
            var previousPage = currentPage - 1;
            localStorage.setItem('page', previousPage); // Store the new page in localStorage
            get_package(previousPage)
            get_pagination(previousPage)
          }
        });

        $(document).on('click', '#next-button', function () {
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
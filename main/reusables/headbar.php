<style>
  #loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1056;
  }

  nav {
    font-family: "Bebas";
    display: flex;
    align-items: center;
    background-color: #ffffff;
    padding: 0 4rem;
    position: sticky;
    top: 0;
    z-index: 5;
  }


  .user-buttons {
    margin-left: auto;
    display: flex;
    flex-direction: row;
    gap: 1rem;
    cursor: pointer;
  }

  .nav-links {
    display: flex;
    flex-direction: row;
    margin-left: 8rem;
  }

  /* FOR 700PX BELOW */
  @media (max-width: 700px) {
    .logo>a {
      display: none;
    }

    nav {
      padding: 10px;
      flex-direction: row;
      justify-content: space-between;
    }

    .nav-links {
      display: none;
    }

    .nav-links-mobile {
      display: flex !important;
      flex-direction: column;
    }

    .user-buttons {
      margin-left: 0;
      display: flex;
      flex-direction: row;
      gap: 1rem;
      cursor: pointer;
    }

    .user-buttons>a {
      padding: 10px 1rem !important;
      font-size: 18px;
    }
  }

  .nav-links-mobile {
    display: none;
  }

  #password_error {
    display: none;
    font-size: 14px;
    color: red;
  }

  .logo {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
  }

  .logo>a {
    text-decoration: none;
    color: #000;
    font-weight: bold;
    font-size: 26px;
  }

  .logo>img {
    width: 60px;
    height: 60px;
    object-fit: cover;
  }

  .nav-links>a {
    text-decoration: none;
    text-align: center;
    color: #000;
    font-size: 28px;
    font-weight: bold;
    width: 170px;
    padding: 1.25rem 0;
    cursor: pointer;
  }

  .nav-links-mobile>a {
    text-decoration: none;
    color: #000;
    font-size: 24px;
    font-weight: bold;
    padding: 1.25rem 0;
    cursor: pointer;
    border-bottom: 1px solid black;
  }

  .nav-links>a:hover {
    color: #fff;
    background-color: #000;
  }


  .user-buttons>a {
    padding: 0.5rem 2rem;
    font-size: 20px;
    text-align: center;
    text-decoration: none;
  }

  .login-btn {
    background-color: #000;
    border: 2px solid #000;
    color: #fff;
  }

  .signup-btn {
    border: 2px solid #000;
    color: #000;
  }

  #loginform,
  #signupform {
    font-family: "Bebas";
    font-size: 26px;
  }

  #loginform>input,
  #signupform>input {
    font-size: 18px;
    font-family: "Inter";
  }

  #signupform>button,
  #loginform>button {
    font-size: 22px;
    width: 100%;
    font-family: "Bebas";
  }
</style>

<div id="loadingOverlay">
  <div class="spinner-border text-light" role="status"></div>
</div>

<nav>
  <div class="logo">
    <img src="../images/logo3.png" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
    <a href="index.php">QUEEN AND KNIGHT EVENT SERVICES</a>
  </div>

  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="index.php#packages">Packages</a>
    <a href="event_gallery.php">Event Gallery</a>
    <a href="index.php#services">Services</a>
    <a href="index.php#about">About</a>
  </div>

  <div class="user-buttons">
    <?php

    if (isset($_SESSION['userid'])) {
      if ($_SESSION['usertype'] === "admin") {
        echo "<a class='login-btn' href='packages.php'>" . $_SESSION['userfullname'] . "</a>";
      } else {
        echo "<a class='login-btn' href='my-account.php'>" . $_SESSION['userfullname'] . "</a>";
      }


      echo "<a class='signup-btn' href='api/logout.php'>Logout</a>";
    } else {
      echo "
          <a class='login-btn' data-bs-toggle='modal' data-bs-target='#loginModal'>Login</a>
          <a class='signup-btn' data-bs-toggle='modal' data-bs-target='#signupModal'>Sign Up</a>
      ";
    }
    ?>
  </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Navigation</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div class="nav-links-mobile">
      <a href="index.php">Home</a>
      <a href="index.php#packages">Packages</a>
      <a href="event_gallery.php">Event Gallery</a>
      <a href="index.php#services">Services</a>
      <a href="index.php#about">About</a>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close text-align-right" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 d-flex flex-column">
        <form id="loginform">
          <h1 class="mb-4 fw-bold">Login</h1>
          <p>Email</p>
          <input class="form-control mb-4" name="login_email" type="email" required />
          <p>Password</p>
          <input class="form-control mb-4" name="login_password" type="password" required />
          <button class="btn btn-primary" type="submit">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Sign Up Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 d-flex flex-column">
        <form id="signupform">
          <h1 class="mb-4 fw-bold">Signup</h1>
          <p>Full Name</p>
          <input class="form-control mb-4" placeholder="Juan Dela Cruz" name="signup_fullname" type="text" required />
          <p>Email</p>
          <input class="form-control" placeholder="j.delacruz@gmail.com" name="signup_email" type="email" required />
          <p style="font-family: Arial; font-size: 14px;" class="fw-semibold mb-4">Note: Make sure this is active; an OTP will be sent to this address later.</p>
          <p>Contact Number</p>
          <div class="input-group input-group-lg">
            <span class="input-group-text" id="basic-addon1">+63</span>
            <input 
              type="tel"
              class="form-control" 
              placeholder="976222095X" 
              name="signup_contact" 
              name="signup_contact"
              pattern="\d{10}"
              maxlength="10" 
              required>
          </div>
          <p style="font-family: Arial; font-size: 14px;" class="fw-semibold mb-4">Note: Make sure this is active; an OTP will be sent to this address later.</p>
          <p>Password</p>
          <input class="form-control mb-4" placeholder="Password" name="signup_password" type="password" required />
          <p>Confirm Password</p>
          <input class="form-control mb-4" placeholder="Confirm Password" name="signup_confirm_password" type="password" required />
          <p class="mb-4 mt-2" id="password_error"></p>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="termsCheck">
            <label class="form-check-label" for="termsCheck">
              I agree to the <a href="#">terms and conditions</a>
            </label>
          </div>
          <button class="btn btn-primary mt-4" id="signup-button" type="submit" disabled>Signup</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Terms and Conditions Modal (Stacked) -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
          By using our platform, you agree to abide by the rules and regulations outlined herein. Please read all terms carefully.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- OTP SIGNUP Modal -->
<div class="modal fade" id="otpSignupModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="otpSignupForm">
          <input type="hidden" name="hidden_signup_name">
          <input type="hidden" name="hidden_signup_email">
          <input type="hidden" name="hidden_signup_password">
          <input type="hidden" name="hidden_signup_contact">

          <div class="mb-3">
            <label class="form-label">Email OTP Code</label>
            <input type="number" class="form-control" name="otp" required>
          </div>

          <div class="mb-3">
            <label class="form-label">SMS OTP Code</label>
            <input type="number" class="form-control" name="sms_otp" required>
          </div>

          <button type="submit" class="btn btn-success">Complete Signup</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="otpForm">
          <input type="hidden" name="client_name" id="client_name">
          <input type="hidden" name="client_id" id="client_id">
          <input type="hidden" name="client_email" id="client_email">
          <input type="hidden" name="client_type" id="client_type">

          <div class="mb-3">
            <label for="otpInput" class="form-label">OTP Code</label>
            <input type="number" class="form-control" name="otp" id="otpInput" required>
          </div>

          <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const sessionid = <?php
  if (isset($_SESSION['userid'])) {
    echo $_SESSION['userid'];
  } else {
    echo 0;
  }
  ?>

$('#termsCheck').on('change', function () {
    if (this.checked) {
      $('#signup-button').removeAttr('disabled');

      // Show the terms modal without hiding the signup modal
      var termsModal = new bootstrap.Modal(document.getElementById('termsModal'), {
        backdrop: 'static',
        keyboard: false
      });
      termsModal.show();
    } else {
      $('#signup-button').attr('disabled', 'disabled');
    }
  });


  $("input[name='signup_password']").on("input", function () {
    var password = $(this).val();
    var regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])(?!.*\s).{8,}$/;

    if (!regex.test(password)) {
      $("#password_error").show();
      $("#password_error").text("Password must contain at least 1 uppercase letter, 1 number, 1 special character, and no spaces.");
    } else {
      $("#password_error").hide();
    }
  });

  $(document).on("submit", "#otpForm", function (e) {
    e.preventDefault();

    var formdata = new FormData(this);

    $.ajax({
      type: 'post',
      url: "api/verify_otp.php",
      data: formdata,
      processData: false,
      contentType: false,
      success: response => {
        if (response.status === "success") {
         Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.message,
        }).then(() => {
          location.reload();
        });
        } else {
          alert(response.message);
        }
      }
    });
  });

  $(document).on("submit", "#otpSignupForm", function (e) {
    e.preventDefault();

    var formdata = new FormData(this)

   $.ajax({
    type: 'post',
    url: "api/signup.php?step=2",
    data: formdata,
    processData: false,
    contentType: false,
    success: response => {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: response.message,
      }).then(() => {
        location.reload();
      });
    }
  });

  })

  $(document).on("submit", "#signupform", function (e) {
    e.preventDefault();

    var password = $("input[name='signup_password']").val();
    var confirm_password = $("input[name='signup_confirm_password']").val();

    if (password !== confirm_password) {
      $("#password_error").show();
      $("#password_error").text("Password not matched");
      console.log("password not matched")

      return;
    } else {
      $("#password_error").hide();
    }

    console.log("Proceed signup")


    var formdata = new FormData(this)

    $.ajax({
      type: 'post',
      url: "api/signup.php?step=1",
      data: formdata,
      processData: false,
      contentType: false,
      beforeSend: () => {
        $("#signup-button").attr("disabled", true)
        $("#signup-button").text("Checking... (Don't close or reload page)");
      },
      success: response => {
        console.log(response)
        if (response.status === "success") {
          $("input[name='hidden_signup_name']").val(response.data.signup_fullname)
          $("input[name='hidden_signup_email']").val(response.data.signup_email)
          $("input[name='hidden_signup_password']").val(response.data.signup_password)
          $("input[name='hidden_signup_contact']").val(response.data.signup_contact)

          $("#signupModal").modal("toggle");
          $("#otpSignupModal").modal("toggle");
        } else {
          alert(response.message)
        }

        $("#signup-button").attr("disabled", false)
        $("#signup-button").text("Signup");
      }
    })
  })

  $(document).on("submit", "#loginform", function (e) {
    e.preventDefault();

    var formdata = new FormData(this)

    $('#loadingOverlay').css("display", "flex");

    $.ajax({
      type: 'post',
      url: "api/login.php",
      data: formdata,
      processData: false,
      contentType: false,
      success: response => {
        if (response.status === "otp_required") {
          $("#loginModal").modal("toggle");
          $("#otpModal").modal("toggle");

          $("#client_name").val(response.data.name);
          $("#client_id").val(response.data.id);
          $("#client_email").val(response.data.email);
          $("#client_type").val(response.data.type);
        } else if (response.status === "error") {
          console.log(response)
        } else if (response.status === "success") {
          Swal.fire({
            icon: 'success',
            title: 'Logged In',
            text: 'Logged in successfully!',
          }).then(() => {
            location.href = response.redirect;
          });
        }
      },
      complete: () => {
        $('#loadingOverlay').css("display", "none");
      }
    })
  })
</script>

<?php
if (isset($_SESSION['userid']) && $_SESSION['userid'] !== 1 && $_SESSION['userid'] !== 2) {
  include "chat_floating.php";
}
?>
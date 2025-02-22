<style>
    nav {
        font-family: "Bebas";
        display: flex;
        align-items: center;
        background-color: #ffffff;
        padding: 1rem 4rem;
        position: sticky;
        top: 0;
        z-index: 5;
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
        font-size: 28px;

    }


    .logo>img {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    .nav-links {
        display: flex;
        flex-direction: row;
        margin-left: 8rem;
    }


    .nav-links>a {
        text-decoration: none;
        text-align: center;
        color: #000;
        font-size: 28px;
        font-weight: bold;
        width: 150px;
        padding: 1.25rem 0;
        cursor: pointer;
    }

    .nav-links>a:hover {
        color: #fff;
        background-color: #000;
    }

    .user-buttons {
        margin-left: auto;
        display: flex;
        flex-direction: row;
        gap: 1rem;
        cursor: pointer;
    }

    .user-buttons>a {
        padding: 0.75rem 2rem;
        font-size: 22px;
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

    #loginform, #signupform {
        font-family: "Bebas";
        font-size: 28px;
    }

   #loginform > input, #signupform > input {
        font-size: 18px;
        font-family: "Inter";
    }

    #signupform > button, #loginform > button {
        font-size: 24px;
        width: 100%;
        font-family: "Bebas";
    }
</style>

<nav>
    <div class="logo">
        <img src="../images/logo3.png">
        <a href="index.php">QUEEN AND KNIGHT EVENT SERVICES</a>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="index.php#packages">Packages</a>
        <a href="index.php#services">Services</a>
        <a href="index.php#about">About</a>
        <?php
            if(isset($_SESSION['userid']) && $_SESSION['usertype'] === "admin") {
                echo "<a href='packages.php'>Admin</a>";
            }
        ?>
    </div>

    <div class="user-buttons">
        <?php

            if(isset($_SESSION['userid'])){
                echo "
                <a class='login-btn'>".$_SESSION['userfullname']."</a>
                <a class='signup-btn' href='api/logout.php'>Logout</a>
                ";
            }else {
                echo "
                    <a class='login-btn' data-bs-toggle='modal' data-bs-target='#loginModal'>Login</a>
                    <a class='signup-btn' data-bs-toggle='modal' data-bs-target='#signupModal'>Sign Up</a>
                ";
            }
        ?>
    </div>
</nav>

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
                    <input class="form-control mb-4" name="signup_fullname" type="text" required />
                    <p>Email</p>
                    <input class="form-control mb-4" name="signup_email" type="email" required />
                    <p>Set Password</p>
                    <input class="form-control mb-4" name="signup_password" type="text" required />
                    <button class="btn btn-primary" type="submit">Signup</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("submit", "#signupform", function(e){
        e.preventDefault();

        var formdata = new FormData(this)

        $.ajax({
            type: 'post',
            url: "api/signup.php",
            data: formdata,
            processData: false,
            contentType: false,
            success: response => {
                alert(response.message)

                location.reload();
            }
        })
    })
    $(document).on("submit", "#loginform", function(e){
        e.preventDefault();

        var formdata = new FormData(this)

        $.ajax({
            type: 'post',
            url: "api/login.php",
            data: formdata,
            processData: false,
            contentType: false,
            success: response => {
                if(response.status === "success"){
                    alert("logged in")

                    localStorage.setItem("userid", response.data.id)
                    localStorage.setItem("useremail", response.data.email) 
                    localStorage.setItem("usertype", response.data.type) 

                    location.reload();
                }else {
                    alert(response.message)
                }
            }
        })
    })
</script>
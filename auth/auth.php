<?php
session_start();
if(isset($_SESSION["email"])){
    header("Location: ../home/home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />a
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login SignUp || Learn Code With Amit</title>
    <link rel="stylesheet" href="auth-style.css" />
    <!-- =============Font Awesome CDN Link================= -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="auth-serv.php">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" name="nom">
                <input type="email" placeholder="Email" name="email">
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" name="type" value="register" id="type">
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="auth-serv.php">
                <h1>Login In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <!-- <input type="text" placeholder="Name"> -->
                <input type="email" placeholder="Email" name="email" >
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" name="type" value="login" id="type">
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Don't have an account!</h1>
                    <h2>Create one </h2>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
        <!-- <input type="hidden" name="type" value="login" id="type"> -->a

    </div>

    <!-- error message -->
    <style>
        /* Error message styling */
        .error-alert {
            display: none; /* Initially hidden */
            background-color: #f8d7da; /* Light red */
            color: #721c24; /* Dark red */
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            width: 300px;
            text-align: center;
            margin: 20px auto;
            opacity: 0;
            transition: opacity 0.5s ease-in-out; /* Smooth fade-in effect */
            position: absolute;
            top: 0;
            z-index: 1000;
        }
    </style>
        <?php if (isset($_SESSION['error-login'])): ?>
            <div id="error-alert" class="error-alert">
                <?php echo $_SESSION['error-login']; ?>
            </div>
            <?php unset($_SESSION['error-login']); ?> <!-- Clear the error after displaying -->
        <?php endif; ?>


<script>
    const container=document.getElementById('container');
    const registerBtn=document.getElementById('register');
    const loginBtn=document.getElementById('login');

    registerBtn.addEventListener('click',()=>{
        // document.getElementById("tfype").value="register";
        container.classList.add("active");
    });
     loginBtn.addEventListener('click',()=>{
        // document.getElementById("type").value="login";
        container.classList.remove("active");
     });


    //  error message
    document.addEventListener("DOMContentLoaded", function () {
        let errorAlert = document.getElementById("error-alert");
        if (errorAlert) {
            errorAlert.style.display = "block"; // Show the alert
            errorAlert.style.opacity = "1"; // Fade in

            setTimeout(() => {
                errorAlert.style.opacity = "1"; // Fade in
            }, 100);

            // setTimeout(() => {
            //     errorAlert.style.opacity = "0"; // Fade out after 3s
            //     setTimeout(() => errorAlert.style.display = "none", 500);
            // }, 3000);
        }
    });

</script>





  </body>
</html>

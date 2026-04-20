<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Full Screen Layout */
        body, html {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f7f2e8;
        }

        /* Login Container */
        .container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        /* Left Side - Login */
        .left-container {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5%;
            background: white;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            margin: auto;
            text-align: center;
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
            font-size: 2rem;
        }

        p {
            color: #777;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            text-align: left;
            margin-bottom: 5px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: #5a1b85;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #4a156e;
        }

        /* Right Side - Animated Circle */
        .right-container {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f7f2e8;
        }

        .circle {
            width: 300px;
            height: 300px;
            background: linear-gradient(to bottom, #5a1b85, #9a6ebe);
            border-radius: 50%;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .circle {
                width: 250px;
                height: 250px;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .left-container, .right-container {
                width: 100%;
                padding: 10%;
            }

            .right-container {
                display: none; /* Hide circle on mobile */
            }

            input, .login-btn {
                font-size: 1rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Side - Login -->
    <div class="left-container">
        <div class="login-box">
            <h2>Student Login</h2>
            <p>Welcome back! Please enter your details</p>

            <form id="loginForm" action="login.php" method="POST" onsubmit="return validateForm();">
                <input type="email" name="email" id="email" placeholder="Enter email">
                <p class="error-message" id="emailError">
                    <?php echo isset($_GET['emailError']) ? $_GET['emailError'] : ''; ?>
                </p>

                <input type="password" name="password" id="password" placeholder="Enter password">
                <p class="error-message" id="passwordError">
                    <?php echo isset($_GET['passwordError']) ? $_GET['passwordError'] : ''; ?>
                </p>

                <button class="login-btn" type="submit">LOGIN</button>
            </form>
        </div>
    </div>

    <!-- Right Side - Animated Circle -->
    <div class="right-container">
        <div class="circle"></div>
    </div>
</div>

    <script>
     function validateForm() {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    // Clear previous errors
    emailError.textContent = "";
    passwordError.textContent = "";

    let isValid = true;

    // Email Empty Check
    if (!email) {
        emailError.textContent = "Email field cannot be empty.";
        isValid = false;
    } 
    // Email Format Check
    else if (!email.includes("@") || !email.includes(".")) {
        emailError.textContent = "Enter a valid email address.";
        isValid = false;
    }

    // Password Empty Check
    if (!password) {
        passwordError.textContent = "Password field cannot be empty.";
        isValid = false;
    }
    // Password Length Check
    else if (password.length < 2) {
        passwordError.textContent = "Password must be at least 6 characters long.";
        isValid = false;
    }

    return isValid; // Only submit the form if all checks pass
}
   
       
    </script>

</body>
</html>

<?php
session_start();

require("conection/connect.php");

$msg = "";
if (isset($_POST['btn_log'])) {
    $uname = $_POST['unametxt'];
    $pwd = $_POST['pwdtxt'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $uname, $pwd); // 'ss' indicates two strings
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // $row = $result->fetch_assoc();
        // if ($row['type'] == 'admin') {
        //     $msg = "Login trov hery!.....";
        // } else {
            header("Location: everyone.php");
            exit();
        // }
    } else {
        $msg = "Invalid login authentication, try again!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map"/> -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css"/> -->
<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css.map"/> -->
<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css"/> -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
<!-- <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="css/login.css" /> -->
<title>EduSphere.</title>
<style>
    body{
        background:#f0ead6;
        height:100vh;
        /* position:relative; */
        display:flex;
        width:100vw;
    }
    .con{
        width:40%;
        background:white;
        padding-top: 30px;
        display:flex;
        flex-direction:column;
        align-items:center;
        /* justify-content:center; */
        
    }
    p{
        margin-bottom:20px;
    }
    .logo{
        width:60%;
        display:flex;
        /* flex-direction:column; */
        align-items:center;
        justify-content:center;
    }
    .inp{
        width: 350px;
        padding: 10px;
        margin-bottom:10px;
        border:1px solid #e2e2e2;
        border-radius:6px;
    }
    .button{
        margin-top:20px;
        width:350px;
        background: #662d91;
        color:white;
        text-transform:uppercase;
        height:30px;
        font-weight:lighter;
        /* padding:4px; */
        /* border-radius:4px; */
        border:none;
    }
    



.pur-ball {
    position: relative;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: #662d91;
    overflow: hidden; /* Prevents pseudo-element from going outside */
}

.pur-ball::after {
    content: "";
    position: absolute;
    width: 350px;
    height: 50%; /* Covers the bottom half */
    bottom: 0;
    background: rgba(255, 255, 255, 0.2); /* Semi-transparent white */
    backdrop-filter: blur(10px); /* Adds blurriness */
}

/* For tablets and medium-sized screens */
@media (max-width: 1024px) {
    .con {
        width: 60%; /* Increase width to accommodate more space */
    }
    .inp, .button {
        width: 300px;
    }
    .pur-ball {
        width: 150px;
        height: 150px;
    }
}

/* For smaller tablets and large phones */
@media (max-width: 768px) {
    .con {
        width: 80%;
    }
    .inp, .button {
        width: 280px;
    }
    .pur-ball {
        width: 120px;
        height: 120px;
    }
}

/* For mobile screens */
@media (max-width: 480px) {
    body {
        flex-direction: column; /* Stack items vertically */
        align-items: center;
    }
    .con {
        /* margin-top:50px; */
        width: 90%;
        margin:auto;
        padding: 20px;
    }
    .inp, .button {
        width: 100%; /* Full width on smaller screens */
    }
    .pur-ball {
        display:none;
        width: 100px;
        height: 100px;
    }
}

</style>
</head>

<body>
	<div class="con">
    		
    		<h2>Admin Login</h2>
            <p>Welcome back!Please enter your details</p>
    	
    		<form method="post">
                    <input type="text" class="inp" name="unametxt" placeholder="Enter username here" title="Enter username here" /><br>
                    <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:14px;margin-bottom:10px">Username should not be empty</p>
                    <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:14px;margin-bottom:10px">Username should contain at least 4 characters</p>
                    <p id="dname_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:14px;margin-bottom:10px">Username should contain only letters</p>
                    <input type="password" class="inp" name="pwdtxt" placeholder="Enter password here" title="Enter password here" /><br>
                    <p id="dcode_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:14px;margin-bottom:10px">Password should not be empty</p>
                    <p id="dcode_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:14px;margin-bottom:10px">Password should contain at least 4 characters</p>
                    <input type="submit" href="#" class="button" name="btn_log" value="Login"/>
                    <!-- <p style="color:red; text-align: center;">
                        <?php echo $msg; ?>
                    </p>     -->
            </form>

    	</div>
    </div>
    <div class="logo">

        <div class="pur-ball">
        </div>
       
    </div>

	
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let dnameInput = document.querySelector("input[name='unametxt']");
        let dcodeInput = document.querySelector("input[name='pwdtxt']");
        let submitBtn = document.querySelector(".button");
  

    let dnameEmpty = document.querySelector("#dname_empty");
    let dnameSize = document.querySelector("#dname_size");
    let dnameLetter = document.querySelector("#dname_letter");
    let dcodeEmpty = document.querySelector("#dcode_empty");
    let dcodeLetter = document.querySelector("#dcode_size");

    // Function to clear error messages when typing
    function clearDnameErrors() {
        dnameEmpty.style.display = "none";
        dnameSize.style.display = "none";
        dnameLetter.style.display = "none";
    }

    function clearDcodeErrors() {
        dcodeEmpty.style.display = "none";
        dcodeLetter.style.display = "none";
    }

    // Add event listeners for real-time validation
    dnameInput.addEventListener("input", clearDnameErrors);
    dcodeInput.addEventListener("input", clearDcodeErrors);

    submitBtn.addEventListener("click", function (event) {
        let departmentName = dnameInput.value.trim();
        let departmentCode = dcodeInput.value.trim();
        let valid = true; // Track form validity

        // Validation for Department Name
        if (departmentName === "") {
            dnameEmpty.style.display = "block";
            valid = false;
        } else if (/^[A-Za-z ]+$/.test(departmentName) && departmentName.length < 4) {
            dnameSize.style.display = "block";
            valid = false;
        }
        else if (!/^[A-Za-z ]+$/.test(departmentName)) {
            dnameLetter.style.display = "block";
            valid = false;
        }

        // Validation for Department Code
        if (departmentCode === "") {
            dcodeEmpty.style.display = "block";
            valid = false;
        } else if (departmentCode.length < 4) {
            dcodeLetter.style.display = "block";
            valid = false;
        }

        // Prevent form submission if invalid
        if (valid) {
            alert("Submitted successfully");
        }else{
            event.preventDefault();

        }
    });
});

</script>
</html> 

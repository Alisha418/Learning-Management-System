<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* 🔹 Medium Screens (Tablets: 768px - 1024px) */
 
@media screen and (max-width: 1024px) {
    .panel {
        width: 80%;
        /* height:max-content; */
        padding: 15px;
    }

    form {
        max-width: 450px;
    }

    .teacher_note_pos input {
        padding: 7px;
        font-size: 14px;
    }

    .submit_btn, .reset_btn {
        font-size: 14px;
        padding: 10px 15px;
    }
}

/* 🔹 Small Screens (Phones: < 768px) */
@media screen and (max-width: 768px) {
    .panel {
        width: 100% !important;
        height:max-content;
        margin:auto;
        padding: 15px;
        margin-top:100px !important;
        margin-left:10px !important;
        margin-right:10px !important;
    }

    .panel-heading h1 {
        font-size: 20px;
    }

    form {
        max-width: 100%;
    }

    .teacher_note_pos input {
        font-size: 14px !important;
        padding: 7px !important;
    }

    .submit_btn, .reset_btn {
        font-size: 14px !important;
        padding: 10px 15px !important;
    }
}

/* 🔹 Extra Small Screens (Very Small Phones: < 480px) */
@media screen and (max-width: 480px) {
    .panel {
        width: 95%;
        padding: 10px !important;
    }

    .panel-heading h1 {
        font-size: 18px !important;
    }

    .teacher_note_pos input {
        font-size: 14px;
        padding: 6px;
    }

    .submit_btn, .reset_btn {
        font-size: 12px !important;
        padding: 8px 12px !important;
    }
    .hamburger{
        font-size:20px !important;
        
    }
}
@media screen and (max-width: 320px) {
    .panel {
        width: 100%;
        padding: 10px !important;
    }
    .panel-heading{
        /* width:100%; */
    }
    .panel-heading h1 {
        font-size: 16px !important; 
        padding:3px !important;
        /* width:100%; */
    }

    .teacher_note_pos input {
        font-size: 12px !important;
        padding: 5px !important;
    }

    .submit_btn, .reset_btn {
        font-size: 12px !important;
        padding: 10px !important;
    }
    .container p{
        font-size:14px;
    }
}
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    overflow: hidden;
    height: 100vh; 
    display: flex;
}

/* Hamburger Menu Icon */
.hamburger {
    display:none;
    font-size: 30px;
    background: none;
    border: none;
    cursor: pointer;
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1000;
    color: white;
    background-color: black;
    padding: 10px 15px;
    border-radius: 5px;
}

/* Sidebar Styles */
.sidebar {
    flex-shrink: 0;
    width: 250px;
    height: 100vh; /* Full viewport height */
    background: black;
    padding-top: 60px;
    box-sizing: border-box;
   
}

/* Close Button Inside Sidebar */
.close-btn {
    display:none;
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 30px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
}

/* Sidebar Links */
.sidebar-links {
    list-style: none;
    padding: 0;
}

.sidebar-links li {
    padding: 15px;
}

.sidebar-links a {
    text-decoration: none;
    color: white;
    font-size: 18px;
    display: block;
}

/* Show sidebar when active */
.sidebar.active {
    left: 0;
}

/* Hide hamburger menu when sidebar is open */
.hamburger.hidden {
    display: none;
}

/* Responsive: Show only on small screens */
@media screen and (max-width: 768px) {
    .sidebar {
    width: 250px;
    height: 100%;
    position: fixed;
    top: 0;
    left: -250px; 
    background: black;
    transition: left 0.3s ease-in-out;
    padding-top: 60px;
    z-index: 2000; /* Ensure it appears on top */
  }
    .hamburger {
        display: block;
    }
    .close-btn{
        display:block;
    }
    
}

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("sidebar");
    const closeBtn = document.getElementById("close-btn");
    const sidebarLinks = document.querySelectorAll(".sidebar-link");

    // Open sidebar
    menuBtn.addEventListener("click", function () {
        sidebar.classList.add("active");
        menuBtn.classList.add("hidden");
    });

    // Close sidebar on close button click
    closeBtn.addEventListener("click", function () {
        sidebar.classList.remove("active");
        menuBtn.classList.remove("hidden");
    });

    // Close sidebar when any link is clicked
    sidebarLinks.forEach(link => {
        link.addEventListener("click", function () {
            sidebar.classList.remove("active");
            menuBtn.classList.remove("hidden");
        });
    });
});

</script>
<body>

    <!-- Hamburger Menu Icon -->
    <button id="menu-btn" class="hamburger">&#9776;</button>
    <div style="display:flex;width:100%;align-items:stretch;">

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <button id="close-btn" class="close-btn">&times;</button>
            <ul class="sidebar-links">
                <li><a href="#home" class="sidebar-link">Home</a></li>
                <li><a href="#about" class="sidebar-link">About</a></li>
                <li><a href="#services" class="sidebar-link">Services</a></li>
                <li><a href="#contact" class="sidebar-link">Contact</a></li>
            </ul>
        </div>
      
    
                
           <div class="panel panel-default panel-p" style="flex:1;box-sizing:border-box;width:80%;background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);min-height:max-content;margin:0 40px 20px 40px;">
              <div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align:center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Department Entry Form</h1></div>
              <div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
              <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
             <div class="container" style="width:auto;text-align:center;">
                <p style="text-align:center;margin:0;padding:0;">Here, you'll add new department's detail to record into database.</p>
             </div>
    
             <!-- <div class="container_form"> -->
    
                
                    <div class="teacher_note_pos" style="margin:0;">
                        <input type="text" class="form-control" name="dname" id="textbox" placeholder="Department Name" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                        <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Department name should not be empty</p>
                        <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Department name should contain at least 4 characters</p>
                        <p id="dname_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Department name should contain only letters</p>
                    </div><br>
                
                    <div class="teacher_note_pos" style="margin:0;">
                        <input type="text" class="form-control" name="dcode"  id="textbox" placeholder="Department Code" style="width:100%;padding:8px;margin:5px 0;border:2px solid rgb(70, 55, 82);border-radius:5px;background-color:white;color:black;"/>
                        <p id="dcode_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Department code should not be empty</p>
                        <p id="dcode_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Department code should only contain uppercase letters</p>
                    </div><br>
                    
                
                    <div>
                        <input type="submit" class="submit_btn" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
                        <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                    </div>
               </form>
            </div>
        </form>
    </div><!-- end of style_informatios -->
    </div>

</body>
<script>
  

document.addEventListener("DOMContentLoaded", function () {
    let dnameInput = document.querySelector("input[name='dname']");
    let dcodeInput = document.querySelector("input[name='dcode']");
    let submitBtn = document.querySelector(".submit_btn");

    let dnameEmpty = document.querySelector("#dname_empty");
    let dnameSize = document.querySelector("#dname_size");
    let dnameLetter = document.querySelector("#dname_letter");
    let dcodeEmpty = document.querySelector("#dcode_empty");
    let dcodeLetter = document.querySelector("#dcode_letter");

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
        } else if (!/^[A-Z]+$/.test(departmentCode)) {
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


    <!-- <script src="script.js"></script> -->
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
  
 
    @media screen and (max-width: 1024px) {
    .btn_pos {
        margin-top: 30px;
        text-align: center;
    }
    .input_box_pos {
        width: 80%;
    }
    .btn_pos_search input {
        width: 100%;
        margin-top: 5px;
    }
    .table_margin {
        width: 100%;
    }
    table {
        font-size: 14px;
    }
}


@media screen and (max-width: 768px) {
    .btn_pos {
        margin-top: 20px;
        flex-direction: column;
        align-items: center;
    }
    .input_box_pos {
        width: 100%;
        font-size: 14px;
    }
    .btn_pos_search input {
        width: 100%;
        font-size: 14px;
        padding: 6px 10px;
    }
    .table_margin {
        overflow-x: scroll;
    }
    table {
        font-size: 12px;
    }
    th, td {
        padding: 5px;
    }
}


@media screen and (max-width: 480px) {
    .hamburger{
        font-size:20px !important;
    }
    .btn_pos {
        margin-top: 10px;
    }
    .input_box_pos {
        font-size: 12px;
    }
    .btn_pos_search input {
        font-size: 12px;
        padding: 5px 8px;
    }
    .table_margin {
        width: 100%;
        overflow-x: auto;
    }
    table {
        font-size: 10px;
    }
    th, td {
        padding: 3px;
    }
    th {
        font-size: 11px;
    }
    td {
        font-size: 10px;
    }
}
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    overflow: hidden;
    height: 100vh; /* Ensure full height */
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
      

  <div class="btn_pos" style="margin-top:50px;flex:1;">
    <form method="post">
        <input type="text" name="searchtxt" class="input_box_pos form-control" style="padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Search name.." />
        <div class="btn_pos_search">
            <input type="submit" class="" style="padding:8px 14px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" name="btnsearch" value="Search"/>&nbsp;
            <a href="?tag=Department_entry"><input type="button" class="" style="padding:8px 14px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" value="Register new" name="butAdd"/></a>
        </div>
    </form>
</div>

<div class="table_margin" style="width:98%;overflow-x:auto;border:2px solid #662d91">
<table class="table table-bordered">
        <thead>
            <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Department Name</th>
            <th style="text-align: center;">Department Code</th>

            <th style="text-align: center;" colspan="2">Operation</th>
            </tr>
            <tr>
            <td style="text-align: center;">1</td>
            <td style="text-align: center;">Computer Science</td>
            <td style="text-align: center;">CS</td>
            <td style="text-align:center;">

               <a href="?tag=Department_entry&opr=upd&dname=Computer%20Science&dcode=CS" title="Update">
                <img src="picture/update.png" height="20" alt="Update" />
               </a>
            </td>

            <td style="text-align:center;"><a href="#" title="Delete">
                    <img src="picture/delete.jpg" height="20" alt="Delete" /> </a>
            </td>
            </tr>
            <tr>
            <td style="text-align: center;">2</td>
            <td style="text-align: center;">Electrical Engineering</td>
            <td style="text-align: center;">EE</td>

            <td style="text-align:center;">

               <a href="?tag=Department_entry&opr=upd&dname=Electrical%20Engineering&dcode=EE" title="Update">
                <img src="picture/update.png" height="20" alt="Update" />
               </a>
            </td>
            <td style="text-align:center;"><a href="#" title="Delete">
                    <img src="picture/delete.jpg" height="20" alt="Delete" /> </a>
            </td>
            </tr>
        </thead>
        
</table>
</div><!--end of content_input -->

                
       
</div>
</body>
</html>
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

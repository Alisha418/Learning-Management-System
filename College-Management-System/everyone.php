<?php
	session_start();
	require("conection/connect.php");
	$tag="";
	if (isset($_GET['tag']))
	$tag=$_GET['tag'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Welcome to College Management system</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="jquery-1.11.0.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
<style>
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
     height: 100vh !important;
     position: fixed;
     top: 0;
     left: -250px; 
     background: black;
     transition: left 0.3s ease-in-out;
     padding-top: 60px;
	 overflow-y:auto !important;
     z-index: 2000; /* Ensure it appears on top */
	 
    }
    .hamburger {
        display: block;
		font-size:25px;
		padding: 7px 14px;
		/* font-size:20px; */
    }
    .close-btn{
        display:block;
    }
    
}
@media screen and (max-width: 700px) {
	.hamburger{
		font-size:23px !important;
		padding: 6px 12px;
	}
}
@media screen and (max-width: 500px) {
	.hamburger{
		font-size:20px !important;
		padding: 5px 10px;
	}
}
@media screen and (max-width: 230px) {
	.sidebar{
		padding:30px !important;
		height:100vh !important;
		padding-bottom:0 !important;
	
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
<!-- <link rel="stylesheet" type="text/css" href="css/home.css" /> -->
</head>
<!-- <body style="display:flex; align-items:stretch; gap:10px; background:#f5f5f5; overflow-x:hidden;"> -->
<body style="display:flex;background:#f5f5f5; overflow-x:hidden;height:100vh;margin:0;padding:0;">
   <div style="display:flex; width:100%; align-items:stretch;gap:10px;">
       <!-- <button class="sidebar-toggle">☰</button> -->
		
	   <button id="menu-btn" class="hamburger">&#9776;</button>

	   <div class="sidebar" id="sidebar" style="flex:1;background:#1a1a1a;max-width:230px; padding:20px; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);height:max-content;">
		   
		   <?php        
			   include './drop_down_menu.php';
		   ?>
						   
	    </div>
	    <div class="container_middle" style="flex:1;width:80%;overflow-y:auto;overflow-x:hidden;">		
			   
		  <!-- <div class="container_show_post" style="padding-bottom:4px;"> -->
							   <?php
										if($tag=="home" or $tag=="")
										  include("home.php");
										   // include("home.php");
									    elseif($tag=="student_entry")
										   include("Students_Entry.php");
									    elseif($tag=="teachers_entry")
										   include("Teachers_Entry.php");
									    elseif($tag=="Department_entry")
										   include("Department_Entry.php");	
									    elseif($tag=="subject_entry")
										   include("Subject_Entry.php");
									    elseif($tag=="session_entry")
										   include("Session_Entry.php");
									    elseif($tag=="semester_entry")
										   include("Semester_Entry.php");	
										elseif($tag=="section_entry")
										   include("Section_Entry.php");	
									 
									    elseif($tag=="view_students")
										   include("View_Students.php");
									    elseif($tag=="view_teachers")
										   include("View_Teachers.php");
									    elseif($tag=="view_subjects")
										   include("View_Subjects.php");
									    elseif($tag=="view_scores")
										   include("View_Scores.php");
									    elseif($tag=="view_users")
										   include("View_Users.php");
									    elseif($tag=="view_faculties")
										   include("View_Faculties.php");
									    elseif($tag=="location_entry")
										   include("Location_Entry.php");
									    elseif($tag=="semester_entry")
										   include("Semester_entry.php");
										elseif($tag=="semester_view")
										   include("Semester_view.php");
										elseif($tag=="offer_entry")
										   include("Offer_entry.php");
										elseif($tag=="offer_view")
										   include("Offer_view.php");
										elseif($tag=="enroll_entry")
										   include("Enroll_entry.php");
										elseif($tag=="enroll_view")
										   include("Enroll_view.php");
										elseif($tag=="artical_entry")
										   include("Artical_Entry.php");
				
									    elseif($tag=="view_artical")
										   include("View_Article.php");
										elseif($tag=="department_view")
										   include("Department_view.php");	
										elseif($tag=="session_view")
										   include("Session_view.php");	
										elseif($tag=="section_view")
										   include("Section_view.php");	
										elseif($tag=="survey")
										   include("Feedback.php");	 
									    elseif($tag=="timetable_entry")
										   include("TimeTable_Entry.php");	
										   /*$tag= $_REQUEST['tag'];
										   
										   /*if(empty($tag)){
											   include ("Students_Entry.php");
										   }
										   else{
											   include $tag;
										   }*/
												   
									   ?>
								   </div>
				              
				   <!-- </div> -->
					   
        </div>
                   
		
        <!-- <div class="bottom_pos">
            <a href="AboutManagement.php" style="text-decoration: none;">About management</a>
        </div> -->
</body>
</html>


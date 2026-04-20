
<!--first button-->
<!-- btn btn-default dropdown-toggle -->
 <head>
	<style>
		.menu-btn:hover{
			background:#8544c6 !important;
			transform: scale(1.05);
			/* color:white; */


		}
		.list-con{
			/* list-style-type: none; */
			display:none;
			padding-left: 20px;
			border-left: 3px solid #8544c6; /* Lighter Purple for contrast */
			/* margin-bottom:0; */
			/* width:70px; */
			/* text-decoration:none; */
		}
		/* .list-con:hover{
			background:rgb(212, 102, 195);
			
		} */
		.submenu-a{
			display:block;
			padding:10px;
			color:white;
			text-decoration:none;
			font-size:14px;
			border-radius:3px;
			background:#3d1c60;
			transition:background 0.3s ease-in-out;
		    /* display: flex;
            align-items: center; 
           justify-content: center; 
			color:#ffffff;
			background:#3d1c60; */
			/* display:block; */
			/* padding-bottom:2px; */
			/* text-align:center; */
		}
		.submenu-a:hover{
			text-decoration:none;
			color:white; 
			background:#8544c6;
			/* padding:4px 0; */
			/* font-size:14px; 
			height:30px; */
		}
   .logout{
    display: block;
    /* width: 100%; */
    background-color: #662d91; /* Red */
    color: white;
    text-align: center;
    padding: 6px 10px;
    border-radius: 5px;
    border: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 20px; /* Space from menu items */
    transition: background 0.3s ease-in-out, transform 0.2s;
  }

/* Hover Effect */
.logout:hover {
    background-color: #c9302c; /* Darker Red */
    transform: scale(1.05);
}
.menu-btn{
	width:100%;
	box-sizing:border-box;
	display:flex;background:#662d91;
	align-items:center;
	gap:5px;
	
	/* justify-content:center; */
	padding:12px 20px;border-radius:5px;margin-bottom:10px;
	cursor:pointer;border:1px solid #3d1c60;font-size:16px; 
	transition: background 0.3s ease-in-out, transform 0.2s;color:white;
}
#offer{
	padding:12px 15px;
}
#enroll{
	padding:12px 5px;
}
.menu-btn span{
	line-height:1;
	display:flex;
	align-items:center;
}
/* Default styles (Desktop First) */
/* Adjustments for larger screens (above 1200px) */
@media (min-width: 1200px) {
  .menu-btn {
    font-size: 18px;
    padding: 14px 24px;
  }
  .caret{
	margin-left:20px !important;
  }
  .submenu-a {
    font-size: 16px;
  }
  #offer{
	font-size: 18px !important;
    padding: 14px 15px !important;
  }
  #enroll{
	font-size: 18px !important;
    padding: 14px 5px !important;
  }
}

/* Tablets (768px - 1200px) */
@media (max-width: 1200px) {
  .menu-btn {
    font-size: 16px;
    padding: 10px 16px;
  }
  #offer{
	font-size: 16px !important;
    padding: 10px 16px !important;
  }
  #enroll{
	font-size: 16px !important;
    padding: 10px 15px!important;
  }
  .submenu-a {
    font-size: 14px;
  }
  .drop{
	margin-left:0 !important;
  }
}

/* Smaller tablets and large phones (600px - 768px) */
@media (max-width: 768px) {
  .menu-btn {
    font-size: 14px;
    padding: 8px 15px;
  }
  #enroll{
	font-size: 14px !important;
    padding: 8px 15px !important;
  }
  #offer{
	font-size: 14px !important;
    padding: 8px 15px !important;

  }
  .submenu-a {
    font-size: 12px;
  }
  .logout {
    font-size: 14px;
    padding: 5px 8px;
  }
}


@media (max-width: 230px) {
  .menu-btn {
    font-size: 12px;
    padding: 6px 12px;
  }
  #enroll{
	font-size: 12px !important;
    padding: 6px 12px !important;
  }
  #offer{
	font-size: 12px !important;
    padding: 6px 12px !important;

  }
  .submenu-a {
    font-size: 10px;
  }
  .logout {
    font-size: 12px;
    padding: 6px 12px;
  }
}
	</style>

 </head>

	<button id="close-btn" class="close-btn">&times;</button>
	<div style="width:100%;color:white;display:flex;flex-direction:column;align-items:center;margin-bottom:10px;">
		<!-- <div style="width:50px;height:50px;border-radius:50%;border:3px solid white;text-align:center;"> -->

		<i class="bi bi-person-circle" style="font-size:50px;color:white;"></i>
		<!-- </div> -->
		<p style="font-size:20px;">Admin</p>
	</div>
	<div class="menu-button" style="display:flex; flex-direction:column;padding-left:0;">
	  <div class="btn-group">
	   <button type="button" class="menu-btn" onclick="window.location.href='everyone.php?tag=home'" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt" style=""></span>
	     Dashboard
	  </button>
    </div>
	
	 <div class="btn-group">
	  <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style=""></span>
	   Students	
	  </button>
	 <!-- dropdown-menu -->
	 <div class="list-con" role="menu" id="menu">
	  <a class="submenu-a sidebar-link" href="everyone.php?tag=student_entry">Students Entry</a>
	  <a class="submenu-a sidebar-link" href="everyone.php?tag=view_students">View Students</a>
	  </div>
	 </div>
	
	<!--second button-->
	<div class="btn-group">
	 <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style=""></span>
	   Teachers 				
	  </button>
	 <div class="list-con" role="menu" id="menu">
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=teachers_entry">Teachers Entry</a>
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=view_teachers">View Teachers</a>
     </div>
	</div>
	
	<!--third button-->
	<div class="btn-group">
	 <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-hdd" style=""></span>
	   Department 					
	  </button>
	<div class="list-con" role="menu" id="menu">
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=Department_entry">Department Entry</a>
	 <a class="submenu-a sidebar-link"  href="everyone.php?tag=department_view">View Departments</a>
   </div>
	</div>
	<div class="btn-group">
	 <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list" style=""></span>
	   Sessions 				
	  </button>
	<div class="list-con" role="menu" id="menu">
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=session_entry">Sessions Entry</a>
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=session_view">View Sessions</a>
   </div>
	</div>
	<div class="btn-group">
	 <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list" style=""></span>
	   Sections 				
	  </button>
	<div class="list-con" role="menu" id="menu">
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=section_entry">Section Entry</a>
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=section_view">View Sections</a>
   </div>
	</div>
	<!--forth button-->
	<div class="btn-group">
	 <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list" style=""></span>
	   Subjects				
	  </button>
	<div class="list-con" role="menu" id="menu">
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=subject_entry">Subjects Entry</a>
	 <a class="submenu-a sidebar-link" href="everyone.php?tag=view_subjects">View Subjects</a>
   </div>
	</div>
	<div class="btn-group">
	 <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list" style=""></span>
	   Semesters			
	  </button>
     	<div class="list-con" role="menu" id="menu">
	      <a class="submenu-a sidebar-link" href="everyone.php?tag=semester_entry">Semester Entry</a>
	      <a class="submenu-a sidebar-link" href="everyone.php?tag=semester_view">View Semester</a>
        </div>
	</div>
	<div class="btn-group">
	 <button type="button" class="menu-btn" id="offer" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list" style=""></span>
	   Subject Offering	
	  </button>
	  <div class="list-con" role="menu" id="menu">
	    <a class="submenu-a sidebar-link" href="everyone.php?tag=offer_entry">Offer Subject</a>
	    <a class="submenu-a sidebar-link" href="everyone.php?tag=offer_view">Offered Subjects</a>
      </div>
    </div>
   <!-- <div class="btn-group">
	 <button type="button" class="menu-btn" id="enroll" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list" style=""></span>
	   Student Enrollment		
	  </button>
	 <div class="list-con" role="menu" id="menu">
	  <a class="submenu-a sidebar-link" href="everyone.php?tag=enroll_entry">Enroll Student</a>
	  <a class="submenu-a sidebar-link" href="everyone.php?tag=enroll_view">Enrolled Students</a>
     </div>
	</div> -->
	<div class="menu-button" style="display:flex; flex-direction:column;padding-left:0;">
	  <div class="btn-group">
	   <button type="button" class="menu-btn" onclick="window.location.href='everyone.php?tag=survey'" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt" style=""></span>
	     Surveys
	   </button>
      </div>
    </div>
	<div class="menu-button" style="display:flex; flex-direction:column;padding-left:0;">
	  <div class="btn-group">
	   <button type="button" class="menu-btn" onclick="window.location.href='everyone.php?tag=timetable_entry'" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt" style=""></span>
	     TimeTable
	   </button>
      </div>
    </div>
	
	
	<!--seventh button-->
	
	<!--eaigth button-->
	<div class="btn-group">
	  <button type="button" class="menu-btn" onclick="dropdown()" data-toggle="dropdown"><span class="glyphicon glyphicon-align-justify" style=""></span>
	   Article 			
	  </button>
	  <div class="list-con" role="menu" id="menu">
	   <a class="submenu-a sidebar-link" href="?tag=artical_entry">Article Entry</a>
	   <a class="submenu-a sidebar-link" href="?tag=view_artical">View Article</a>
      </div>
	</div>
	<div class="btn-group">
	  <button type="button" class="menu-btn"  onclick="window.location.href='index.php'"><span class="glyphicon glyphicon-log-out" style=""></span>
	    Logout			
	  </button>
    </div>
	<!-- <div class="logout_btn">
		<span class="glyphicon glyphicon-log-out glyphicon-align-justify"></span><button class="menu-btn">Logout</button>
	</div> -->
	<!-- <a href="index.php" class="btn btn-primary btn-large">Logout <i class="icon-white icon-check"></i></a> -->

</div>
<script>
//   function dropdown() {
//     var menu = document.getElementById("menu");
   

//     if (menu.style.display === "none" || menu.style.display === "") {
//         menu.style.display = "block"; // Show the dropdown
        
//     } else {
//         menu.style.display = "none"; // Hide the dropdown
       
//     }
// }

document.addEventListener("DOMContentLoaded", function () {
    // Select all buttons with the class 'menu-btn'
    const buttons = document.querySelectorAll(".menu-btn");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            // Find the submenu related to the clicked button
            const menu = this.nextElementSibling; // Assuming submenu is directly after the button
            
            // Close all other open submenus
            document.querySelectorAll(".list-con").forEach(sub => {
                if (sub !== menu) {
                    sub.style.display = "none";
                }
            });

            // Toggle only the clicked button's submenu
            if (menu.style.display === "none" || menu.style.display === "") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        });
    });
});


</script>				     
                               
<?php
// include "connect.php"; // Ensure connection file is included

$id = "";
$opr = "";
if (isset($_GET['opr']))
    $opr = $_GET['opr'];

if (isset($_GET['rs_id']))
    $id = $_GET['rs_id'];

//-------------- Add Data -----------------    
if (isset($_POST['btn_sub'])) {
   
    $name = $_POST['name'];
    // Get Department ID
$dep = mysqli_real_escape_string($conn, $_POST['department']);
$session = mysqli_real_escape_string($conn, $_POST['session']);

// Query department table
$dep_query = mysqli_query($conn, "SELECT DepId FROM department WHERE DepName = '$dep'");
$dep_row = mysqli_fetch_assoc($dep_query);
$dep_id = $dep_row['DepId'];

// Query session table
$session_query = mysqli_query($conn, "SELECT SessionId FROM session WHERE SessionName = '$session'");
$session_row = mysqli_fetch_assoc($session_query);
$session_id = $session_row['SessionId'];

   
   

    // ✅ Use `mysqli_query` and pass `$conn`
    $sql_ins = mysqli_query($conn, "INSERT INTO section
                        (SectionName, Dep_Id, Session_Id) 
                        VALUES ('$name', '$dep_id','$session_id')");

    if ($sql_ins) {
        // echo "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;'>"
        //     . "<span class='p_font'>"
        //     . "1 Row Inserted Successfully!"
        //     . "</span>"
        //     . "</div>";
		echo "<script>alert('Submitted Successfully')</script>";
    } else {
		
		echo "<script>alert('Insert Error:',mysqli_error($conn))</script>";
        
    }
}

//------------------ Update Data ----------
if (isset($_POST['btn_upd'])) {
   
    $name = $_POST['Section'];
    // Get Department ID
$dep = mysqli_real_escape_string($conn, $_POST['department']);
$session = mysqli_real_escape_string($conn, $_POST['session']);

// Query department table
$dep_query = mysqli_query($conn, "SELECT DepId FROM department WHERE DepName = '$dep'");
$dep_row = mysqli_fetch_assoc($dep_query);
$dep_id = $dep_row['DepId'];

// Query session table
$session_query = mysqli_query($conn, "SELECT SessionId FROM session WHERE SessionName = '$session'");
$session_row = mysqli_fetch_assoc($session_query);
$session_id = $session_row['SessionId'];

   
  

    $sql_update = mysqli_query($conn, "UPDATE section SET 
                           
                            SectionName='$name',
                            Dep_Id='$dep_id',
                            Session_Id='$session_id'
                           
                        WHERE SectionId=$id");

    if ($sql_update) {
        // echo "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;'>"
        //     . "<span class='p_font'>"
        //     . "Record Updated Successfully!"
        //     . "</span>"
        //     . "</div>";
		echo "<script>alert('Submitted Successfully')</script>";
    } else {
		
		echo "<script>alert('Can't Update:',mysqli_error($conn))</script>";
		
        
    }
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style_entry.css" />
<link rel="stylesheet" type="text/css" href="somecss.css" />
<style>
    @media screen and (max-width: 1024px) {
    .panel {
        width: 95%;
        max-width:95%;
        margin:0 auto;
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
    .panel-heading{
        padding:5px !important;
       
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
    .container p{
        font-size:14px;
        margin-bottom:10px !important;
        
    }
    .p_font{
        font-size:14px !important;
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
@media screen and (max-width: 380px) {
    .panel {
       
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
    .teacher_note_pos{
        width:85% !important;

    }
    .teacher_note_pos input {
        font-size: 12px !important;
        padding: 5px !important;
        width:100%;
    }

    .submit_btn, .reset_btn {
        font-size: 12px !important;
        padding: 10px !important;
    }
    .container p{
        font-size:14px;
    }
    .p_font{
        font-size:14px !important;
    }
}
</style>
</head>

<body>


<?php

if ($opr == "upd") {
    $sql_upd=mysqli_query($conn,"SELECT * FROM section WHERE SectionId=$id");
	$rs_upd=mysqli_fetch_array($sql_upd);
?>


     <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Section Update Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
		 <div class="container" style="width:100%;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll update section's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
                  <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">    
                   
                            <div class="teacher_note_pos" style="margin:0;">
                                <input type="text" class="form-control" name="Section"  id="textbox"  placeholder="Section Name" value="<?php echo $rs_upd['SectionName'];?> " style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                                <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Section name should not be empty</p>
                                <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Section name should contain only one character</p>
                                <p id="dname_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Section name should contain only uppercase letter</p>
                            </div>
                           
            
                            
                            <div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Department: </span>
    <select name="department" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $dep_id = $rs_upd['Dep_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT DepName FROM department WHERE DepId = '$dep_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $dep_name = $dep_row['DepName'];
   ?> 
      <option><?php echo $dep_name;?></option>
        <?php
            $sql_departments = mysqli_query($conn, "SELECT DepName FROM department");
            while ($row = mysqli_fetch_assoc($sql_departments)) {
                echo "<option value='" . htmlspecialchars($row['DepName']) . "'>" . htmlspecialchars($row['DepName']) . "</option>";
            }
        ?> 
    </select>
</div>

<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Session: </span>
    <select name="session" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $sess_id = $rs_upd['Session_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $sess_query = mysqli_query($conn, "SELECT SessionName FROM session WHERE SessionId = '$sess_id'");
    $sess_row = mysqli_fetch_assoc($sess_query);
    $sess_name = $sess_row['SessionName'];
   ?> 
      <option><?php echo $sess_name;?></option>
        <?php
            $sql_sessions = mysqli_query($conn, "SELECT SessionName FROM session Status='active'");
            while ($row = mysqli_fetch_assoc($sql_sessions)) {
                echo "<option value='" . htmlspecialchars($row['SessionName']) . "'>" . htmlspecialchars($row['SessionName']) . "</option>";
            }
        ?> 
    </select>
</div>

            
            
                            <div style="margin-top:10px;">
                            <input type="submit" name="btn_upd" class="submit_btn" value="Update" id="updateButton" onClick="Update()" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
                            <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                            </div>
                  </form>            
    	</div>
    </form>
</div>
<?php
}
else

{
?>


            <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Section Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
          <form id="myForm" method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new section's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->

            
                <div class="teacher_note_pos" style="margin:0;">
                	<input type="text" class="form-control" name="name" id="name" placeholder="Section Name" 
                      style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;
                       border-radius:5px;background-color:white;color:black;"/>
                    <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Section name should not be empty</p>
                    <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Section name should contain only one character</p>
                    <p id="dname_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Section name should contain only uppercase letter</p>
                </div>
                <div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Department: </span>
    <select name="department" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
        <option disabled selected>Select Department</option>
        <?php
            $sql_departments = mysqli_query($conn, "SELECT DepName FROM department");
            while ($row = mysqli_fetch_assoc($sql_departments)) {
                echo "<option value='" . htmlspecialchars($row['DepName']) . "'>" . htmlspecialchars($row['DepName']) . "</option>";
            }
        ?> 
    </select>
</div>

<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Session: </span>
    <select name="session" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
        <option disabled selected>Select Session</option>
        <?php
            $sql_sessions = mysqli_query($conn, "SELECT SessionName FROM session WHERE Status='active'");
            while ($row = mysqli_fetch_assoc($sql_sessions)) {
                echo "<option value='" . htmlspecialchars($row['SessionName']) . "'>" . htmlspecialchars($row['SessionName']) . "</option>";
            }
        ?> 
    </select>
</div>

                <div style="margin-top:10px;">
                  
                	<input type="submit" name="btn_sub" class="submit_btn" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"/>
                    <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                </div>
           </form>
    	</div>
    </form>
    <p id="dname_empty" style="color:red; display:none;">Form submitted successfully!</p>
</div><!-- end of style_informatios -->

<?php
}
?>
</body>
<!-- <script type="module" src="file2"></script> -->
<script>

document.addEventListener("DOMContentLoaded", function () {

   

    let dnameInput = document.querySelector("input[name='dname']");
   
    let submitBtn = document.querySelector(".submit_btn");

    let dnameEmpty = document.querySelector("#dname_empty");
    let dnameSize = document.querySelector("#dname_size");
    let dnameLetter = document.querySelector("#dname_letter");
  

    // Function to clear error messages when typing
    function clearDnameErrors() {
        dnameEmpty.style.display = "none";
        dnameSize.style.display = "none";
        dnameLetter.style.display = "none";
    }



    // Add event listeners for real-time validation
    dnameInput.addEventListener("input", clearDnameErrors);
  
    submitBtn.addEventListener("click", function (event) {
        let departmentName = dnameInput.value.trim();
      
        let valid = true; // Track form validity

        // Validation for Department Name
        if (departmentName === "") {
            dnameEmpty.style.display = "block";
            valid = false;
        } else if (departmentName.length!==1) {
            dnameSize.style.display = "block";
            valid = false;
        }
        else if (!/^[A-Z]+$/.test(departmentName)) {
            dnameLetter.style.display = "block";
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
// function Update() {
//     // Get the ID from the URL
//     const urlParams = new URLSearchParams(window.location.search);
// let ID = urlParams.get("ID");

// // Select elements
// let sectionInput = document.querySelector("input[name='Section']");
// let dnameInput = document.querySelector("select[name='Department']");
// let sessionInput = document.querySelector("select[name='Session']");

// // Ensure inputs exist
// if (sectionInput && dnameInput && sessionInput) {
//     if (ID === "1") {
//         localStorage.setItem("section1", sectionInput.value);
//         localStorage.setItem("dep1", dnameInput.value);
//         localStorage.setItem("session1", sessionInput.value);
//     } else if (ID === "2") {
//         localStorage.setItem("section2", sectionInput.value);
//         localStorage.setItem("dep2", dnameInput.value);
//         localStorage.setItem("session2", sessionInput.value);
//     }
// } else {
//     console.error("One or more input fields are missing!");
// }

   
// }



</script>


</html>